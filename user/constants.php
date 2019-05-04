<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Headers: Content-Type, Accept, X-Requested-With, Authorization, X-Custom-Header');
header('Access-Control-Max-Age: 86400');


// Allow from any origin
if (isset($_SERVER['HTTP_ORIGIN'])) {
    // should do a check here to match $_SERVER['HTTP_ORIGIN'] to a
    // whitelist of safe domains
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 86400');    // cache for 1 day
}
// Access-Control headers are received during OPTIONS requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");         

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
        header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

}


error_reporting(E_ALL);
ini_set('display_errors', 1);



	
// $baseURL = 'http://localhost';

// $dbServer = 'localhost';
// $dbName = 'gotobuses';
// $dbUser = 'root';
// $dbPassword = '';


$baseURL = 'http://142.93.218.37';

$dbServer = 'localhost';
$dbName = 'gotobuses';
$dbUser = 'root';
$dbPassword = 'D4dinesh@123S';


$conn = mysqli_connect($dbServer, $dbUser, $dbPassword, $dbName);

if (!$conn) {
	die('Error connection to the database');
}

$uploadDirectory = '../uploads/';

function sendResponse($response)
{
    $response['error'] = mysqli_error($GLOBALS['conn']);
    return json_encode($response);
}

?>
