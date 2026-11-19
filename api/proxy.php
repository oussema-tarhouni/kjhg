<?php
// Same-origin JSON endpoint used by the page scripts: /api/* -> local MySQL handlers
ini_set('display_errors', '0'); ob_start(); // stray PHP warnings must never corrupt the JSON
$sub = preg_replace('#^/?api/?#', '', $route_path);
$method = $_SERVER['REQUEST_METHOD'];
header('Content-Type: application/json');
if ($method !== 'GET' && ($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '') !== 'XMLHttpRequest') { http_response_code(403); echo '{"error":"Forbidden"}'; exit; }
$ctype = $_SERVER['CONTENT_TYPE'] ?? '';
$body = $method === 'GET' ? [] : (stripos($ctype, 'multipart/') === 0 || stripos($ctype, 'x-www-form') !== false ? $_POST : (json_decode(file_get_contents('php://input') ?: '{}', true) ?: []));
$r = api_request($method, $sub, $body, ['query' => $_SERVER['QUERY_STRING'] ?? '']);
ob_end_clean(); header('Content-Type: application/json'); http_response_code($r['status']); echo $r['raw'];
