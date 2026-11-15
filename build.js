const fs = require('fs'), path = require('path');
const ts = require('/home/claude/testg/node_modules/typescript');
const SRC = '/home/claude/testg/src', APP = SRC + '/app', OUT = '/home/claude/eos-php';
const rd = (p) => fs.readFileSync(p, 'utf8'), wr = (p, s) => { fs.mkdirSync(path.dirname(p), { recursive: true }); fs.writeFileSync(p, s); };
function rep(s, from, to, label) { // asserted replace
  const n = typeof from === 'string' ? s.split(from).length - 1 : (s.match(from) || []).length;
  if (!n) throw new Error('no match: ' + (label || from));
  return typeof from === 'string' ? s.split(from).join(to) : s.replace(from, to);
}
const BASEJS = `(window.EOS_BASE||'')+`;
const fixAssetsJs = (s) => s; // <base href> in the layout keeps relative assets/ URLs working
const fixCss = (s) => s.replace(/@import\s+['"][^'"]*auth-shared\.css['"];?/g, "@import 'auth-shared.css';")
  .replace(/:host-context\(\[data-theme="dark"\]\)/g, '[data-theme="dark"]').replace(/:host\b/g, 'body')
  .replace(/url\((['"]?)(?:\.\.\/)*assets\//g, "url($1../");

// ---------- static assets / css ----------
for (const f of fs.readdirSync(SRC + '/assets')) fs.copyFileSync(`${SRC}/assets/${f}`, `${OUT}/assets/${f}`);
wr(`${OUT}/assets/css/styles.css`, rd(SRC + '/styles.css'));
wr(`${OUT}/assets/css/auth-shared.css`, rd(APP + '/shared/auth-shared.css'));
const cssPages = { admin: 'admin', admin_gate: 'admin-gate', dashboard: 'dashboard', forgetpass: 'forgot-password', landing: 'landing', login: 'login', otp: 'otp', pending: 'pending', plan: 'plan', 'reset-password': 'reset-password', signup: 'signup' };
for (const [d, n] of Object.entries(cssPages)) wr(`${OUT}/assets/css/${n}.css`, fixCss(rd(`${APP}/pages/${d}/${n}.component.css`)));
// plan: highlight the radio-selected tier (server-rendered replacement for [class.plan-row--active])
{ const p = `${OUT}/assets/css/plan.css`; let c = rd(p); const m = c.match(/\.plan-row--active\s*\{[^}]*\}/);
  if (m) c += '\n' + m[0].replace('.plan-row--active', '.plan-row:has(input:checked)') + '\n.plan-row input{position:absolute;opacity:0;pointer-events:none}.plan-row{position:relative;cursor:pointer}\n.plan-tab{text-decoration:none;display:inline-block}\n'; wr(p, c); }

// ---------- TS -> browser JS ----------
const tr = (src) => ts.transpileModule(src, { compilerOptions: { target: ts.ScriptTarget.ES2022, module: ts.ModuleKind.ESNext, useDefineForClassFields: false } }).outputText;
wr(`${OUT}/assets/js/auth-common.js`, fixAssetsJs(tr(rd(APP + '/shared/auth-common.ts'))));
const mech = { landing: ['landing', ''], login: ['login', 'Log In'], signup: ['signup', 'Sign Up'], otp: ['otp', 'Verify'], pending: ['pending', 'Pending approval'], dashboard: ['dashboard', 'EOS Fitness'] };
const NAMES = { AuthService: 1, Router: 1, ActivatedRoute: 1, ClassesService: 1, StoreService: 1 };
for (const k of Object.keys(mech)) {
  const dir = { otp: 'otp', pending: 'pending' }[k] || k, file = `${APP}/pages/${dir}/${dir}.component`;
  let ts_ = rd(file + '.ts');
  const cls = ts_.match(/export class (\w+)/)[1];
  const ctor = (ts_.match(/constructor\(([^)]*)\)/) || [, ''])[1];
  const deps = ctor.split(',').map((x) => (x.split(':')[1] || '').trim()).filter((t) => NAMES[t]);
  ts_ = ts_.replace(/@Component\(\{[\s\S]*?\n\}\)\n/, '').replace(/^import [^\n]*\n/gm, (l) => /shared\/auth-common/.test(l) ? l.replace(/'[^']*auth-common'/, "'./auth-common.js'") : '')
    .replace(/\s+implements\s+[\w,\s]+(?=\{)/, ' ');
  let js = fixAssetsJs(tr(ts_)).replace(/^export class/m, 'class');
  js = `import { ${[...new Set([...deps, 'boot'])].join(', ')} } from './eos-runtime.js';\n` + js + `\nboot(${cls}, [${deps.join(', ')}]);\n`;
  wr(`${OUT}/assets/js/${k}.js`, js);
  // template -> PHP view
  let html = rd(file + '.html');
  if (/<\?/.test(html)) throw new Error('php tag in ' + k);
  html = html.replace(/routerLink="([^"]*)"/g, (m, p) => `href="<?= url('${p.replace(/^\//, '')}') ?>"`)
    .replace(/\(click\)="([^"]*)"/g, (m, e) => `onclick="__page.${e.replace(/\$event/g, 'event')}"`)
    .replace(/(src|href)="(?:\.\.\/)*assets\//g, `$1="<?= BASE ?>/assets/`);
  wr(`${OUT}/views/${k}.php`, html);
  // controller
  const pageFile = { otp: 'otp', pending: 'pending' }[k] || k;
  const extraCss = k === 'landing' ? ['landing'] : [k];
  const bodyAttr = '';
  wr(`${OUT}/pages/${k}.php`, `<?php\nlayout_begin(${JSON.stringify((k === 'landing' ? 'EOS Gym' : mech[k][1] + ' · EOS Gym'))}, ${JSON.stringify(['auth-shared', ...extraCss].filter((x) => ['login', 'signup', 'otp', 'pending'].includes(k) || x !== 'auth-shared'))});\ninclude __DIR__ . '/../views/${k}.php';\nlayout_end('${k}');\n`);
}
// ---------- legal pages (inline templates) ----------
for (const [k, t] of [['terms', 'Terms of Service'], ['privacy', 'Privacy Policy']]) {
  const s = rd(`${APP}/pages/${k}/${k}.component.ts`);
  const sections = eval('(' + s.match(/const SECTIONS\s*=\s*(\[[\s\S]*?\n\]);/)[1] + ')');
  let tpl = s.match(/template: `([\s\S]*?)`,\n\s*styles/)[1];
  tpl = tpl.replace(/@for \([^)]*\) \{[\s\S]*?\n\s*\}\n/, '<?php foreach ($sections as $s): ?><h2><?= h($s["title"]) ?></h2><p><?= h($s["body"]) ?></p><?php endforeach; ?>\n')
    .replace(/routerLink="([^"]*)"/g, (m, p) => `href="<?= url('${p.replace(/^\//, '')}') ?>"`).replace(/\(click\)="toggle\(\)"/, 'id="theme-btn"');
  if (k === 'terms') wr(`${OUT}/assets/css/legal.css`, fixCss(s.match(/styles: \[`([\s\S]*?)`\]/)[1]));
  wr(`${OUT}/data/${k}.json`, JSON.stringify(sections, null, 1));
  wr(`${OUT}/pages/${k}.php`, `<?php\n$sections = json_decode(file_get_contents(__DIR__ . '/../data/${k}.json'), true);\nlayout_begin('${t} · EOS Gym', ['legal']);\n?>${tpl}<?php theme_script(); layout_end();\n`);
}
// ---------- admin resource definitions ----------
{ const cc = eval(rd(APP + '/core/class.categories.ts').match(/CLASS_CATEGORIES = (\[[\s\S]*?\])/)[1]);
  const CLASS_CATEGORIES = cc; const body = rd(APP + '/pages/admin/admin.component.ts').match(/const RESOURCES: ResourceDef\[\] = (\[[\s\S]*?\n\]);/)[1];
  wr(`${OUT}/data/admin_defs.json`, JSON.stringify(eval('(' + body + ')'), null, 1)); }
// ---------- hand-converted bound templates: forgot / reset / gate use original markup with asserted substitutions ----------
const base = (h) => h.replace(/routerLink="([^"]*)"/g, (m, p) => `href="<?= url('${p.replace(/^\//, '')}') ?>"`)
  .replace(/src="(?:\.\.\/)*assets\//g, 'src="<?= BASE ?>/assets/').replace(/\[disabled\]="[^"]*"/g, '').replace(/\[\(ngModel\)\]="(\w+)"/g, 'value="<?= h($$$1) ?>"')
  .replace(/\s*\(ngSubmit\)="[^"]*"/g, ' method="post"').replace(/\s*\[class\.field__error--show\]="error"/, '')
  .replace(/<span class="field__error"([^>]*)>\{\{ error \}\}<\/span>/, '<span class="field__error<?= $error ? " field__error--show" : "" ?>"$1><?= h($error) ?></span>');
let f = base(rd(`${APP}/pages/forgetpass/forgot-password.component.html`));
f = rep(f, /<div \*ngIf="!sent">/, '<?php if (!$sent): ?><div>'); f = rep(f, /<\/form>\s*<\/div>\s*<div \*ngIf="sent" class="auth__head">/, '</form></div><?php else: ?><div class="auth__head">');
f = rep(f, /<\/div>(\s*<p class="auth__foot">)/, '</div><?php endif; ?>$1');
wr(`${OUT}/views/forgot_password.php`, f);
let r = base(rd(`${APP}/pages/reset-password/reset-password.component.html`));
r = rep(r, /<div \*ngIf="!done">/, '<?php if (!$done): ?><div>'); r = rep(r, /<\/form>\s*<\/div>\s*<div \*ngIf="done" class="auth__head">/, '</form></div><?php else: ?><div class="auth__head">');
r = rep(r, /<\/div>(\s*<p class="auth__foot">)/, '</div><?php endif; ?>$1'); r = rep(r, 'name="confirm" type="password" value="<?= h($confirm) ?>"', 'name="confirm" type="password"'); r = rep(r, 'name="password" type="password" value="<?= h($password) ?>"', 'name="password" type="password"');
wr(`${OUT}/views/reset_password.php`, r);
let p = base(rd(`${APP}/pages/plan/plan.component.html`));
p = rep(p, /<div class="plan-tabs">[\s\S]*?<\/button>\s*<\/div>\s*<div class="plan-groups">[\s\S]*?<span class="field__error[\s\S]*?<\/span>\s*<button type="button" class="auth-form__submit" id="plan-continue"[^>]*>/, '<?php include __DIR__ . "/plan_body.php"; ?><button type="submit" class="auth-form__submit" id="plan-continue">');
p = rep(p, /(<span class="btn-label">Confirm & Submit<\/span>\s*<\/button>)/, '$1</form>');
wr(`${OUT}/views/plan.php`, p);
let g = base(rd(`${APP}/pages/admin_gate/admin-gate.component.html`));
g = g.replace(/<input \[\(ngModel\)\]="(\w+)" name="(\w+)" required \/>/g, '<input name="$2" required />').replace(/<input type="password" \[\(ngModel\)\]="\w+" name="(\w+)" required \/>/g, '<input type="password" name="$1" required />')
  .replace(/<p class="gate-error" \*ngIf="error">\{\{ error \}\}<\/p>/, '<?php if ($error): ?><p class="gate-error"><?= h($error) ?></p><?php endif; ?>').replace("{{ loading ? 'Checking…' : 'Continue' }}", 'Continue');
wr(`${OUT}/views/admin_gate.php`, g);
console.log('build ok');
{ const s = rd(APP + '/pages/plan/plan.component.ts'); const cat = s.match(/const CATEGORIES: CategoryTab\[\] = (\[[\s\S]*?\n\]);/)[1];
  wr(`${OUT}/data/plan_catalog.json`, JSON.stringify(eval('(' + cat + ')'), null, 1)); }
