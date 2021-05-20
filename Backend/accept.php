<?php

include_once("../LoginSystem/cooks.php");
include_once '../includes/db_connect.php';
include_once '../includes/functions.php';

//session_start();
 

$mysqli->query("UPDATE OrderGroup SET Status = 'Approved' WHERE OrderNum = '".$_POST['orderID']."' ");

//OneSignal Start
$sql2 = "SELECT * FROM OrderGroup WHERE OrderNum = '".$_POST['orderID']."' ";
$result2 = mysqli_query($mysqli, $sql2);
$laundromat = mysqli_fetch_assoc($result2);



$sql = "SELECT * FROM users WHERE username = '".$laundromat['Username']."' ";
$result = mysqli_query($mysqli, $sql);
$row = mysqli_fetch_assoc($result);

$playerid = array();
if($row['OneSignal'] != ""){

array_push($playerid,$row['OneSignal']);

}


$fields = array(
		'app_id' => '4ab03baa-ba83-4456-9aec-20722a178737',
		'include_player_ids' => $playerid,
		'contents' => array("en" =>"A driver is on the way to pickup your laundry"),
		'headings' => array("en"=>"Your Order Has Been Accepted!"),
		'url' => 'https://'.$_SERVER['SERVER_NAME'].'/Users/orderdetail.php?orderID='.$laundromat['OrderNum'],
		
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