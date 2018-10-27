<?php

require ('constants.php');
require ('middleware.php');

function generateAccessToken($length = 20) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

if (isset($_POST['name']) && isset($_POST['address']) && isset($_POST['phone']) && isset($_POST['category']) && isset($_POST['username']) && isset($_POST['password'])  && isset($_POST['lat']) && isset($_POST['lng']) && isset($_POST['video'])) {

	$name = mysqli_escape_string($conn, $_POST['name']);
	$address = mysqli_escape_string($conn, $_POST['address']);
	$phone = mysqli_escape_string($conn, $_POST['phone']);
	$category = mysqli_escape_string($conn, $_POST['category']);
	$username = mysqli_escape_string($conn, $_POST['username']);
	$password = mysqli_escape_string($conn, $_POST['password']);
	$lat = mysqli_escape_string($conn, $_POST['lat']);
	$lng = mysqli_escape_string($conn, $_POST['lng']);
	$video = mysqli_escape_string($conn, $_POST['video']);

	if (isset($_POST['storeId'])) {
		$storeId = mysqli_escape_string($conn, $_POST['storeId']);

		$updateStoreQuery = "UPDATE stores SET name='$name', address='$address', phone='$phone', category='$category', lat='$lat', lng='$lng', video='$video' WHERE id='$storeId'";

		$updateRetailerQuery = "UPDATE retailers SET username='$username', password='$password' WHERE store_id='$storeId'";

		$result = mysqli_query($conn, $updateStoreQuery);
		$result2 = mysqli_query($conn, $updateRetailerQuery);

		if ($result && $result2) {
			$response = array(
			    'result' => array(
			        'success' => True,
			        'message' => 'Store updated successfully.'
			    )
			);
			die(json_encode($response));	
		}
		else {
			$response = array(
			    'result' => array(
			        'success' => False,
			        'message' => 'Failed to update store.'
			    )
			);
			die(json_encode($response));
		}
	}

	$result = upload_image('stores');

	if ($result['result']['success']) {
		$file_name = $result['result']['file_name'];

		$addStoreQuery = "INSERT INTO stores (name, photo, address, phone, category, lat, lng, video) VALUES ('$name', '$file_name', '$address', '$phone', '$category', '$lat', '$lng', '$video')";

		$result = mysqli_query($conn, $addStoreQuery);

		if ($result) {
			$getStoreIdQuery = "SELECT id from stores WHERE phone='$phone'";

			$result = mysqli_query($conn, $getStoreIdQuery);

			if ($result) {
				$storeId = mysqli_fetch_assoc($result)['id'];
				$access_token = generateAccessToken();

				$addRetailerQuery = "INSERT INTO retailers (store_id, username, password, access_token) VALUES ('$storeId', '$username', '$password', '$access_token')";

				$result = mysqli_query($conn, $addRetailerQuery);
				if ($result) {
					$response = array(
					    'result' => array(
					        'success' => True,
					        'message' => 'Store added successfully.'
					    )
					);
					die(json_encode($response));
				}
				else {
					$response = array(
					    'result' => array(
					        'success' => False,
					        'message' => 'Failed to add store.'
					    )
					);
					die(json_encode($response));
				}
			}
			else {
				$response = array(
				    'result' => array(
				        'success' => False,
				        'message' => 'Failed to add store.'
				    )
				);
				die(json_encode($response));
			}
			
		}
		else {
			$response = array(
			    'result' => array(
			        'success' => False,
			        'message' => 'Failed to add store.'
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