<!DOCTYPE html>
<?php
//get the three pet
ob_start();
require_once("queryheadline.php");
$ret = ob_get_contents();
ob_end_clean();
$ret = json_decode($ret);
if($ret->msg != "Success")
exit;
$children = $ret->children;
//foreach($children as $child){
///	echo $child->uid;
//}
?>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="">
		<meta name="author" content="">
		<!--<link rel="shortcut icon" href="../../assets/ico/favicon.ico">-->

		<title>Main Page</title>

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
	<!-- NAVBAR
	================================================== -->
	<body>
		<nav class="navbar main-nav" role="navigation">
		<div class="container">
			<div class="navbar-collapse collapse">
				<ul class="nav navbar-nav nav-item">
					<li><img data-src="holder.js/160x80/text:LOGO"></img></li>
					<li><a href="index.php">首页</a></li>
					<li><a href="browse.php?keywords=狗">汪们</a></li>
					<li><a href="browse.php?keywords=猫">喵们</a></li>
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

		<!--
		<div class="navbar">
			<div class="navbar-inner main-nav">
				<div class="container"  >
					<ul class="nav nav-item" >
						<li><img data-src="holder.js/160x80/text:LOGO"></img></li>
						<li><a href="#">首页</a></li>
						<li><a href="#">汪们</a></li>
						<li><a href="#">喵们</a></li>
						<li class="pull-right ">
							<form class="form-search form-inline">
								<div class="input-append">
									<input type="text" class="form-control">
									<button type="submit" class="btn"> <span class="glyphicon glyphicon-search"></span></button>
								</div>
							</form>
						</li>
					</ul>


				</div>
			</div>
		</div>
		-->

		<!--
		<div id="myCarousel" class="carousel slide" data-ride="carousel">
			<ol class="carousel-indicators">
				<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
				<li data-target="#myCarousel" data-slide-to="1"></li>
				<li data-target="#myCarousel" data-slide-to="2"></li>
			</ol>
			<div class="carousel-inner">
				<div class="item active">
					<img data-src="holder.js/900x500/auto/#777:#7a7a7a/text:First slide" alt="First slide">
					<div class="container">
						<div class="carousel-caption">
							<h1>Example headline.</h1>
							<p>Note: If you're viewing this page via a <code>file://</code> URL, the "next" and "previous" Glyphicon buttons on the left and right might not load/display properly due to web browser security rules.</p>
							<p><a class="btn btn-lg btn-primary" href="#" role="button">Sign up today</a></p>
						</div>
					</div>
				</div>
				<div class="item">
					<img data-src="holder.js/900x500/auto/#666:#6a6a6a/text:Second slide" alt="Second slide">
					<div class="container">
						<div class="carousel-caption">
							<h1>Another example headline.</h1>
							<p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
							<p><a class="btn btn-lg btn-primary" href="#" role="button">Learn more</a></p>
						</div>
					</div>
				</div>
				<div class="item">
					<img data-src="holder.js/900x500/auto/#555:#5a5a5a/text:Third slide" alt="Third slide">
					<div class="container">
						<div class="carousel-caption">
							<h1>One more for good measure.</h1>
							<p>Cras justo odio, dapibus >
								ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
							<p><a class="btn btn-lg btn-primary" href="#" role="button">Browse gallery</a></p>
						</div>
					</div>
				</div>
			</div>
			<a class="left carousel-control" href="#myCarousel" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a>
			<a class="right carousel-control" href="#myCarousel" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>
		</div>
		-->



		<!-- Marketing messaging and featurettes
		================================================== -->
		<!-- Wrap the rest of the page in another container to center all the content. -->

		<div class="container marketing">

			<!-- Three columns of text below the carousel -->
			<div class="carousel slide" id="main-slide" data-ride="carousel">
				<div class="row">
					<?php
					foreach($children as $child){
					echo '<div class="col-lg-4">';
						echo '<img class="img-circle" src="./photo/'.$child->uid.'/'.$child->photo.'"  alt="Generic placeholder image">';
						echo '<h2>'.$child->name.'</h2>';
						//echo '<p>'.$child->description.'</p>';
						echo '<p><a class="btn btn-default" href="pet.php?uid='.$child->uid.'" role="button">详情 &raquo;</a></p>';
						echo '</div><!-- /.col-lg-4 -->';
					}
					?>

				</div><!-- /.row -->
				<!--temp remove the arrow
				<a class="left carousel-control" href="#myCarousel" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a>
				<a class="right carousel-control" href="#myCarousel" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>
				-->
			</div>


			<!-- START THE FEATURETTES -->

			<hr class="featurette-divider">

			<div class="row featurette">
				<div class="col-md-7">
					<h2 class="featurette-heading">First featurette heading. <span class="text-muted">It'll blow your mind.</span></h2>
					<p class="lead">Donec ullamcorper nulla non metus auctor fringilla. Vestibulum id ligula porta felis euismod semper. Praesent commodo cursus magna, vel scelerisque nisl consectetur. Fusce dapibus, tellus ac cursus commodo.</p>
				</div>
				<div class="col-md-5">
					<img class="featurette-image img-responsive" data-src="holder.js/500x500/auto" alt="Generic placeholder image">
				</div>
			</div>

			<hr class="featurette-divider">

			<div class="row featurette">
				<div class="col-md-5">
					<img class="featurette-image img-responsive" data-src="holder.js/500x500/auto" alt="Generic placeholder image">
				</div>
				<div class="col-md-7">
					<h2 class="featurette-heading">Oh yeah, it's that good. <span class="text-muted">See for yourself.</span></h2>
					<p class="lead">Donec ullamcorper nulla non metus auctor fringilla. Vestibulum id ligula porta felis euismod semper. Praesent commodo cursus magna, vel scelerisque nisl consectetur. Fusce dapibus, tellus ac cursus commodo.</p>
				</div>
			</div>

			<hr class="featurette-divider">

			<div class="row featurette">
				<div class="col-md-7">
					<h2 class="featurette-heading">And lastly, this one. <span class="text-muted">Checkmate.</span></h2>
					<p class="lead">Donec ullamcorper nulla non metus auctor fringilla. Vestibulum id ligula porta felis euismod semper. Praesent commodo cursus magna, vel scelerisque nisl consectetur. Fusce dapibus, tellus ac cursus commodo.</p>
				</div>
				<div class="col-md-5">
					<img class="featurette-image img-responsive" data-src="holder.js/500x500/auto" alt="Generic placeholder image">
				</div>
			</div>

			<hr class="featurette-divider">

			<!-- /END THE FEATURETTES -->


			<!-- FOOTER -->
			<footer>
			<p class="pull-right"><a href="#">Back to top</a></p>
			<p>&copy; 2014 Company, Inc. &middot; <a href="#">Privacy</a> &middot; <a href="#">Terms</a></p>
			</footer>

		</div><!-- /.container -->

		<!-- Bootstrap core JavaScript
		================================================== -->
		<!-- Placed at the end of the document so the pages load faster -->
		<script src="javascripts/jquery-1.8.2.min.js"></script>
		<script src="javascripts/bootstrap.min.js"></script>
		<script src="javascripts/docs.min.js"></script>
	</body>
</html>

