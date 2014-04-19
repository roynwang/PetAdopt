<?php
session_start(); 

require_once("consvr.php");

if(!isset($_SESSION['name'])){
	exit();
}
$salvor = $_SESSION['name'];
$name = $_POST['nickname'];

$query ="INSERT INTO pets_table (`uid`,`name`,`salvor`) VALUES (null,'".$name."','".$salvor."')";
if(mysql_query($query)){
	$uid = mysql_insert_id();
	mkdir("photo/".$uid,0777,true);
	echo $uid;
}
else
	echo $query;
mysql_close();
?>
