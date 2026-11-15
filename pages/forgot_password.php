<?php
$email = ''; $error = ''; $sent = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = trim($_POST['email'] ?? '');
  if (!preg_match('/^\S+@\S+\.\S+$/', $email)) $error = 'Enter a valid email';
  else {
    $r = api_request('POST', 'auth/forgot-password', ['email' => $email]);
    if ($r['status'] < 300) $sent = true; else $error = api_error($r, 'Something went wrong, please try again');
  }
}
layout_begin('Forgot password · EOS Gym', ['auth-shared', 'forgot-password']);
include __DIR__ . '/../views/forgot_password.php';
theme_script(); layout_end();
