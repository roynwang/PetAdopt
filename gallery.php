<head>
<title>Gallery test</title>
<script type='text/javascript' src='javascripts/jquery-1.8.2.min.js'></script>
<script type='text/javascript' src='javascripts/jquery.justifiedgallery.js'></script>
</head>
<link href="front.css" media="screen, projection" rel="stylesheet" type="text/css">
<link rel='stylesheet' href="css/jquery.justifiedgallery.css" type='text/css' media='all' />
<body>
<div class="gallery">
<?php
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
				$images[$i] ="./usrimages/".$file;	
				$i++;
			}
		}
	}
	return $images;
}
foreach(getImages("./usrimages") as $image){
	echo "<a href=\"".$image."\" title=\"test\">";
	echo "<img alt=\"!!!!!!!!!!!!!!!!!!!!\", src=\"".$image."\"/>";
	echo "</a>\n";
}
?>
</div>
<script type="text/javascript">
$(".gallery").justifiedGallery();
</script>
</body>
