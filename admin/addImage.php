<?php

require ('constants.php');
require ('middleware.php');


if (isset($_FILES['imageToUpload']) && isset($_POST['store_id'])) {

	$store_id = mysqli_escape_string($conn, $_POST['store_id']);

	$result = upload_image('store_pictures');

	if ($result['result']['success']) {
		$file_name = $result['result']['file_name'];

		$addImageQuery = "INSERT INTO store_pictures (store_id, photo) VALUES ('$store_id', '$file_name')";

		$result = mysqli_query($conn, $addImageQuery);

		if ($result) {
			$response = array(
			    'result' => array(
			        'success' => True,
			        'message' => 'Image added successfully.'
			    )
			);
			die(json_encode($response));
		}
		else {
			$response = array(
			    'result' => array(
			        'success' => False,
			        'message' => 'Failed to add image.'
			    )
			);
			die(json_encode($response));
		}
	}
	else {
		$response = array(
		    'result' => array(
		        'success' => False,
		        'message' => 'Failed to add image.'
		    )
		);
		die(json_encode($response));
	}
}
else {
	$response = array(
	    'result' => array(
	        'success' => False,
	        'message' => 'Something went wrong.'
	    )
	);
	header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
	die(json_encode($response));
}
?>