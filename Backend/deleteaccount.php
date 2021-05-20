<?php

include_once("../LoginSystem/cooks.php");
include_once '../includes/db_connect.php';
include_once '../includes/functions.php';

//session_start();
require_once('../includes/stripe-php-master/init.php');


$sql = "SELECT * FROM Laundromat WHERE email = '".$_SESSION['username']."' ";
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




try {
	
	\Stripe\Stripe::setApiKey($keys['Key']);
	
	
	
	$subscription = \Stripe\Subscription::retrieve($row['SubscriptionID']);
	$subscription->cancel();
	
	
	
	$mysqli->query("DELETE FROM Laundromat WHERE GroupID = ".$row['GroupID']." ");
	
	
	
}catch (Exception $e) {
	$error = $e->getMessage();
	
	//echo($error);
	
}



echo'
<script>
window.location.href = "logout.php";
		
</script>';


?>