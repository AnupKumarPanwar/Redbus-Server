<?php

require ('constants.php');
session_start();

function generateOTP($length = 4) {
    $characters = '0123456789';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

if (isset($_POST['phone']))
{
    $phone = mysqli_escape_string($conn, $_POST['phone']);

    $loginQuery = "SELECT * FROM users WHERE phone='$phone'";
    $result = mysqli_query($conn, $loginQuery);

    $r=mysqli_fetch_assoc($result);

    $response = array(
        'result' => array(
            'success' => True,
            'message' => 'Verify the OTP.',
            'data' => $r
        )
    );
   
    die(json_encode($response));
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