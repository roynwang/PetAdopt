<!DOCTYPE html>
<!--[if lt IE 7 ]> <html class="ie ie6 no-js" lang="en"> <![endif]-->
<!--[if IE 7 ]>    <html class="ie ie7 no-js" lang="en"> <![endif]-->
<!--[if IE 8 ]>    <html class="ie ie8 no-js" lang="en"> <![endif]-->
<!--[if IE 9 ]>    <html class="ie ie9 no-js" lang="en"> <![endif]-->
<!--[if gt IE 9]><!--><html class="no-js" lang="en"><!--<![endif]-->
<?php
session_start();
if(!isset($_SESSION['name'])){
	//return 404
	exit();
}
require_once("consvr.php");
$result = mysql_query("SELECT * FROM salvor_table WHERE id='".$_GET['id']."'");
$item = mysql_fetch_array($result);
mysql_close();
?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="description" content="~~~~~~~~~~~~~~~~" />
<title>
<?php
echo $item['display_name'];
?>
</title>
<link rel="stylesheet" type="text/css" href="css/demo.css" />
<link rel="stylesheet" type="text/css" href="css/style.css" />
<link rel="stylesheet" type="text/css" href="css/menu.css" />
<link rel="stylesheet" type="text/css" href="css/piclist.css" />
</head>
<body>
<!-- Codrops top bar -->
<div class="codrops-top">
<a href="!!!!!INPUT" target="_blank">
WAITING YOU
</a>
<span class="right">
<a href="./login/logout.php" target="_blank">
<strong>LOGOUT</strong>
</a>
</span>
<div class="clr"></div>
</div><!--/ Codrops top bar -->

<!-- Home -->
<div id="home" class="content">
<h2 id="content-title">个人信息</h2>
<div id="addchild_menu" class="menu">
<fieldset id="child_form">
<form method="post" >
<p>
<label class="menu_sublabel" >昵称</label>
<input id="nick_name" type="text" title="请输入10个字符内的昵称">
</p>
</br>
<input id="child_submit" class="menubutton" value="确定" type="submit">
<div id="child_result" class="menu_result"></div>
</form>
</fieldset>
</div>

<a id="children-list" class="pic-list"/>
<a id="info-list">
<p id="field_mail" style="font-size:30px;margin-left:-7px"><?php 
echo $item['id'];
?></p>
<table class="infolist">
<tr><td>昵称: </td><td id="field_displayname">
<?php 
echo $item['display_name'];
?></td></tr>
<tr><td>Q Q: </td><td id="field_qq"><?php 
echo $item['QQ'];
?></td></tr>
<tr><td>手机: </td><td id="field_mobile"><?php 
echo $item['phone_0'];
?></td></tr>
<tr><td><a id="info-edit" class="button">编辑</a></td></tr>
</table>
</a>
<p id="errmsg" style="color:red"></p>
</div>
<!-- /Home -->

<!-- Header with Navigation -->
<div id="header">
<h1>
</br>
<?php
echo $item['display_name'];
?>
</h1>
<ul id="navigation">
<li><a id="personal-info">个人信息</a></li>
<li><a id="children-info">孩子们</a></li>
</ul>
<!-- disable Nav -->
<!--<nav id="codrops-demos">
<a class="current-demo" href="#home">Demo 1</a>
<a href="index2.html#home">Demo 2</a>
<a href="index3.html#home">Demo 3</a>
</nav>-->
</div>
<script src="javascripts/jquery.js" type="text/javascript"></script> 
<script src="javascripts/json.js" type="text/javascript"></script> 
<script type="text/javascript">

