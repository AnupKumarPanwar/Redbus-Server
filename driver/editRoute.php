<?php

require ('constants.php');
require ('middleware.php');


if (isset($_POST['wayponits']) && isset($_POST['source']) && isset($_POST['destination']) && isset($_POST['departure_time']) && isset($_POST['route_id'])) {

	$bus_id = $_SESSION['bus_id'];
	$route_id = mysqli_escape_string($conn, $_POST['route_id']);
	$wayponits = mysqli_escape_string($conn, $_POST['wayponits']);
	$source = mysqli_escape_string($conn, $_POST['source']);
	$destination = mysqli_escape_string($conn, $_POST['destination']);
	$departure_time = mysqli_escape_string($conn, $_POST['departure_time']);

	$updateRoute = "UPDATE routes SET source='$source', destination='$destination', wayponits='$wayponits', departure_time='$departure_time' WHERE route_id='$route_id'";

	$result = mysqli_query($conn, $updateRoute);

	if ($result) {
		$response = array(
		    'result' => array(
		        'success' => True,
		        'message' => 'Route updated successfully.'
		    )
		);
		die(json_encode($response));
	}
	else {
		$response = array(
		    'result' => array(
		        'success' => False,
		        'message' => 'Failed to update route.'
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