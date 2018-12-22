<?php

require ('constants.php');
require ('middleware.php');


$totalOffersQuery = "SELECT count(*) as res FROM offers WHERE 1";
$result1 = mysqli_query($conn, $totalOffersQuery);

$totalRetailersQuery = "SELECT count(*) as res FROM retailers WHERE 1";
$result2 = mysqli_query($conn, $totalRetailersQuery);

$totalOffersUnlockedQuery = "SELECT count(*) as res FROM coupons WHERE 1";
$result3 = mysqli_query($conn, $totalOffersUnlockedQuery);

$totalOffersUsedQuery = "SELECT count(*) as res FROM coupons WHERE used=1";
$result4 = mysqli_query($conn, $totalOffersUsedQuery);

$totalUsersQuery = "SELECT count(*) as res FROM users WHERE 1";
$result5 = mysqli_query($conn, $totalUsersQuery);

$newUserQuery = "SELECT count(*) as res FROM users WHERE created_at >= (NOW()-INTERVAL 1 DAY)";
$result6 = mysqli_query($conn, $newUserQuery);

if ($result1 && $result2 && $result3 && $result4 && $result5 && $result6) {


	$totalOffer = mysqli_fetch_assoc($result1)['res'];
	$totalRetailers = mysqli_fetch_assoc($result2)['res'];
	$totalOffersUnlocked = mysqli_fetch_assoc($result3)['res'];
	$totalOffersUsed = mysqli_fetch_assoc($result4)['res'];
	$totalUsers = mysqli_fetch_assoc($result5)['res'];
	$newUsers = mysqli_fetch_assoc($result6)['res'];

	$response = array(
	    'result' => array(
	        'success' => True,
	        'message' => 'Successfully fetched analytics data.',
	        'data' => array(
	        	'totalOffer' => $totalOffer,
	        	'totalRetailers' => $totalRetailers,
	        	'totalOffersUnlocked' => $totalOffersUnlocked,
	        	'totalOffersUsed' => $totalOffersUsed,
	        	'totalUsers' => $totalUsers,
	        	'newUsers' => $newUsers
	        )
	    )
	);
	die(json_encode($response));
}
else {
	$response = array(
	    'result' => array(
	        'success' => False,
	        'message' => 'Failed to fetch analytics data.'
	    )
	);
	die(json_encode($response));
}

?>