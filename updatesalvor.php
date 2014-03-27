<?php	
require_once("consvr.php");	
$query = "UPDATE `salvor_table` SET `display_name`='".$_POST['displayname']."', `QQ`='".$_POST["qq"]."', `phone_0`='".$_POST['mobile']."' where `id` = '".$_POST['name']."'";
if(mysql_query($query)){
	echo "Success";
}
else{
	echo mysql_error();
}
mysql_close();
?>
