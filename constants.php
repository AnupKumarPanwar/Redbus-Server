<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: *");
header("Access-Control-Allow-Header: *");

// $baseURL = 'http://locahost';

// $dbServer = 'localhost';
// $dbName = 'zomato';
// $dbUser = 'root';
// $dbPassword = 'biappanwar';


// $baseURL = 'http://locahost';

$dbServer = 'localhost';
$dbName = 'id2254995_worthit';
$dbUser = 'id2254995_root';
$dbPassword = 'biappanwar';



$conn = mysqli_connect($dbServer, $dbUser, $dbPassword, $dbName);

if (!$conn) {
	die('Error connection to the database');
}

$uploadDirectory = './uploads/';

?>