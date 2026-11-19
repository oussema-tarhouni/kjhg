<?php require 'eos_config.php'; $u=require_login();
if($_SERVER['REQUEST_METHOD']!=='POST'||!csrf_ok())exit('Bad request');
$a=$_POST['a']??'';$id=(int)($_POST['id']??0);$d=db();
if($a==='book'){ // capacity check + upsert
 $d->beginTransaction();
 $c=$d->prepare('SELECT capacity FROM classes WHERE id=? AND starts_at>NOW() FOR UPDATE');$c->execute([$id]);$cap=$c->fetchColumn();
 $n=$d->prepare("SELECT COUNT(*) FROM bookings WHERE class_id=? AND status='booked'");$n->execute([$id]);
 if($cap!==false&&$n->fetchColumn()<$cap)
  $d->prepare("INSERT INTO bookings(user_id,class_id) VALUES(?,?) ON DUPLICATE KEY UPDATE status='booked'")->execute([$u['id'],$id]);
 $d->commit();
}elseif($a==='cancel')$d->prepare("UPDATE bookings SET status='cancelled' WHERE user_id=? AND class_id=?")->execute([$u['id'],$id]);
elseif($a==='read')$d->prepare('UPDATE notifications SET is_read=1 WHERE user_id=?')->execute([$u['id']]);
header('Location: dashboard.php');
