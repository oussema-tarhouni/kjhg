<?php require 'eos_config.php'; $u=require_login(); $d=db();
function q($sql,$p){global $d;$s=$d->prepare($sql);$s->execute($p);return $s->fetchAll();}
$classes=q("SELECT c.*,t.name trainer,(SELECT COUNT(*) FROM bookings b WHERE b.class_id=c.id AND b.status='booked') taken,
 (SELECT status FROM bookings b WHERE b.class_id=c.id AND b.user_id=?) mine FROM classes c JOIN trainers t ON t.id=c.trainer_id WHERE c.starts_at>NOW() ORDER BY c.starts_at LIMIT 50",[$u['id']]);
$mem=q("SELECT m.*,p.name plan FROM memberships m JOIN membership_plans p ON p.id=m.plan_id WHERE m.user_id=? ORDER BY m.id DESC",[$u['id']]);
$notes=q("SELECT * FROM notifications WHERE user_id=? ORDER BY id DESC LIMIT 10",[$u['id']]);
function f($a,$id,$l){return '<form method=post action=action.php style=display:inline><input type=hidden name=csrf value="'.csrf().'"><input type=hidden name=a value='.$a.'><input type=hidden name=id value='.$id.'><button>'.$l.'</button></form>';}
?><!doctype html><meta charset=utf-8><title>Dashboard</title>
<h1>Hi <?=h($u['name'])?> (<?=h($u['level'])?>, <?=h($u['status'])?>)</h1><a href=logout.php>Logout</a>
<h2>Membership</h2><?php foreach($mem as $m)echo '<p>'.h($m['plan']).' – '.h($m['status']).'</p>'; if(!$mem)echo '<p>None</p>'?>
<h2>Notifications</h2><?php foreach($notes as $n)echo '<p>'.($n['is_read']?'':'• ').h($n['message']).'</p>'; if($notes)echo f('read',0,'Mark read')?>
<h2>Upcoming classes</h2><table border=1 cellpadding=4><tr><th>Class<th>Trainer<th>When<th>Seats<th>
<?php foreach($classes as $c){echo '<tr><td>'.h($c['name']).'<td>'.h($c['trainer']).'<td>'.h($c['starts_at']).'<td>'.$c['taken'].'/'.$c['capacity'].'<td>'.
 ($c['mine']==='booked'?f('cancel',$c['id'],'Cancel'):f('book',$c['id'],'Book'));}?></table>
