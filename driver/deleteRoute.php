<?php

include_once ('constants.php');
include_once ('middleware.php');


if (isset($_POST['route_id'])) {

	$bus_id = $_SESSION['bus_id'];
	$route_id = mysqli_escape_string($conn, $_POST['route_id']);

	$deleteRoute = "DELETE FROM routes WHERE route_id='$route_id'";

	$result = mysqli_query($conn, $deleteRoute);

	if ($result) {
		$response = array(
		    'result' => array(
		        'success' => True,
		        'message' => 'Route deleted successfully.'
		    )
		);
		die(sendResponse($response));
	}
	else {
		$response = array(
		    'result' => array(
		        'success' => False,
		        'message' => 'Failed to delete route.'
		    )
		);
		die(sendResponse($response));
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
    die(sendResponse($response));
}
?>