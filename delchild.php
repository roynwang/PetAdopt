<?php
session_start(); 
require_once("consvr.php");

function deldir($dir) {
	$dh=opendir($dir);
	while ($file=readdir($dh)) {
		if($file!="." && $file!="..") {
			$fullpath=$dir."/".$file;
			if(!is_dir($fullpath)) {
				unlink($fullpath);
			} else {
				deldir($fullpath);
			}
		}
	}

	closedir($dh);
	if(rmdir($dir)) {
		return true;
	} else {
		return false;
	}
}

if(!isset($_SESSION['name'])){
	exit();
}
$salvor = $_SESSION['name'];
$query = "DELETE FROM `pets_table` WHERE `uid`=".$_POST['uid'];
if(mysql_query($query)){
	deldir("./photo/".$_POST['uid']);
	echo "Success";
}
else
echo "Failed";
mysql_close();

?>
