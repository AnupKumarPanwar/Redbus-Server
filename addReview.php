<?php

require ('constants.php');
require ('middleware.php');

if (isset($_POST['storeId']) && isset($_POST['review'])) {

	$storeId = mysqli_escape_string($conn, $_POST['storeId']);
	$review = mysqli_escape_string($conn, $_POST['review']);

	$addReviewQuery = "INSERT INTO reviews (storeId, review, review_time) VALUES ('$storeId', '$review', NOW())";

	$result = mysqli_query($conn, $addReviewQuery);

	if ($result) {
		$response = array(
		    'result' => array(
		        'success' => True,
		        'message' => 'Review added successfully.'
		    )
		);
		die(json_encode($response));
	}
	else {
		$response = array(
		    'result' => array(
		        'success' => False,
		        'message' => 'Failed to add review.'
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