<?php
require_admin();
$defs = json_decode(file_get_contents(__DIR__ . '/../data/admin_defs.json'), true);
$bySlug = []; foreach ($defs as $d) $bySlug[$d['key']] = $d;
$section = $_GET['s'] ?? 'resource';
$rk = $_GET['r'] ?? 'users';
if (!isset($bySlug[$rk])) $rk = 'users';
$self = url('access-admin');
$error = ''; $info = '';
$adm = fn(string $m, string $p, $b = null, array $o = []) => api_request($m, 'admin/' . $p, $b, $o);

// category dropdowns come from the class-categories table
$catNames = DEFAULT_CATEGORIES;
$cr = $adm('GET', 'class-categories');
if ($cr['status'] < 300 && is_array($cr['data'])) $catNames = array_values(array_map(fn($c) => $c['name'], array_filter($cr['data'], fn($c) => !isset($c['is_active']) || ($c['is_active'] !== 0 && $c['is_active'] !== false))));
foreach ($defs as &$d) foreach ($d['fields'] as &$f) {
  if (($d['key'] === 'users' && $f['key'] === 'preferred_category') || ($d['key'] === 'classes' && $f['key'] === 'category')) $f['options'] = array_merge([''], $catNames);
  elseif ($d['key'] === 'plans' && $f['key'] === 'category') $f['options'] = $catNames;
}
unset($d, $f);
foreach ($defs as $d) $bySlug[$d['key']] = $d;
$active = $bySlug[$rk];

// ---------- actions (POST -> redirect) ----------
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $act = $_POST['action'] ?? ''; $back = $self . '?r=' . urlencode($rk);
  if ($act === 'save' || $act === 'delete') {
    $id = (int)($_POST['id'] ?? 0); $files = false; $payload = [];
    if ($act === 'save') {
      foreach ($active['fields'] as $f) {
        $t = $f['type'] ?? 'text'; $k = $f['key'];
        if ($t === 'image') { if (!empty($_FILES[$k]['tmp_name']) && $_FILES[$k]['error'] === UPLOAD_ERR_OK) { $payload[$k] = new CURLFile($_FILES[$k]['tmp_name'], $_FILES[$k]['type'], $_FILES[$k]['name']); $files = true; } }
        elseif ($t === 'checkbox') $payload[$k] = isset($_POST[$k]) ? 1 : 0;
        elseif (isset($_POST[$k])) $payload[$k] = $_POST[$k];
      }
      $r = $id ? $adm('PUT', "$rk/$id", $payload, ['multipart' => $files]) : $adm('POST', $rk, $payload, ['multipart' => $files]);
      if ($r['status'] < 300) redirect($back);
      $error = api_error($r, 'Save failed'); $_GET['edit'] = $id ?: null; $_GET['new'] = $id ? null : 1; $posted = $_POST;
    } else {
      $r = $adm('DELETE', "$rk/$id");
      if ($r['status'] < 300) redirect($back);
      $error = api_error($r, 'Delete failed');
    }
  } elseif ($act === 'approve' || $act === 'reject') {
    $r = $adm('POST', 'users/' . (int)$_POST['id'] . '/' . $act, []);
    if ($r['status'] < 300) redirect($self . '?s=approvals');
    $error = api_error($r, ucfirst($act) . ' failed'); $section = 'approvals';
  } elseif ($act === 'send_notification') {
    $section = 'send'; $msg = trim($_POST['message'] ?? '');
    $ur = $adm('GET', 'users'); $users = array_values(array_filter($ur['data'] ?? [], fn($u) => ($u['role'] ?? '') !== 'admin'));
    $ids = ($_POST['audience'] ?? 'all') === 'all' ? array_column($users, 'id') : array_map('intval', $_POST['users'] ?? []);
    if ($msg === '') $error = 'Message is required'; elseif (!$ids) $error = 'No recipients selected';
    else { $ok = 0; foreach ($ids as $uid) { $r = $adm('POST', 'notifications', ['user_id' => $uid, 'message' => $msg]); if ($r['status'] < 300) $ok++; }
      $info = "Sent to $ok user(s)."; if ($ok < count($ids)) $error = 'Some notifications failed'; }
  }
}

