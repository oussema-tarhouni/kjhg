<?php
// Same-origin JSON proxy used by the page scripts: /api/* -> Node API (adds the session token)
$sub = preg_replace('#^/?api/?#', '', $route_path);
$method = $_SERVER['REQUEST_METHOD'];
header('Content-Type: application/json');
if ($method !== 'GET' && ($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '') !== 'XMLHttpRequest') { http_response_code(403); echo '{"error":"Forbidden"}'; exit; }
$opt = ['query' => $_SERVER['QUERY_STRING'] ?? ''];
$ctype = $_SERVER['CONTENT_TYPE'] ?? '';
$body = null;
if ($method !== 'GET') {
  if ($method === 'POST' && stripos($ctype, 'multipart/') === 0) {
    $body = $_POST;
    foreach ($_FILES as $k => $f) if ($f['error'] === UPLOAD_ERR_OK) $body[$k] = new CURLFile($f['tmp_name'], $f['type'], $f['name']);
    $opt['multipart'] = true;
  } else { $body = file_get_contents('php://input') ?: '{}'; $opt['ctype'] = $ctype ?: 'application/json'; }
}
$r = api_request($method, $sub, $body, $opt);
if (preg_match('#^auth/(login|register|refresh)$#', $sub) && isset($r['data']['token'])) $r['data']['token'] = 'session'; // never expose the JWT
if ($sub === 'auth/logout') { unset($_SESSION['token'], $_SESSION['refresh']); }
http_response_code($r['status']);
echo $r['raw'] !== '' ? json_encode($r['data']) : '{}';
