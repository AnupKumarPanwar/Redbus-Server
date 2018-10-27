<?php

require ('constants.php');
require ('middleware.php');


if (isset($_POST['id'])) {

	$category_id = mysqli_escape_string($conn, $_POST['id']);

	$removeCategoryQuery = "DELETE FROM categories WHERE id='$category_id'";

	$result = mysqli_query($conn, $removeCategoryQuery);

	if ($result) {
		$response = array(
		    'result' => array(
		        'success' => True,
		        'message' => 'Category removed successfully.'
		    )
		);
		die(json_encode($response));
	}
	else {
		$response = array(
		    'result' => array(
		        'success' => False,
		        'message' => 'Failed to remove category.'
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