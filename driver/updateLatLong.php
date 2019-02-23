<?php

include_once ('constants.php');
include_once ('middleware.php');


if (isset($_POST['last_location']) && isset($_POST['bearing'])) {

	$bus_id = $_SESSION['bus_id'];
	$lastLocation = mysqli_escape_string($conn, $_POST['last_location']);
	$bearing = mysqli_escape_string($conn, $_POST['bearing']);

	$updateLocation = "UPDATE buses SET last_location='$lastLocation', bearing='$bearing', last_updated_at=NOW() WHERE id='$bus_id'";

	$result = mysqli_query($conn, $updateLocation);

	if ($result) {
		$response = array(
		    'result' => array(
		        'success' => True,
		        'message' => 'Bus location updated successfully.'
		    )
		);
		die(sendResponse($response));
	}
	else {
		$response = array(
		    'result' => array(
		        'success' => False,
		        'message' => 'Failed to update bus location.'
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