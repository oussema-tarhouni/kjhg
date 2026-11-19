<?php require 'eos_config.php';
$err='';
if($_SERVER['REQUEST_METHOD']==='POST'){
 try{$s=db()->prepare('SELECT * FROM users WHERE email=?');$s->execute([strtolower(trim($_POST['email']??''))]);$u=$s->fetch();}catch(PDOException $x){$u=null;$dberr='DB error: '.$x->getMessage();}
 if(isset($dberr))$err=$dberr;
 elseif(!csrf_ok())$err='Invalid request';
 elseif(!$u||!password_verify($_POST['password']??'',$u['password_hash']))$err='Wrong email or password';
 elseif($u['status']==='rejected')$err='Account rejected';
 else{session_regenerate_id(true);$_SESSION['uid']=$u['id'];header('Location: dashboard.php');exit;}
}?>
<!doctype html><meta charset=utf-8><title>Login</title>
<h1>Login</h1><?php if(isset($_GET['registered']))echo '<p style=color:green>Registered, please log in.</p>'; if($err)echo '<p style=color:red>'.h($err).'</p>'?>
<form method=post><input type=hidden name=csrf value="<?=csrf()?>">
<p><input type=email name=email placeholder=Email required>
<p><input type=password name=password placeholder=Password required>
<p><button>Login</button></form><a href=register.php>Register</a>