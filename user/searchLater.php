<?php

include_once ('constants.php');
include_once ('middleware.php');

if (isset($_POST['source']) && isset($_POST['destination'])) {
	
	$source = mysqli_escape_string($conn, $_POST['source']);
	$destination = mysqli_escape_string($conn, $_POST['destination']);

	$searchBusQuery = "SELECT *, r.id as route_id, b.id as bus_id FROM buses b, routes r WHERE (r.waypoints LIKE '%$source%$destination%' OR (r.source LIKE '%$source%' AND r.waypoints LIKE '%$destination%') OR (r.source LIKE '%$source%' AND r.destination LIKE '%$destination%') OR (r.waypoints LIKE '%$source%' AND r.destination LIKE '%$destination%')) AND b.id=r.bus_id";

	$result = mysqli_query($conn, $searchBusQuery);

	if (mysqli_num_rows($result)>0) {
		$availableBuses = [];
		while ($r = mysqli_fetch_assoc($result)) {
			$availableBuses[] = $r;
		}
		$response = array(
		    'result' => array(
		        'success' => True,
		        'message' => 'Successfully fetched available buses.',
		        'data' => $availableBuses
		    )
		);
		die(sendResponse($response));
	}
	else {
		$response = array(
		    'result' => array(
		        'success' => False,
		        'message' => 'No buses available.'
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