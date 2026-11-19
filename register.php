<?php require 'eos_config.php';
$err='';
if($_SERVER['REQUEST_METHOD']==='POST'){
 $n=trim($_POST['name']??'');$e=strtolower(trim($_POST['email']??''));$ph=trim($_POST['phone']??'')?:null;$pw=$_POST['password']??'';
 if(!csrf_ok())$err='Invalid request';
 elseif($n===''||!filter_var($e,FILTER_VALIDATE_EMAIL))$err='Name and valid email required';
 elseif(strlen($pw)<8)$err='Password must be at least 8 characters';
 else try{
  db()->prepare('INSERT INTO users(name,email,phone,password_hash) VALUES(?,?,?,?)')->execute([$n,$e,$ph,password_hash($pw,PASSWORD_DEFAULT)]);
  header('Location: login.php?registered=1');exit;
 }catch(PDOException $x){ $err=$x->errorInfo[1]==1062?'Email or phone already used':'DB error: '.$x->getMessage(); }
}?>
<!doctype html><meta charset=utf-8><title>Register</title>
<h1>Register</h1><?php if($err)echo '<p style=color:red>'.h($err).'</p>'?>
<form method=post><input type=hidden name=csrf value="<?=csrf()?>">
<p><input name=name placeholder=Name required value="<?=h($_POST['name']??'')?>">
<p><input type=email name=email placeholder=Email required value="<?=h($_POST['email']??'')?>">
<p><input name=phone placeholder="Phone (optional)">
<p><input type=password name=password placeholder="Password (8+)" required>
<p><button>Create account</button></form><a href=login.php>Login</a>