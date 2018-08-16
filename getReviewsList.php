<?php

require ('constants.php');
require ('middleware.php');

if (isset($_POST['storeId'])) {
	
	$storeId = mysqli_escape_string($conn, $_POST['storeId']);

	$getAllReviewsQuery = "SELECT * FROM reviews WHERE storeId='$storeId' ORDER BY review_time DESC";
	$result = mysqli_query($conn, $getAllReviewsQuery);

	if ($result) {
		$allReviewsList=array();
		while ($r = mysqli_fetch_assoc($result)) {
			$allReviewsList[] = $r;
		}

		$response = array(
		    'result' => array(
		        'success' => True,
		        'message' => 'Successfully fetched reviews list.',
		        'data' => $allReviewsList
		    )
		);
		die(json_encode($response));
	}
	else {
		$response = array(
		    'result' => array(
		        'success' => False,
		        'message' => 'Failed to fetch reviews list.'
		    )
		);
		die(json_encode($response));
	}
}
else {
	$response = array(
	    'result' => array(
	        'success' => False,
	        'message' => 'Failed to fetch reviews list.'
	    )
	);
	die(json_encode($response));
}
?>