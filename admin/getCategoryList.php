<?php

require ('constants.php');

$getAllCategoriesQuery = "SELECT * FROM categories WHERE 1";
$result = mysqli_query($conn, $getAllCategoriesQuery);

if ($result) {
	$allCategoriesList=array();
	while ($r = mysqli_fetch_assoc($result)) {
		$r['thumbnail'] = $baseURL.$r['thumbnail'];
		$allCategoriesList[] = $r;
	}

	$response = array(
	    'result' => array(
	        'success' => True,
	        'message' => 'Successfully fetched categories list.',
	        'data' => $allCategoriesList
	    )
	);
	die(json_encode($response));
}
else {
	$response = array(
	    'result' => array(
	        'success' => False,
	        'message' => 'Failed to fetch categories list.'
	    )
	);
	die(json_encode($response));
}

?>