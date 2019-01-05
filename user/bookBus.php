<?php

require ('constants.php');
require ('middleware.php');

if (isset($_POST['source']) && isset($_POST['destination']) && isset($_POST['route_id'])) {
	
	$userId = $_SESSION['user_id'];
	$routeId = mysqli_escape_string($conn, $_POST['route_id']);
	$source = mysqli_escape_string($conn, $_POST['source']);
	$destination = mysqli_escape_string($conn, $_POST['destination']);

	$

	$addBooking = "INSERT INTO bookings (route_id, user_id, source, destination, booked_at) VALUES ('routeId', '$userId', '$source', '$destination', NOW())";

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