<?php
$count = 0;
function selectequal($tarcols,$skey){
	$where ="";
	$connector = " ";
	global $count;
	foreach($tarcols as $tarcol ){

		$where .= $connector;
		$where .= "lower($tarcol) = lower('$skey')";
		if($connector == " "){
			$connector = " OR ";
		}
	}
	$sql = "SELECT * FROM pets_table WHERE $where";
	$result = mysql_query($sql);
	$ret = Array();
	while($item = mysql_fetch_array($result, MYSQL_ASSOC)){
		$count ++;
		$ret[] = $item;
	}
	return $ret;
}
function selectlocate($tarcols,$skey){
	$where ="";
	$connector = " ";
	global $count;
	foreach($tarcols as $tarcol ){
		$where .= $connector;
		$where .= "LOCATE('$skey', $tarcol) != 0  ";
		if($connector == " "){
			$connector = " OR ";
		}
	}

	$sql = "SELECT * FROM pets_table WHERE $where";
	$result = mysql_query($sql);
	$ret = Array();
	while($item = mysql_fetch_array($result, MYSQL_ASSOC)){
		$count ++;
		$ret[] = $item;
	}
	return $ret;
}
function cleanarr($arr){
	global $count;
	$tmp = Array();
	$tmpall = Array();
	foreach($arr as $item){
		if(array_key_exists($item['uid'], $tmp)){
			$tmp[$item['uid']]++;
		}
		else{
			$tmp[$item['uid']] = 1;
			$tmpall[$item['uid']] = $item;
		}

	}

	//!!Debug
	//print_r($tmp);

	$keytmp=array_keys($tmp);
	$ret = Array();

	$count = 0;
	for($i = 0; $i<count($tmp);$i++){
		$count++;
		$ret[]=$tmpall[$keytmp[$i]];	
	}
	return $ret;
}

require_once("consvr.php");

$sql = "";
if("猫"== $keywords."" || $keywords == "1" || "狗"==$keywords."" || $keywords == "0"){
	if("猫"== $keywords."" || $keywords == "1"){
		$sql = "SELECT * FROM pets_table WHERE species = 1 ";
	}
	else if("狗"==$keywords."" || $keywords == "0"){
		$sql = "SELECT * FROM pets_table WHERE species = 0 ";
	}
	$limit = "LIMIT $offset, $maxcount;";
	$sql.=$limit;
	$result = mysql_query($sql);
	$arr = Array();
	$count = 0;
	while($item = mysql_fetch_array($result, MYSQL_ASSOC)){
		$arr[] = $item;
		$count++;
	}
	$ret = array('msg' => "Success", 'count'=>$count,'children' => $arr, 'query'=>$sql);
	echo json_encode($ret);
	mysql_close();
}
else{
	$cols = array("name","description");
	$ret = Array();
	$keywords=explode(" ", $keywords);
	foreach($keywords as $keyword){
		$ret = array_merge($ret,selectequal($cols, $keyword));
		$ret = array_merge($ret,selectlocate($cols, $keyword));
	}
	$ret = cleanarr($ret);
	$ret = array('msg' => "Success", 'count'=>$count,'children' => $ret, 'query'=>"COMPLEX:NOT READABLE");
	echo json_encode($ret);
	mysql_close();
}
?>
