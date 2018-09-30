<?php

require ('constants.php');

if (isset($_POST['category'])) {
	
	$category = mysqli_escape_string($conn, $_POST['category']);

	$getAllStoresQuery = "SELECT id, name, photo, address, phone, rating, total_ratings, category FROM stores, retailers WHERE category='$category' and stores.id=retailers.store_id";


	if ($category==-1) {
		$getAllStoresQuery = "SELECT id, name, photo, address, phone, rating, total_ratings, category FROM stores, retailers WHERE id=store_id";
	}

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
	        'message' => 'Some error occured.'
	    )
	);
	die(json_encode($response));
}
?>