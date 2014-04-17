<?php
require_once("consvr.php");	
$updatestr = "";
foreach($_POST as $key => $value){
	$value = mysql_real_escape_string($value);
	$updatestr .= "`";
	$updatestr .= $key;
	$updatestr .= "`";
	$updatestr .= "=";
	$updatestr .= '\'';
	$updatestr .= $value;
	$updatestr .= '\',';
}
$updatestr = rtrim($updatestr, ',');
$query = "UPDATE `pets_table` SET " .$updatestr ." WHERE `uid` = '".$_POST['uid']."';";
if(mysql_query($query)){
	echo "Success";
}
else{
	echo mysql_error();
}
mysql_close();
?>
