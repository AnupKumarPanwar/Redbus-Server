<?php

include_once ('constants.php');
include_once ('middleware.php');
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

function generateOTP($length = 4) {
    $characters = '0123456789';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

if (isset($_POST['phone']) && isset($_POST['name']) && isset($_POST['email']) && isset($_POST['age']) && isset($_POST['gender']))
{
	$userId = $_SESSION['user_id'];
    $phone = mysqli_escape_string($conn, $_POST['phone']);
    $email = mysqli_escape_string($conn, $_POST['email']);
    $name = mysqli_escape_string($conn, $_POST['name']);
    $age = mysqli_escape_string($conn, $_POST['age']);
    $gender = mysqli_escape_string($conn, $_POST['gender']);
    

    $checkIfPhoneAlreadyRegistered = "SELECT name FROM users WHERE phone='$phone'";
    $result = mysqli_query($conn, $checkIfPhoneAlreadyRegistered);
    if (mysqli_num_rows($result) != 0)
    {
        $response = array(
            'result' => array(
                'success' => False,
                'message' => 'Phone number already registered.'
            )
        );
        die(sendResponse($response));
    }

    $checkIfEmailAlreadyRegistered = "SELECT name FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $checkIfEmailAlreadyRegistered);

    if (mysqli_num_rows($result) != 0)
    {
        $response = array(
            'result' => array(
                'success' => False,
                'message' => 'Email already registered.'
            )
        );
        die(sendResponse($response));
    }
    else
    {
        $randCode = generateAccessToken();
        $otp = generateOTP();
        
        $edit_profile = "UPDATE users SET name='$name', email='$email', age='$age', gender='$gender' WHERE id='$userId'";
        $result = mysqli_query($conn, $edit_profile);
        
        if ($result)
        {
           	$_SESSION['otp'] = $otp;
           	$_SESSION['phone'] = $phone;
            $_SESSION['access_token'] = $randCode;

            $sms_api = 'https://2factor.in/API/V1/c577a86c-09c5-11e9-a895-0200cd936042/SMS/'.$phone.'/'.$otp;

            $send = file_get_contents($sms_api);

            $response = array(
                'result' => array(
                    'success' => True,
                    'message' => 'Verify the OTP.'
                )
            );
           
            die(sendResponse($response));
        }
        else
        {
            $response = array(
                'result' => array(
                    'success' => False,
                    'message' => 'Registration failed.'
                )
            );
            die(sendResponse($response));
        }   
   
    }
}
else
{
    $response = array(
        'result' => array(
            'success' => False,
            'data' => 'Some error occured.'
        )
    );
    die(sendResponse($response));
}

?>