<?php

require ('constants.php');
require ('middleware.php');

$user_id = $_SESSION['user_id'];

$getBookings = "SELECT route_id, pickup_point, dropoff_point  FROM bookings, trips WHERE bookings.user_id='$user_id' AND dropoff_at IS NULL AND bookings.trip_id=trips.id";

$result = mysqli_query($conn, $getBookings);

echo(mysqli_error($conn));

if(mysqli_num_rows($result)!=1) {
	$response = array(
	    'result' => array(
	        'success' => False,
	        'message' => 'No bookings.'
	    )
	);
	die(json_encode($response));
}

$r = mysqli_fetch_assoc($result);
$routeId = $r['route_id'];
$bestSource = explode(',', $r['pickup_point']);
$bestDestination = explode(',', $r['dropoff_point']);

$getRoute = "SELECT *, r.id as route_id, b.id as bus_id FROM buses b, routes r WHERE b.id=r.bus_id AND r.id='$routeId'";
$result = mysqli_query($conn, $getRoute);
$r=mysqli_fetch_assoc($result);

$response = array(
    'result' => array(
        'success' => True,
        'message' => 'Successfully fetched bookings.',
        'data' => array(
        	'neareatSource' => $bestSource,
        	'nearestDestination' => $bestDestination,
        	'route' => $r
        )
    )
);
die(json_encode($response));	

?>