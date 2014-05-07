<?php
$count = 0;
function selectequal($col,$val,$skey){
	$connector = " ";
	global $count;
	$sql = "SELECT * FROM pets_table WHERE LOWER($col)=LOWER('$skey')";
	$result = mysql_query($sql);
	$ret = Array();
	while($item = mysql_fetch_array($result, MYSQL_ASSOC)){
		$count ++;
		$item["weight"] = 1000*$val;
		$ret[] = $item;
	}
	return $ret;
}
function selectlocate($col,$val,$skey){
	global $count;
	$sql = "SELECT *,(LENGTH(description) - LENGTH(REPLACE(description, '$skey', '')))/LENGTH('$skey') *10*$val as weight FROM pets_table WHERE LOCATE(LOWER('$skey'),LOWER($col))>0 AND LOWER($col)!=LOWER('$skey')";
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
			$tmp[$item['uid']]+=$item["weight"];
		}
		else{
			$tmp[$item['uid']] = $item["weight"];
			$tmpall[$item['uid']] = $item;
		}
	}

	//sort by weight in descending order 
	arsort($tmp);

	$ret = Array();

	//rebuild the return arary
	$count = 0;
	foreach($tmp as $k=>$v){
		$count++;
		$tmpall[$k]['weight']=$v;
		$ret[]=$tmpall[$k];
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
	$colshash = array("name"=>10,"description"=>1);
	$ret = Array();
	$keywords=explode(" ", $keywords);
	$cols = array_keys($colshash);
	foreach($keywords as $keyword){
		foreach($colshash as $col=>$val){
			$ret = array_merge($ret,selectequal($col,$val, $keyword));
			$ret = array_merge($ret,selectlocate($col,$val, $keyword));
		}
		
	}
	$ret = cleanarr($ret);
	$ret = array('msg' => "Success", 'count'=>$count,'children' => $ret, 'query'=>"COMPLEX:NOT READABLE");
	echo json_encode($ret);
	mysql_close();
}
?>
