<?php

require ('constants.php');
require ('middleware.php');

$user_id = $_SESSION['user_id'];
$getBookings = "SELECT buses.id, name, phone, bus_number, bus_type  FROM bookings, buses, trips WHERE bookings.user_id='$user_id' AND dropoff_at IS NULL AND bookings.trip_id=trips.id AND trips.bus_id=buses.id";

$result = mysqli_query($conn, $getBookings);

if ($result) {
	if (mysqli_num_rows($result)==1) {
	
		$r = mysqli_fetch_assoc($result);

		$response = array(
		    'result' => array(
		        'success' => True,
		        'message' => 'Bookings fetched successfully.',
		        'data' => $r
		    )
		);
		die(json_encode($response));
	}
	else {
		$response = array(
		    'result' => array(
		        'success' => False,
		        'message' => 'No bookings.'
		    )
		);
		die(json_encode($response));
	}
}
else {
	$response = array(
	    'result' => array(
	        'success' => False,
	        'message' => 'Failed to get bookings.'
	    )
	);
	die(json_encode($response));
}

?>