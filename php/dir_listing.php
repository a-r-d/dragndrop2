<?php
require("lib.php");
$parent_dir = $_GET["dir"];
$parent_dir = ".".$parent_dir."/";
if( strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
	//$parent_dir = cleanSlashesReverse($parent_dir);
	//echo $parent_dir;
	//echo "\n";
	$arr = getDirListingAndFileListing($parent_dir);
	$file_arr = array();
	$dirs_arr = array();
	foreach( $arr["files"] as $file ) {
		array_push($file_arr, cleanSlashes($file));
	}
	foreach( $arr["dirs"] as $dir ) {
		array_push($dirs_arr, cleanSlashes($dir));
	}
	echo json_encode(array("files"=>$file_arr, "dirs"=>$dirs_arr));
} else {
	$arr = getDirListingAndFileListing($parent_dir);
	echo json_encode($arr);
}
?>