// ---------- data for the current view ----------
$stats = $adm('GET', 'stats')['data'] ?? null;
$rows = []; $loadErr = '';
if ($section === 'resource') { $r = $adm('GET', $rk); if ($r['status'] < 300 && is_array($r['data'])) $rows = $r['data']; else $loadErr = api_error($r, 'Failed to load data'); }
$pending = []; $notifUsers = [];
if ($section === 'approvals') { $r = $adm('GET', 'pending-approvals'); if ($r['status'] < 300) $pending = $r['data'] ?? []; else $loadErr = api_error($r, 'Failed to load pending approvals'); }
if ($section === 'send') { $r = $adm('GET', 'users'); $notifUsers = array_values(array_filter($r['data'] ?? [], fn($u) => ($u['role'] ?? '') !== 'admin')); }
$editRow = null; $showForm = false; $editingId = (int)($_GET['edit'] ?? 0);
if ($section === 'resource' && ($editingId || !empty($_GET['new']))) {
  $showForm = true;
  if ($editingId) foreach ($rows as $row) if ((int)$row['id'] === $editingId) $editRow = $row;
  if (isset($posted)) $editRow = array_merge($editRow ?? [], $posted);
  foreach ($active['fields'] as $f) if ($editRow && !empty($editRow[$f['key']]) && is_string($editRow[$f['key']])) {
    if (($f['type'] ?? '') === 'date') $editRow[$f['key']] = substr($editRow[$f['key']], 0, 10);
    if (($f['type'] ?? '') === 'datetime-local') $editRow[$f['key']] = substr(str_replace(' ', 'T', $editRow[$f['key']]), 0, 16);
  }
}
$cell = fn($v) => h(is_array($v) ? json_encode($v) : $v);
$singular = substr($active['title'], 0, -1);
layout_begin('Admin · EOS Gym', ['admin']);
?>
<div class="adm-shell">
  <aside class="adm-nav">
    <h2>Admin</h2>
    <a href="<?= url('app') ?>" class="adm-back-link">← Back to app</a>
    <nav>
      <?php foreach ($defs as $d): ?>
        <a class="adm-nav-btn<?= $d['key'] === $rk && $section === 'resource' ? ' adm-active' : '' ?>" href="<?= $self ?>?r=<?= h($d['key']) ?>" style="display:block;text-decoration:none"><?= h($d['title']) ?></a>
      <?php endforeach; ?>
      <a class="adm-nav-btn<?= $section === 'approvals' ? ' adm-active' : '' ?>" href="<?= $self ?>?s=approvals" style="display:block;text-decoration:none">Approvals</a>
      <a class="adm-nav-btn<?= $section === 'send' ? ' adm-active' : '' ?>" href="<?= $self ?>?s=send" style="display:block;text-decoration:none">Send Notification</a>
    </nav>
    <?php if ($stats): ?><div class="adm-stats">
      <div>Users: <?= h($stats['users'] ?? '') ?></div><div>Trainers: <?= h($stats['trainers'] ?? '') ?></div>
      <div>Upcoming classes: <?= h($stats['upcoming_classes'] ?? '') ?></div><div>Active memberships: <?= h($stats['active_memberships'] ?? '') ?></div>
      <div>Bookings today: <?= h($stats['bookings_today'] ?? '') ?></div>
    </div><?php endif; ?>
  </aside>
  <main class="adm-main">
    <?php if ($section === 'resource'): ?>
      <div class="adm-header"><h1><?= h($active['title']) ?></h1><a class="adm-btn-primary" style="text-decoration:none" href="<?= $self ?>?r=<?= h($rk) ?>&new=1">+ Add</a></div>
    <?php endif; ?>
    <?php if ($error || $loadErr): ?><p class="adm-error"><?= h($error ?: $loadErr) ?></p><?php endif; ?>

    <?php if ($section === 'resource'): ?>
      <?php if ($rows): ?>
      <table class="adm-table"><thead><tr><?php foreach ($active['columns'] as $c): ?><th><?= h($c) ?></th><?php endforeach; ?><th></th></tr></thead><tbody>
        <?php foreach ($rows as $row): ?><tr>
          <?php foreach ($active['columns'] as $c): ?><td><?= $cell($row[$c] ?? '') ?></td><?php endforeach; ?>
          <td class="adm-row-actions">
            <a href="<?= $self ?>?r=<?= h($rk) ?>&edit=<?= (int)$row['id'] ?>"><button type="button">Edit</button></a>
            <form method="post" style="display:inline" onsubmit="return confirm('Delete this <?= h($singular) ?>?')">
              <input type="hidden" name="action" value="delete"><input type="hidden" name="id" value="<?= (int)$row['id'] ?>">
              <button class="adm-btn-danger">Delete</button></form>
          </td></tr><?php endforeach; ?>
      </tbody></table>
      <?php elseif (!$loadErr): ?><p>No records.</p><?php endif; ?>

    <?php elseif ($section === 'send'): ?>
      <div class="adm-header"><h1>Send Notification</h1></div>
      <form method="post" class="adm-send"><input type="hidden" name="action" value="send_notification">
        <label>Message<textarea name="message" rows="3" maxlength="500"><?= h($_POST['message'] ?? '') ?></textarea></label>
        <div class="adm-send-audience">
          <?php $aud = $_POST['audience'] ?? 'all'; ?>
          <label><input type="radio" name="audience" value="all" <?= $aud === 'all' ? 'checked' : '' ?> onclick="document.getElementById('nl').style.display='none'"> All users (<?= count($notifUsers) ?>)</label>
          <label><input type="radio" name="audience" value="selected" <?= $aud === 'selected' ? 'checked' : '' ?> onclick="document.getElementById('nl').style.display='block'"> Selected users</label>
        </div>
        <div class="adm-send-list" id="nl" style="display:<?= $aud === 'selected' ? 'block' : 'none' ?>">
          <?php foreach ($notifUsers as $u): ?><label><input type="checkbox" name="users[]" value="<?= (int)$u['id'] ?>"> <?= h($u['name']) ?> — <?= h($u['email']) ?></label><?php endforeach; ?>
        </div>
        <?php if ($info): ?><p><?= h($info) ?></p><?php endif; ?>
        <button class="adm-btn-primary">Send</button>
      </form>

    <?php elseif ($section === 'approvals'): ?>
      <div class="adm-header"><h1>Pending Approvals</h1></div>
      <?php if ($pending): ?>
      <table class="adm-table"><thead><tr><th>Name</th><th>Email</th><th>Phone</th><th>Category</th><th>Plan</th><th>Price</th><th>Requested</th><th></th></tr></thead><tbody>
        <?php foreach ($pending as $row): ?><tr>
          <td><?= h($row['name']) ?></td><td><?= h($row['email']) ?></td><td><?= h($row['phone'] ?? '') ?></td><td><?= h($row['preferred_category'] ?? '') ?></td>
          <td><?= h($row['plan_name'] ?? '') ?> (<?= h($row['duration_months'] ?? '') ?> mo)</td><td><?= h($row['price'] ?? '') ?> TND</td>
          <td><?= !empty($row['requested_at']) ? h(date('n/j/y, g:i A', strtotime($row['requested_at']))) : '' ?></td>
          <td class="adm-row-actions"><form method="post" style="display:inline"><input type="hidden" name="id" value="<?= (int)$row['id'] ?>">
            <button name="action" value="approve" class="adm-btn-success">Approve</button>
            <button name="action" value="reject" class="adm-btn-danger" onclick="return confirm('Reject this account request?')">Reject</button></form></td></tr><?php endforeach; ?>
      </tbody></table>
      <?php else: ?><p>No pending requests.</p><?php endif; ?>
    <?php endif; ?>
  </main>

  <?php if ($showForm): ?>
  <div class="adm-modal-backdrop"><div class="adm-modal">
    <h3><?= $editingId ? 'Edit' : 'Add' ?> <?= h($singular) ?></h3>
    <form method="post" enctype="multipart/form-data">
      <input type="hidden" name="action" value="save"><input type="hidden" name="id" value="<?= $editingId ?>">
      <?php foreach ($active['fields'] as $f): $t = $f['type'] ?? 'text'; $k = $f['key']; $v = $editRow[$k] ?? ''; ?>
        <label><?= h($f['label']) ?>
          <?php if ($t === 'select'): ?>
            <select name="<?= h($k) ?>"><?php foreach ($f['options'] ?? [] as $o): ?><option value="<?= h($o) ?>" <?= (string)$o === (string)$v ? 'selected' : '' ?>><?= h($o) ?></option><?php endforeach; ?></select>
          <?php elseif ($t === 'checkbox'): ?>
            <input type="checkbox" name="<?= h($k) ?>" value="1" <?= $v && $v !== '0' ? 'checked' : '' ?>>
          <?php elseif ($t === 'textarea'): ?>
            <textarea name="<?= h($k) ?>" rows="3"><?= h($v) ?></textarea>
          <?php elseif ($t === 'image'): ?>
            <?php if (!empty($editRow[$k . '_url'])): ?><img src="<?= h($editRow[$k . '_url']) ?>" class="adm-file-preview"><?php endif; ?>
            <input type="file" accept="image/*" name="<?= h($k) ?>">
          <?php else: ?>
            <input type="<?= h($t) ?>" name="<?= h($k) ?>" value="<?= h($v) ?>">
          <?php endif; ?>
        </label>
      <?php endforeach; ?>
      <div class="adm-modal-actions">
        <a href="<?= $self ?>?r=<?= h($rk) ?>" class="adm-btn-secondary" style="text-decoration:none">Cancel</a>
        <button type="submit" class="adm-btn-primary">Save</button>
      </div>
    </form>
  </div></div>
  <?php endif; ?>
</div>
<?php layout_end(); ?>
