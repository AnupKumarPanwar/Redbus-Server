<?php

require ('constants.php');
require ('middleware.php');

if (isset($_POST['categoryName']) && isset($_FILES["imageToUpload"]) && isset($_POST['categoryId'])) {
	$categoryName = mysqli_escape_string($conn, $_POST['categoryName']);
	$categoryId = mysqli_escape_string($conn, $_POST['categoryId']);

	$result = upload_image('categories');

	if ($result['result']['success']) {
		$file_name = $result['result']['file_name'];
		$addCategoryQuery = "UPDATE categories SET name='$categoryName', thumbnail='$file_name' WHERE id='$categoryId'";
		$result = mysqli_query($conn, $addCategoryQuery);

		if ($result) {
			$response = array(
			    'result' => array(
			        'success' => True,
			        'message' => 'Category updated successfully.'
			    )
			);
			die(json_encode($response));
		}
		else {
			$response = array(
			    'result' => array(
			        'success' => False,
			        'message' => 'Failed to update category.'
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