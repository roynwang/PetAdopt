<?php
session_start();
require_once("../consvr.php");
$name = $_POST['name'];
$result = mysql_query("SELECT * FROM salvor_table WHERE id='".$name."'");
$item = mysql_fetch_array($result);
mysql_close();
if($item){
	if($item['pwd'] == $_POST['password']){
		$_SESSION['name']=$name;
		echo "Success";
	}
	else{
		echo "错误的用户名/密码";
	}
	exit;
}
echo "用户不存在";
?>
