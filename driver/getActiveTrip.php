<?php

require('constants.php');
require('middleware.php');

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
		die(json_encode($response));
	}
	$r = mysqli_fetch_assoc($result);
	$response = array(
		'result' => array(
			'success' => true,
			'message' => 'Active trip fetched successfully.',
			'data' => $r
		)
	);
	die(json_encode($response));
} else {
	$response = array(
		'result' => array(
			'success' => false,
			'message' => 'Failed to get active trip.'
		)
	);
	die(json_encode($response));
}

?>