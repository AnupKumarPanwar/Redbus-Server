<?php

require ('constants.php');
require ('middleware.php');

if (isset($_POST['name']) && isset($_POST['address']) && isset($_POST['phone']) && isset($_POST['category'])) {

	$name = mysqli_escape_string($conn, $_POST['name']);
	$address = mysqli_escape_string($conn, $_POST['address']);
	$phone = mysqli_escape_string($conn, $_POST['phone']);
	$category = mysqli_escape_string($conn, $_POST['category']);

	$result = upload_image('stores');

	if ($result['result']['success']) {
		$file_name = $result['result']['file_name'];

		$addStoreQuery = "INSERT INTO stores (name, photo, address, phone, category) VALUES ('$name', '$file_name', '$address', '$phone', '$category')";

		$result = mysqli_query($conn, $addStoreQuery);

		if ($result) {
			$response = array(
			    'result' => array(
			        'success' => True,
			        'message' => 'Store added successfully.'
			    )
			);
			die(json_encode($response));
		}
		else {
			$response = array(
			    'result' => array(
			        'success' => False,
			        'message' => 'Failed to add store.'
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