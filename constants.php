<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
	
$baseURL = 'http://locahost';

$dbServer = 'localhost';
$dbName = 'zomato';
$dbUser = 'root';
$dbPassword = 'biappanwar';

$conn = mysqli_connect($dbServer, $dbUser, $dbPassword, $dbName);

if (!$conn) {
	die('Error connection to the database');
}

$uploadDirectory = './uploads/';

?>