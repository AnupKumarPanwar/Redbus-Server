<?php

include_once ('constants.php');
include_once ('middleware.php');

$availableBuses = [];

function alreadyPushed($value)
{
	global $availableBuses;
	for ($i=0; $i < sizeof($availableBuses); $i++) { 
		if ($availableBuses[$i]['route_id']==$value) {
			return True;
		}
	}
	return False;
}

function findRoutes($sourceLat, $sourceLng, $destinationLat, $destinationLng)
{
	global $availableBuses;
	global $conn;
	$searchBusQuery = "SELECT *, r.id as route_id, b.id as bus_id FROM buses b, routes r WHERE (r.waypointsLatLong LIKE '%$sourceLat%,$sourceLng%$destinationLat%,$destinationLng%') AND b.id=r.bus_id";

	$result = mysqli_query($conn, $searchBusQuery);


	while ($r = mysqli_fetch_assoc($result)) {
		if (!alreadyPushed($r['route_id'])) {
			$availableBuses[] = $r;
		}
	}
}

if (isset($_POST['sourceLat']) && isset($_POST['sourceLng']) && isset($_POST['destinationLat']) && isset($_POST['destinationLng'])) {
	
	$sourceLat = number_format(floatval(mysqli_escape_string($conn, $_POST['sourceLat'])),1,'.','');
	$sourceLng = number_format(floatval(mysqli_escape_string($conn, $_POST['sourceLng'])),1,'.','');
	$destinationLat = number_format(floatval(mysqli_escape_string($conn, $_POST['destinationLat'])),1,'.','');
	$destinationLng = number_format(floatval(mysqli_escape_string($conn, $_POST['destinationLng'])),1,'.','');

	// findRoutes($sourceLat, $sourceLng, $destinationLat, $destinationLng);


	for ($a=-1; $a <=1 ; $a++) { 
		$offset1 = $a/10;
		$p = $sourceLat + $offset1;

		for ($b=-1; $b <=1 ; $b++) { 
			$offset2 = $b/10;
			$q = $sourceLng + $offset1;

			for ($c=-1; $c <=1 ; $c++) { 
				$offset3 = $c/10;
				$r = $destinationLat + $offset3;

				for ($d=-1; $d <=1 ; $d++) { 
					$offset4 = $d/10;
					$s = $destinationLng + $offset4;

					// echo ("$p, $q, $r, $s <br>");

					findRoutes($p, $q, $r, $s);
				}
			}
		}
	}

	if (sizeof($availableBuses)>0) {
		
		$response = array(
		    'result' => array(
		        'success' => True,
		        'message' => 'Successfully fetched available buses.',
		        'data' => $availableBuses
		    )
		);
		die(sendResponse($response));
	}
	else {
		$response = array(
		    'result' => array(
		        'success' => False,
		        'message' => 'No buses available.'
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