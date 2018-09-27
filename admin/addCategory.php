<?php

require ('constants.php');
require ('middleware.php');

if (isset($_POST['categoryName']) && isset($_FILES["imageToUpload"])) {
	$categoryName = mysqli_escape_string($conn, $_POST['categoryName']);

	$result = upload_image('categories');

	if ($result['result']['success']) {
		$file_name = $result['result']['file_name'];
		$addCategoryQuery = "INSERT INTO categories (name, thumbnail) VALUES ('$categoryName', '$file_name')";
		$result = mysqli_query($conn, $addCategoryQuery);

		if ($result) {
			$response = array(
			    'result' => array(
			        'success' => True,
			        'message' => 'Category added successfully.'
			    )
			);
			die(json_encode($response));
		}
		else {
			$response = array(
			    'result' => array(
			        'success' => False,
			        'message' => 'Failed to add category.'
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