<?php

require ('constants.php');
require ('middleware.php');

function generateCouponCode($length = 8) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

if (isset($_POST['offerId'])) {

	$offerId = mysqli_escape_string($conn, $_POST['offerId']);

	$userId = $_SESSION['userId'];

	// $getUserIdFromAccessTokenQuery = "SELECT id FROM users WHERE access_token='$access_token'";

	// $result = mysqli_query($conn, $getUserIdFromAccessTokenQuery);
	// if (mysqli_num_rows($result)==1) {
	// 	$userId = mysqli_fetch_assoc($result)['id'];
	// }
	// else {
	// 	$response = array(
	// 	    'result' => array(
	// 	        'success' => False,
	// 	        'message' => 'Invalid user.'
	// 	    )
	// 	);
	// 	die(json_encode($response));
	// }

	$coupon_code = generateCouponCode();

	$addCouponCodeQuery = "INSERT INTO coupons (offer_id, user_id, coupon_code, created_at, used) VALUES ('$offerId', '$userId', '$coupon_code', NOW(), 0)";

	$result = mysqli_query($conn, $addCouponCodeQuery);


	if ($result) {
		$response = array(
		    'result' => array(
		        'success' => True,
		        'message' => 'Coupon generated successfully.',
		        'data' => $coupon_code
		    )
		);
		die(json_encode($response));
	}
	else {
		$response = array(
		    'result' => array(
		        'success' => False,
		        'message' => 'Failed to generate coupon.'
		    )
		);
		die(json_encode($response));
	}
}
else
{
    $response = array(
        'result' => array(
            'success' => False,
            'message' => 'Some error occured.'
        )
    );

    die(json_encode($response));
}

?>