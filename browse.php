<!DOCTYPE html>
<?php
$offset = 0;
$page=0;
$keywords="";
if(isset($_GET["keywords"])){

$keywords=$_GET["keywords"];
//$keywords=iconv("gbk","utf-8",$keywords);
//echo "$keywords~~~~";
}
else{
exit;
}
if(isset($_GET["page"])){
$page = $_GET["page"];
}



$offset = $page*15;

ob_start();
$count=15;
require_once("search.php");
$ret = ob_get_contents();
ob_end_clean();
$ret = json_decode($ret);
if($ret->msg != "Success"){
exit;
}
$children = $ret->children;
$count = $ret->count;
?>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="">
		<meta name="author" content="">
		<!--<link rel="shortcut icon" href="../../assets/ico/favicon.ico">-->

		<title>浏览</title>

		<!-- Bootstrap core CSS -->
		<link href="css/bootstrap.min.css" rel="stylesheet">

		<!-- TODC Bootstrap core CSS -->
		<link href="css/todc-bootstrap.min.css" rel="stylesheet">

		<!-- Just for debugging purposes. Don't actually copy this line! -->
		<!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->

		<!-- Custom styles for this template -->
		<link href="css/carousel.css" rel="stylesheet">
		<link href="css/mainpage.css" rel="stylesheet">
	</head>
	<body>
		<nav class="navbar main-nav" role="navigation">
		<div class="container">
			<div class="navbar-collapse collapse">
				<ul class="nav navbar-nav nav-item">
					<li><img data-src="holder.js/160x80/text:LOGO"></img></li>
					<li><a href="index.php">首页</a></li>
					<li><a href="browse.php?keywords=0">汪们</a></li>
					<li><a href="browse.php?keywords=1">喵们</a></li>
					<li class="pull-right"><a href="login.php">救助人入口</a></li>
				</ul>
				<form class="navbar-form navbar-right" action="browse.php" method="get">
					<div class="form-group">
						<input id="querytext" type="text" placeholder="搜一下..." class="form-control" accept-charset="utf-8" name="keywords">
					</div>
					<button id="searchbtn" type="submit" class="btn btn-success"><span class="glyphicon glyphicon-search"></span></button>
				</form>
			</div><!--/.navbar-collapse -->
		</div>
		</nav>
		<div class="container" id="result-container">
			<?php 	
			for($i=0; $i<$count;$i++){
			$child = $children[$i];
			echo ' <div class="col-sm-6 col-md-4">
				<div class="thumbnail thumbnail-searchresult">
					<img src="./photo/'.$child->uid.'/'.$child->photo.'" alt="..." class="img-searchresult">
					<div class="caption">
						<h3>'.$child->name.'</h3>
						<p>...</p>
						<p><a href="#" class="btn btn-primary" role="button">Button</a> <a href="#" class="btn btn-default" role="button">Button</a></p>
					</div>
				</div>
			</div>';

			}

			?>
		</div>
		<div class="container">
			<ul class="pagination">
				<li><a href="#">Prev</a></li>
				<li><a href="#">1</a></li>
				<li><a href="#">2</a></li>
				<li><a href="#">3</a></li>
				<li><a href="#">4</a></li>
				<li><a href="#">5</a></li>
				<li><a href="#">Next</a></li>
			</ul>
		</div>

		<div class="container">
			<!-- FOOTER -->
			<footer>
			<p class="pull-right"><a href="#">Back to top</a></p>
			<p>&copy; 2014 Company, Inc. &middot; <a href="#">Privacy</a> &middot; <a href="#">Terms</a></p>
			</footer>
		</div>


		<script src="javascripts/jquery-1.8.2.min.js"></script>
		<script src="javascripts/bootstrap.min.js"></script>
		<script src="javascripts/docs.min.js"></script>

		<script type="text/javascript">
			$(document).ready(function(){
					$('.thumbnail img').css({
						'height': $('.thumbnail img').height(),
						'margin-left': 0,
						'margin-right': 0,
						});
					});
				</script>

			</body>
		</body>
		<html>

