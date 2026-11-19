<?php
// Front controller (replaces app.routes.ts)
require __DIR__ . '/config.php'; require __DIR__ . '/lib/helpers.php'; require __DIR__ . '/lib/http.php';
start_session();
$route_path = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
if (BASE !== '' && str_starts_with('/' . $route_path, BASE)) $route_path = trim(substr('/' . $route_path, strlen(BASE)), '/');
if (str_starts_with($route_path, 'api/') || $route_path === 'api') { require __DIR__ . '/api/proxy.php'; exit; }
if (preg_match('#^admin/([^/]+)$#', $route_path, $m)) { $code = $m[1]; require __DIR__ . '/pages/admin_gate.php'; exit; }
$routes = ['approvals' => 'approvals', '' => 'landing', 'login' => 'login', 'signup' => 'signup', 'terms' => 'terms', 'privacy' => 'privacy',
  'forgot-password' => 'forgot_password', 'reset-password' => 'reset_password', 'select-plan' => 'plan', 'pending' => 'pending',
  'app' => 'dashboard', 'dashboard' => 'dashboard', 'access-admin' => 'admin'];
$page = $routes[$route_path] ?? null;
if (!$page) redirect('');
if (in_array($page, ['plan', 'pending', 'dashboard'], true)) require_auth();
require __DIR__ . "/pages/$page.php";
