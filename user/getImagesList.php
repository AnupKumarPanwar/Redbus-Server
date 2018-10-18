<?php

require ('constants.php');

if (isset($_POST['storeId'])) {

	// $store_id = $_SESSION['store_id'];
		
	$store_id = mysqli_escape_string($conn, $_POST['storeId']);

	$getAllImagesQuery = "SELECT * FROM store_pictures WHERE store_id='$store_id' and active=1";

	$result = mysqli_query($conn, $getAllImagesQuery);

	if ($result) {
		$allImagesList=array();
		while ($r = mysqli_fetch_assoc($result)) {
			$r['photo'] = $baseURL.$r['photo'];
			$allImagesList[] = $r;
		}

		$response = array(
		    'result' => array(
		        'success' => True,
		        'message' => 'Successfully fetched offers list.',
		        'data' => $allImagesList
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
}
else {
	$response = array(
	    'result' => array(
	        'success' => False,
	        'message' => 'Something went wrong.'
	    )
	);
	die(json_encode($response));
}
?>