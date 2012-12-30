<?php

function getFileExtension($str) {
	$i = strrpos($str,".");
	if (!$i) { 
		return ""; 
	}
	$l = strlen($str) - $i;
	$ext = substr($str,$i+1,$l);
	return $ext;
}

function cleanSlashes($str) {
	return str_replace('\\', '/', $str);
}

function cleanSlashesReverse($str) {
	return str_replace('/', '\\', $str);
}

function makeJavascriptArray($arr, $arr_name) {
	$current_array_string = "";
	$i = 0;
	$current_array_string .= "var $arr_name = [";
	foreach( $arr as $name) {
		$fixed = cleanSlashes($name);
		if( $i == count($arr) - 1) {
			$current_array_string .= "\"$fixed\"";
			break;
			}
		$current_array_string .= "\"$fixed\",";
		$i++;
		}		
	$current_array_string .= "];\n";
	return $current_array_string;	
}

function makeJavascriptFullDimsArray($arr, $arr_name) {
	$current_array_string = "";
	$i = 0;
	$current_array_string .= "var $arr_name = [";
	foreach( $arr as $photo_file_arr) {
		$fixed = cleanSlashes($photo_file_arr["name"]);
		if( $i == count($arr) - 1) {
			$current_array_string .= "{name:\"$fixed\", width:".$photo_file_arr["width"].", height:".$photo_file_arr["height"]."}";
			break;
			}
		$current_array_string .= "{name:\"$fixed\", width:".$photo_file_arr["width"].", height:".$photo_file_arr["height"]."},";
		$i++;
		}		
	$current_array_string .= "];\n";
	return $current_array_string;
}

function getDirListingAndFileListing($parent_dir) {
	$photo_file_names = array();
	$dir_file_names = array();
	
	foreach (new RecursiveDirectoryIterator($parent_dir) as $filename => $file) {
	    //echo $filename . ' - ' . $file->getSize() . ' bytes <br/>';
		if( is_dir($file)  &&  
			strpos( $filename, "/." ) == false && 
			strpos( $filename, "\\." ) == false && 
			strpos( $filename, "/.." ) == false && 
			strpos( $filename, "\\.." ) == false
			) {
			array_push($dir_file_names, $filename);
		}
		
		if( is_file($file) && 
			(	strpos( $filename, ".jpg" ) != false || 
				strpos( $filename, ".jpeg" ) != false || 
				strpos( $filename, ".png" ) != false ||
				strpos( $filename, ".gif" ) != false) 
			) {
			$exif = exif_read_data($file);
			array_push($photo_file_names, array("name"=>$filename, "width"=>$exif["COMPUTED"]["Width"], "height"=>$exif["COMPUTED"]["Height"]));	
		}
	}
	return array("files"=>$photo_file_names, "dirs"=>$dir_file_names);
}


?>