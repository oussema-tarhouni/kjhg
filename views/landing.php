<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:wght@600;800&family=Instrument+Sans:wght@400;600;700&display=swap" rel="stylesheet">
<style>
.page-root{--bg:#0e0d0a;--bg2:#171510;--bg3:#1f1c15;--line:rgba(245,238,220,.14);--white:#f6f1e4;--gray:#cfc8b6;--gold:#dcaa43;--gold-light:#f0cf85;--green-light:#dcaa43;
--display:'Bricolage Grotesque','Arial Black',sans-serif;--body:'Instrument Sans','Helvetica Neue',Arial,sans-serif;
margin:0;background:var(--bg);color:var(--white);font:400 16px/1.65 var(--body);overflow-x:clip}
html{scroll-behavior:smooth}
.page-root *{box-sizing:border-box}
.page-root img,.page-root video{max-width:100%}
.page-root svg{width:1.2em;height:1.2em;flex:none}
.page-root a{color:inherit}
.page-root h1,.page-root h2,.page-root h3,.page-root h4{font-family:var(--display);color:var(--white);line-height:1.08;margin:0 0 .5em;letter-spacing:-.02em}
.page-root h1{font-size:clamp(2.6rem,7vw,5rem);font-weight:800}
.page-root h2{font-size:clamp(1.9rem,4vw,2.8rem);font-weight:800}
.page-root h3{font-size:1.25rem;font-weight:600}
.page-root p{margin:0 0 1em;color:var(--gray);max-width:62ch}
.page-root .wrap{max-width:1120px;margin:0 auto;padding:0 24px}
.page-root section{padding:88px 0}
.page-root .eyebrow{display:inline-block;padding:6px 14px;margin-bottom:16px;border:1px solid rgba(220,170,67,.4);border-radius:999px;background:rgba(220,170,67,.1);color:var(--gold-light);font-weight:600;font-size:.85rem;line-height:1.3}
.page-root .section-head{text-align:center;margin-bottom:48px}
.page-root .section-head p{margin-inline:auto}
.page-root .btn{display:inline-block;padding:13px 28px;border-radius:999px;font-weight:700;text-decoration:none;border:1px solid transparent;cursor:pointer;white-space:nowrap;transition:background .2s,color .2s}
.page-root .btn--gold{background:var(--gold);color:#1a1405}
.page-root .btn--gold:hover{background:var(--gold-light)}
.page-root .btn--ghost{background:transparent;color:var(--white);border-color:rgba(246,241,228,.4)}
.page-root .btn--ghost:hover{background:rgba(246,241,228,.1)}
.page-root /* navbar: gradient that blends into the video,.page-root solid after scrolling */
.nav{position:fixed;top:0;left:0;right:0;z-index:60;border:0!important;box-shadow:none!important;background:linear-gradient(180deg,rgba(14,13,10,.7),rgba(14,13,10,0));transition:background .3s}
.page-root .nav.is-solid{background:rgba(14,13,10,.9);backdrop-filter:blur(10px);border-bottom:1px solid var(--line)!important}
.page-root .nav__row{display:flex;align-items:center;justify-content:space-between;gap:16px;height:72px}
.page-root .nav__brand{flex:none;text-decoration:none;font:800 1.5rem var(--display);color:var(--gold)}
.page-root .nav__brand img{width:auto;height:25px;max-width:none;display:block}
.page-root .nav__links{display:flex;gap:28px}
.page-root .nav__links a{text-decoration:none;color:var(--white);opacity:.85;font-weight:600}
.page-root .nav__links a:hover{opacity:1;color:var(--gold-light)}
.page-root .nav__actions{display:flex;align-items:center;gap:10px}
.page-root .nav__burger{display:none;background:none;border:0;color:var(--white);cursor:pointer}
.page-root .nav__burger-icon span{display:block;width:22px;height:2px;background:currentColor;margin:5px 0}
.page-root #mobile-menu{background:rgba(14,13,10,.96)}
.page-root .lang{position:relative}
.page-root .lang__btn{display:flex;align-items:center;gap:6px;background:rgba(14,13,10,.35);border:1px solid rgba(246,241,228,.3);color:var(--white);border-radius:999px;padding:8px 12px;cursor:pointer;font:600 .85rem var(--body)}
.page-root .lang__menu{display:none;position:absolute;inset-inline-end:0;top:115%;background:var(--bg2);border:1px solid var(--line);border-radius:14px;padding:6px;min-width:150px}
.page-root .lang__menu button{display:flex;gap:8px;width:100%;text-align:start;background:none;border:0;color:var(--white);padding:9px 12px;cursor:pointer;font:inherit;border-radius:8px}
.page-root .lang__menu button:hover{background:rgba(246,241,228,.08)}
.page-root /* hero (centered,.page-root video behind) */
.hero{position:relative;min-height:100vh;display:flex;align-items:center;justify-content:center;text-align:center;overflow:hidden;padding:120px 0 96px;background:linear-gradient(135deg,#2a2210,#0e0d0a 65%)}
.page-root .hero__bg,.page-root .hero__scrim{position:absolute;inset:0}
.page-root .hero__bg video{position:absolute;inset:0;width:100%;height:100%;object-fit:cover}
.page-root .hero__bg-blur{filter:blur(24px);opacity:.5}
.page-root .hero__bg-fg{opacity:.75}
.page-root .hero__scrim{background:linear-gradient(180deg,rgba(14,13,10,.6) 0%,rgba(14,13,10,.4) 45%,rgba(14,13,10,.92) 100%)}
.page-root .hero .wrap{width:100%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;}
.page-root .hero__content{position:relative;z-index:1}
.page-root .hero__eyebrow{display:flex;justify-content:center;align-items:center;gap:14px;margin-bottom:18px}
.page-root .hero__eyebrow .eyebrow{margin:0}
.page-root .hero h1{margin-inline:auto;max-width:18ch; text-align: center;}
.page-root .hero h1 span{color:var(--gold-light);-webkit-text-fill-color:initial;background:none; text-align: center;}
.page-root .lead{font-size:1.2rem;margin-inline:auto;max-width:56ch;color:var(--white);opacity:.9}
.page-root .hero__ctas{display:flex;justify-content:center;gap:12px;flex-wrap:wrap;margin-top:28px}
.page-root .hero__scroll{position:absolute;bottom:22px;left:0;right:0;text-align:center;z-index:1;color:var(--gray);font-size:.8rem}
.page-root .barbell{display:flex;align-items:center;gap:3px}
.page-root .barbell--center{justify-content:center;margin-bottom:20px}
.page-root .plate{width:10px;height:34px;background:var(--gold);border-radius:3px}
.page-root .plate.small{height:22px;background:var(--gold-light)}
.page-root /* stats */
.stats{background:var(--bg2);border-block:1px solid var(--line);padding:44px 0}
.page-root .stats__row{display:grid!important;grid-template-columns:repeat(3,1fr);max-width:900px;margin:0 auto;gap:0!important;text-align:center}
.page-root .stat{text-align:center;padding:8px 20px}
.page-root .stat::before,.page-root .stat::after{content:none!important}
.page-root .stat+.stat{border-inline-start:1px solid var(--line)}
.page-root .stat__num{font:800 clamp(2rem,4vw,2.8rem)/1.1 var(--display);color:var(--gold)!important}
.page-root .stat__label{color:var(--gray);margin-top:4px}
@media (max-width:640px){.page-root .stats__row{grid-template-columns:1fr}
.page-root .stat+.stat{border-inline-start:0;border-top:1px solid var(--line);margin-top:14px;padding-top:22px}}
.page-root /* about */
.about__grid{display:grid;gap:56px;grid-template-columns:minmax(0,5fr) minmax(0,6fr);align-items:center}
.page-root .about__media{position:relative}
.page-root .about__media img{display:block;width:100%;height:auto;aspect-ratio:4/5;max-height:600px;object-fit:cover;border-radius:24px;border:1px solid var(--line);background:linear-gradient(135deg,#2a2210,#171510)}
.page-root .about__badge{position:absolute;bottom:20px;inset-inline-start:20px;display:flex;align-items:center;gap:12px;padding:12px 18px;border-radius:16px;background:rgba(14,13,10,.85);backdrop-filter:blur(8px);border:1px solid rgba(220,170,67,.5);color:var(--white)}
.page-root .about__badge svg{width:26px;height:26px;color:var(--gold)}
.page-root .about__badge div{display:flex;flex-direction:column;line-height:1.3}
.page-root .about__badge b{color:var(--gold-light);font-family:var(--display)}
.page-root .about__badge span{font-size:.85rem;color:var(--gray)}
.page-root .about__pillars{display:grid;gap:14px;margin-top:28px}
.page-root .pillar{display:grid;grid-template-columns:48px 1fr;column-gap:16px;align-items:center;padding:16px 18px;background:var(--bg2);border:1px solid var(--line);border-radius:16px}
.page-root .pillar svg{grid-row:1/3;width:48px;height:48px;padding:12px;border-radius:12px;background:rgba(220,170,67,.12);color:var(--gold)}
.page-root .pillar b{grid-column:2;color:var(--white);display:block}
.page-root .pillar span{grid-column:2;color:var(--gray);font-size:.95rem}
.page-root .about>.wrap:not(.about__grid){text-align:center}
.page-root .about__team{max-width:1120px;margin:24px auto 0!important;padding:0 24px!important;background:none!important;border:0!important;box-shadow:none!important;border-radius:0!important}
.page-root .team__grid{display:flex!important;flex-wrap:wrap;justify-content:center;gap:28px 24px!important;background:none!important}
.page-root .team-card{width:190px;padding:0!important;background:none!important;border:0!important;border-radius:0!important;text-align:center;transform:none!important}
.page-root .team-card img{display:block;width:100%;aspect-ratio:1/1;object-fit:cover;object-position:center top;border-radius:20px;margin:0 0 12px;border:1px solid var(--line);background:linear-gradient(135deg,#2a2210,#171510)}
.page-root .team-card b{display:block;color:var(--white)}
.page-root .team-card span{display:block;font-size:.85rem;color:var(--gold-light);opacity:1;margin-top:2px}
.page-root /* programs */
.programs__grid{display:grid;gap:24px;grid-template-columns:repeat(auto-fit,minmax(260px,1fr))}
.page-root .card{background:var(--bg2);border:1px solid var(--line);border-radius:20px;overflow:hidden}
.page-root .card__media img{display:block;width:100%;aspect-ratio:16/10;object-fit:cover;background:linear-gradient(135deg,#2a2210,#171510)}
.page-root .card__body{padding:24px}
.page-root .card__tag{display:inline-block;color:var(--gold-light);font-weight:600;font-size:.85rem;margin-bottom:8px}
.page-root /* plans */
.plans{background:var(--bg2)}
.page-root .plans__tabs{display:flex;justify-content:center;gap:8px;margin-bottom:32px}
.page-root .plans__tab{font:600 1rem var(--body);color:var(--gray);background:transparent;border:1px solid var(--line);border-radius:999px;padding:10px 24px;cursor:pointer}
.page-root .plans__tab.is-active{background:var(--gold);color:#1a1405;border-color:var(--gold)}
.page-root .plans__panel{display:none}
.page-root .plans__panel.is-active{display:block}
.page-root .price-grid{display:grid;gap:20px;grid-template-columns:repeat(auto-fit,minmax(300px,1fr))}
.page-root .price-block{background:var(--bg);border:1px solid var(--line);border-radius:18px;padding:24px}
.page-root .price-block h3{margin-bottom:14px}
.page-root .price-table{width:100%;border-collapse:collapse}
.page-root .price-table td{padding:10px 0;border-top:1px solid var(--line);color:var(--white)}
.page-root .price-table td:last-child{text-align:end;font-weight:700;color:var(--gold);white-space:nowrap;padding-inline-start:12px}
.page-root .price-note{font-size:.82rem;margin:14px 0 0;color:var(--gray)}
.page-root /* banner */
.banner{position:relative;padding:120px 0;text-align:center;background:linear-gradient(135deg,#2a2210,#0e0d0a)}
.page-root .banner__bg{position:absolute;inset:0}
.page-root .banner__bg img{width:100%;height:100%;object-fit:cover;opacity:.45}
.page-root .banner__scrim{position:absolute;inset:0;background:rgba(14,13,10,.5)}
.page-root .banner__inner{position:relative;    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;}
.page-root .banner p{margin-inline:auto;color:var(--white);opacity:.9}
.page-root /* locations (large map) */
.loc__grid{max-width:1120px!important;margin:0 auto!important;grid-template-columns:1fr!important;display:block!important}
.page-root .loc{display:grid;grid-template-columns:minmax(0,1.7fr) minmax(0,1fr);max-width:none;background:var(--bg2);border:1px solid var(--line);border-radius:24px;overflow:hidden}
.page-root .loc__media{position:relative;min-height:520px;height:auto;margin:0}
.page-root .loc__media iframe{position:absolute;inset:0;width:100%!important;height:100%!important;border:0;display:block}
.page-root .loc__pin{display:none}
.page-root .loc__body{padding:40px;display:flex;flex-direction:column;justify-content:center}
.page-root .loc__hours{margin:0 0 16px}
.page-root .loc__hours span{display:block;font-size:.8rem;color:var(--gray)}
.page-root .loc__hours div{color:var(--white);font-weight:600}
.page-root .loc__link{display:inline-flex;align-items:center;gap:6px;color:var(--gold);font-weight:700;text-decoration:none}
.page-root .loc__link:hover{color:var(--gold-light)}
.page-root .loc__socials{display:flex;gap:10px;margin-top:22px}
.page-root .soc{display:inline-flex;align-items:center;justify-content:center;width:44px;height:44px;border:1px solid var(--line);border-radius:50%;color:var(--white)}
.page-root .soc svg{width:20px;height:20px}
.page-root .soc--wa{color:#4ade80}
.page-root .soc:hover{border-color:var(--gold)}
@media (max-width:860px){.page-root .loc{grid-template-columns:1fr}
.page-root .loc__media{min-height:380px}
.page-root .loc__body{padding:28px}}
.page-root /* cta + footer */
.cta{text-align:center;padding:100px 24px;background:linear-gradient(180deg,var(--bg),#1d1809)}
.page-root .cta p{margin-inline:auto}
.page-root footer{border-top:1px solid var(--line);padding:60px 0 28px}
.page-root .foot__grid{display:grid;gap:36px;grid-template-columns:1.4fr 1fr 1fr 1fr}
.page-root .foot__brand{margin-bottom:12px}
.page-root .foot__col h4{font-size:1rem;margin-bottom:14px}
.page-root .foot__col a,.page-root .foot__col p{display:block;color:var(--gray);text-decoration:none;margin:0 0 8px}
.page-root .foot__col a:hover{color:var(--gold-light)}
.page-root .foot__bottom{display:flex;justify-content:space-between;flex-wrap:wrap;gap:8px;margin-top:40px;padding-top:24px;border-top:1px solid var(--line);color:var(--gray);font-size:.9rem}
@media (max-width:900px){.page-root .foot__grid{grid-template-columns:1fr 1fr}}
@media (max-width:860px){.page-root .about__grid{grid-template-columns:1fr;gap:36px}}
@media (max-width:760px){.page-root .nav__links{display:none}
.page-root .nav__burger{display:block}
.page-root .nav__actions .btn--ghost{display:none}
.page-root .nav__row{height:64px}
.page-root .nav__actions{gap:8px}
.page-root .nav__actions .btn{padding:9px 16px;font-size:.9rem}
.page-root section{padding:64px 0}}
[dir=rtl] .page-root .hero__scrim{background:linear-gradient(180deg,rgba(14,13,10,.6) 0%,rgba(14,13,10,.4) 45%,rgba(14,13,10,.92) 100%)}
[dir=rtl] .page-root .loc__link svg{transform:scaleX(-1)}
.page-root .about>.wrap:not(.about__grid) h2{margin-bottom:32px}

/* ---- round 4: left alignment, scroll hint, pillars, socials, directions link ---- */
.page-root .hero{text-align:start}
.page-root .hero__eyebrow{justify-content:flex-start}
.page-root .hero h1{margin-inline:0}
.page-root .lead{margin-inline:0}
.page-root .hero__ctas{justify-content:flex-start}
.page-root .hero__scrim{background:linear-gradient(90deg,rgba(14,13,10,.85) 0%,rgba(14,13,10,.35) 70%,rgba(14,13,10,.2) 100%),linear-gradient(180deg,rgba(14,13,10,.5) 0%,rgba(14,13,10,0) 40%,rgba(14,13,10,.9) 100%)}
[dir=rtl] .page-root .hero__scrim{background:linear-gradient(270deg,rgba(14,13,10,.85) 0%,rgba(14,13,10,.35) 70%,rgba(14,13,10,.2) 100%),linear-gradient(180deg,rgba(14,13,10,.5) 0%,rgba(14,13,10,0) 40%,rgba(14,13,10,.9) 100%)}
.page-root .hero__scroll{left:auto;right:auto;inset-inline-end:max(24px,calc((100% - 1120px)/2 + 24px));bottom:28px;text-align:end;display:flex;align-items:center;gap:10px}
.page-root .hero__scroll::after{content:"";width:1px;height:36px;background:var(--gold);display:block}
.page-root .section-head,.page-root .about>.wrap:not(.about__grid){text-align:start}
.page-root .section-head p{margin-inline:0}
.page-root .plans__tabs{justify-content:flex-start}
.page-root .about__pillars{grid-template-columns:repeat(auto-fit,minmax(150px,1fr))}
.page-root .pillar{display:block;padding:20px}
.page-root .pillar svg{display:block;width:48px;height:48px;margin:0 0 14px}
.page-root .pillar b{display:block;margin-bottom:4px}
.page-root .pillar span{display:block}
.page-root .loc__socials{display:flex;gap:12px}
.page-root .soc{display:inline-flex!important;align-items:center;justify-content:center;flex:none;width:46px!important;height:46px!important;min-width:46px;padding:0!important;border-radius:50%!important;border:1px solid var(--line);background:rgba(246,241,228,.05);overflow:hidden}
.page-root .soc svg{width:20px!important;height:20px!important}
.page-root .soc:hover{border-color:var(--gold);background:rgba(220,170,67,.15)}
.page-root .loc__link{align-self:flex-start;display:inline-flex;align-items:center;gap:8px;padding:11px 20px;border:1px solid var(--gold);border-radius:999px;color:var(--gold);font-weight:700;text-decoration:underline;text-underline-offset:4px;transition:background .2s,color .2s}
.page-root .loc__link svg{transition:transform .2s}
.page-root .loc__link:hover{background:var(--gold);color:#1a1405}
.page-root .loc__link:hover svg{transform:translate(3px,-3px)}
[dir=rtl] .page-root .loc__link:hover svg{transform:scaleX(-1) translate(3px,-3px)}
@media (max-width:640px){.page-root .hero__scroll{display:none}}
</style>
<div class="page-root">
<nav class="nav" id="nav">
  <div class="wrap nav__row">
    <a class="nav__brand" href="#top">
      <img src="<?= BASE ?>/assets/logo.svg" alt="EOS" height="25" style="display:block;">
    </a>
    <div class="nav__links">
      <a href="#about" data-i18n="nav.about">About</a>
      <a href="#programs" data-i18n="nav.programs">Programs</a>
      <a href="#plans" data-i18n="nav.plans">Plans</a>
      <a href="#locations" data-i18n="nav.locations">Locations</a>
      <a href="#membership" data-i18n="nav.membership">Membership</a>
    </div>
    <div class="nav__actions">
      <div class="lang" id="lang-switch">
        <button class="lang__btn" id="lang-btn" aria-haspopup="true" aria-expanded="false">
          <span id="lang-flag">🇫🇷</span><span id="lang-code">FR</span>
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="12" height="12"><path d="m6 9 6 6 6-6"/></svg>
        </button>
        <div class="lang__menu" id="lang-menu">
          <button type="button" data-lang="en"><span>🇬🇧</span>English</button>
          <button type="button" data-lang="fr"><span>🇫🇷</span>Français</button>
          <button type="button" data-lang="tn"><span>🇹🇳</span>تونسي</button>
        </div>
      </div>
      <a href="<?= url('login') ?>" class="btn btn--ghost" data-i18n="nav.login">Log In</a>
      <a href="<?= url('signup') ?>" class="btn btn--gold" data-i18n="nav.join">Join Now</a>
      <button class="nav__burger" id="nav-burger" aria-label="Menu">
        <span class="nav__burger-icon"><span></span><span></span><span></span></span>
      </button>
    </div>
  </div>
  <div id="mobile-menu" style="display:none;">
    <div class="wrap" style="display:flex; flex-direction:column; gap:2px; padding-top:16px;">
      <a href="#about" data-i18n="nav.about" style="padding:12px 0; border-top:1px solid var(--line); color:var(--gray); font-weight:600;">About</a>
      <a href="#programs" data-i18n="nav.programs" style="padding:12px 0; border-top:1px solid var(--line); color:var(--gray); font-weight:600;">Programs</a>
      <a href="#plans" data-i18n="nav.plans" style="padding:12px 0; border-top:1px solid var(--line); color:var(--gray); font-weight:600;">Plans</a>
      <a href="#locations" data-i18n="nav.locations" style="padding:12px 0; border-top:1px solid var(--line); color:var(--gray); font-weight:600;">Locations</a>
      <a href="#membership" data-i18n="nav.membership" style="padding:12px 0; border-top:1px solid var(--line); color:var(--gray); font-weight:600;">Membership</a>
      <a href="<?= url('login') ?>" data-i18n="nav.login" style="padding:12px 0; border-top:1px solid var(--line); color:var(--white); font-weight:700;">Log In</a>
    </div>
  </div>
</nav>

<div id="top" class="hero">
  <div class="hero__bg">
    <video class="hero__bg-blur" src="<?= BASE ?>/assets/hero.mp4" autoplay muted loop playsinline></video>
    <video class="hero__bg-fg" src="<?= BASE ?>/assets/hero.mp4" autoplay muted loop playsinline></video>
  </div>
  <div class="hero__scrim"></div>
  <div class="wrap hero__content">
    <div class="hero__eyebrow">
      <div class="barbell barbell--left"><div class="plate small"></div><div class="plate"></div></div>
      <span class="eyebrow" data-i18n="hero.eyebrow">Strength · Pilates · Community</span>
    </div>
    <h1 data-i18n="hero.title">Train like the<br>work actually <span>matters</span></h1>
    <p class="lead" data-i18n="hero.lead" style="text-align:center;">Free weights, a reformer pilates studio, and group classes under one roof — with a front desk that actually remembers your name. Open early, open late, three floors near you.</p>
    <div class="hero__ctas">
      <a href="<?= url('signup') ?>" class="btn btn--gold" data-i18n="nav.join">Join Now</a>
      <a href="#locations" class="btn btn--ghost" data-t='{"en":"Location","fr":"Localisation","tn":"الموقع"}'>Localisation</a>
    </div>
</div>
</div>

<div class="stats">
  <div class="wrap">
    <div class="stats__row" style="display:flex;justify-content:center;flex-wrap:wrap;gap:24px 64px;text-align:center;">
      <div class="stat"><div class="stat__num">50+</div><div class="stat__label" data-i18n="stats.members">Active Members</div></div>
      <div class="stat"><div class="stat__num">15+</div><div class="stat__label" data-t='{"en":"Classes per week","fr":"Cours par semaine","tn":"كورسات في الجمعة"}'>Cours par semaine</div></div>
      <div class="stat"><div class="stat__num">8a–10p</div><div class="stat__label" data-i18n="stats.hours">Daily Hours</div></div>
    </div>
  </div>
</div>

<section class="about" id="about">
  <div class="wrap about__grid">
    <div class="about__media">
      <img src="<?= BASE ?>/assets/gym/pilates-1.jpg" alt="Instructor coaching a member through a lift" />
      <div class="about__badge">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2l2.4 6.9L21 11l-6.6 2.1L12 20l-2.4-6.9L3 11l6.6-2.1z"/></svg>
        <div><b data-i18n="about.badge.title">Est. 2025</b><span data-i18n="about.badge.sub">Locally owned, still coached</span></div>
      </div>
    </div>
    <div class="about__text">
      <div class="eyebrow" data-i18n="about.eyebrow">About Us</div>
      <h2 class="display" style="font-size:clamp(30px,4vw,44px); margin-top:12px;" data-i18n="about.title">A gym built by people who actually train here</h2>
      <p data-i18n="about.p1">EOS started as a single strength floor and a stubborn belief that a gym should feel like it belongs to its members, not the other way around. A decade later that hasn't changed — the same coaches who designed the programming are still on the floor spotting sets and correcting form.</p>
      <p data-i18n="about.p2">We built three things under one roof: a serious free-weight and machine floor, a reformer pilates studio led by instructors who watch every rep, and a class schedule people actually show up for. No matter which door you walk through, someone knows your name and your goals.</p>
      <div class="about__pillars">
        <div class="pillar">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6.5 6.5 17.5 17.5M4 4l3 3M20 20l-3-3M2 8l2-2M22 16l-2 2M8 2l-2 2M16 22l2-2"/></svg>
          <b data-i18n="about.pillar1.title">Strength Floor</b><span data-i18n="about.pillar1.desc">Free weights &amp; machines, zero waiting.</span>
        </div>
        <div class="pillar">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M12 3v18M3 12h18"/></svg>
          <b data-i18n="about.pillar2.title">Pilates Studio</b><span data-i18n="about.pillar2.desc">Reformer &amp; mat, small class sizes.</span>
        </div>
        <div class="pillar">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="16" rx="2"/><path d="M3 9h18M8 20v-4M16 20v-4"/></svg>
          <b data-t='{"en":"Group Class Room","fr":"Salle de cours collectifs","tn":"قاعة الكورسات الجماعية"}'>Salle de cours collectifs</b><span data-t='{"en":"Dedicated room for group classes.","fr":"Une salle dédiée aux cours collectifs.","tn":"قاعة مخصصة للكورسات الجماعية."}'>Une salle dédiée aux cours collectifs.</span>
        </div>
      </div>
    </div>
  </div>

  <div class="wrap" style="margin-top:64px; margin-bottom:12px;">
    <div class="eyebrow" data-i18n="team.eyebrow">Meet The Team</div>
    <h2 class="display" style="font-size:clamp(24px,3vw,32px); margin-top:12px;" data-i18n="team.title">Administration &amp; Coaches</h2>
  </div>
  <div class="about__team">
    <div class="team__grid" style="display:grid;grid-template-columns:repeat(auto-fit,minmax(160px,200px));justify-content:center;gap:24px;">
      <div class="team-card"><img src="<?= BASE ?>/assets/team/ameni.jpeg" alt="Ameni" /><b>Ameni</b><span data-i18n="team.coach">Coach</span></div>
      <div class="team-card"><img src="<?= BASE ?>/assets/team/ameur.jpeg" alt="Ameur" /><b>Ameur</b><span data-i18n="team.coach">Coach</span></div>
      <div class="team-card"><img src="<?= BASE ?>/assets/team/Mouhamed.jpeg" alt="Mouhamed" /><b>Mouhamed</b><span data-i18n="team.coach">Coach</span></div>
      <div class="team-card"><img src="<?= BASE ?>/assets/team/fedi.jpeg" alt="Fedi" /><b>Fedi</b><span data-i18n="team.coach">Coach</span></div>
      <div class="team-card"><img src="<?= BASE ?>/assets/team/nourane.jpeg" alt="Nourane" /><b>Nourane</b><span data-i18n="team.coach">Coach</span></div>
      <div class="team-card"><img src="<?= BASE ?>/assets/team/rami.jpeg" alt="Rami" /><b>Rami</b><span data-i18n="team.coach">Coach</span></div>
      <div class="team-card"><img src="<?= BASE ?>/assets/team/sourour.jpeg" alt="Sourour" /><b>Sourour</b><span data-i18n="team.coach">Coach</span></div>
      <div class="team-card"><img src="<?= BASE ?>/assets/team/ranim.jpeg" alt="Ranim" /><b>Ranim</b><span data-i18n="team.coach">Coach</span></div>
      <div class="team-card"><img src="<?= BASE ?>/assets/team/samia.jpeg" alt="Samia" /><b>Samia</b><span data-i18n="team.coach">Coach</span></div>
    </div>
  </div>
</section>

<section class="programs" id="programs">
  <div class="wrap">
    <div class="section-head">
      <div class="eyebrow" data-i18n="programs.eyebrow">Programs</div>
      <h2 data-i18n="programs.title">Train your way</h2>
      <p data-i18n="programs.lead">Three floors, one membership. Move between them as your training changes.</p>
    </div>
    <div class="programs__grid">
      <div class="card">
        <div class="card__media"><img src="<?= BASE ?>/assets/gym/pilates-2.jpg" alt="Strength training floor with free weights" /></div>
        <div class="card__body">
          <div class="card__tag" data-i18n="programs.c1.tag">Strength</div>
          <h3 data-i18n="programs.c1.title">Strength &amp; Conditioning</h3>
          <p data-i18n="programs.c1.desc">A full floor of free weights, plate-loaded machines, and platforms for serious lifting — plus programming if you want it.</p>
        </div>
      </div>
      <div class="card">
        <div class="card__media"><img src="<?= BASE ?>/assets/gym/pilates-3.jpg" alt="Reformer pilates class in session" /></div>
        <div class="card__body">
          <div class="card__tag" data-i18n="programs.c2.tag">Pilates</div>
          <h3 data-i18n="programs.c2.title">Reformer &amp; Mat Pilates</h3>
          <p data-i18n="programs.c2.desc">Small classes led by instructors who watch your form rep by rep — reformer, mat, and everything between.</p>
        </div>
      </div>
      <div class="card">
        <div class="card__media"><img src="<?= BASE ?>/assets/gym/pilates-4.jpg" alt="Group fitness class" /></div>
        <div class="card__body">
          <div class="card__tag" data-i18n="programs.c3.tag">Group Classes</div>
          <h3 data-i18n="programs.c3.title">HIIT, Cycle &amp; More</h3>
          <p data-i18n="programs.c3.desc">15+ classes a week across every floor. Book your spot in the app before it fills up.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="plans" id="plans">
  <div class="wrap">
    <div class="section-head">
      <div class="eyebrow" data-i18n="plans.eyebrow">Plans</div>
      <h2 data-i18n="plans.title">Pricing built to move you</h2>
      <p data-i18n="plans.lead">Strength, pilates, or both — pick your track. </p>
    </div>
    <div class="plans__tabs">
      <button class="plans__tab is-active" data-tab="musc" data-action="switchPlan" data-arg="musc" onclick="__page.__run(event)" data-i18n="plans.tabMusc">Musculation</button>
      <button class="plans__tab" data-tab="pilates" data-action="switchPlan" data-arg="pilates" onclick="__page.__run(event)" data-i18n="plans.tabPilates">Pilates</button>
    </div>

    <div class="plans__panel is-active" id="panel-musc">
      <div class="price-grid">
        <div class="price-block">
          <h3>Musculation + Classes</h3>
          <table class="price-table">
            <tr><td>1 Month</td><td>110 DT</td></tr>
            <tr><td>2 Months</td><td>180 DT</td></tr>
            <tr><td>3 Months</td><td>250 DT</td></tr>
            <tr><td>6 Months</td><td>450 DT</td></tr>
            <tr><td>12 Months</td><td>750 DT</td></tr>
          </table>
        </div>
        <div class="price-block">
          <h3>Musculation + Classes + Pilates</h3>
          <table class="price-table">
            <tr><td>1 Month + classes + 8 R</td><td>360 DT</td></tr>
            <tr><td>2 Months + classes + 16 R</td><td>640 DT</td></tr>
            <tr><td>3 Months + classes + 24 R</td><td>800 DT</td></tr>
            <tr><td>6 Months + classes + 48 R</td><td>1530 DT</td></tr>
          </table>
          <p class="price-note">R = Reformer &nbsp; P = Privé (Cadillac, Wunda Chair, Barrel, Tower)</p>
        </div>
        <div class="price-block">
          <h3>Private Coaching</h3>
          <table class="price-table">
            <tr><td>1 Session</td><td>30 DT</td></tr>
            <tr><td>8 Sessions</td><td>200 DT</td></tr>
            <tr><td>16 Sessions</td><td>320 DT</td></tr>
          </table>
        </div>
        <div class="price-block">
          <h3>Musculation Per Session</h3>
          <table class="price-table">
            <tr><td>1 Session</td><td>10 DT</td></tr>
            <tr><td>1 Class session</td><td>20 DT</td></tr>
          </table>
        </div>
      </div>
    </div>

    <div class="plans__panel" id="panel-pilates">
      <div class="price-grid">
        <div class="price-block">
          <h3>Essentiel — Reformer</h3>
          <table class="price-table">
            <tr><td>8 R · 30 days</td><td>260 DT</td></tr>
            <tr><td>12 R · 45 days</td><td>360 DT</td></tr>
            <tr><td>24 R · 90 days</td><td>550 DT</td></tr>
            <tr><td>48 R · 180 days</td><td>1050 DT</td></tr>
          </table>
        </div>
        <div class="price-block">
          <h3>Premium — Reformer + Privé</h3>
          <table class="price-table">
            <tr><td>5R + 3P · 30 days</td><td>290 DT</td></tr>
            <tr><td>7R + 5P · 45 days</td><td>420 DT</td></tr>
            <tr><td>16R + 8P · 90 days</td><td>750 DT</td></tr>
            <tr><td>38R + 10P · 180 days</td><td>1300 DT</td></tr>
          </table>
          <p class="price-note">R = Reformer &nbsp; P = Privé (Cadillac, Wunda Chair, Barrel, Tower)</p>
        </div>
        <div class="price-block">
          <h3>Intégral — Pilates + Musculation</h3>
          <table class="price-table">
            <tr><td>1 Month · Musculation + 8 R</td><td>320 DT</td></tr>
            <tr><td>3 Months · Musculation + 24 R</td><td>700 DT</td></tr>
            <tr><td>6 Months · Musculation + 48 R</td><td>1350 DT</td></tr>
            <tr><td>12 Months · Musculation + 100 R</td><td>2650 DT</td></tr>
          </table>
        </div>
        <div class="price-block">
          <h3>Balance — Pilates + Classes</h3>
          <table class="price-table">
            <tr><td>1 Month · 8 R</td><td>300 DT</td></tr>
            <tr><td>2 Months · 16 R</td><td>560 DT</td></tr>
            <tr><td>3 Months · 24 R</td><td>670 DT</td></tr>
            <tr><td>6 Months · 48 R</td><td>1290 DT</td></tr>
          </table>
        </div>
        <div class="price-block">
          <h3>Super Premium — Reformer + Privé + Classes</h3>
          <table class="price-table">
            <tr><td>5R + 3P + classes</td><td>340 DT</td></tr>
            <tr><td>7R + 5P + classes</td><td>510 DT</td></tr>
            <tr><td>16R + 8P + classes</td><td>870 DT</td></tr>
            <tr><td>38R + 10P + classes</td><td>1520 DT</td></tr>
          </table>
          <p class="price-note">R = Reformer &nbsp; P = Privé (Cadillac, Wunda Chair, Barrel, Tower)</p>
        </div>
        <div class="price-block">
          <h3>Pack Privé</h3>
          <table class="price-table">
            <tr><td>Pilates Reformer</td><td>35 DT</td></tr>
            <tr><td>Private session (any machine)</td><td>45 DT</td></tr>
            <tr><td>8 Private sessions</td><td>340 DT</td></tr>
          </table>
        </div>
      </div>
    </div>
  </div>
</section>

<div class="banner">
  <div class="banner__bg"><img src="<?= BASE ?>/assets/gym/pilates-5.jpg" alt="" /></div>
  <div class="banner__scrim"></div>
  <div class="wrap banner__inner">
    <div class="barbell barbell--center"><div class="plate small"></div><div class="plate"></div><div class="plate small"></div></div>
    <h2 data-i18n="banner.title" style="text-align: center;">A gym that knows your name</h2>
    <p data-i18n="banner.text">Group classes, a members-only app, and a front desk that remembers your goals — not just your card number.</p>
  </div>
</div>

<section class="locations" id="locations">
  <div class="wrap">
    <div class="section-head">
      <div class="eyebrow" data-i18n="locations.eyebrow">Location</div>
      <h2 data-i18n="locations.title">Find us on the map</h2>
      <p data-i18n="locations.lead">One floor, open early, open late. Drop in whenever training calls.</p>
    </div>
    <div class="loc__grid" style="grid-template-columns:1fr; max-width:840px; margin:0 auto;">
      <div class="loc">
        <div class="loc__media">
          <iframe src="https://www.google.com/maps?q=Eos+gym+fitness+%26+pilates,+Bizerte&output=embed" width="100%" height="100%" style="border:0; display:block;" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
          <div class="loc__pin"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg></div>
        </div>
        <div class="loc__body">
          <h3>EOS Gym</h3>
          <p class="addr" data-i18n="locations.addr">Fitness &amp; Pilates<br>Bizerte Governorate, Tunisia</p>
          <div class="loc__hours">
            <div><span data-i18n="stats.hours">Daily Hours</span>8:00a – 10:00p</div>
          </div>
          <a class="loc__link" href="https://www.google.com/maps/place/Eos+gym+%7C+fitness+%26+pilates/@35.7609098,10.8309126,18z/data=!4m6!3m5!1s0x130213328e932abf:0x3764c48c05d7556c!8m2!3d35.7609098!4d10.8322001!16s%2Fg%2F11z22ls4df" target="_blank" rel="noopener" data-i18n="locations.directions">Get Directions
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M7 17 17 7M7 7h10v10"/></svg>
          </a>
          <div class="loc__socials">
            <a href="https://wa.me/21654088881" target="_blank" rel="noopener" aria-label="WhatsApp" class="soc soc--wa">
              <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.5 2 2 6.5 2 12c0 1.8.5 3.5 1.3 5L2 22l5.2-1.3c1.4.8 3.1 1.3 4.8 1.3 5.5 0 10-4.5 10-10S17.5 2 12 2zm0 18c-1.5 0-3-.4-4.2-1.2l-.3-.2-3.1.8.8-3-.2-.3C4.4 15 4 13.5 4 12c0-4.4 3.6-8 8-8s8 3.6 8 8-3.6 8-8 8zm4.4-6c-.2-.1-1.4-.7-1.6-.8-.2-.1-.4-.1-.6.1-.2.2-.6.8-.8 1-.1.2-.3.2-.5.1-.2-.1-1-.4-2-1.2-.7-.6-1.2-1.4-1.4-1.6-.1-.2 0-.4.1-.5.1-.1.2-.3.4-.4.1-.1.2-.3.2-.4.1-.2 0-.3 0-.5-.1-.1-.6-1.4-.8-1.9-.2-.5-.4-.4-.6-.4h-.5c-.2 0-.5.1-.7.3-.2.2-.9.9-.9 2.2 0 1.3.9 2.5 1.1 2.7.1.2 1.8 2.8 4.4 3.9.6.3 1.1.4 1.5.5.6.2 1.2.2 1.6.1.5-.1 1.4-.6 1.6-1.1.2-.5.2-1 .1-1.1-.1-.1-.2-.2-.5-.3z"/></svg>
            </a>
            <a href="https://facebook.com/eosfitness" target="_blank" rel="noopener" aria-label="Facebook" class="soc">
              <svg viewBox="0 0 24 24" fill="currentColor"><path d="M22 12a10 10 0 1 0-11.6 9.9v-7H7.9V12h2.5V9.8c0-2.5 1.5-3.9 3.8-3.9 1.1 0 2.2.2 2.2.2v2.4h-1.3c-1.2 0-1.6.8-1.6 1.6V12h2.8l-.4 2.9h-2.4v7A10 10 0 0 0 22 12z"/></svg>
            </a>
            <a href="https://instagram.com/eosfitness" target="_blank" rel="noopener" aria-label="Instagram" class="soc">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="1" fill="currentColor" stroke="none"/></svg>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<div id="membership" class="cta">
  <div class="barbell barbell--center" style="margin-bottom:22px;"><div class="plate small"></div><div class="plate"></div><div class="plate small"></div></div>
  <h2 data-i18n="cta.title">Your first rep starts here</h2>
  <p data-i18n="cta.text">Create a free account and set up your membership in under a minute — book classes, track workouts, and manage everything from the app.</p>
  <a href="<?= url('signup') ?>" class="btn btn--gold" data-i18n="nav.join">Join Now</a>
</div>

<footer>
  <div class="wrap">
    <div class="foot__grid">
      <div>
        <div class="foot__brand">
          <img src="<?= BASE ?>/assets/logo.svg" alt="EOS" height="25" style="display:block;">
        </div>
        <p style="max-width:280px; color:var(--gray); font-size:14px; line-height:1.7;" data-i18n="foot.tagline">Strength, pilates, and group classes across three floors — built for people who actually train.</p>
      </div>
      <div class="foot__col">
        <h4 data-i18n="foot.explore">Explore</h4>
        <a href="#about" data-i18n="nav.about">About</a>
        <a href="#programs" data-i18n="nav.programs">Programs</a>
        <a href="#locations" data-i18n="nav.locations">Locations</a>
        <a href="#membership" data-i18n="nav.membership">Membership</a>
      </div>
      <div class="foot__col">
        <h4 data-i18n="foot.account">Account</h4>
        <a href="<?= url('login') ?>" data-i18n="nav.login">Log In</a>
        <a href="<?= url('signup') ?>" data-i18n="nav.join">Join Now</a>
        <a href="#" data-i18n="foot.schedule">Class Schedule</a>
      </div>
      <div class="foot__col">
        <h4 data-i18n="foot.contact">Contact</h4>
        <p>hello.eosfitness.examplee</p>
        <p>(555) 019-2280</p>
      </div>
    </div>
    <div class="foot__bottom">
      <span data-i18n="foot.rights">© 2026 EOS Fitness &amp; Pilates. All rights reserved.</span>
      <span>Monastir, Tunisia</span>
    </div>
  </div>
</footer>

</div>
<style>
.stat__num,.hero h1 span{-webkit-text-fill-color:initial;background:none}
.stats__row .stat:nth-child(odd) .stat__num{color:var(--gold)}
.stats__row .stat:nth-child(even) .stat__num{color:var(--green-light)}
.hero h1 span{color:var(--gold-light)}
.team-card{background:rgba(255,255,255,.04);border:1px solid rgba(255,255,255,.08);border-radius:24px;padding:14px 14px 18px;text-align:center;transition:transform .25s,border-color .25s}
.team-card:hover{transform:translateY(-4px);border-color:var(--gold)}
.team-card img{width:100%;aspect-ratio:1/1;object-fit:cover;object-position:center top;border-radius:18px;display:block;margin:0 0 12px}
.team-card b{display:block;font-size:16px}
.team-card span{display:block;font-size:12px;opacity:.65;margin-top:2px}
.team-card:nth-child(even):hover{border-color:var(--green-light)}
</style>
<script>
(function(){
var T=[].slice.call(document.querySelectorAll('[data-t]'));
function ap(){var c=((document.getElementById('lang-code')||{}).textContent||'FR').trim().toLowerCase();T.forEach(function(e){try{var d=JSON.parse(e.getAttribute('data-t'));if(d[c])e.textContent=d[c]}catch(x){}})}
var lc=document.getElementById('lang-code');
if(lc)new MutationObserver(ap).observe(lc,{childList:true,characterData:true,subtree:true});
try{if(!localStorage.getItem('eos_fr_default')){localStorage.setItem('eos_fr_default','1');var b=document.querySelector('#lang-menu [data-lang="fr"]');if(b)b.click()}}catch(x){}
ap();
})();
</script>

<script>
/* navbar: transparent gradient over the video, solid once the page scrolls */
(function(){var n=document.getElementById('nav');if(!n)return;
function f(){n.classList.toggle('is-solid',window.scrollY>40)}f();
window.addEventListener('scroll',f,{passive:true});})();
</script>
