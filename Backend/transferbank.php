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

	
	$_POST['ammount'] = $_POST['ammount'] *100;


// Create a Transfer to a connected account (later):
$transfer = \Stripe\Transfer::create(array(
		"amount" => $_POST['ammount'],
		"currency" => "usd",
		"destination" => $row['StripeAccount']
		//"transfer_group" => "{ORDER10}",
));


/**	
$transfer = \Stripe\Payout::create([
		"amount" => $_POST['ammount'],
		"currency" => "usd",
], ["stripe_account" => $row['StripeAccount']]);
**/

$_POST['ammount'] = number_format(($_POST['ammount'] /100),2);



$_SESSION['errmsg'] = "You have successfully transfered $".$_POST['ammount']." to your stripe account.";



$newbal = $row['Balance']-$_POST['ammount'];

$mysqli->query("UPDATE Laundromat SET Balance = '.$newbal.' WHERE email = '".$_SESSION['username']."' ");


//insert payment history database
$ddate = date("Y-m-d");
$time = date("H:i:s");
$mysqli->query("INSERT INTO Laundromat_Transfer_History (Email, UserID, Date, Time, Amount) VALUES ('".$_SESSION['username']."', ".$row['ID'].", '".$ddate."', '".$time."', ".$_POST['ammount'].") ");


}catch (Exception $e) {
	$error = $e->getMessage();
	
	$_SESSION['errmsg'] = $error;
//	$_SESSION['errmsg'] = "There waas an error transferring funds to your stripe account. Please check that you have entered the correct stripe account id.";
	
	//   echo($error);
	
	
	
	
}
//echo($_SESSION['errmsg']);



echo'<script> window.location.href = "../account.php#transferdiv"; </script>';


?>