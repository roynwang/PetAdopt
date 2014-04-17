<!DOCTYPE html>
<?php
session_start();

$editMode = false;

function getExtension($file){
$info = pathinfo($file);
return $info['extension'];
}
function getImages($dir){
$images[]=NULL;
$i = 0;
if(false != ($handle = opendir($dir))){
	while( false!= ($file = readdir($handle))){
		$type = getExtension($file); 
		if($type == "jpg" || $type == 'jpeg'){
			$images[$i] = $dir.'/'.$file;	
			$i++;
		}
	}
}
return $images;
}

require_once("consvr.php");
$result = mysql_query("SELECT * FROM pets_table WHERE uid=".$_GET['uid']);
$item = mysql_fetch_array($result);

$salvorname = $item['salvor'];
$sql = "SELECT * FROM salvor_table WHERE id=\"".$salvorname."\"";
$salvorresult = mysql_query("SELECT * FROM salvor_table WHERE id=\"".$salvorname."\"");

$salvor = mysql_fetch_array($salvorresult);

mysql_close();
$editMode = false;
if( isset($_SESSION['name']) &&
	$_SESSION['name'] == $item['salvor'] &&
	$_GET['edit'] == '1'
	){
	$editMode = true;

}


if(!$item){
      header('HTTP/1.1 404 Not Found');
	  header("status: 404 Not Found");
}
?>

<!--[if lt IE 7 ]> <html class="ie ie6 no-js" lang="en"> <![endif]-->
<!--[if IE 7 ]>    <html class="ie ie7 no-js" lang="en"> <![endif]-->
<!--[if IE 8 ]>    <html class="ie ie8 no-js" lang="en"> <![endif]-->
<!--[if IE 9 ]>    <html class="ie ie9 no-js" lang="en"> <![endif]-->
<!--[if gt IE 9]><!--><html class="no-js" lang="en"><!--<![endif]-->

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="description" content="~~~~~~~~~~~~~~~~" />
<title>
<?php
echo $item['name'];
?>
</title>
<link rel="stylesheet" type="text/css" href="css/demo.css" />
<link rel="stylesheet" type="text/css" href="css/style.css" />
<link rel="stylesheet" type="text/css" href="css/piclist.css" />
<link rel="stylesheet" type="text/css" href="css/menu.css" />


</head>
<body>
<!-- Codrops top bar -->
<div class="codrops-top">
<?php
if($editMode){
	echo '<a href="'.'salvor.php?id='.$salvor['id'].'" target="_blank">';
	echo '<strong>返回个人页面</strong>';
}
else{

	echo '<a href="index.php">';
	echo '<strong>返回主页</strong>';
}
?>
</a>
<span class="right">
<a href="./login/logout.php" target="_blank">
<strong>注销</strong>
</a>
</span>
<div class="clr"></div>
</div><!--/ Codrops top bar -->

<!-- Home -->
<div id="home" class="content">
<h2>故事</h2>
<p id="pet_desc">
<?php
echo $item['description']
?>
</p>
</br><p><a id="edit_story" class="menubutton" onclick="editstory()">编辑</a></p>
<p id = "story_result"></p>
</div>
<!-- /Home -->

<!-- Portfolio -->
<div id="portfolio" class="panel">
<div class="content">
<h2>照片</h2>

<ul id="works" class="pic-list">
<?php
$dir = "./photo/".$item['uid'];
foreach(getImages($dir) as $image){
	echo '<div class="picdiv"><li><a><img src= "'.$image.'"><div class="picdesc"><div class="del_child">删除</div></div></a></li></div>';
}
?>
<div class="picdiv">
<a id="add_pic" class="menubutton" onclick="addpicdial()">新照片</a>
</div>
<!--<li><a href="http://dribbble.com/shots/388799-Harvey-Birdman"><img src="images/portfolio_03.jpeg" width="250"></a></li>-->
</ul>
<!--<p class="footnote">Dribbble shots by <a href="http://dribbble.com/stuntman">Matt Kaufenberg</a>.</p>-->
</div>
</div>
<div id="addpic_dial" class="menu">
<fieldset id="child_form">
<form method="post" >
<p>
<label class="menu_sublabel" >文件</label>
</br>
<input id="file_path" type="file" title="路径">
</p>
</br>
<input id="file_submit" class="menubutton" value="确定" type="submit">
<div id="file_result" class="menu_result"></div>
</form>
</fieldset>
</div>

<!-- /Portfolio -->

<!-- About -->
<div id="about" class="panel">
<div class="content">
<h2>
<?php
	echo $salvor['display_name'];
?>

</h2>
<!--- Contact infomation-->
<p>QQ:
<?php
	echo $salvor['QQ'];
?>
</p>
<p></p>
<p></p>
</div>
</div>
<!-- /About -->


<!-- Header with Navigation -->
<div id="header">
<h1>
</br>
<?php
	echo $item['name'];
?>
</h1>
<ul id="navigation">
<li><a id="link-home" href="#home">故事</a></li>
<li><a id="link-portfolio" href="#portfolio">照片</a></li>
<li><a id="link-about" href="#about">救助人</a></li>
</ul>
<div id="tosaveuid" style="display:none"><?php
	echo $item['uid'];
?>
</div>
<!-- disable Nav -->
<!--<nav id="codrops-demos">
<a class="current-demo" href="#home">Demo 1</a>
<a href="index2.html#home">Demo 2</a>
<a href="index3.html#home">Demo 3</a>
</nav>-->
</div>

<script type="text/javascript">
var isEdit = false;
var editStory = false;
</script>


<?php
	if($editMode){
echo '<script type="text/javascript">var isEdit=true;</script>';
	}
?>

<script src="javascripts/jquery.js" type="text/javascript"></script> 
<script type="text/javascript">

function addpicdial(){
	curtop = $("#add_pic").offset().top - $("#addchild_dial").height() -100;
	curleft = $("#add_pic").offset().left - $("#addchild_dial").width()-15;
	$("#addpic_dial").css({left:curleft, top:curtop});
	$("#addpic_dial").fadeIn();
}


function editstory(){
	if(!editStory){
		if($("#pet_desc").height() < 300){
			$("#pet_desc").height(300);
		}
		$("#pet_desc").html('<textarea id="new_desc">'+$("#pet_desc").text()+'</textarea>');
		$("#edit_story").text("提交");
		editStory = true;
	}
	else{
		desc = $("#new_desc").val();
		desc = desc.replace(/'/g,"\\'");
		desc = desc.replace(/"/g,'\\"');
		$("#edit_story").text("编辑");
		$("#pet_desc").html("ttt");
		$("#pet_desc").height("auto");
		$.post("updatepet.php",{uid:$("#tosaveuid").text(), description:desc}, function(data, status){
			if(data == "Success")
				location.reload(true);
			else{
				$("#story_result").text(data);
				}
			});
		editStory = false;
	}
}
if(isEdit == false){
	$("#add_pic").hide();
	$("#edit_story").hide();
	$(".del_child").hide();
}

$(document).ready(
		function(){
		$(document).mousedown(function(e){
			if($(e.target).parents(".menu").length==0 && $(".menu").is(':visible')){
				$(".menu").fadeOut();
			}
		});

});

</script>
</body>
</html>
