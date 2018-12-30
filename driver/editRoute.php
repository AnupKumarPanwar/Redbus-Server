<?php

require ('constants.php');
require ('middleware.php');


if (isset($_POST['routeId']) && isset($_POST['waypoints']) && isset($_POST['source']) && isset($_POST['destination']) && isset($_POST['departure_time']) && isset($_POST['waypointsLatLong']) && isset($_POST['sourceLatLong']) && isset($_POST['destinationLatLong'])) {

	
	$routeId = mysqli_escape_string($conn, $_POST['routeId']);
	$waypoints = mysqli_escape_string($conn, $_POST['waypoints']);
	$source = mysqli_escape_string($conn, $_POST['source']);
	$destination = mysqli_escape_string($conn, $_POST['destination']);
	$departure_time = mysqli_escape_string($conn, $_POST['departure_time']);

	$waypointsLatLong = mysqli_escape_string($conn, $_POST['waypointsLatLong']);
	$sourceLatLong = mysqli_escape_string($conn, $_POST['sourceLatLong']);
	$destinationLatLong = mysqli_escape_string($conn, $_POST['destinationLatLong']);

	$addRoute = "UPDATE routes SET source='$source', destination='$destination', waypoints='$waypoints', sourceLatLong='$sourceLatLong', destinationLatLong='$destinationLatLong', waypointsLatLong='$waypointsLatLong', departure_time='$departure_time' WHERE id='$routeId'";

	$result = mysqli_query($conn, $addRoute);

	if ($result) {
		$response = array(
		    'result' => array(
		        'success' => True,
		        'message' => 'Route added successfully.'
		    )
		);
		die(json_encode($response));
	}
	else {
		$response = array(
		    'result' => array(
		        'success' => False,
		        'message' => 'Failed to add route.'
		    )
		);
		die(json_encode($response));
	}
}
else
{
    $response = array(
        'result' => array(
            'success' => False,
            'message' => 'Some error occured.'
        )
    );
    die(json_encode($response));
}
?>