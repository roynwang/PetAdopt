<?php
session_start(); 
if(!isset($_SESSION['name'])){
	exit();
}
$salvor = $_SESSION['name'];
$name = $_POST['nickname'];
echo "success";
?>
