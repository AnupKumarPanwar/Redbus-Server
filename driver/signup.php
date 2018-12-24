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


if (isset($_POST['phone']) && isset($_POST['name']) && isset($_POST['email']) && isset($_POST['bus_number']))
{
    $phone = mysqli_escape_string($conn, $_POST['phone']);
    $email = mysqli_escape_string($conn, $_POST['email']);
    $name = mysqli_escape_string($conn, $_POST['name']);
    $bus_number = mysqli_escape_string($conn, $_POST['bus_number']);
    

    $checkIfPhoneAlreadyRegistered = "SELECT name FROM drivers WHERE phone='$phone'";
    $result = mysqli_query($conn, $checkIfPhoneAlreadyRegistered);
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

    $checkIfBusAlreadyRegistered = "SELECT name FROM drivers WHERE bus_number='$bus_number'";
    $result = mysqli_query($conn, $checkIfPhoneAlreadyRegistered);
    if (mysqli_num_rows($result) != 0)
    {
        $response = array(
            'result' => array(
                'success' => False,
                'message' => 'Bus number already registered.'
            )
        );
        die(json_encode($response));
    }

    $checkIfEmailAlreadyRegistered = "SELECT name FROM drivers WHERE email='$email'";
    $result = mysqli_query($conn, $checkIfEmailAlreadyRegistered);

    if (mysqli_num_rows($result) != 0)
    {
        $response = array(
            'result' => array(
                'success' => False,
                'message' => 'Email already registered.'
            )
        );
        die(json_encode($response));
    }
    else
    {
        $randCode = generateAccessToken();
        
        $signup_driver = "INSERT INTO drivers (name, phone, email, bus_number, access_token, created_at) VALUES ('$name', '$phone', '$email', '$bus_number', '$randCode', NOW())";
        $result = mysqli_query($conn, $signup_driver);
        
        if ($result)
        {
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