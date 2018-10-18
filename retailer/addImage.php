<?php

require ('constants.php');
require ('middleware.php');


if (isset($_FILES['imageToUpload'])) {

	$store_id = $_SESSION['store_id'];

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
	die(json_encode($response));
}
?>