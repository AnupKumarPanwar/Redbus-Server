<?php

	session_start();

	$_SESSION['val'] = 'loda';

	$response = array(
	    'result' => array(
	        'success' => False,
	        'message' => 'Phone number not registered.'
	    )
	);
	die(json_encode($response));

?>