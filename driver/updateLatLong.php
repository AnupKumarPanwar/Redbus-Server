<?php

require ('constants.php');
require ('middleware.php');


if (isset($_POST['lat']) && isset($_POST['long'])) {

	$bus_id = $_SESSION['bus_id'];
	$lat = mysqli_escape_string($conn, $_POST['lat']);
	$long = mysqli_escape_string($conn, $_POST['long']);

	$updateRoute = "UPDATE bus_locations SET lat='$lat', long='$long', updated_at=NOW() WHERE bus_id='$bus_id'";

	$result = mysqli_query($conn, $updateRoute);

	if ($result) {
		$response = array(
		    'result' => array(
		        'success' => True,
		        'message' => 'Bus location updated successfully.'
		    )
		);
		die(json_encode($response));
	}
	else {
		$response = array(
		    'result' => array(
		        'success' => False,
		        'message' => 'Failed to update bus location.'
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