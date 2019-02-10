<?php

require ('constants.php');
require ('middleware.php');

function generateOTP($length = 4) {
    $characters = '0123456789';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

if (isset($_POST['source']) && isset($_POST['destination']) && isset($_POST['route_id']) && isset($_POST['bus_id'])) {
	
	$userId = $_SESSION['user_id'];
	$routeId = mysqli_escape_string($conn, $_POST['route_id']);
	$busId = mysqli_escape_string($conn, $_POST['bus_id']);
	$source = mysqli_escape_string($conn, $_POST['source']);
	$destination = mysqli_escape_string($conn, $_POST['destination']);

	$getTripId = "SELECT * FROM trips WHERE route_id='$routeId' AND completed_at IS NULL";
	$result = mysqli_query($conn, $getTripId);
	$r = mysqli_fetch_assoc($result);
	$tripId = $r['id'];

	$otp = generateOTP();

	$addBooking = "INSERT INTO bookings (user_id, trip_id, pickup_point, dropoff_point, otp, fare) VALUES ('$userId', '$tripId', '$source', '$destination', '$otp', 500)";

	$result = mysqli_query($conn, $addBooking);

	if ($result) {
		$response = array(
		    'result' => array(
		        'success' => True,
		        'message' => 'Booking successful.',
		        'data' => array(
		        	'otp' => $otp,
		        	'fare' => 500
		        )
		    )
		);
		die(json_encode($response));
	}
	else {
		$response = array(
		    'result' => array(
		        'success' => False,
		        'message' => 'Booking failed.'
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