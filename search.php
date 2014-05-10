<?php

session_start();
$maxSearchCacheCount = 10;
$compareweight = Array("equal"=>1000, "locate"=>10);
$colshash = Array("name"=>0,"description"=>5, "tag" =>6 , "species"=> 4);

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
	file_exists($_SESSION['tmpsearchfile']) && unlink($_SESSION['tmpsearchfile']);
	unset($_SESSION['tmpsearchfile']);
}
//if the md5 has not been setted or not equal to the existed
$_SESSION['keywords']= $keywords;


function buildret($ret, $page){
	global $pagesize,$count;
	$offset = $page*$pagesize;
	$ret = array_slice($ret, $offset, $pagesize);
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

	global $count;
	$arr = unserialize(file_get_contents($filename));
	$count = count($arr);
	return $arr;
}


function selectequal($col,$val,$skey){
	$connector = " ";
	global $count, $compareweight;
	$sql = "SELECT * FROM pets_table WHERE LOWER($col)=LOWER('$skey')";
	$result = mysql_query($sql);
	$ret = Array();
	while($item = mysql_fetch_array($result, MYSQL_ASSOC)){
		$count ++;
		$item["weight"] = $compareweight["equal"]*$val; $ret[] = $item;
#		echo "!!!!!!!!!".$item["weight"];
	}
	return $ret;
}
function selectlocate($col,$val,$skey){
	echo "!!! $col,$val, $skey <br>";
	global $count, $compareweight;
	$sql = "SELECT *,(LENGTH(description) - LENGTH(REPLACE(description, '$skey', '')))/LENGTH('$skey')*$val*".$compareweight["locate"]." as weight FROM pets_table WHERE LOCATE(LOWER('$skey'),LOWER($col))>0 AND LOWER($col)!=LOWER('$skey')";
	$result = mysql_query($sql);
	$ret = Array();
	while($item = mysql_fetch_array($result, MYSQL_ASSOC)){
		$count ++;
		$ret[] = $item;
		echo "!!!!!!!!!".$item["weight"];
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
$ret = Array();
if($keywords == "猫" || $keywords == "狗"){
	$ret = array_merge($ret,selectequal("species",$colshash["species"], $keywords));
}
else{
	$keywords=explode(" ", $keywords);
	$cols = array_keys($colshash);
	foreach($keywords as $keyword){
	//special locgic for species
		if($keyword == "猫" || $keyword == "狗"){
			//reduce the equal weight when query spieces
			$compareweight['equal'] = 5;
			$ret = array_merge($ret,selectequal("species",$colshash["species"], $keyword));
			$compareweight['equal'] = 1000;
			continue;
		}
		foreach($colshash as $col=>$val){
			if($col == "species")
				continue;
			$ret = array_merge($ret,selectequal($col,$val, $keyword));
			$ret = array_merge($ret,selectlocate($col,$val, $keyword));
			}

	}

	$ret = cleanarr($ret);
}
$count = count($ret);
$_SESSION['tmpsearchfile'] = tempnam("./temp",date("YmdHis")) ;
writeresult($_SESSION['tmpsearchfile'], $ret);
buildret($ret,$page);
mysql_close();
?>
