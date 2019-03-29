<?php

include_once('constants.php');
include_once('middleware.php');


if (isset($_POST['bookingId'])) {
	
	$bookingId = mysqli_escape_string($conn, $_POST['bookingId']);

	$updateBookingStatus = "UPDATE bookings SET status='DROPPED', dropoff_at=NOW() WHERE id='$bookingId'";

	$result = mysqli_query($conn, $updateBookingStatus);

	if (mysqli_affected_rows($conn)==1) {
		$response = array(
			'result' => array(
				'success' => true,
				'message' => 'User dropped off successfully.'
			)
		);
		die(sendResponse($response));
	} else {
		$response = array(
			'result' => array(
				'success' => false,
				'message' => 'Invalid bookingId.'
			)
		);
		die(sendResponse($response));
	}
} else {
		$response = array(
			'result' => array(
				'success' => false,
				'message' => 'Some error occured.'
			)
		);
		die(sendResponse($response));
	}
 