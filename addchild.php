<?php
session_start(); 

require_once("consvr.php");

if(!isset($_SESSION['name'])){
	exit();
}
$salvor = $_SESSION['name'];
$name = $_POST['nickname'];
$maxid = 3;

$query ="INSERT INTO pets_table (`uid`,`name`,`salvor`) VALUES ('".$maxid."','".$name."','".$salvor."')";
if(mysql_query($query)){
	echo $maxid;
}
else
	echo $query;
mysql_close();

?>
