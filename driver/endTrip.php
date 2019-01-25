<?php

require ('constants.php');
require ('middleware.php');


if (isset($_POST['tripId'])) {

	$bus_id = $_SESSION['bus_id'];
	$tripId = mysqli_escape_string($conn, $_POST['tripId']);

	$getTripInfo = "SELECT * FROM trips WHERE id='$tripId'";
	$result = mysqli_query($conn, $getTripInfo);

	$r = mysqli_fetch_assoc($result);
	$busId = $r['bus_id'];
	$routeId = $r['route_id'];

	$getReturnTrip = "SELECT * FROM routes WHERE bus_id='$busId' AND id!='$routeId'";
	$result = mysqli_query($conn, $getReturnTrip);

	$r = mysqli_fetch_assoc($result);
	$returnRouteId = $r['id'];

	$endTrip = "UPDATE trips SET completed_at=NOW() WHERE id='$tripId'";
	$result = mysqli_query($conn, $endTrip);

	$addReturnTrip = "INSERT INTO trips(route_id, bus_id) VALUES('$returnRouteId', '$bus_id')";
	$result2 = mysqli_query($conn, $addReturnTrip);

	if ($result && $result2) {
		$response = array(
		    'result' => array(
		        'success' => True,
		        'message' => 'Trip completed successfully.'
		    )
		);
		die(json_encode($response));
	}
	else {
		$response = array(
		    'result' => array(
		        'success' => False,
		        'message' => 'Failed to complete trip.'
		    )
		);
		die(json_encode($response));
	}
}
else
{
    $response = array(
        'result' => array(
            'success' => False,
            'message' => 'Some error occured.'
        )
    );
    die(json_encode($response));
}
?>