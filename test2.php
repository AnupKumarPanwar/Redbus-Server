<?php

	session_start();

	if (!isset($_SESSION['val'])) {
		$response = array(
		    'result' => array(
		        'success' => False,
		        'message' => 'Phone number not registered.'
		    )
		);
		die(json_encode($response));	
	}

	$_SESSION['val'] = 'loda';

	$response = array(
	    'result' => array(
	        'success' => False,
	        'message' => $_SESSION['val']
	    )
	);
	die(json_encode($response));

?>