<?php

require ('constants.php');
require ('middleware.php');


if (isset($_POST['title']) && isset($_POST['description'])) {

	$store_id = $_SESSION['store_id'];
	$title = mysqli_escape_string($conn, $_POST['title']);
	$description = mysqli_escape_string($conn, $_POST['description']);

	$addOffer = "INSERT INTO offers (store_id, title, description, creation_time) VALUES ('$store_id', '$title', '$description', NOW())";

	$result = mysqli_query($conn, $addOffer);

	if ($result) {
		$response = array(
		    'result' => array(
		        'success' => True,
		        'message' => 'Offer added successfully.'
		    )
		);
		die(json_encode($response));
	}
	else {
		$response = array(
		    'result' => array(
		        'success' => False,
		        'message' => 'Failed to add offer.'
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