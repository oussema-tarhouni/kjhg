<?php
// Local (PHP + MySQL) API layer: api_request() now runs against MySQL instead of calling a Node API.
require_once __DIR__ . '/local_api.php';
function require_auth(): void { if (!empty($_SESSION['uid'])) return; redirect('login'); }
function require_admin(): void { if (empty($_SESSION['admin_token']) || empty($_SESSION['admin_uid'])) redirect(''); }
