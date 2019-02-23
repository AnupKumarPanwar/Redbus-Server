<?php

include_once ('constants.php');
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

    $checkIfAlreadyRegistered = "SELECT access_token FROM users WHERE phone='$phone'";
    $result = mysqli_query($conn, $checkIfAlreadyRegistered);
    if (mysqli_num_rows($result) != 1)
    {
        $response = array(
            'result' => array(
                'success' => False,
                'message' => 'Phone number not registered.'
            )
        );
        die(sendResponse($response));
    }
    else
    {
        $otp = generateOTP();
        $_SESSION['otp'] = $otp;

        $sms_api = 'https://2factor.in/API/V1/c577a86c-09c5-11e9-a895-0200cd936042/SMS/'.$phone.'/'.$otp;

        $send = file_get_contents($sms_api);

        $r=mysqli_fetch_assoc($result);
        $access_token = $r['access_token'];
        $_SESSION['access_token'] = $access_token;

        $response = array(
            'result' => array(
                'success' => True,
                'message' => 'Login successful.'
            )
        );
        die(sendResponse($response));
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
    die(sendResponse($response));
}

?>