<?php
// Admin approval page: /approvals  (only users with role = 'admin')
$me = !empty($_SESSION['uid']) ? q('SELECT role,name FROM users WHERE id=?', [$_SESSION['uid']])->fetch() : null;
if (!$me || $me['role'] !== 'admin') { http_response_code(403); exit('<body style="background:#0e0e0d;color:#f5f4f0;font-family:sans-serif;padding:40px">Admins only. <a style="color:#e6cc7a" href="' . h(url('login')) . '">Log in</a> with an account whose users.role = admin.'); }
header('Cache-Control: no-store'); header('X-Frame-Options: DENY'); header('X-Content-Type-Options: nosniff');
$_SESSION['csrf'] ??= bin2hex(random_bytes(16)); $msg = '';
// second lock: admin must re-enter their password (valid 15 min of inactivity)
if (($_SESSION['admin_ok'] ?? 0) < time() - 900) {
  $err = ''; $k = 'a:' . (int)$_SESSION['uid'];
  if ($_SERVER['REQUEST_METHOD'] === 'POST' && hash_equals($_SESSION['csrf'], $_POST['csrf'] ?? '') && isset($_POST['pw'])) {
    if (throttled($k)) $err = 'Too many attempts. Try again in 15 minutes.';
    elseif (password_verify((string)$_POST['pw'], q('SELECT password_hash FROM users WHERE id=?', [$_SESSION['uid']])->fetchColumn())) { $_SESSION['admin_ok'] = time(); header('Location: ' . url('approvals')); exit; }
    else { record_fail($k); $err = 'Wrong password.'; }
  }
  exit('<!doctype html><meta charset="utf-8"><body style="background:#0e0e0d;color:#f5f4f0;font-family:sans-serif;padding:40px"><h2>Admin verification</h2><p style="color:#e5484d">' . h($err) . '</p><form method="post"><input type="hidden" name="csrf" value="' . h($_SESSION['csrf']) . '"><input type="password" name="pw" placeholder="Your password" autofocus required style="padding:10px"> <button style="padding:10px 16px;background:#c9a227;border:0;border-radius:8px">Unlock</button></form>');
}
$_SESSION['admin_ok'] = time();
if ($_SERVER['REQUEST_METHOD'] === 'POST' && hash_equals($_SESSION['csrf'], $_POST['csrf'] ?? '')) {
  $id = (int)($_POST['id'] ?? 0);
  if (($_POST['a'] ?? '') === 'approve') {
    $lv = in_array($_POST['level'] ?? '', ['Initiation','Debutant','Intermediaire','Avancee','Expert'], true) ? $_POST['level'] : 'Initiation';
    q("UPDATE users SET status='approved', level=? WHERE id=? AND status='pending_approval'", [$lv, $id]);
    q("UPDATE memberships m JOIN membership_plans p ON p.id=m.plan_id SET m.status='active', m.started_at=CURDATE(), m.renews_at=DATE_ADD(CURDATE(),INTERVAL p.duration_months MONTH) WHERE m.user_id=? AND m.status='pending'", [$id]);
    q('INSERT INTO notifications(user_id,message) VALUES(?,?)', [$id, 'Your account has been approved. Welcome to EOS!']); $msg = 'Approved.';
  } elseif (($_POST['a'] ?? '') === 'reject') {
    q("DELETE FROM users WHERE id=? AND status='pending_approval'", [$id]); $msg = 'Rejected and deleted.';
  }
}
$rows = q("SELECT u.id,u.name,u.email,u.phone,u.preferred_category,u.created_at,(SELECT p.name FROM memberships m JOIN membership_plans p ON p.id=m.plan_id WHERE m.user_id=u.id ORDER BY m.id DESC LIMIT 1) plan FROM users u WHERE u.status='pending_approval' ORDER BY u.created_at")->fetchAll();
?><!doctype html><meta charset="utf-8"><title>Approvals · EOS</title>
<style>body{background:#0e0e0d;color:#f5f4f0;font-family:Poppins,sans-serif;padding:32px}table{border-collapse:collapse;width:100%}td,th{border-bottom:1px solid #2a2923;padding:10px;text-align:left}th{color:#e6cc7a}button,select{padding:7px 12px;border-radius:8px;border:0;font:inherit}.ok{background:#c9a227}.no{background:#7a2e2e;color:#fff}form{display:inline}</style>
<h1>Pending approvals</h1><?php if ($msg) echo '<p style="color:#8fc25f">' . h($msg) . '</p>'; if (!$rows) echo '<p>Nothing to approve.</p>'; else { ?>
<table><tr><th>Name<th>Email<th>Phone<th>Category<th>Plan<th>Signed up<th></tr>
<?php foreach ($rows as $r): ?><tr><td><?= h($r['name']) ?><td><?= h($r['email']) ?><td><?= h($r['phone']) ?><td><?= h($r['preferred_category']) ?><td><?= h($r['plan']) ?><td><?= h($r['created_at']) ?>
<td><form method="post"><input type="hidden" name="csrf" value="<?= h($_SESSION['csrf']) ?>"><input type="hidden" name="id" value="<?= (int)$r['id'] ?>">
<select name="level"><?php foreach (['Initiation','Debutant','Intermediaire','Avancee','Expert'] as $l) echo "<option>$l</option>"; ?></select>
<button class="ok" name="a" value="approve">Approve</button> <button class="no" name="a" value="reject">Reject</button></form></tr><?php endforeach; ?></table><?php } ?>
<p><a style="color:#e6cc7a" href="<?= h(url('app')) ?>">← Dashboard</a></p>
