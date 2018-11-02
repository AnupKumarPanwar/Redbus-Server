<?php

require ('constants.php');
require ('middleware.php');

$getAllUsersQuery = "SELECT * FROM users WHERE 1";
$result = mysqli_query($conn, $getAllUsersQuery);

if ($result) {

	$allUsersList=array();
	while ($r = mysqli_fetch_assoc($result)) {
		$allUsersList[] = $r;
	}
	
	$response = array(
	    'result' => array(
	        'success' => True,
	        'message' => 'Successfully fetched users list.',
	        'data' => $allUsersList
	    )
	);
	die(json_encode($response));
}
else {
	$response = array(
	    'result' => array(
	        'success' => False,
	        'message' => 'Failed to fetch users list.'
	    )
	);
	die(json_encode($response));
}

?>