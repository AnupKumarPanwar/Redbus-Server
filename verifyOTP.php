<?php

require ('constants.php');
session_start();

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
        $updateCardUsed = "UPDATE cards, users set cards.is_used=1 WHERE cards.card_number=users.card AND users.access_token='$access_token'";
        $result = mysqli_query($conn, $updateCardUsed);
        if ($result) {
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