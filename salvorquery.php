
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
$con = mysql_connect("localhost","root","s0556062");
if(!$con){
die('Could not connect: '.mysql_error());
}
mysql_select_db("allpets",$con);
mysql_query("SET NAMES 'utf8'");
$result = mysql_query("SELECT * FROM salvor_table WHERE id=\"".$_GET[$name]."\"");
$item = mysql_fetch_array($result);
mysql_close();
//$item['display_name'] = mb_convert_encoding($item['display_name'],'utf-8','gb2312');
echo json_encode($item);
?>
