<?php

require ('constants.php');
require ('middleware.php');

if (isset($_POST['storeId'])) {
	
	$storeId = mysqli_escape_string($conn, $_POST['storeId']);

	$getCredsQuery = "SELECT * FROM retailers WHERE store_id='$storeId'";

	$result = mysqli_query($conn, $getCredsQuery);

	if (mysqli_num_rows($result)==1) {
		$storeDetails=mysqli_fetch_assoc($result);
		$response = array(
		    'result' => array(
		        'success' => True,
		        'message' => 'Successfully fetched store details.',
		        'data' => $storeDetails
		    )
		);
		die(json_encode($response));
	}
	else {
		$response = array(
		    'result' => array(
		        'success' => False,
		        'message' => 'Failed to fetch store details.'
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