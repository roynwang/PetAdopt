<?php
	require_once("consvr.php");
	$keywords=$_GET["keys"];
	$query = "SELECT * FROM pets_table WHERE MATCH (name, description) AGAINST ($keywords IN BOOLEAN MODE);";
$result = mysql_query($query);
$arr = Array();
$count = 0;
while($item = mysql_fetch_array($result, MYSQL_ASSOC)){
	$arr[] = $item;
	$count++;
}
$ret = array('msg' => "Success", 'count'=>$count,'children' => $arr);
echo json_encode($ret);
mysql_close();
?>
