<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?php
	session_start();
	if(isset($_SESSION['name'])){
		header("Location:salvor.php?id=".$_SESSION['name']);
		exit();
	}
?>
<html xml:lang="en" xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
<meta content="text/html; charset=UTF-8" http-equiv="Content-Type">
<title>Mew</title>
<link href="front.css" media="screen, projection" rel="stylesheet" type="text/css">
</head>
<body>
<div id="container">
  <div id="topnav" class="topnav"><a id="signinbutton" class="signin"><span>登录</span></a>  <a id="registerbutton" class="signin"><span>注册</span></a> 
  <div>
  <fieldset id="register_menu" class="register">
    <form method="post" >
	  <p>
      <label class="sublabel" >用户名(邮箱)</label>
      <input id="registername" type="text">
      </p>
	  <p id="name_tips" class="register_tips"></p>
      <p>
        <label class="sublabel" >密码</label>
        <input id="registerpassword" type="password">
      </p>
	  <p>
        <label class="sublabel" >重复密码</label>
        <input id="repeatpassword" type="password">
      </p>
	  <p id="pwd_tips" class="register_tips"></p>
	  <input id="register_submit" style="font-size:15px" value="注册" type="submit">
    </form>
  </fieldset>
</div>
  <fieldset id="signin_menu">
    <form method="post" id="signin">
	  <p>
      <label class="sublabel" for="username">用户名(邮箱)</label>
      <input id="username" name="username" value="" title="username" tabindex="4" type="text">
      </p>
      <p>
        <label class= "sublabel" for="password">密码</label>
        <input id="password" name="password" value="" title="password" tabindex="5" type="password">
      </p>
      <p class="remember">
        <input id="signin_submit" style="font-size:15px" value="Sign in" tabindex="6" type="submit">
        <input id="remember" name="remember_me" value="1" tabindex="7" type="checkbox">
        <label for="remember" style="font-size:15px"> Remember me</label>
      </p>
      <p> <a href="#" id=tips  style="font-size:15px"title="TESTING">Forgot your password?</a> </p>
	  <div id="signin_result"></div>
    </form>
  </fieldset>

</div>
<script src="javascripts/jquery.js" type="text/javascript"></script> 
<script src="javascripts/jquery.md5.js" type="text/javascript"></script> 
<script type="text/javascript">
		function cleanPwd(){
			$(":password").val("");
		}
		function verifyRegister(){
			var id = $("#registername").val().trim();
			var pwd = $("#registerpassword").val();
			var repeatpwd = $("#repeatpassword").val();
			var idRegex = /^\w+([-\.]\w+)*@\w+([\.-]\w+)*\.\w{2,4}$/;
			var pwdRegex =  /^[\@A-Za-z0-9\!\#\$\%\^\&\*\.\~]{6,16}$/;
			if(id == null || id.length==0){
				$("#name_tips").text("邮箱不能为空");
				return false;
			}
			if(!idRegex.test(id)){
				$("#name_tips").html("请使用您的邮箱注册");
				return false;
			}
			if(id.length>50){
				$("#name_tips").html("邮箱最长长度是50");
				return false;
			}
			if(repeatpwd != pwd){
				$("#pwd_tips").html("两次输入的密码不一致");
				cleanPwd();
				return false;
			}
			if(pwd == null || pwd.lenght==0){
				$("#pwd_tips").html("密码不能为空");
				cleanPwd();
				return false;
			}
			if(!pwdRegex.test(pwd)){
				$("#pwd_tips").html(pwd);
				cleanPwd();
				return false;
			}
			return true;

		}
        $(document).ready(function() {
            $("#signinbutton").click(function(e) {          
				e.preventDefault();
                $("fieldset#signin_menu").fadeIn();
            });
			$("#registerbutton").click(function(e) {          
				e.preventDefault();
                $("fieldset#register_menu").fadeIn();
            });

			$("#signin_submit").click(function(e){
				e.preventDefault();
				var id = $("#username").val();
				var pwd = $.md5($("#password").val());
				cleanPwd();
				var url = "login/loginverify.php";
				$.post(url,{name:id,password:pwd},function(data,status){
					$("#signin_result").html(data);
					if( data == 'Success')
						window.location.href = "salvor.php?id="+id;
					}
					);
			});
			$("#register_submit").click(function(e){
				e.preventDefault();
				$(".register_tips").each(function(){$(this).html("");});
				if(!verifyRegister())
					return;
				var id = $("#registername").val();
				var pwd = $.md5($("#registerpassword").val());
				var url = "login/register.php";
				$.post(url,{name:id,password:pwd},function(data,status){
					$("#pwd_tips").html(data);
					if( data == 'Success')
						window.location.href = "salvor.php?id="+id +"&edit=1";
					}
					);
			});
			
			$("fieldset#signin_menu").mouseup(function() {
				return false;
			});
			$(document).mousedown(function(e) {
				if($(e.target).parents("#signin_menu").length==0 && $("#signin_menu").is(':visible')) {
					$("fieldset#signin_menu").fadeOut();
					cleanPwd();
				}
				if($(e.target).parents(".register").length==0 && $("#register_menu").is(':visible')) {
					$("#register_menu").fadeOut();
					cleanPwd();
				}
			});			
			
        });
</script> 
<script src="javascripts/jquery.tipsy.js" type="text/javascript"></script> 
<script type='text/javascript'>
    $(function() {
	  $('#tips').tipsy({gravity: 'w'});   
    });
  </script>
</body>
</html>
