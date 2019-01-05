<?php

require ('constants.php');
require ('middleware.php');

if (isset($_POST['source']) && isset($_POST['destination']) &&) {
	
	$bus_id = $_SESSION['user_id'];
	$source = mysqli_escape_string($conn, $_POST['destination']);

	// $addBooking = "INSERT INTO bookings (trip_id, user_id, source, destination) VALUES "

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