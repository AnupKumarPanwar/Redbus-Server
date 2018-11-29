<?php

require ('constants.php');
require ('middleware.php');


if (isset($_POST['id'])) {

	$store_id = $_SESSION['store_id'];

	$image_id = mysqli_escape_string($conn, $_POST['id']);

	$removeImageQuery = "DELETE FROM store_pictures WHERE id='$image_id' AND store_id='$store_id'";

	$result = mysqli_query($conn, $removeImageQuery);

	if ($result) {
		$response = array(
		    'result' => array(
		        'success' => True,
		        'message' => 'Image removed successfully.'
		    )
		);
		die(json_encode($response));
	}
	else {
		$response = array(
		    'result' => array(
		        'success' => False,
		        'message' => 'Failed to remove image.'
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