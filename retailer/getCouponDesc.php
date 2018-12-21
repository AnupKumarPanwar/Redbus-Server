<?php

require ('constants.php');
require ('middleware.php');

if (isset($_POST['couponCode'])) {

	$coupon_code = mysqli_escape_string($conn, $_POST['couponCode']);

	$checkIfExistsQuery = "SELECT c.id as coupon_id, offer_id, title, description, created_at, used, used_at FROM coupons c, offers WHERE coupon_code='$coupon_code' AND offer_id=offers.id";

	$result = mysqli_query($conn, $checkIfExistsQuery);

	if (mysqli_num_rows($result)==1) {

		$result = mysqli_fetch_assoc($result);


		if ($result) {
			$response = array(
			    'result' => array(
			        'success' => True,
			        'message' => 'Coupon details fetched successfully.',
			        'data' => $result
			    )
			);
			die(json_encode($response));
		}
		else {
			$response = array(
			    'result' => array(
			        'success' => False,
			        'message' => 'Failed to fetch coupon details.'
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
	            'message' => 'Invalid coupon code.'
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