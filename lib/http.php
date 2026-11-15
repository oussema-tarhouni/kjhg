<?php
// Server-side client for the Node API. The access token and refresh cookie live only in the PHP session.
function api_request(string $method, string $path, $body = null, array $opt = []): array {
  $path = ltrim($path, '/');
  $url = API_BASE . '/' . $path . (!empty($opt['query']) ? '?' . $opt['query'] : '');
  $h = ['Accept: application/json'];
  if (!empty($_SESSION['token'])) $h[] = 'Authorization: Bearer ' . $_SESSION['token'];
  if (str_starts_with($path, 'admin') && !empty($_SESSION['admin_token'])) $h[] = 'X-Admin-Session: ' . $_SESSION['admin_token'];
  if (!empty($_SESSION['refresh']) && preg_match('#^auth/(refresh|logout)#', $path)) $h[] = 'Cookie: refresh_token=' . $_SESSION['refresh'];
  $ch = curl_init($url);
  curl_setopt_array($ch, [CURLOPT_CUSTOMREQUEST => $method, CURLOPT_RETURNTRANSFER => true, CURLOPT_TIMEOUT => 30,
    CURLOPT_HEADERFUNCTION => function ($c, $line) {
      if (stripos($line, 'set-cookie:') === 0 && preg_match('/refresh_token=([^;]*)/i', $line, $m)) $_SESSION['refresh'] = $m[1];
      return strlen($line);
    }]);
  if ($body !== null && $method !== 'GET') {
    if (is_array($body) && !empty($opt['multipart'])) curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
    elseif (is_string($body)) { curl_setopt($ch, CURLOPT_POSTFIELDS, $body); if (!empty($opt['ctype'])) $h[] = 'Content-Type: ' . $opt['ctype']; }
    else { curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body)); $h[] = 'Content-Type: application/json'; }
  }
  curl_setopt($ch, CURLOPT_HTTPHEADER, $h);
  $raw = curl_exec($ch);
  $status = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
  $err = curl_error($ch); curl_close($ch);
  if ($raw === false) return ['status' => 502, 'data' => ['error' => 'API unreachable: ' . $err], 'raw' => ''];
  $data = json_decode($raw, true);
  if ($status === 401 && empty($opt['retried']) && !empty($_SESSION['refresh']) && !preg_match('#^auth/(login|register|refresh)#', $path)) {
    if (api_refresh()) return api_request($method, $path, $body, $opt + ['retried' => 1]);
  }
  if ($status < 300 && is_array($data) && !empty($data['token']) && preg_match('#^auth/(login|register|refresh)#', $path)) $_SESSION['token'] = $data['token'];
  return ['status' => $status, 'data' => $data, 'raw' => $raw];
}
function api_refresh(): bool {
  $r = api_request('POST', 'auth/refresh', [], ['retried' => 1]);
  if ($r['status'] < 300 && !empty($r['data']['token'])) return true;
  unset($_SESSION['token']); return false;
}
function api_error(array $r, string $fallback): string { return is_array($r['data']) && !empty($r['data']['error']) ? (string)$r['data']['error'] : $fallback; }
function require_auth(): void { // = Angular authGuard
  if (!empty($_SESSION['token'])) return;
  if (!empty($_SESSION['refresh']) && api_refresh()) return;
  redirect('login');
}
function require_admin(): void { if (empty($_SESSION['admin_token'])) redirect(''); }
