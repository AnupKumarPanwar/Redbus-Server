<?php

include_once('constants.php');
include_once('middleware.php');


if (isset($_POST['bookingId']) && isset($_POST['otp'])) {
	
	$bookingId = mysqli_escape_string($conn, $_POST['bookingId']);
	$otp = mysqli_escape_string($conn, $_POST['otp']);

	$updateBookingStatus = "UPDATE bookings SET status='PICKED', pickup_at=NOW() WHERE id='$bookingId' AND otp='$otp'";

	$result = mysqli_query($conn, $updateBookingStatus);

	if (mysqli_affected_rows($result)==1) {
		$response = array(
			'result' => array(
				'success' => true,
				'message' => 'User picked up successfully.'
			)
		);
		die(sendResponse($response));
	} else {
		$response = array(
			'result' => array(
				'success' => false,
				'message' => 'Invalid OTP.'
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
 