<?php

include_once ('constants.php');
include_once ('middleware.php');

if (isset($_POST['sourceLat']) && isset($_POST['sourceLng']) && isset($_POST['routeId']) && isset($_POST['destinationLat']) && isset($_POST['destinationLng'])) {
	
	$sourceLat = mysqli_escape_string($conn, $_POST['sourceLat']);
	$sourceLng = mysqli_escape_string($conn, $_POST['sourceLng']);
	$routeId = mysqli_escape_string($conn, $_POST['routeId']);
	$destinationLat = mysqli_escape_string($conn, $_POST['destinationLat']);
	$destinationLng = mysqli_escape_string($conn, $_POST['destinationLng']);

	$searchBusQuery = "SELECT *, r.id as route_id, b.id as bus_id FROM buses b, routes r WHERE b.id=r.bus_id AND r.id='$routeId'";

	$result = mysqli_query($conn, $searchBusQuery);

	if ($result) {
			$sourceIndex = 0;
		
			$r = mysqli_fetch_assoc($result);

			$minDistSource = 500;
			$minDistDestination = 500;
			
			$waypoints = $r['waypointsLatLong'];
			// echo $waypoints;
			$waypoints_array = explode('|', $waypoints);
			for ($i=0; $i < count($waypoints_array)-1; $i++) { 
				// echo($waypoints_array[$i]);
				$latLong = explode(',', $waypoints_array[$i]);
				$lat = $latLong[0];
				$long = $latLong[1];

				$distance = ($lat-$sourceLat)*($lat-$sourceLat) + ($long-$sourceLng)*($long-$sourceLng);
				if ($distance < $minDistSource) {
					$minDistSource = $distance;
					$sourceIndex = $i;
					$nearestSource = $latLong;
				}
			}

			for ($i=$sourceIndex; $i < count($waypoints_array)-1; $i++) { 
				$latLong = explode(',', $waypoints_array[$i]);
				$lat = $latLong[0];
				$long = $latLong[1];

				$distance = ($lat-$destinationLat)*($lat-$destinationLat) + ($long-$destinationLng)*($long-$destinationLng);
				if ($distance < $minDistDestination) {
					$minDistDestination = $distance;
					$nearestDestination = $latLong;
				}
			}		


			$response = array(
			    'result' => array(
			        'success' => True,
			        'message' => 'Successfully fetched nearest waypoints.',
			        'data' => array(
			        	'neareatSource' => $nearestSource,
			        	'nearestDestination' => $nearestDestination,
			            'otp' => '0000',
			            'fare' => '500',
			        	'route' => $r
			        )
			    )
			);
			die(sendResponse($response));	
	}
	else {
		$response = array(
		    'result' => array(
		        'success' => False,
		        'message' => 'Failed to check routes.'
		    )
		);
		die(sendResponse($response));
	}
}
else {
	$response = array(
	    'result' => array(
	        'success' => False,
	        'message' => 'Some error occured.'
	    )
	);
	die(sendResponse($response));
}
?>