
<?php
session_start();
require_once("consvr.php");
$name = $_GET['name'];
$query = "SELECT `uid`,`name`,`species`,`sex`,`description`, `photo` FROM `pets_table` WHERE `salvor` = '".$name."'";
$result = mysql_query($query);
$arr = Array();
while($item = mysql_fetch_array($result, MYSQL_ASSOC)){
	$arr[] = $item;
}
$ret = array('msg' => "Success", 'children' => $arr);
header('Content-Type: application/json');
echo json_encode($ret);
mysql_close();
?>
