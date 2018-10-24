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
        die(json_encode($response));
    }
    else
    {
        $otp = generateOTP();
        $_SESSION['otp'] = $otp;

        $sms_text = 'Dear user, your Worthit login OTP is '.$otp;

        $sms_api = 'https://www.uengage.in/ueapi/send?usr=contact@worthitproduction.com&pwd=worthit123&mobileNo='.$phone.'&senderId=worthi&smsText='.$sms_text;

        // echo $sms_api;

        $send = file_get_contents($sms_api);

        // echo $send;

        $r=mysqli_fetch_assoc($result);
        $access_token = $r['access_token'];
        $_SESSION['access_token'] = $access_token;

        $response = array(
            'result' => array(
                'success' => True,
                'message' => 'Verify the OTP.'
            )
        );
       
        die(json_encode($response));
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
    die(json_encode($response));
}

?>