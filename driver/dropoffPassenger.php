<?php

include_once('constants.php');
include_once('middleware.php');


if (isset($_POST['bookingId'])) {
	
	$bookingId = mysqli_escape_string($conn, $_POST['bookingId']);

	$updateBookingStatus = "UPDATE bookings SET status='DROPPED', dropoff_at=NOW() WHERE id='$bookingId' AND status='PICKED'";

	$result = mysqli_query($conn, $updateBookingStatus);

	if (mysqli_affected_rows($conn)==1) {
		$getBookingInfo = "SELECT * FROM bookings WHERE id='$bookingId'";
		$result = mysqli_query($conn, $getBookingInfo);
		$r = mysqli_fetch_assoc($result);
		$userId = $r['user_id'];
		$fare = $r['fare'];
		$cashbackAmount = rand(1, $fare/5);
		$giveCashback = "INSERT into cashbacks (user_id, booking_id, amount, status, created_at) VALUES ('$userId', '$bookingId', '$cashbackAmount', NOW()";
		$result = mysqli_query($conn, $giveCashback);

		if($result) {
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
					'success' => true,
					'message' => 'User dropped off successfully without cashback.'
				)
			);
			die(sendResponse($response));
		}
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
 