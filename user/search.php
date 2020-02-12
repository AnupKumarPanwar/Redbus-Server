<?php

include_once ('constants.php');
include_once ('middleware.php');

if (isset($_POST['slat']) && isset($_POST['slong']) && isset($_POST['type']) && isset($_POST['dlat']) && isset($_POST['dlong'])) {
	
	$slat = mysqli_escape_string($conn, $_POST['slat']);
	$slong = mysqli_escape_string($conn, $_POST['slong']);
	$dlat = mysqli_escape_string($conn, $_POST['dlat']);
	$dlong = mysqli_escape_string($conn, $_POST['dlong']);
	$type = mysqli_escape_string($conn, $_POST['type']);

	$searchBusQuery = "SELECT *, r.id as route_id, b.id as bus_id FROM buses b, routes r, trips t WHERE b.id=r.bus_id AND b.bus_type='$type' AND t.route_id=r.id AND t.completed_at IS NULL";

	$result = mysqli_query($conn, $searchBusQuery);

	if ($result) {
		$sourceIndex = 0;
		$minTotalDistance = 2000;

		$nearestSource = 0;
		$nearestDestination = 0;

		$bestRouteId = 0;
		$bestSource = 0;
		$bestDestination = 0;


		while ($r = mysqli_fetch_assoc($result)) {

			$minDistSource = 500;
			$minDistDestination = 500;
			
			$latLong = explode(',', $r['sourceLatLong']);
			$lat = $latLong[0];
			$long = $latLong[1];


			$distance = ($lat-$slat)*($lat-$slat) + ($long-$slong)*($long-$slong);
			if ($distance < $minDistSource) {
				$minDistSource = $distance;
				$sourceIndex = 0;
				$nearestSource = $latLong;
			}

			$waypoints = $r['waypointsLatLong'];
			// echo $waypoints;
			$waypoints_array = explode('|', $waypoints);
			for ($i=0; $i < count($waypoints_array)-1; $i++) { 
				// echo($waypoints_array[$i]);
				$latLong = explode(',', $waypoints_array[$i]);
				$lat = $latLong[0];
				$long = $latLong[1];

				$distance = ($lat-$slat)*($lat-$slat) + ($long-$slong)*($long-$slong);
				if ($distance < $minDistSource) {
					$minDistSource = $distance;
					$sourceIndex = $i;
					$nearestSource = $latLong;
				}
			}

			$latLong = explode(',', $r['destinationLatLong']);
			$lat = $latLong[0];
			$long = $latLong[1];

			$distance = ($lat-$dlat)*($lat-$dlat) + ($long-$dlong)*($long-$dlong);
			if ($distance < $minDistDestination) {
				$minDistDestination = $distance;
				$nearestDestination = $latLong;
			}

			for ($i=$sourceIndex; $i < count($waypoints_array)-1; $i++) { 
				$latLong = explode(',', $waypoints_array[$i]);
				$lat = $latLong[0];
				$long = $latLong[1];

				$distance = ($lat-$dlat)*($lat-$dlat) + ($long-$dlong)*($long-$dlong);
				if ($distance < $minDistDestination) {
					$minDistDestination = $distance;
					$nearestDestination = $latLong;
				}
			}

			$totalDistance = $minDistSource + $minDistDestination;

			if ($totalDistance < $minTotalDistance) {
				$minTotalDistance = $totalDistance;
				$bestRouteId = $r['route_id'];
				$bestSource = $nearestSource;
				$bestDestination = $nearestDestination;
			}
		}

		// echo $bestRouteId;

		if ($bestRouteId!=0) {
			$getRoute = "SELECT *, r.id as route_id, b.id as bus_id FROM buses b, routes r WHERE b.id=r.bus_id AND r.id='$bestRouteId'";
			$result = mysqli_query($conn, $getRoute);
			$r=mysqli_fetch_assoc($result);

			$response = array(
			    'result' => array(
			        'success' => True,
			        'message' => 'Successfully fetched routes list.',
			        'data' => array(
			        	'neareatSource' => $bestSource,
			        	'nearestDestination' => $bestDestination,
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
		        'message' => 'No bus available on this route.'
		    )
		);
		die(sendResponse($response));
		}
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