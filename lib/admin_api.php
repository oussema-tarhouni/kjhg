<?php
// Admin API (PHP + MySQL). Reachable only with an admin session unlocked via /admin/<ADMIN_GATE_CODE>.
function admin_guard(): ?array {
  $ok = !empty($_SESSION['admin_token']) && !empty($_SESSION['admin_uid']) && ($_SESSION['admin_seen'] ?? 0) > time() - 1800
     && q("SELECT 1 FROM users WHERE id=? AND role='admin'", [$_SESSION['admin_uid']])->fetch();
  if (!$ok) { unset($_SESSION['admin_token'], $_SESSION['admin_uid'], $_SESSION['admin_seen']); return [403, ['error' => 'Admin session expired']]; }
  $_SESSION['admin_seen'] = time(); return null;
}
function admin_gate_route(string $m, string $p, array $b): array {
  $code = defined('ADMIN_GATE_CODE') ? (string)ADMIN_GATE_CODE : '';
  if (preg_match('#^admin-gate/check/(.+)$#', $p, $x)) return $code !== '' && hash_equals($code, rawurldecode($x[1])) ? [200, ['ok' => true]] : [404, ['error' => 'Not found']];
  if ($p === 'admin-gate/verify' && $m === 'POST') {
    $k = 'g:' . ($_SERVER['REMOTE_ADDR'] ?? ''); if (throttled($k)) return [429, ['error' => 'Too many attempts. Try again in 15 minutes.']];
    $un = (string)($b['username'] ?? ''); $u = q("SELECT id,password_hash FROM users WHERE (email=? OR name=?) AND role='admin' LIMIT 1", [strtolower($un), $un])->fetch();
    $good = $code !== '' && hash_equals($code, (string)($b['code'] ?? '')) && $u && password_verify((string)($b['password'] ?? ''), $u['password_hash']);
    if (!$good) { record_fail($k); return [401, ['error' => 'Invalid credentials']]; }
    session_regenerate_id(true); $_SESSION['admin_uid'] = (int)$u['id']; $_SESSION['admin_seen'] = time(); $_SESSION['admin_token'] = bin2hex(random_bytes(16));
    return [200, ['adminToken' => $_SESSION['admin_token']]];
  }
  return [404, ['error' => 'Not found']];
}
function admin_resources(): array { static $R; return $R ??= [
  'users' => ['t' => 'users', 'sql' => 'SELECT id,name,email,phone,role,level,status,preferred_category,email_verified_at,phone_verified_at FROM users ORDER BY id DESC',
    'w' => ['name','email','phone','role','level','status','preferred_category'], 'null' => ['phone','level','preferred_category'], 'img' => ['avatar' => ['avatar','data']]],
  'trainers' => ['t' => 'trainers', 'sql' => 'SELECT id,name,specialty,bio FROM trainers ORDER BY name', 'w' => ['name','specialty','bio'], 'null' => ['specialty','bio'], 'img' => ['avatar' => ['avatar','data']]],
  'classes' => ['t' => 'classes', 'sql' => "SELECT c.*,t.name trainer_name,GREATEST(c.capacity-(SELECT COUNT(*) FROM bookings b WHERE b.class_id=c.id AND b.status='booked'),0) spots_left FROM classes c JOIN trainers t ON t.id=c.trainer_id ORDER BY c.starts_at DESC",
    'w' => ['name','trainer_id','category','level','location','starts_at','ends_at','capacity'], 'null' => ['category','level','location'], 'int' => ['trainer_id','capacity'], 'dt' => ['starts_at','ends_at']],
  'class-categories' => ['t' => 'class_categories', 'sql' => 'SELECT * FROM class_categories ORDER BY sort_order,name', 'w' => ['name','is_active','sort_order'], 'int' => ['sort_order'], 'bool' => ['is_active']],
  'plans' => ['t' => 'membership_plans', 'sql' => 'SELECT * FROM membership_plans ORDER BY category,price', 'w' => ['name','price','classes_per_month','duration_months','category','is_active'],
    'null' => ['classes_per_month','category'], 'int' => ['classes_per_month','duration_months'], 'bool' => ['is_active']],
  'memberships' => ['t' => 'memberships', 'sql' => 'SELECT m.*,u.name user_name,p.name plan_name FROM memberships m JOIN users u ON u.id=m.user_id JOIN membership_plans p ON p.id=m.plan_id ORDER BY m.id DESC',
    'w' => ['status','plan_id','classes_used_this_month','started_at','renews_at'], 'null' => ['started_at','renews_at'], 'int' => ['plan_id','classes_used_this_month'], 'noadd' => 1],
  'bookings' => ['t' => 'bookings', 'sql' => 'SELECT b.id,u.name user_name,c.name class_name,c.starts_at,b.status FROM bookings b JOIN users u ON u.id=b.user_id JOIN classes c ON c.id=b.class_id ORDER BY c.starts_at DESC', 'w' => ['status'], 'noadd' => 1],
  'workouts' => ['t' => 'workouts', 'sql' => 'SELECT w.*,u.name user_name FROM workouts w JOIN users u ON u.id=w.user_id ORDER BY w.performed_at DESC', 'w' => ['user_id','class_id','type','duration_minutes','calories_burned','performed_at'],
    'null' => ['class_id','type','duration_minutes','calories_burned'], 'int' => ['user_id','class_id','duration_minutes','calories_burned']],
  'diet-logs' => ['t' => 'diet_logs', 'sql' => 'SELECT d.*,u.name user_name FROM diet_logs d JOIN users u ON u.id=d.user_id ORDER BY d.logged_at DESC', 'w' => ['user_id','meal_type','description','calories','logged_at'],
    'null' => ['description','calories'], 'int' => ['user_id','calories']],
  'products' => ['t' => 'products', 'sql' => 'SELECT id,name,category,description,price,stock,is_active FROM products ORDER BY id DESC', 'w' => ['name','category','description','price','stock','is_active'],
    'null' => ['category','description'], 'int' => ['stock'], 'bool' => ['is_active'], 'img' => ['image' => ['image_url','data']]],
  'posters' => ['t' => 'posters', 'sql' => 'SELECT id,username,location,text,created_at FROM posters ORDER BY created_at DESC', 'w' => ['username','location','text'], 'null' => ['location'], 'img' => ['image' => ['image_url','file']]],
  'notifications' => ['t' => 'notifications', 'sql' => 'SELECT * FROM notifications ORDER BY created_at DESC LIMIT 500', 'w' => ['user_id','message','is_read'], 'int' => ['user_id'], 'bool' => ['is_read']],
]; }
function admin_image(string $f, string $mode): ?string {
  if (empty($_FILES[$f]) || $_FILES[$f]['error'] !== UPLOAD_ERR_OK) return null;
  $t = $_FILES[$f]['tmp_name']; $mime = mime_content_type($t); $ext = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/gif' => 'gif', 'image/webp' => 'webp'][$mime] ?? null;
  if (!$ext || $_FILES[$f]['size'] > 3 * 1024 * 1024) throw new RuntimeException('Image must be JPG/PNG/GIF/WEBP under 3MB');
  if ($mode === 'data') return 'data:' . $mime . ';base64,' . base64_encode(file_get_contents($t));
  $dir = dirname(__DIR__) . '/uploads';
  if (!is_dir($dir)) { mkdir($dir, 0755, true); file_put_contents("$dir/.htaccess", "<FilesMatch \"\\.php\$\">\nRequire all denied\n</FilesMatch>\n"); }
  $n = bin2hex(random_bytes(10)) . '.' . $ext; if (!move_uploaded_file($t, "$dir/$n")) throw new RuntimeException('Upload failed'); return BASE . '/uploads/' . $n;
}
function admin_write(string $res, array $R, ?int $id, array $b): array {
  $set = [];
  foreach ($R['w'] as $k) {
    if (!array_key_exists($k, $b) || !is_scalar($b[$k]) && $b[$k] !== null) continue; $v = $b[$k];
    if (in_array($k, $R['bool'] ?? [], true)) $v = $v ? 1 : 0;
    elseif ($v === '' || $v === null) { if (in_array($k, $R['null'] ?? [], true)) $v = null; else continue; }
    elseif (in_array($k, $R['int'] ?? [], true)) $v = (int)$v;
    elseif (in_array($k, $R['dt'] ?? [], true)) { $v = str_replace('T', ' ', (string)$v); if (strlen($v) === 16) $v .= ':00'; }
    $set[$k] = is_string($v) ? trim($v) : $v;
  }
  foreach ($R['img'] ?? [] as $f => [$col, $mode]) if (($img = admin_image($f, $mode)) !== null) $set[$col] = $img;
  if ($res === 'users') {
    if (isset($set['email'])) { $set['email'] = strtolower($set['email']); if (!filter_var($set['email'], FILTER_VALIDATE_EMAIL)) return [400, ['error' => 'Invalid email']]; }
    if (!$id) { if (empty($set['name']) || empty($set['email'])) return [400, ['error' => 'Name and email are required']]; $set['password_hash'] = password_hash(bin2hex(random_bytes(12)), PASSWORD_DEFAULT); }
  }
  if (!$set) return [400, ['error' => 'Nothing to save']];
  $cols = implode(',', array_map(fn($k) => "`$k`", array_keys($set)));
  if ($id) { q("UPDATE `{$R['t']}` SET " . implode(',', array_map(fn($k) => "`$k`=?", array_keys($set))) . ' WHERE id=?', [...array_values($set), $id]); return [200, ['id' => $id]]; }
  q("INSERT INTO `{$R['t']}`($cols) VALUES(" . implode(',', array_fill(0, count($set), '?')) . ')', array_values($set)); return [201, ['id' => (int)db()->lastInsertId()]];
}
function admin_route(string $m, string $p, array $b, array $qs): array {
  $E = fn($c, $msg) => [$c, ['error' => $msg]];
  try {
    if ($p === 'stats') return [200, [
      'users' => (int)q('SELECT COUNT(*) FROM users')->fetchColumn(), 'trainers' => (int)q('SELECT COUNT(*) FROM trainers')->fetchColumn(),
      'upcoming_classes' => (int)q('SELECT COUNT(*) FROM classes WHERE starts_at>NOW()')->fetchColumn(),
      'active_memberships' => (int)q("SELECT COUNT(*) FROM memberships WHERE status='active'")->fetchColumn(),
      'bookings_today' => (int)q("SELECT COUNT(*) FROM bookings b JOIN classes c ON c.id=b.class_id WHERE DATE(c.starts_at)=CURDATE() AND b.status='booked'")->fetchColumn()]];
    if ($p === 'pending-approvals') return [200, q("SELECT u.id,u.name,u.email,u.phone,u.preferred_category,u.created_at requested_at,p.name plan_name,p.duration_months,p.price FROM users u
      LEFT JOIN memberships m ON m.id=(SELECT MAX(id) FROM memberships WHERE user_id=u.id) LEFT JOIN membership_plans p ON p.id=m.plan_id WHERE u.status='pending_approval' ORDER BY u.created_at")->fetchAll()];
    if (preg_match('#^users/(\d+)/(approve|reject)$#', $p, $x) && $m === 'POST') {
      $id = (int)$x[1];
      if ($x[2] === 'approve') {
        q("UPDATE users SET status='approved' WHERE id=? AND status='pending_approval'", [$id]);
        q("UPDATE memberships m JOIN membership_plans p ON p.id=m.plan_id SET m.status='active',m.started_at=CURDATE(),m.renews_at=DATE_ADD(CURDATE(),INTERVAL p.duration_months MONTH) WHERE m.user_id=? AND m.status='pending'", [$id]);
        q('INSERT INTO notifications(user_id,message) VALUES(?,?)', [$id, 'Your account has been approved. Welcome to EOS!']);
      } else { q("DELETE FROM users WHERE id=? AND status='pending_approval'", [$id]); } // rejected = account deleted (memberships etc. cascade); the person can register again
      return [200, ['ok' => true]];
    }
    if (!preg_match('#^([a-z-]+)(?:/(\d+))?$#', $p, $x) || !isset(admin_resources()[$x[1]])) return $E(404, 'Not found');
    $res = $x[1]; $id = isset($x[2]) ? (int)$x[2] : null; $R = admin_resources()[$res];
    if ($m === 'GET') return [200, q($R['sql'])->fetchAll()];
    if ($m === 'POST' && !$id) return !empty($R['noadd']) ? $E(400, 'Cannot be added from here') : admin_write($res, $R, null, $b);
    if ($m === 'PUT' && $id) return admin_write($res, $R, $id, $b);
    if ($m === 'DELETE' && $id) { q("DELETE FROM `{$R['t']}` WHERE id=?", [$id]); return [200, ['ok' => true]]; }
    return $E(405, 'Method not allowed');
  } catch (PDOException $e) {
    $c = $e->errorInfo[1] ?? 0;
    if ($c == 1451) return $E(409, 'Cannot delete: it is still used by other records');
    if ($c == 1062) return $E(409, 'Duplicate value (already exists)');
    if ($c == 1452) return $E(400, 'Invalid reference: that user/trainer/plan id does not exist');
    if (in_array($c, [1048, 1364, 1292, 1265, 1366], true)) return $E(400, 'Invalid or missing value');
    throw $e;
  } catch (RuntimeException $e) { return $E(400, $e->getMessage()); }
}