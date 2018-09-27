<?php

require ('constants.php');
require ('middleware.php');

// if (isset($_POST['storeId'])) {

	$store_id = $_SESSION['store_id'];
		
	// $storeId = mysqli_escape_string($conn, $_POST['storeId']);

	$getAllOffersQuery = "SELECT * FROM offers WHERE store_id='$store_id'";

	$result = mysqli_query($conn, $getAllOffersQuery);

	if ($result) {
		$allOffersList=array();
		while ($r = mysqli_fetch_assoc($result)) {
			$allOffersList[] = $r;
		}

		$response = array(
		    'result' => array(
		        'success' => True,
		        'message' => 'Successfully fetched offers list.',
		        'data' => $allOffersList
		    )
		);
		die(json_encode($response));
	}
	else {
		$response = array(
		    'result' => array(
		        'success' => False,
		        'message' => 'Failed to fetch offers list.'
		    )
		);
		die(json_encode($response));
	}
// }
// else {
// 	$response = array(
// 	    'result' => array(
// 	        'success' => False,
// 	        'message' => 'Some error occured.'
// 	    )
// 	);
// 	die(json_encode($response));
// }
?>