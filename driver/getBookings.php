<?php

include_once ('constants.php');
include_once ('middleware.php');

$bus_id = $_SESSION['bus_id'];

$getTrip = "SELECT * FROM trips WHERE bus_id='$bus_id' AND completed_at IS NULL";
$result = mysqli_query($conn, $getTrip);

if (mysqli_num_rows($result)==0) {
	$response = array(
	    'result' => array(
	        'success' => False,
	        'message' => 'No bookings.'
	    )
	);
	die(sendResponse($response));
}

$r = mysqli_fetch_assoc($result);
$tripId = $r['id'];

$getBookings = "SELECT phone, name, age, gender, pickup_point, dropoff_point, otp, fare FROM bookings, users WHERE trip_id='$tripId' AND users.id=bookings.user_id AND cancelled=0";

$result = mysqli_query($conn, $getBookings);

if ($result) {
	$allBookings = array();
	while ($r = mysqli_fetch_assoc($result)) {
		$allBookings[] = $r;
	}
	$response = array(
	    'result' => array(
	        'success' => True,
	        'message' => 'Bookings fetched successfully.',
	        'data' => $allBookings
	    )
	);
	die(sendResponse($response));
}
else {
	$response = array(
	    'result' => array(
	        'success' => False,
	        'message' => 'Failed to get bookings.'
	    )
	);
	die(sendResponse($response));
}

?>