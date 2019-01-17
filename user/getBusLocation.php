<?php

require ('constants.php');
// require ('middleware.php');

if (isset($_POST['id'])) {

	$id = mysqli_escape_string($conn, $_POST['id']);

	$getLocation = "SELECT * FROM buses WHERE id='$id'";

	$result = mysqli_query($conn, $getLocation);

	if ($result) {
		$r = mysqli_fetch_assoc($result);
			
		$response = array(
		    'result' => array(
		        'success' => True,
		        'message' => 'Location fetched successfully.',
		        'data' => $r
		    )
		);
		die(json_encode($response));
	}
	else {
		$response = array(
		    'result' => array(
		        'success' => False,
		        'message' => 'Failed to get location.'
		    )
		);
		die(json_encode($response));
	}
}
else {
	$response = array(
	    'result' => array(
	        'success' => False,
	        'message' => 'Some error occured.'
	    )
	);
	die(json_encode($response));
}

?>