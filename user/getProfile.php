<?php

include_once ('constants.php');
include_once ('middleware.php');

$user_id = $_SESSION['user_id'];
$getProfile = "SELECT * FROM users WHERE id='$user_id'";

$result = mysqli_query($conn, $getProfile);

if ($result) {
	if (mysqli_num_rows($result)==1) {
	
		$r = mysqli_fetch_assoc($result);

		$response = array(
		    'result' => array(
		        'success' => True,
		        'message' => 'Profile fetched successfully.',
		        'data' => $r
		    )
		);
		die(sendResponse($response));
	}
	else {
		$response = array(
		    'result' => array(
		        'success' => False,
		        'message' => 'User does not exist.'
		    )
		);
		die(sendResponse($response));
	}
}
else {
	$response = array(
	    'result' => array(
	        'success' => False,
	        'message' => 'Failed to get profile.'
	    )
	);
	die(sendResponse($response));
}

?>