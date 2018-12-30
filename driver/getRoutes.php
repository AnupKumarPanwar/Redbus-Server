<?php

require ('constants.php');
require ('middleware.php');

$bus_id = $_SESSION['bus_id'];

$getRoutes = "SELECT * FROM routes WHERE bus_id='$bus_id'";

$result = mysqli_query($conn, $getRoutes);

if ($result) {
	$allRoutes = array();
	while ($r = mysqli_fetch_assoc($result)) {
		$allRoutes[] = $r;
	}
	$response = array(
	    'result' => array(
	        'success' => True,
	        'message' => 'Routes fetched successfully.',
	        'data' => $allRoutes
	    )
	);
	die(json_encode($response));
}
else {
	$response = array(
	    'result' => array(
	        'success' => False,
	        'message' => 'Failed to get routes.'
	    )
	);
	die(json_encode($response));
}

?>