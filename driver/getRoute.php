<?php

include_once ('constants.php');
include_once ('middleware.php');

if (isset($_POST['route_id'])) {

	$route_id = mysqli_escape_string($conn, $_POST['route_id']);

	$getRoute = "SELECT * FROM routes WHERE id='$route_id'";

	$result = mysqli_query($conn, $getRoute);

	if ($result) {
		$r = mysqli_fetch_assoc($result);
			
		$response = array(
		    'result' => array(
		        'success' => True,
		        'message' => 'Route fetched successfully.',
		        'data' => $r
		    )
		);
		die(sendResponse($response));
	}
	else {
		$response = array(
		    'result' => array(
		        'success' => False,
		        'message' => 'Failed to get route.'
		    )
		);
		die(sendResponse($response));
	}
}
else {
	$response = array(
	    'result' => array(
	        'success' => False,
	        'message' => 'Some error occured.'
	    )
	);
	die(sendResponse($response));
}

?>