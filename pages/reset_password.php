<?php
$token = $_GET['token'] ?? '';
if (!preg_match('/^[a-f0-9]{64}$/i', $token)) redirect('forgot-password'); // = resetGuard
$error = ''; $done = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $password = $_POST['password'] ?? ''; $confirm = $_POST['confirm'] ?? '';
  if (strlen($password) < 8) $error = 'Password must be at least 8 characters';
  elseif ($password !== $confirm) $error = 'Passwords do not match';
  else {
    $r = api_request('POST', 'auth/reset-password', ['token' => $token, 'password' => $password, 'newPassword' => $password]);
    if ($r['status'] < 300) { $done = true; header('Refresh: 2; url=' . url('login')); } else $error = api_error($r, 'Link expired or invalid');
  }
}
layout_begin('New password · EOS Gym', ['auth-shared', 'reset-password']);
include __DIR__ . '/../views/reset_password.php';
theme_script(); layout_end();
