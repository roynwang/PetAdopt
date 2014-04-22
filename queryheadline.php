<?php
	require_once("consvr.php");
	$query = "SELECT * FROM headline_table LEFT JOIN pets_table ON headline_table.uid=pets_table.uid LIMIT 3;";
$result = mysql_query($query);
$arr = Array();
while($item = mysql_fetch_array($result, MYSQL_ASSOC)){
	$arr[] = $item;
}
$ret = array('msg' => "Success", 'children' => $arr);
echo json_encode($ret);
mysql_close();

?>
