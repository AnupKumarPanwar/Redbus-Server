<?php

include_once('constants.php');
include_once('middleware.php');

$bus_id = $_SESSION['bus_id'];

$getActiveTrip = "SELECT * FROM trips, routes WHERE trips.bus_id='$bus_id' AND route_id=routes.id AND completed_at IS NULL";

$result = mysqli_query($conn, $getActiveTrip);

if ($result) {
	if (mysqli_num_rows($result) != 1) {
		$response = array(
			'result' => array(
				'success' => false,
				'message' => 'No active trips.'
			)
		);
		die(sendResponse($response));
	}
	$r = mysqli_fetch_assoc($result);
	$response = array(
		'result' => array(
			'success' => true,
			'message' => 'Active trip fetched successfully.',
			'data' => $r
		)
	);
	die(sendResponse($response));
} else {
	$response = array(
		'result' => array(
			'success' => false,
			'message' => 'Failed to get active trip.'
		)
	);
	die(sendResponse($response));
}

?>