<?php

require ('constants.php');
require ('middleware.php');
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

if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['role']) && isset($_POST['phone']))
{
    $username = mysqli_escape_string($conn, $_POST['username']);
    $password = mysqli_escape_string($conn, $_POST['password']);
    $role = mysqli_escape_string($conn, $_POST['role']);
    $phone = mysqli_escape_string($conn, $_POST['phone']);

    $checkIfAlreadyRegistered = "SELECT username FROM admins WHERE username='$username' ";
    $result = mysqli_query($conn, $checkIfAlreadyRegistered);
    if (mysqli_num_rows($result) != 0)
    {
        $response = array(
            'result' => array(
                'success' => False,
                'message' => 'Username already registered.'
            )
        );
        die(json_encode($response));
    }
    else
    {

    	$checkIfAlreadyRegistered = "SELECT phone FROM admins WHERE phone='$phone' ";
    	$result = mysqli_query($conn, $checkIfAlreadyRegistered);
    	if (mysqli_num_rows($result) != 0)
    	{
    	    $response = array(
    	        'result' => array(
    	            'success' => False,
    	            'message' => 'Phone number already registered.'
    	        )
    	    );
    	    die(json_encode($response));
    	}

        // $checkCardNumber = "SELECT card_number FROM cards WHERE card_number='$card' AND is_used=0";
        // $result = mysqli_query($conn, $checkCardNumber);
        // if (mysqli_num_rows($result) != 1) {
        //     $response = array(
        //         'result' => array(
        //             'success' => False,
        //             'message' => 'Card number is invalid or already used.'
        //         )
        //     );
        //     die(json_encode($response));
        // }

        $randCode = generateAccessToken();
        // $otp = generateOTP();
        // echo $otp;
        $signup_user = "INSERT INTO admins (username, phone, password, role, access_token) VALUES ('$username', '$phone', '$password', '$role', '$randCode')";
        $result = mysqli_query($conn, $signup_user);
        
        if ($result)
        {
            // $_SESSION['otp'] = $otp;
            $_SESSION['access_token'] = $randCode;

            $response = array(
                'result' => array(
                    'success' => True,
                    'message' => 'Registration successful.'
                )
            );
           
            die(json_encode($response));
        }
        else
        {
            $response = array(
                'result' => array(
                    'success' => False,
                    'message' => 'Registration failed.'
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
            'data' => 'Some error occured.'
        )
    );
    die(json_encode($response));
}

?>