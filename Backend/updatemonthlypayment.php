<?php
include_once("../LoginSystem/cooks.php");
//session_start();
include_once '../includes/db_connect.php';
include_once '../includes/functions.php';
require_once('../includes/stripe-php-master/init.php');

$sql = "SELECT * FROM Laundromat WHERE email = '".$_SESSION['username']."' ";
$result = mysqli_query($mysqli, $sql);
$row = mysqli_fetch_assoc($result);


if($row["Type"] == "Test"){

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
	
	if (!isset($_POST['stripeToken']))
					throw new Exception("The Stripe Token was not generated correctly");
	


//update

	
	$customer = \Stripe\Customer::update($row['Stripe_Customer_ID'], [
			'source' => $_POST['stripeToken'],
	]);





$mysqli->query("UPDATE Laundromat SET CardName = '".$_POST['cardname']."' WHERE GroupID = ".$row['GroupID']." ");


$_SESSION['carderrmsg'] = "Payment Method Saved!";

}catch (Exception $e) {
	$error = $e->getMessage();
	$_SESSION['carderrmsg'] =$error;
	
//	echo($error);
	
}



echo'
<script>
window.location.href = "../account.php#updatepayment";

</script>';

?>