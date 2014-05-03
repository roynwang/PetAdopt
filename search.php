<?php
require_once("consvr.php");
$limit = ";";
$query = "SELECT * FROM pets_table WHERE MATCH (name, description) AGAINST ($keywords IN BOOLEAN MODE) ";
if("猫"== $keywords."" || $keywords == "1"){
	$query = "SELECT * FROM pets_table WHERE species = 1 ";
}
else if("狗"==$keywords."" || $keywords == "0"){
	$query = "SELECT * FROM pets_table WHERE species = 0 ";
}
$limit = "LIMIT $offset, $count;";
$query.=$limit;
$result = mysql_query($query);
$arr = Array();
$count = 0;
while($item = mysql_fetch_array($result, MYSQL_ASSOC)){
$arr[] = $item;
$count++;
}
$ret = array('msg' => "Success", 'count'=>$count,'children' => $arr, 'query'=>$query);
echo json_encode($ret);
mysql_close();
?>
