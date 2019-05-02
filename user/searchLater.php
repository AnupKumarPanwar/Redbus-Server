<?php

include_once ('constants.php');
include_once ('middleware.php');

if (isset($_POST['sourceLat']) && isset($_POST['sourceLng']) && isset($_POST['destinationLat']) && isset($_POST['destinationLng'])) {
	
	$sourceLat = number_format(floatval(mysqli_escape_string($conn, $_POST['sourceLat'])),1,'.','');
	$sourceLng = number_format(floatval(mysqli_escape_string($conn, $_POST['sourceLng'])),1,'.','');
	$destinationLat = number_format(floatval(mysqli_escape_string($conn, $_POST['destinationLat'])),1,'.','');
	$destinationLng = number_format(floatval(mysqli_escape_string($conn, $_POST['destinationLng'])),1,'.','');

	$searchBusQuery = "SELECT *, r.id as route_id, b.id as bus_id FROM buses b, routes r WHERE (r.waypointsLatLong LIKE '%$sourceLat%,$sourceLng%$destinationLat%,$destinationLng%') AND b.id=r.bus_id";

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