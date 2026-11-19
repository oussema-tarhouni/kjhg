<?php
const DB_HOST='', DB_NAME='eos', DB_USER='root', DB_PASS='';
session_start();
function db(): PDO { static $p; return $p ??= new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=utf8mb4',DB_USER,DB_PASS,[PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC]); }
if(!function_exists('h')){function h($s){ return htmlspecialchars((string)$s,ENT_QUOTES); }}
function csrf(){ return $_SESSION['csrf'] ??= bin2hex(random_bytes(16)); }
function csrf_ok(){ return hash_equals($_SESSION['csrf']??'', $_POST['csrf']??''); }
function user(){ if(empty($_SESSION['uid'])) return null; $s=db()->prepare('SELECT id,name,email,phone,role,level,status FROM users WHERE id=?'); $s->execute([$_SESSION['uid']]); return $s->fetch()?:null; }
function require_login(){ $u=user(); if(!$u){header('Location: login.php');exit;} return $u; }
function require_admin(){ $u=require_login(); if($u['role']!=='admin'){http_response_code(403);exit('Forbidden');} return $u; }
