<?php
session_start();
$maxSearchCacheCount = 10;

function cleanSearchCache(){
	global $maxSearchCacheCount;
	$fi = new FilesystemIterator("./temp", FilesystemIterator::SKIP_DOTS);
	if($fi > $maxSearchCacheCount){
		//delete the oldest one
		$files = glob( './temp/*' );
		// Sort files by modified time, latest to earliest
		// Use SORT_ASC in place of SORT_DESC for earliest to latest
		array_multisort(
			array_map( 'filemtime', $files ),
			SORT_NUMERIC,
			SORT_ASC,
			$files
		);
		unlink($files[0]);
	}
}


if(!is_dir("temp")){
	mkdir("temp", 0777, true);
}

$pagesize = 15;
$count = 0;
//if searchmd5 setted and equal to the existed value
if(isset($_SESSION['keywords']) && $_SESSION['keywords'] == $keywords){
//read
	$ret = readresult($_SESSION['tmpsearchfile']);
	if($ret != NULL) {
		buildret($ret,$page);
		return;
	}
}
if(isset($_SESSION['tmpsearchfile'])){
	unlink($_SESSION['tmpsearchfile']);
	unset($_SESSION['tmpsearchfile']);
}
//if the md5 has not been setted or not equal to the existed
$_SESSION['keywords']= $keywords;


function buildret($ret, $page){
	global $pagesize;
	$offset = $page*$pagesize;
	$ret = array_slice($ret, $offset, $pagesize);
	$count = count($ret);
	$retjson = array('msg' => "Success", 'count'=>$count,'children' => $ret, 'query'=>"COMPLEX:NOT READABLE");
	echo json_encode($retjson);
}

function writeresult($filename,$arr){
	cleanSearchCache();
	$handle = fopen($filename, "w");
	fwrite($handle,serialize($arr));
	fclose($handle);
}

function readresult($filename){
	if(!file_exists($filename))
		return NULL;
	return unserialize(file_get_contents($filename));
}


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
	$ret = Array();
	$count = 0;
	while($item = mysql_fetch_array($result, MYSQL_ASSOC)){
		$ret[] = $item;
		$count++;
	}
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
}

$_SESSION['tmpsearchfile'] = tempnam("./temp",date("YmdHis")) ;
writeresult($_SESSION['tmpsearchfile'], $ret);
buildret($ret,$page);
mysql_close();
?>
