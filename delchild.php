<?php
session_start(); 

require_once("consvr.php");

if(!isset($_SESSION['name'])){
	exit();
}
$salvor = $_SESSION['name'];
$query = "DELETE FROM `pets_table` WHERE `uid`=".$_POST['uid'];
if(mysql_query($query)){
	echo "Success";
}
else
	echo "Failed";
mysql_close();

?>
