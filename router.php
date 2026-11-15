<?php // dev server: php -S localhost:8000 router.php
$f = __DIR__ . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
if (is_file($f) && !preg_match('/\.php$/', $f)) return false;
require __DIR__ . '/index.php';
