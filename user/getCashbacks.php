<?php

include_once ('constants.php');
include_once ('middleware.php');

$user_id = $_SESSION['user_id'];
$getCashbacks = "SELECT * FROM cashbacks WHERE user_id='$user_id' ORDER BY created_at DESC";

$result = mysqli_query($conn, $getCashbacks);

if ($result) {
		$allCashbacks = array();
		while ($r = mysqli_fetch_assoc($result)) {
			$allCashbacks[] = $r;
		}
		$response = array(
		    'result' => array(
		        'success' => True,
		        'message' => 'Cashbacks fetched successfully.',
		        'data' => $allCashbacks
		    )
		);
		die(sendResponse($response));
	
}
else {
	$response = array(
	    'result' => array(
	        'success' => False,
	        'message' => 'Failed to get cashbacks.'
	    )
	);
	die(sendResponse($response));
}

?>