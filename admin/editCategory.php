<?php

require ('constants.php');
require ('middleware.php');

if (isset($_POST['categoryName']) && isset($_POST['categoryId'])) {
	$categoryName = mysqli_escape_string($conn, $_POST['categoryName']);
	$categoryId = mysqli_escape_string($conn, $_POST['categoryId']);

	if(isset($_FILES["imageToUpload"])){
		$result = upload_image('categories');
		$file_name = $result['result']['file_name'];
		if ($result['result']['success']) {
			$editCategoryQuery = "UPDATE categories SET name='$categoryName', thumbnail='$file_name' WHERE id='$categoryId'";
		}
	}
	else {
		$editCategoryQuery = "UPDATE categories SET name='$categoryName' WHERE id='$categoryId'";
	}

	if (True) {
		
		$result = mysqli_query($conn, $editCategoryQuery);

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
