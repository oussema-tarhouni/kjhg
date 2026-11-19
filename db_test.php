<?php
error_reporting(E_ALL); ini_set('display_errors',1);
$host='127.0.0.1'; $port=3306; $db='eos'; $user='root'; $pass='';
try{
 $p=new PDO("mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4",$user,$pass,[PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION]);
 echo "<p style=color:green>Connected OK</p>";
 foreach($p->query('SHOW TABLES')->fetchAll(PDO::FETCH_COLUMN) as $t)echo h($t)."<br>";
}catch(Throwable $e){echo "<p style=color:red>".htmlspecialchars($e->getMessage())."</p>";}
function h($s){return htmlspecialchars($s);}
