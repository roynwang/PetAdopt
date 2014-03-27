<?php
session_start();
require_once("../consvr.php");
$name = $_POST['name'];
$result = mysql_query("SELECT * FROM salvor_table WHERE id='".$name."'");
$item = mysql_fetch_array($result);
if(!$item){
	$query ="INSERT INTO salvor_table (`id`,`pwd`,`display_name`,`QQ`,`phone_0`,`phone_1`) VALUES ('".$name."','".$_POST['password']."','','','','')";
	if(mysql_query($query)){
			$_SESSION['name']=$name;
			echo "Success";
		}
	else{
			echo $query;
	}
}
else{
	echo "邮箱已被注册过了";
}
mysql_close();
?>
