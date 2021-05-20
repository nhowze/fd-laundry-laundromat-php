<?php
include_once("../LoginSystem/cooks.php");
//session_start();
include_once('../LoginSystem/db.php');
include_once '../includes/db_connect.php';
include_once '../includes/functions.php';
require_once('../includes/stripe-php-master/init.php');

$sql = "SELECT * FROM Products WHERE ID = '".$_POST['pid']."'";


$result = mysqli_query($mysqli, $sql);
$result = mysqli_fetch_assoc($result);


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

/**
try {
	
	\Stripe\Stripe::setApiKey($keys['Key']);



	
	$product = \Stripe\Product::retrieve($result['StripeID']);
	
	
	$product->active= false;
	$product->save();**/


//$mysqli->query("DELETE FROM Products WHERE ID = '".$_POST['pid']."' ");

$sqll = "UPDATE  Products SET Active = 'False' WHERE ID = '".$_POST['pid']."' ";
$mysqli->query($sqll);


$_SESSION['productmsg'] = "Product Removed";

/**
}catch (Exception $e) {
	$error = $e->getMessage();
	
	$_SESSION['errmsg'] = $error;
	//echo($error);
	
}
**/


header('Location: ../products.php#plist');
?>


