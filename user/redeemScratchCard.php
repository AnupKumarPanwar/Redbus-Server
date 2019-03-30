<?php

include_once('constants.php');
include_once('middleware.php');


if (isset($_POST['scratchCardId'])) {
    $userId = $_SESSION['user_id'];

    $scratchCardId = mysqli_escape_string($conn, $_POST['scratchCardId']);

    $redeemScratchCard = "UPDATE users, cashbacks SET credits=credits+cashbacks.amount, cashbacks.status='SCRATCHED' WHERE users.id='$userId' AND cashbacks.id='$scratchCardId' AND cashbacks.status='CREATED'";

    $result = mysqli_query($conn, $redeemScratchCard);

    if ($result) {
        $response = array(
            'result' => array(
                'success' => false,
                'message' => 'Cashback redeemed successfully.'
            )
        );
        die(sendResponse($response));
    } else {
        $response = array(
            'result' => array(
                'success' => false,
                'message' => 'Failed to redeem cashback.'
            )
        );
        die(sendResponse($response));
    }
} else {
    $response = array(
        'result' => array(
            'success' => false,
            'message' => 'Some error occured.'
        )
    );
    die(sendResponse($response));
}
 