<?php

require ('constants.php');
require ('middleware.php');

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
		die(json_encode($response));
	}
	else {
		$response = array(
		    'result' => array(
		        'success' => False,
		        'message' => 'Failed to get route.'
		    )
		);
		die(json_encode($response));
	}
}
else {
	$response = array(
	    'result' => array(
	        'success' => False,
	        'message' => 'Some error occured.'
	    )
	);
	die(json_encode($response));
}

?>