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





$sql2 = "SELECT * FROM Laundromat WHERE GroupID = '".$row['GroupID']."' AND AccountType = 'Main' ";
$result2 = mysqli_query($mysqli, $sql2);
$row2 = mysqli_fetch_assoc($result2);


$_SESSION['username'] = $row2['email'];
unset($_SESSION['lanlocation']);




	
	
	
	$mysqli->query("DELETE FROM Laundromat WHERE ID = ".$row['ID']." ");
	$_SESSION['savemess'] = "Location Removed!";
	



echo'
<script>
window.location.href = "resetlocation.php";
		
</script>';


?>