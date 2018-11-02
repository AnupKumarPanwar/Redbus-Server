<?php

require ('constants.php');
require ('middleware.php');


$couponsUnlockedQuery = "SELECT u.name as user, s.name as store, title, description, c.created_at as created_at, c.used as used FROM offers o, coupons c, users u, stores s WHERE c.offer_id=o.id AND c.user_id=u.id AND o.store_id=s.id";
$result = mysqli_query($conn, $couponsUnlockedQuery);

if ($result) {

	$unlockedOffersList=array();
	while ($r = mysqli_fetch_assoc($result)) {
		$unlockedOffersList[] = $r;
	}

	$response = array(
	    'result' => array(
	        'success' => True,
	        'message' => 'Successfully fetched unlocked coupons data.',
	        'data' => $unlockedOffersList
	    )
	);
	die(json_encode($response));
}
else {
	$response = array(
	    'result' => array(
	        'success' => False,
	        'message' => 'Failed to fetch unlocked coupons data.'
	    )
	);
	die(json_encode($response));
}

?>