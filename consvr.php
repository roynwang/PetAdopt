<?php
$con = mysql_connect("localhost","root","s0556062");
if(!$con){
	die('Could not connect: '.mysql_error());
}
mysql_select_db("allpets",$con);
mysql_query("SET NAMES 'utf8'");
?>
