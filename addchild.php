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
	echo mysql_insert_id();
}
else
	echo $query;
mysql_close();
?>
