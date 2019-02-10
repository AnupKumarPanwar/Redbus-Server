<?php

require ('constants.php');
require ('middleware.php');

$userId = $_SESSION['user_id'];

$checkTripStartedQuery = "SELECT * FROM bookings WHERE user_id='$userId' AND pickup_at IS NOT NULL AND dropoff_at IS NULL AND cancelled=0";

$result = mysqli_query($conn, $checkTripStartedQuery);

if(mysqli_num_rows($result)==1) {
	$response = array(
        'result' => array(
            'success' => False,
            'message' => 'Trip has already started.'
        )
    );
    die(json_encode($response));
}
else
{
	$cancelTripQuery = "UPDATE bookings SET cancelled=1 WHERE user_id='$userId' AND pickup_at IS NULL AND cancelled=0";

    $result = mysqli_query($conn, $cancelTripQuery);

    if ($result) {
        $response = array(
                'result' => array(
                    'success' => True,
                    'message' => 'Trip cancelled successfully.'
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
?>