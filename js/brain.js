$( document ).ready(function(){
	/***
	 *  There are two arrays that are processed server side:
	 *  photo_files
	 *  dir_files
	 */
	$(".fancybox").fancybox();
	
	initApp();
	
	fillPhotoArea(photo_files);
	fillDirArea(dir_files);
});

function initApp() {
	dir_files.unshift($("#parentDir").html()); // put the root in first so we can navigate back to it.
}

function traverse(dir_to_go_to) {
	// fix trailing slash
	if(dir_to_go_to.substring(dir_to_go_to.length - 1, dir_to_go_to.length) === "/")
		dir_to_go_to = dir_to_go_to.substring(0, dir_to_go_to.length - 1);
	console.log("Dir:" + dir_to_go_to);
	$("#parentDir").empty().append(dir_to_go_to);
	var dat = {
		dir: dir_to_go_to	
	};
	$.ajax({
		url: "php/dir_listing.php",
		data:dat,
		dataType:"json",
		success: function(result) {
			var file_arr = result.files;
			var dir_arr = result.dirs;
			$("#photoListing").empty();
			$("#directoryListing").empty();
			
			var dir_arr_no_dupes = deDupe(dir_files, twoToOneDots(dir_arr));
			dir_files = dir_arr_no_dupes; // swap this out for the new one.
			fillPhotoArea(twoToOneDotsPhoto(file_arr));
			fillDirArea(dir_arr_no_dupes);
		},
		error: function(result) {
			console.log("There was some error: " + result);
			alert("error getting files");
		}
	});
}

function fillPhotoArea(arr) {
	for(var i = 0; i < arr.length; i++) {
		var name = arr[i].name;
		var width = arr[i].width;
		var height = arr[i].height;
		var new_dims = imageResizer(width, height);
		var new_image = "<a class='fancybox imageThumbLink' rel='group' href='" + name + "'>" +
				"<img class='imageThumbImg' src='" + name + "' width='" + new_dims.width + "' height='" + new_dims.height + "' /></a>";
		$("#photoListing").append(new_image);
	}
}

function fillDirArea(arr) {
	for(var i = 0; i < arr.length; i++) {
		var new_dir = "<div><a class='dirThumbLink' src='#' onClick='traverse(\"" + arr[i] + "\")'><img class='dirThumbImg' src='img/foldr_125.png'/><span>" + arr[i] + "</span></a></div>";
		$("#directoryListing").append(new_dir);
	}
}

function twoToOneDots(arr){
	var fixed = [];
	for(var i=0; i < arr.length; i++) {
		fixed.push(arr[i].replace("..", "."));
	}
	return fixed;
}

function twoToOneDotsPhoto(arr){
	var fixed = [];
	for(var i=0; i < arr.length; i++) {
		fixed.push({name: arr[i].name.replace("..", "."), width:arr[i].width, height:arr[i].height });
	}
	return fixed;
}

function is_in_array(val, arr) {
	for(var i=0; i < arr.length; i++) {
		if( arr[i] === val) return true;
	}
	return false;
}

function deDupe(arr_original, arr_to_add) {
	var no_dupes = [];
	for(var i=0; i < arr_original.length; i++) {
		no_dupes.push(arr_original[i]);
	}
	for(var i=0; i < arr_to_add.length; i++) {
		var found = false;
		if( is_in_array(arr_to_add[i], arr_original) ) {
			found = true;
			break;
		}
		if( found ) {
			continue;
		} else {
			no_dupes.push(arr_to_add[i]);
		}
	}
	return no_dupes;
}

// 
var max_height = 200;
var max_width = 200;
function imageResizer(width, height) {
	var new_height = 0;
	var new_width = 0;
	var aspect_ratio_width = width / height;
	var aspect_ratio_height = height / width;
	// if wider
	if(width > height) {
		if( width > max_width ) {
			new_width = max_width;
			new_height = aspect_ratio_height * max_height; // this is for when height is smaller.
		} else {
			new_width = width;
			new_height = height;
		}
	} else {
		if( height > max_height ) {
			new_height = max_height;
			new_width = aspect_ratio_width * max_width; // this is for when height is smaller.
		} else {
			new_width = width;
			new_height = height;
		}
	}
	return {
		height: new_height, 
		width: new_width
	};
}
