<?php

require ('constants.php');
require ('middleware.php');

session_start();

if (isset($_POST['storeId']) && isset($_POST['rating'])) {

	$userId = $_SESSION['userId'];
	$storeId = mysqli_escape_string($conn, $_POST['storeId']);
	$rating = mysqli_escape_string($conn, $_POST['rating']);

	if (isset($_POST['review'])) {
		$review = mysqli_escape_string($conn, $_POST['review']);
	}else{
		$review=NULL;
	}

	$addReviewQuery = "INSERT INTO reviews (store_id, user_id, rating, review, review_time) VALUES ('$storeId', '$userId', '$rating', '$review', NOW())";
	
	$updateRatingQuery = "UPDATE stores SET rating=(rating*total_ratings+'$rating')/(total_ratings+1), total_ratings=total_ratings+1 WHERE id='$storeId'";

	$result = mysqli_query($conn, $addReviewQuery);
	$result2 = mysqli_query($conn, $updateRatingQuery);

	if ($result && $result2) {
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