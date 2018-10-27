<?php

require ('constants.php');
require ('middleware.php');


if (isset($_POST['id'])) {

	$store_id = mysqli_escape_string($conn, $_POST['id']);

	$removeStoreQuery = "DELETE FROM stores WHERE id='$store_id'";
	$removeRetailerQuery = "DELETE FROM retailers WHERE store_id='$store_id'";

	$result = mysqli_query($conn, $removeStoreQuery);
	$result2 = mysqli_query($conn, $removeRetailerQuery);

	if ($result && $result2) {
		$response = array(
		    'result' => array(
		        'success' => True,
		        'message' => 'Store removed successfully.'
		    )
		);
		die(json_encode($response));
	}
	else {
		$response = array(
		    'result' => array(
		        'success' => False,
		        'message' => 'Failed to remove store.'
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