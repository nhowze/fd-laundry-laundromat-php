<?php

include_once("../LoginSystem/cooks.php");

include_once '../includes/db_connect.php';
include_once '../includes/functions.php';

//session_start();
 

$sql = "SELECT * FROM Laundromat WHERE email = '".$_SESSION['username']."' ";
$result = mysqli_query($mysqli, $sql);
$row = mysqli_fetch_assoc($result);

$price = round($_POST['pricep'],2);
$price = number_format($_POST['pricep'],2);


$sqll = "INSERT INTO Options (Name, Price, LaundromatID, ProductID) VALUES ('".$_POST['oname']."', '".$price."', ".$row['ID'].", ".$_POST['productid'].") ";

$mysqli->query($sqll);



$_SESSION['productmsg'] = "Addon Saved!";






header('Location: ../products.php#plist');

?>