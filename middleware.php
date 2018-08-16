<?php

require 'constants.php';
session_start();

$headers = apache_request_headers();

// if (!isset($headers['Authorization']) || empty($headers['Authorization'])) {
// 	$response = array(
// 	    'result' => array(
// 	        'success' => False,
// 	        'message' => 'Invalid access token.'
// 	    )
// 	);
// 	die(json_encode($response));
// } else {
// 	$access_token = mysqli_escape_string($conn, $headers['Authorization']);
// 	$checkAccessToken = "SELECT access_token FROM users WHERE access_token = '$access_token'";
// 	$result = mysqli_query($conn, $checkAccessToken);
// 	if (mysqli_num_rows($result)!=1) {
// 		$response = array(
// 		    'result' => array(
// 		        'success' => False,
// 		        'message' => 'Invalid access token.'
// 		    )
// 		);
// 		die(json_encode($response));
// 	}
// 	else {
// 		$_SESSION['access_token'] = $access_token;
// 	}
// }

function upload_image($sub_dir) {
	$timestamp = 'u'.time();
	$target_dir = $GLOBALS['uploadDirectory'].$sub_dir.'/';
	$target_file = $target_dir.$timestamp.basename($_FILES["imageToUpload"]["name"]);
	$uploadOk = 1;
	$message = "Image uploaded successfully.";
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	$check = getimagesize($_FILES["imageToUpload"]["tmp_name"]);
	if($check !== false) {
	    $uploadOk = 1;
	} else {
	    $message = "File is not an image.";
	    $uploadOk = 0;
	}
	// Check if file already exists
	if (file_exists($target_file)) {
	    $message = "File already exists.";
	    $uploadOk = 0;
	}
	// Check file size
	if ($_FILES["imageToUpload"]["size"] > 5000000) {
	    $message = "File is too large.";
	    $uploadOk = 0;
	}
	// Allow certain file formats
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" && $imageFileType != "JPG" && $imageFileType != "PNG" && $imageFileType != "JPEG" && $imageFileType != "GIF" ) {
	    $message = "Invalid image format.";
	    $uploadOk = 0;
	}
	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) {
	    $message = "File uploading failed.";
	// if everything is ok, try to upload file
	} else {
	    if (move_uploaded_file($_FILES["imageToUpload"]["tmp_name"], $target_file)) {
	        $message = "Image uploaded successfully.";
	    } else {
	    	$uploadOk = 0;
	        $message = "File uploading failed.";
	    }
	}

	$response = array(
	    'result' => array(
	        'success' => $uploadOk,
	        'message' => $message,
	        'file_name' => $target_file
	    )
	);
	return $response;
}

?>