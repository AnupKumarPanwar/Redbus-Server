<?php

require ('constants.php');

if (isset($_GET['query'])) {
	
	$query = mysqli_escape_string($conn, $_GET['query']);

	$searchStoresQuery = "SELECT id, name, photo, address, phone, rating, total_ratings, category, video, coordinates FROM stores, retailers WHERE id=store_id and name LIKE '%{$query}%'";

	$result = mysqli_query($conn, $searchStoresQuery);

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
	        'message' => 'Some error occured.'
	    )
	);
	die(json_encode($response));
}
?>