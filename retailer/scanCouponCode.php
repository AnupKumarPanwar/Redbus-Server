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

if (isset($_POST['couponCode'])) {

	$coupon_code = mysqli_escape_string($conn, $_POST['couponCode']);

	$checkIfAlreadyUsedQuery = "SELECT * FROM coupons WHERE coupon_code='$coupon_code' AND used=0";

	$result = mysqli_query($conn, $checkIfAlreadyUsedQuery);

	if (mysqli_num_rows($result)==1) {

		$scanCouponCodeQuery = "UPDATE coupons set used=1, used_at=NOW() WHERE coupon_code='$coupon_code'";

		$result = mysqli_query($conn, $scanCouponCodeQuery);


		if ($result) {
			$response = array(
			    'result' => array(
			        'success' => True,
			        'message' => 'Coupon used successfully.',
			        'data' => $coupon_code
			    )
			);
			die(json_encode($response));
		}
		else {
			$response = array(
			    'result' => array(
			        'success' => False,
			        'message' => 'Failed to use coupon.'
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
	            'message' => 'Coupon code already used.'
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