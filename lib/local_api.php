<?php
// Local PHP+MySQL replacement for the Node API (same request/response shapes the front end expects).
date_default_timezone_set('Africa/Tunis');
if (is_file(dirname(__DIR__) . '/config.admin.php')) require_once dirname(__DIR__) . '/config.admin.php';
function db(): PDO { static $p; return $p ??= new PDO('mysql:host='.DB_HOST.';port='.(defined('DB_PORT')?DB_PORT:3306).';dbname='.DB_NAME.';charset=utf8mb4', DB_USER, DB_PASS, [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC]); }
function q(string $sql, array $p = []): PDOStatement { $s = db()->prepare($sql); $s->execute($p); return $s; }
function dev_log(string $f, string $line): void { @file_put_contents(dirname(__DIR__)."/$f", '['.date('c')."] $line\n", FILE_APPEND); }
function throttled(string ...$keys): bool { // brute-force protection: 5 failures / 15 min per key
  q('CREATE TABLE IF NOT EXISTS login_attempts(id INT AUTO_INCREMENT PRIMARY KEY,k VARCHAR(255) NOT NULL,created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,INDEX(k,created_at))');
  foreach ($keys as $k) if ((int)q('SELECT COUNT(*) FROM login_attempts WHERE k=? AND created_at>DATE_SUB(NOW(),INTERVAL 15 MINUTE)', [$k])->fetchColumn() >= 5) return true;
  return false;
}
function record_fail(string ...$keys): void { foreach ($keys as $k) q('INSERT INTO login_attempts(k) VALUES(?)', [$k]); }
function api_me(): ?array {
  if (empty($_SESSION['uid'])) return null;
  $u = q('SELECT id,name,email,phone,role,level,status,preferred_category,avatar,phone_verified_at,created_at FROM users WHERE id=?', [$_SESSION['uid']])->fetch();
  if (!$u) return null; $u['phone_verified'] = true; return $u;
}
function api_login_session(int $id): void { session_regenerate_id(true); $_SESSION['uid'] = $id; $_SESSION['token'] = 'session'; }
function api_request(string $method, string $path, $body = null, array $opt = []): array {
  $path = trim($path, '/'); $method = strtoupper($method);
  if (is_string($body)) $body = json_decode($body, true);
  $body = is_array($body) ? $body : [];
  $query = []; parse_str($opt['query'] ?? '', $query);
  try { [$s, $d] = api_route($method, $path, $body, $query); }
  catch (Throwable $e) { dev_log('error_log.txt', $e); [$s, $d] = [500, ['error' => get_class($e) . ': ' . $e->getMessage() . ' (' . basename($e->getFile()) . ':' . $e->getLine() . ')']]; }
  return ['status' => $s, 'data' => $d, 'raw' => json_encode($d)];
}
function api_error(array $r, string $fb): string { return is_array($r['data']) && !empty($r['data']['error']) ? (string)$r['data']['error'] : $fb; }
function api_route(string $m, string $p, array $b, array $qs): array {
  $E = fn($c, $msg) => [$c, ['error' => $msg]];
  // ---------- public ----------
  if ($p === 'auth/register' && $m === 'POST') {
    $n = trim($b['name'] ?? ''); $e = strtolower(trim($b['email'] ?? '')); $ph = trim($b['phone'] ?? ''); $pw = (string)($b['password'] ?? '');
    if ($n === '' || !filter_var($e, FILTER_VALIDATE_EMAIL)) return $E(400, 'Name and valid email required');
    if (!preg_match('/^[0-9]{8}$/', $ph)) return $E(400, 'Phone must be 8 digits');
    if (strlen($pw) < 8) return $E(400, 'Password must be at least 8 characters');
    if (q('SELECT 1 FROM users WHERE email=?', [$e])->fetch()) return $E(409, 'Email already registered');
    if (q('SELECT 1 FROM users WHERE phone=?', [$ph])->fetch()) return $E(409, 'Phone already registered');
    q('INSERT INTO users(name,email,phone,password_hash) VALUES(?,?,?,?)', [$n, $e, $ph, password_hash($pw, PASSWORD_DEFAULT)]);
    api_login_session((int)db()->lastInsertId()); return [201, ['user' => api_me(), 'token' => 'session']];
  }
  if ($p === 'auth/login' && $m === 'POST') {
    $em = strtolower(trim($b['email'] ?? '')); $kE = 'e:' . $em; $kI = 'i:' . ($_SERVER['REMOTE_ADDR'] ?? '');
    if (throttled($kE, $kI)) return $E(429, 'Too many attempts. Try again in 15 minutes.');
    $u = q('SELECT id,password_hash,status FROM users WHERE email=?', [$em])->fetch();
    if (!$u || !password_verify((string)($b['password'] ?? ''), $u['password_hash'])) { record_fail($kE, $kI); return $E(401, 'Invalid email or password'); }
    if ($u['status'] === 'rejected') return $E(403, 'Account rejected');
    q('DELETE FROM login_attempts WHERE k=?', [$kE]);
    api_login_session((int)$u['id']); return [200, ['user' => api_me(), 'token' => 'session']];
  }
  if ($p === 'auth/refresh') return empty($_SESSION['uid']) ? $E(401, 'Not authenticated') : [200, ['token' => 'session']];
  if ($p === 'auth/logout') { unset($_SESSION['uid'], $_SESSION['token'], $_SESSION['admin_token']); return [200, ['ok' => true]]; }
  if ($p === 'auth/plans') return [200, q('SELECT * FROM membership_plans WHERE is_active=1 ORDER BY price')->fetchAll()];
  if ($p === 'auth/forgot-password' && $m === 'POST') {
    $u = q('SELECT id FROM users WHERE email=?', [strtolower(trim($b['email'] ?? ''))])->fetch();
    if ($u) { $t = bin2hex(random_bytes(32));
      q("INSERT INTO tokens(user_id,type,token_hash,expires_at) VALUES(?,?,?,DATE_ADD(NOW(),INTERVAL 1 HOUR))", [$u['id'], 'password_reset', hash('sha256', $t)]);
      dev_log('mail_log.txt', "Reset link for {$b['email']}: http://{$_SERVER['HTTP_HOST']}" . BASE . "/reset-password?token=$t"); }
    return [200, ['ok' => true]];
  }
  if ($p === 'auth/reset-password' && $m === 'POST') {
    $pw = (string)($b['password'] ?? $b['newPassword'] ?? ''); if (strlen($pw) < 8) return $E(400, 'Password must be at least 8 characters');
    $t = q("SELECT id,user_id FROM tokens WHERE token_hash=? AND type='password_reset' AND used_at IS NULL AND expires_at>NOW()", [hash('sha256', (string)($b['token'] ?? ''))])->fetch();
    if (!$t) return $E(400, 'Invalid or expired link');
    q('UPDATE users SET password_hash=? WHERE id=?', [password_hash($pw, PASSWORD_DEFAULT), $t['user_id']]);
    q('UPDATE tokens SET used_at=NOW() WHERE id=?', [$t['id']]); return [200, ['ok' => true]];
  }
  if (str_starts_with($p, 'admin-gate')) return admin_gate_route($m, $p, $b);
  if (str_starts_with($p, 'admin/')) { if ($g = admin_guard()) return $g; return admin_route($m, substr($p, 6), $b, $qs); }
  // ---------- authenticated ----------
  $u = api_me(); if (!$u) return $E(401, 'Not authenticated'); $uid = (int)$u['id'];
  if ($p === 'auth/me') {
    if ($m === 'GET') return [200, $u];
    $n = trim($b['name'] ?? $u['name']); $e = strtolower(trim($b['email'] ?? $u['email']));
    if ($n === '' || !filter_var($e, FILTER_VALIDATE_EMAIL)) return $E(400, 'Name and valid email required');
    if (q('SELECT 1 FROM users WHERE email=? AND id<>?', [$e, $uid])->fetch()) return $E(409, 'Email already registered');
    $av = $u['avatar'];
    if (!empty($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
      $f = $_FILES['avatar']; if ($f['size'] > 2*1024*1024 || !str_starts_with((string)mime_content_type($f['tmp_name']), 'image/')) return $E(400, 'Avatar must be an image under 2MB');
      $av = 'data:' . mime_content_type($f['tmp_name']) . ';base64,' . base64_encode(file_get_contents($f['tmp_name']));
    }
    q('UPDATE users SET name=?,email=?,avatar=? WHERE id=?', [$n, $e, $av, $uid]); return [200, ['user' => api_me()]];
  }
  if ($p === 'auth/send-otp' || $p === 'auth/verify-otp') return [200, ['ok' => true]]; // verification removed; kept so stale cached JS still works
  if ($p === 'auth/subscription' && $m === 'POST') {
    $pl = q('SELECT * FROM membership_plans WHERE id=? AND is_active=1', [(int)($b['planId'] ?? 0)])->fetch(); if (!$pl) return $E(400, 'Plan not available');
    $auto = defined('AUTO_APPROVE_USERS') && AUTO_APPROVE_USERS;
    q("DELETE FROM memberships WHERE user_id=? AND status='pending'", [$uid]);
    q('INSERT INTO memberships(user_id,plan_id,status,started_at,renews_at) VALUES(?,?,?,CURDATE(),DATE_ADD(CURDATE(),INTERVAL ? MONTH))', [$uid, $pl['id'], $auto ? 'active' : 'pending', (int)$pl['duration_months']]);
    q('UPDATE users SET preferred_category=?,status=? WHERE id=?', [(string)($b['category'] ?? $pl['category']), $auto ? 'approved' : 'pending_approval', $uid]); return [200, ['ok' => true]];
  }
  if ($p === 'dashboard/home') {
    $r = q('SELECT m.status,m.classes_used_this_month,m.renews_at,p.name plan_name,p.classes_per_month FROM memberships m JOIN membership_plans p ON p.id=m.plan_id WHERE m.user_id=? ORDER BY m.id DESC LIMIT 1', [$uid])->fetch();
    return [200, ['membership' => $r ?: null]];
  }
  if ($p === 'classes' && $m === 'GET') {
    $f = fn($s, $d) => $s ? (new DateTime($s))->setTimezone(new DateTimeZone(date_default_timezone_get()))->format('Y-m-d H:i:s') : $d;
    return [200, q("SELECT c.*,t.name trainer_name,GREATEST(c.capacity-(SELECT COUNT(*) FROM bookings b WHERE b.class_id=c.id AND b.status='booked'),0) spots_left
      FROM classes c JOIN trainers t ON t.id=c.trainer_id WHERE c.starts_at BETWEEN ? AND ? ORDER BY c.starts_at", [$f($qs['from'] ?? '', '1970-01-01'), $f($qs['to'] ?? '', '2999-01-01')])->fetchAll()];
  }
  if ($p === 'classes/bookings') return [200, q('SELECT b.*,c.name,c.starts_at,c.ends_at,c.location,c.level,t.name trainer_name FROM bookings b JOIN classes c ON c.id=b.class_id JOIN trainers t ON t.id=c.trainer_id WHERE b.user_id=? ORDER BY c.starts_at DESC', [$uid])->fetchAll()];
  if (preg_match('#^classes/(\d+)/book$#', $p, $x)) {
    $cid = (int)$x[1]; $d = db();
    if ($m === 'POST') {
      if ($u['status'] !== 'approved') return $E(403, 'Your account is not approved yet');
      $d->beginTransaction();
      $cap = q('SELECT capacity FROM classes WHERE id=? AND starts_at>NOW() FOR UPDATE', [$cid])->fetchColumn();
      if ($cap === false) { $d->rollBack(); return $E(404, 'Class not found or already started'); }
      if ((int)q("SELECT COUNT(*) FROM bookings WHERE class_id=? AND status='booked'", [$cid])->fetchColumn() >= $cap) { $d->rollBack(); return $E(409, 'Class is full'); }
      $prev = q('SELECT status FROM bookings WHERE user_id=? AND class_id=?', [$uid, $cid])->fetchColumn();
      if ($prev === 'booked') { $d->rollBack(); return $E(409, 'Already booked'); }
      q("INSERT INTO bookings(user_id,class_id) VALUES(?,?) ON DUPLICATE KEY UPDATE status='booked'", [$uid, $cid]);
      q("UPDATE memberships SET classes_used_this_month=classes_used_this_month+1 WHERE user_id=? AND status='active' ORDER BY id DESC LIMIT 1", [$uid]);
      $d->commit(); return [200, ['ok' => true]];
    }
    if ($m === 'DELETE') {
      $n = q("UPDATE bookings SET status='cancelled' WHERE user_id=? AND class_id=? AND status='booked'", [$uid, $cid])->rowCount();
      if ($n) q("UPDATE memberships SET classes_used_this_month=GREATEST(classes_used_this_month-1,0) WHERE user_id=? AND status='active' ORDER BY id DESC LIMIT 1", [$uid]);
      return [200, ['ok' => true]];
    }
  }
  if ($p === 'trainers') return [200, q('SELECT id,name,specialty,avatar,bio FROM trainers ORDER BY name')->fetchAll()];
  if ($p === 'content/posters') return [200, q('SELECT * FROM posters ORDER BY created_at DESC')->fetchAll()];
  if ($p === 'content/notifications') return [200, q('SELECT * FROM announcements ORDER BY created_at DESC')->fetchAll()];
  if ($p === 'content/my-notifications') return [200, q('SELECT * FROM notifications WHERE user_id=? ORDER BY created_at DESC LIMIT 50', [$uid])->fetchAll()];
  if ($p === 'content/my-notifications/read') { q('UPDATE notifications SET is_read=1 WHERE user_id=?', [$uid]); return [200, ['ok' => true]]; }
  if ($p === 'store/products') {
    $c = $qs['category'] ?? ''; return [200, $c !== '' ? q('SELECT * FROM products WHERE is_active=1 AND category=?', [$c])->fetchAll() : q('SELECT * FROM products WHERE is_active=1')->fetchAll()];
  }
  if ($p === 'store/orders/mine') return [200, q('SELECT * FROM orders WHERE user_id=? ORDER BY id DESC', [$uid])->fetchAll()];
  if ($p === 'store/orders' && $m === 'POST') {
    $items = $b['items'] ?? []; if (!$items) return $E(400, 'Cart is empty'); $d = db(); $d->beginTransaction(); $total = 0; $rows = [];
    foreach ($items as $i) {
      $qty = (int)($i['quantity'] ?? 0); $pr = q('SELECT * FROM products WHERE id=? AND is_active=1 FOR UPDATE', [(int)($i['product_id'] ?? 0)])->fetch();
      if (!$pr || $qty < 1) { $d->rollBack(); return $E(400, 'Invalid item'); }
      if ($pr['stock'] < $qty) { $d->rollBack(); return $E(409, "Not enough stock for {$pr['name']}"); }
      $total += $pr['price'] * $qty; $rows[] = [$pr['id'], $qty, $pr['price']];
    }
    q('INSERT INTO orders(user_id,total) VALUES(?,?)', [$uid, $total]); $oid = $d->lastInsertId();
    foreach ($rows as $r) { q('INSERT INTO order_items(order_id,product_id,quantity,unit_price) VALUES(?,?,?,?)', [$oid, $r[0], $r[1], $r[2]]); q('UPDATE products SET stock=stock-? WHERE id=?', [$r[1], $r[0]]); }
    $d->commit(); return [201, ['id' => (int)$oid, 'total' => $total]];
  }
  return $E(404, 'Not found');
}

require_once __DIR__ . '/admin_api.php';
