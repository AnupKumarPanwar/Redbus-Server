<?php

require ('constants.php');
require ('middleware.php');


if (isset($_POST['id'])) {

	$offer_id = mysqli_escape_string($conn, $_POST['id']);

	$removeOfferQuery = "DELETE FROM offers WHERE id='$offer_id'";

	$result = mysqli_query($conn, $removeOfferQuery);

	if ($result) {
		$response = array(
		    'result' => array(
		        'success' => True,
		        'message' => 'Offer removed successfully.'
		    )
		);
		die(json_encode($response));
	}
	else {
		$response = array(
		    'result' => array(
		        'success' => False,
		        'message' => 'Failed to remove offer.'
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