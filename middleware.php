<?php

require 'constants.php';
session_start();

$headers = apache_request_headers();

if (!isset($headers['Authorization']) || empty($headers['Authorization'])) {
	die('Invalid access token');
} else {
	$access_token = mysqli_escape_string($conn, $headers['Authorization']);
	$checkAccessToken = "SELECT access_token FROM users WHERE access_token = '$access_token'";
	$result = mysqli_query($conn, $checkAccessToken);
	if (mysqli_num_rows($result)!=1) {
		die('Invalid access token');
	}
	else {
		$_SESSION['access_token'] = $access_token;
	}
}

?>