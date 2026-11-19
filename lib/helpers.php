<?php
function h($v): string { return htmlspecialchars((string)($v ?? ''), ENT_QUOTES, 'UTF-8'); }
function url(string $p = ''): string { return BASE . '/' . ltrim($p, '/'); }
function redirect(string $p): never { header('Location: ' . (preg_match('#^https?://#', $p) ? $p : url($p))); exit; }
function start_session(): void {
  if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params(['httponly' => true, 'samesite' => 'Lax', 'secure' => !empty($_SERVER['HTTPS']), 'path' => '/']);
    session_start();
  }
}
function layout_begin(string $title, array $css = [], string $bodyAttr = ''): void {
  echo '<!doctype html><html lang="en" data-theme="dark"><head><meta charset="UTF-8"><title>' . h($title) . '</title>'
     . '<base href="' . h(BASE) . '/">' . '<meta name="viewport" content="width=device-width, initial-scale=1.0">'
     . '<link rel="icon" type="image/svg+xml" href="' . url('assets/logo.svg') . '">'
     . '<link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>'
     . '<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">'
     . '<link rel="stylesheet" href="' . url('assets/css/styles.css') . '">';
  foreach ($css as $c) echo '<link rel="stylesheet" href="' . url("assets/css/$c.css") . '">';
  echo '</head><body ' . $bodyAttr . '>';
}
// $js = module name in assets/js (page logic), $route = params exposed to the JS runtime
function layout_end(?string $js = null, array $route = []): void {
  echo '<script>window.EOS_BASE=' . json_encode(BASE) . ';window.EOS_ROUTE=' . json_encode($route ?: new stdClass) . ';</script>';
  if ($js) echo '<script type="module" src="' . url("assets/js/$js.js") . '"></script>';
  echo '</body></html>';
}
function theme_script(): void { // light/dark toggle + password eye for server-rendered pages
  echo '<script type="module">import {initThemeToggle,initPasswordToggles} from "' . url('assets/js/auth-common.js') . '";initThemeToggle();initPasswordToggles();</script>';
}
