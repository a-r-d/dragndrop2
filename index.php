<!DOCTYPE html>
<html>
<head>
	<title>Drag N Drop Gallery 2</title>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
	<script src="js/fancy_box/source/jquery.fancybox.js" type="text/javascript"></script>
	<link rel="stylesheet" href="js/fancy_box/source/jquery.fancybox.css" type="text/css" />
	<link rel="stylesheet" type="text/css" href="css/bootstrap/css/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="css/bootstrap/css/bootstrap-responsive.min.css" />
	<link rel="stylesheet" type="text/css" href="css/main.css" />
	<script type="text/javascript">
		<?php
		// pull in our library of functions.
		require("php/lib.php");
			$parent_dir = "./galleries/";
			
			$photo_file_names = array();
			$dir_file_names = array();
			
			$arr = getDirListingAndFileListing($parent_dir);
			$photo_file_names = $arr["files"];
			$dir_file_names = $arr["dirs"];
			// for  all of these, switch backslashes for forward slashes. Cause im developin on windows. Also php is retarted.
			echo makeJavascriptFullDimsArray($photo_file_names, "photo_files")."\n";
			echo makeJavascriptArray($dir_file_names, "dir_files")."\n";
		?>	
		</script>
		<script src="js/brain.js" type="text/javascript"></script>
</head>
<body>
<div class="container">
	<div class="row">
		<div class="hero-unit">
			<h1>Drag N Drop Gallery.</h1> Drop some pics on ./galleries
		</div>
	</div>
	<div class="row">
		<div class="span4">
			<b>Currently Viewing: </b><span id="parentDir"><?php echo $parent_dir ?></span>
		</div>
	</div>
	<div div class="row">
		<div class="span4" style="border-right-width: 1px; border-right-color: gray; border-right-style: solid;">
			<div>
			<br />
			<b>About:</b> Click below on the folders to navigate to a particular gallery. I like to organize my photos by camera. 
				The D5000 is the newest camera that I own. The D50 is the oldest DLSR. This uses PHP on the backend to iterate over the gallery directory,
				so anything you drop in there will be viewable and easy to navigate to from the web. There is no limit to recursive depth, but the next level will not show
				up until you navigate to one above it.
			</div>
			<div  id="directoryListing" class="dirThumbContainer">
			
			</div>
		</div>
		<div class="span7" id="photoListing" class="imageThumbContainer">
		
		</div>
	</div>
</div>
</body>
</html>