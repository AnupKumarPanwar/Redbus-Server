<?php

include_once ('constants.php');
include_once ('middleware.php');

$user_id = $_SESSION['user_id'];
$getCashbacks = "SELECT * FROM cashbacks WHERE user_id='$user_id' ORDER BY created_at DESC";
$getCredits = "SELECT * FROM users WHERE id='$user_id'";

$result = mysqli_query($conn, $getCashbacks);
$result2 = mysqli_query($conn, $getCredits);

if ($result && $result2) {
		$credits = mysqli_fetch_assoc($result2)['credits'];
		$allCashbacks = array();
		while ($r = mysqli_fetch_assoc($result)) {
			$allCashbacks[] = $r;
		}
		$response = array(
		    'result' => array(
		        'success' => True,
		        'message' => 'Cashbacks fetched successfully.',
		        'data' => array(
					'credits' => $credits,
					'cashbacks' => $allCashbacks
				)
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