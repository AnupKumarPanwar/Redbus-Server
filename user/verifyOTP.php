<?php

require ('constants.php');
session_start();

function generateAccessToken($length = 20) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

if (isset($_POST['otp']))
{
    $passed_otp = mysqli_escape_string($conn, $_POST['otp']);
    
    $access_token = $_SESSION['access_token'];
    $actual_otp = $_SESSION['otp'];

    if ($actual_otp!=$passed_otp)
    {
        $response = array(
            'result' => array(
                'success' => False,
                'message' => 'Incorrect OTP.'
            )
        );
        die(json_encode($response));
    }
    else
    {
        $access_token = $_SESSION['access_token'];

        $getReferrerCode = "SELECT referrer_by FROM users WHERE access_token='$access_token'";
        $result = mysqli_query($conn, $getReferrerCode);
        $r = mysqli_fetch_assoc($result);
        $referrer_by = $r['referrer_by'];

        $addCreditsToReferrer = "UPDATE users set credits=credits+100 WHERE (access_token='$access_token' or referral_code='$referrer_by') and verified=0";
        $result = mysqli_query($conn, $addCreditsToReferrer);


        $randCode = generateAccessToken();
        $updateAccessToken = "UPDATE users set access_token='$randCode', verified=1 WHERE access_token='$access_token'";
        $result2 = mysqli_query($conn, $updateAccessToken);
        if ($result && $result2) {
            $_SESSION['access_token'] = $randCode;
            $access_token = $_SESSION['access_token'];
            $response = array(
                'result' => array(
                    'success' => True,
                    'message' => 'OTP verified successfully.',
                    'data' => array(
                        'access_token' => $access_token
                    )
                )
            );
            die(json_encode($response));   
        }
        else {
            $response = array(
                'result' => array(
                    'success' => False,
                    'message' => 'Some error occured.'
                )
            );
            die(json_encode($response));
        }
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