<?php
include_once("../LoginSystem/cooks.php");

include_once '../includes/db_connect.php';
include_once '../includes/functions.php';

//session_start();


require_once('../includes/stripe-php-master/init.php');

$mysqli->query("UPDATE OrderGroup SET Status = 'Rejected' WHERE OrderNum = '".$_POST['orderID']."' ");



$sql = "SELECT * FROM OrderGroup WHERE OrderNum = '".$_POST['orderID']."' ";
$result = mysqli_query($mysqli, $sql);
$row = mysqli_fetch_assoc($result);

if($row['Type'] == "Test"){

$sql2 = "SELECT * FROM `Keys` WHERE `ID` = 4 ";
$result2 = mysqli_query($mysqli, $sql2);
$keys = mysqli_fetch_assoc($result2);


$sql2 = "SELECT * FROM `Keys` WHERE `ID` = 8 ";
$result2 = mysqli_query($mysqli, $sql2);
$keys2 = mysqli_fetch_assoc($result2);
$subscription2 = $keys2['Key'];


}else{

$sql2 = "SELECT * FROM `Keys` WHERE `ID` = 12 ";
$result2 = mysqli_query($mysqli, $sql2);
$keys = mysqli_fetch_assoc($result2);


$sql2 = "SELECT * FROM `Keys` WHERE `ID` = 14 ";
$result2 = mysqli_query($mysqli, $sql2);
$keys2 = mysqli_fetch_assoc($result2);
$subscription2 = $keys2['Key'];

}

// Set your secret key: remember to change this to your live secret key in production
// See your keys here: https://dashboard.stripe.com/account/apikeys

/**
\Stripe\Stripe::setApiKey($keys['Key']);

$refund = \Stripe\Refund::create([
		'charge' => $row['ChargeID'],
]);

**/




//OneSignal Start
$sql2 = "SELECT * FROM OrderGroup WHERE OrderNum = '".$_POST['orderID']."' ";
$result2 = mysqli_query($mysqli, $sql2);
$laundromat = mysqli_fetch_assoc($result2);



$sql = "SELECT * FROM users WHERE username = '".$laundromat['Username']."' ";
$result = mysqli_query($mysqli, $sql);
$row2 = mysqli_fetch_assoc($result);



$playerid = array();
if($row2['OneSignal'] != ""){

array_push($playerid,$row2['OneSignal']);

}



$fields = array(
		'app_id' => '4ab03baa-ba83-4456-9aec-20722a178737',
		'include_player_ids' => $playerid,
		'contents' => array("en" =>"Your order may have been rejected because the laundromat is closed or over booked for orders. Try again later!"),
		'headings' => array("en"=>"Your Order Has Been Rejected :("),
		'url' => 'https://'.$_SERVER['SERVER_NAME'].'/Users/orderdetail.php?orderID='.$row['OrderNum'],
);

$fields = json_encode($fields);
//print("\nJSON sent:\n");
//print($fields);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
		'Authorization: Basic M2ZNDYtMjA4ZGM2ZmE5ZGFj'));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, FALSE);
curl_setopt($ch, CURLOPT_POST, TRUE);
curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

$response = curl_exec($ch);
curl_close($ch);
//print_r($response);

// End OneSignal




echo'<script>window.location.href = "../orders.php";</script>';

?>