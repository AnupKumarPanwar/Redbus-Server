<?php

require ('constants.php');
require ('middleware.php');


if (isset($_POST['routeId'])) {

	$bus_id = $_SESSION['bus_id'];
	$routeId = mysqli_escape_string($conn, $_POST['routeId']);

	$checkAddedTrip = "SELECT * FROM trips WHERE bus_id='$bus_id' AND started_at IS NULL";
	$result = mysqli_query($conn, $checkAddedTrip);

	$checkTripStarted = "SELECT * FROM trips WHERE bus_id='$bus_id' AND started_at IS NOT NULL AND completed_at IS NULL";
	$result2 = mysqli_query($conn, $checkTripStarted);

	if (mysqli_num_rows($result)==1) {
		$addTrip = "UPDATE trips SET started_at=NOW() WHERE bus_id='$bus_id' AND started_at IS NULL";
	}
	else if(mysqli_num_rows($result2)!=0) {
		$response = array(
		    'result' => array(
		        'success' => False,
		        'message' => 'Trip already started'
		    )
		);
		die(json_encode($response));
	}
	else {
		$addTrip = "INSERT INTO trips (bus_id, route_id, started_at) VALUES ('$bus_id', '$routeId', NOW())";
	}

	$result = mysqli_query($conn, $addTrip);

	$getTripId = "SELECT * FROM trips WHERE completed_at IS NULL AND route_id='$routeId'";
	
	$result2 = mysqli_query($conn, $getTripId);
	$r = mysqli_fetch_assoc($result2);

	// echo(mysqli_error($conn));

	if ($result) {
		$response = array(
		    'result' => array(
		        'success' => True,
		        'message' => 'Trip started successfully.',
		        'data' => $r
		    )
		);
		die(json_encode($response));
	}
	else {
		$response = array(
		    'result' => array(
		        'success' => False,
		        'message' => 'Failed to start trip.'
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