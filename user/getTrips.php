<?php

include_once ('constants.php');
include_once ('middleware.php');

$user_id = $_SESSION['user_id'];
$getTrips = "SELECT * FROM bookings, trips, buses WHERE bookings.trip_id = trips.id AND trips.bus_id=buses.id AND bookings.user_id='$user_id' ORDER BY bookings.booked_at desc";

$result = mysqli_query($conn, $getTrips);

if ($result) {
		$allTrips = array();
		while ($r = mysqli_fetch_assoc($result)) {
			if ($r['cancelled']==1) {
				$r['status']='Cancelled';
			}
			elseif (!is_null($r['dropoff_at'])) {
				$r['status']='Completed';
			}
			elseif (!is_null($r['pickup_at'])) {
				$r['status']='Ongoing';	
			}
			else {
				$r['status']='Upcoming';
			}
			$allTrips[] = $r;
		}
		$response = array(
		    'result' => array(
		        'success' => True,
		        'message' => 'Trips fetched successfully.',
		        'data' => $allTrips
		    )
		);
		die(sendResponse($response));
	
}
else {
	$response = array(
	    'result' => array(
	        'success' => False,
	        'message' => 'Failed to get trips.'
	    )
	);
	die(sendResponse($response));
}

?>