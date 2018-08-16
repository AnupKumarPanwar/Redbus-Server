<?php

require ('constants.php');
require ('middleware.php');

if (isset($_POST['category'])) {
	
	$category = mysqli_escape_string($conn, $_POST['category']);

	$getAllStoresQuery = "SELECT * FROM stores WHERE category='$category'";
	$result = mysqli_query($conn, $getAllStoresQuery);

	if ($result) {
		$allStoresList=array();
		while ($r = mysqli_fetch_assoc($result)) {
			$allStoresList[] = $r;
		}

		$response = array(
		    'result' => array(
		        'success' => True,
		        'message' => 'Successfully fetched stores list.',
		        'data' => $allStoresList
		    )
		);
		die(json_encode($response));
	}
	else {
		$response = array(
		    'result' => array(
		        'success' => False,
		        'message' => 'Failed to fetch stores list.'
		    )
		);
		die(json_encode($response));
	}
}
else {
	$response = array(
	    'result' => array(
	        'success' => False,
	        'message' => 'Failed to fetch stores list.'
	    )
	);
	die(json_encode($response));
}
?>