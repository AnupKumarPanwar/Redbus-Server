<?php

require ('constants.php');

if (isset($_POST['category'])) {
	
	$category = mysqli_escape_string($conn, $_POST['category']);

	$getAllStoresQuery = "SELECT id, name, photo, address, phone, rating, total_ratings, category, video, coordinates, lat, lng FROM stores, retailers WHERE category='$category' and stores.id=retailers.store_id";

	if (isset($_POST['lat']) && isset($_POST['lng'])) {
		$lat = mysqli_escape_string($conn, $_POST['lat']);
		$lng = mysqli_escape_string($conn, $_POST['lng']);

		$getAllStoresQuery = "SELECT id, name, photo, address, phone, rating, total_ratings, category, video, coordinates, lat, lng FROM stores, retailers WHERE category='$category' and stores.id=retailers.store_id order by ('$lat'-lat)*('$lat'-lat) + ('$lng'-lng)*('$lng'-lng)";
	}


	if ($category==-1) {
		$getAllStoresQuery = "SELECT id, name, photo, address, phone, rating, total_ratings, category, video, coordinates, lat, lng FROM stores, retailers WHERE id=store_id";

		if (isset($_POST['lat']) && isset($_POST['lng'])) {
			$lat = mysqli_escape_string($conn, $_POST['lat']);
			$lng = mysqli_escape_string($conn, $_POST['lng']);

			$getAllStoresQuery = "SELECT id, name, photo, address, phone, rating, total_ratings, category, video, coordinates, lat, lng FROM stores, retailers WHERE id=store_id order by ('$lat'-lat)*('$lat'-lat) + ('$lng'-lng)*('$lng'-lng)";
		}
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