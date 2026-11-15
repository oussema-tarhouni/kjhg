<?php
$norm = fn($v) => strtolower(trim((string)($v ?? '')));
$categories = json_decode(file_get_contents(__DIR__ . '/../data/plan_catalog.json'), true);
$error = '';
$r = api_request('GET', 'auth/plans');
$active = [];
if ($r['status'] < 300 && is_array($r['data'])) $active = array_values(array_filter($r['data'], fn($p) => !isset($p['is_active']) || (int)$p['is_active'] === 1));
else $error = 'Could not load plans, please try again';
// match each catalog tier to a real plan: by code, then by category + price
foreach ($categories as &$cat) foreach ($cat['groups'] as &$g) foreach ($g['tiers'] as &$t) {
  $t['planId'] = null;
  foreach ($active as $p) if (isset($p['code']) && (int)$p['code'] === $t['key']) { $t['planId'] = $p['id']; break; }
  if ($t['planId'] === null) foreach ($active as $p) if ((float)$p['price'] === (float)$t['price'] && $norm($p['category'] ?? '') === $norm($cat['key'])) { $t['planId'] = $p['id']; break; }
}
unset($cat, $g, $t);
// categories added by the admin -> one extra tab each
$known = array_map(fn($c) => $norm($c['key']), $categories); $extra = [];
foreach ($active as $p) { $cn = trim((string)($p['category'] ?? '')); if ($cn === '' || in_array($norm($cn), $known, true)) continue;
  $extra[$cn][] = ['key' => 1000 + (int)$p['id'], 'planId' => $p['id'], 'label' => $p['name'], 'price' => (float)$p['price']]; }
foreach ($extra as $cn => $tiers) { usort($tiers, fn($a, $b) => $a['price'] <=> $b['price']); $categories[] = ['key' => $cn, 'label' => $cn, 'groups' => [['title' => strtoupper($cn), 'tiers' => $tiers]]]; }
$wanted = $_POST['category'] ?? $_GET['cat'] ?? ($_SESSION['signup_category'] ?? $categories[0]['key']);
$activeCat = $categories[0];
foreach ($categories as $c) if ($c['key'] === $wanted) $activeCat = $c;
$selected = (int)($_POST['planId'] ?? 0);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $valid = false;
  foreach ($activeCat['groups'] as $g) foreach ($g['tiers'] as $t) if ($t['planId'] && (int)$t['planId'] === $selected) $valid = true;
  if (!$selected) $error = 'Please select a plan';
  elseif (!$valid) $error = 'This plan is not available right now';
  else {
    $s = api_request('POST', 'auth/subscription', ['category' => $activeCat['key'], 'planId' => $selected]);
    if ($s['status'] < 300) { unset($_SESSION['signup_category']); redirect('pending'); }
    $error = api_error($s, 'Something went wrong, please try again');
  }
}
layout_begin('Choose your plan · EOS Gym', ['auth-shared', 'plan']);
include __DIR__ . '/../views/plan.php';
theme_script(); layout_end();
