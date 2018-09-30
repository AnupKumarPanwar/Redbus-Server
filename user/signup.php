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

function generateOTP($length = 4) {
    $characters = '0123456789';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

if (isset($_POST['phone']) && isset($_POST['card']) && isset($_POST['name']))
{
    $phone = mysqli_escape_string($conn, $_POST['phone']);
    $card = mysqli_escape_string($conn, $_POST['card']);
    $name = mysqli_escape_string($conn, $_POST['name']);

    $checkIfAlreadyRegistered = "SELECT name FROM users WHERE phone='$phone'";
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
    else
    {
        $checkCardNumber = "SELECT card_number FROM cards WHERE card_number='$card' AND is_used=0";
        $result = mysqli_query($conn, $checkCardNumber);
        if (mysqli_num_rows($result) != 1) {
            $response = array(
                'result' => array(
                    'success' => False,
                    'message' => 'Card number is invalid or already used.'
                )
            );
            die(json_encode($response));
        }

        $randCode = generateAccessToken();
        $otp = generateOTP();
        echo $otp;
        $signup_user = "INSERT INTO users (name, phone, card, access_token) VALUES ('$name', '$phone', '$card', '$randCode')";
        $result = mysqli_query($conn, $signup_user);
        
        if ($result)
        {
            $_SESSION['otp'] = $otp;
            $_SESSION['access_token'] = $randCode;

            $response = array(
                'result' => array(
                    'success' => True,
                    'message' => 'Verify the OTP.',
                    'data' => $otp
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