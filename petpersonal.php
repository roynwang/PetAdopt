<?php
$con = mysql_connect("localhost","root","s0556062");
if(!$con){
	die('Could not connect: '.mysql_error());
}
mysql_select_db("allpets",$con);
$result = mysql_query("SELECT * FROM pets_table WHERE uid=".$_GET['uid']);
?>

<p>!!!!!!!</p>


<?php
echo "!!!!!".$result;
$row = mysql_fetch_array($result);
echo $row['description'];
echo "<br />";
echo $row['name'];
echo "<br />";
echo $row['photo'];
mysql_close($con);

?>