var mode = "edit";
var children = null;
var displaynamevalue, qqvalue,mobilevalue,mailvalue;
function switchToEdit(){
	$("#info-edit").html("提交");
	mode = "submit";
	$("#field_displayname").html('<input id="input_displayname" value="'+displaynamevalue+'"/>');
	$("#field_qq").html('<input id="input_qq" value="'+qqvalue+'"/>');
	$("#field_mobile").html('<input id="input_mobile" value="'+mobilevalue+'\"/>');
}
function funnewchild(){
	curtop = $("#add_kid").offset().top - $("#addchild_menu").height() +10;
	curleft = $("#add_kid").offset().left - $("#addchild_menu").width()-15;
	$("#addchild_menu").css({left:curleft, top:curtop});
	$("#addchild_menu").fadeIn();
}
$(document).ready(
		function(){
		displaynamevalue = $("#field_displayname").text();
		qqvalue = $("#field_qq").text();
		mobilevalue = $("#field_mobile").text();
		mailvalue = $("#field_mail").text();
		$("#personal-info").click(function(e){
			e.preventDefault();
			$("#home").hide();
			$("#content-title").html("个人信息");
			$("#children-list").hide();
			$("#info-list").show();
			$("#info-list").fadeIn("fast");
			$("#info-edit").html("编辑");
			$("#field_displayname").html(displaynamevalue);
			$("#field_qq").html(qqvalue);
			$("#field_mobile").html(mobilevalue);
			$("#home").fadeIn();
			});
		$("#children-info").click(function(e){
			e.preventDefault();	
			$("#content-title").html("孩子们");
			$("#info-list").hide();
			$("#home").hide();

			$("#children-list").show();
			if(children == null){
			$.get("querychildren.php",{name:mailvalue},function(data,status){
				children = JSON.parse(data);
				var imghtml = "<ul>";
				for(var i in children.children){
				var child = children.children[i];
				imghtml = imghtml + "<div class=\"picdiv\"><li><a href=\"pet.php?uid=" + child.uid + "&edit=1\"><img class=\"child_image\" src=\"./photo/"+child.uid+"/"+child.photo + "\" title=\"单击以编辑它\"><div class=\"picdesc\"><a>" + child['name'] + "</a><div class=\"del_child\">删除</div></div></a></li></div>";
				}
				imghtml+="<div class=\"picdiv\"><a id=\"add_kid\" class=\"button\" onclick=\"funnewchild()\">添加</a></div>";
				imghtml+="</ul>";
				//append button add
				$("#children-list").html(imghtml);
				});
			}
			$("#home").fadeIn();

		});
		$("#info-edit").click(function(e){
				e.preventDefault();
				if(mode == "edit"){
				switchToEdit();
				}
				else{
				displaynamevalue = $("#input_displayname").val().trim();
				qqvalue = $("#input_qq").val().trim();
				mobilevalue = $("#input_mobile").val().trim();
				$("#errmsg").html("sending");
				//post the request to update page
				$.post("updatesalvor.php",{name:mailvalue,displayname:displaynamevalue,qq:qqvalue,mobile:mobilevalue},function(data,status){
					$("#errmsg").html(data);
					if(data == "Success"){
					window.location.href = "salvor.php?id="+mailvalue;
					}
					});
				//refresh the page
				}
				});
		$(document).mousedown(function(e){
			if($(e.target).parents(".menu").length==0 && $(".menu").is(':visible')){
				$(".menu").fadeOut();
			}
		});
		$("#child_submit").click(function(e){
			e.preventDefault();
			nickname = $("#nick_name").val().trim();
			if(nickname.length == 0){
				$("#child_result").html("昵称不能为空");
				return;
			}
			url = "addchild.php";
			$.post(url,{nickname:nickname}, function(data,status){
				$("#child_result").html(data);
			});
		});
});
</script>
<script src="javascripts/jquery.tipsy.js" type="text/javascript"></script> 
<script>
$(function(){
	$("#nick_name").tipsy({gravity: 'w'});
	$(".child_image").tipsy({gravity: 'w'});
});
</script>
<?php
if($_GET['edit'] == 1){
	echo "<script type=\"text/javascript\"> $(document).ready(function(){switchToEdit();})</script>";
}
?>
</body>
</html>
