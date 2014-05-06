<?php
$count = 0;
function selectequal($cols,$skey){
	$where ="";
	$connector = " ";
	global $count;
	$tarcols = array_keys($cols);
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
		$item["weight"] = 1000;
		$ret[] = $item;
	}
	return $ret;
}
function selectlocate($cols,$skey){
	$where ="";
	$connector = " ";
	global $count;
	$tarcols = array_keys($cols);
	foreach($tarcols as $tarcol ){
		$where .= $connector;
		$where .= "LOCATE(lower('$skey'), lower($tarcol)) != 0  ";
		if($connector == " "){
			$connector = " OR ";
		}
	}
	$sql = "SELECT * FROM pets_table WHERE $where";
	$result = mysql_query($sql);
	$ret = Array();
	while($item = mysql_fetch_array($result, MYSQL_ASSOC)){
		$count ++;
		$item["weight"]=10;
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


	$keytmp=array_keys($tmp);
	$ret = Array();

	//recaculte the return arary and sort the it by weight
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
	$cols = array("name"=>1000,"description"=>100);
	$ret = Array();
	$keywords=explode(" ", $keywords);
	foreach($keywords as $keyword){
		$ret = array_merge($ret, selectequal($cols, $keyword));
		$ret = array_merge($ret,selectlocate($cols, $keyword));
	}
	$ret = cleanarr($ret);
	$ret = array('msg' => "Success", 'count'=>$count,'children' => $ret, 'query'=>"COMPLEX:NOT READABLE");
	echo json_encode($ret);
	mysql_close();
}
?>
