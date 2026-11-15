<?php
// $code comes from the router (/admin/:code) = gateCodeGuard
$c = api_request('GET', 'admin-gate/check/' . rawurlencode($code));
if ($c['status'] >= 300 || empty($c['data']['ok'])) redirect('');
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $r = api_request('POST', 'admin-gate/verify', ['code' => $code, 'username' => $_POST['username'] ?? '', 'dbUsername' => $_POST['dbUsername'] ?? '',
    'dbPassword' => $_POST['dbPassword'] ?? '', 'password' => $_POST['password'] ?? '']);
  if ($r['status'] < 300 && !empty($r['data']['adminToken'])) { $_SESSION['admin_token'] = $r['data']['adminToken']; redirect('access-admin'); }
  $error = api_error($r, 'Invalid credentials');
}
layout_begin('Admin Access', ['admin-gate']);
include __DIR__ . '/../views/admin_gate.php';
layout_end();
