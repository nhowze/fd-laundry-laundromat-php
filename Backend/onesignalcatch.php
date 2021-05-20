<?php 
include_once("LoginSystem/cooks.php");
//session_start();
include_once('LoginSystem/db.php');
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';




$sql = "SELECT * FROM Laundromat WHERE email = '".$_SESSION['username']."' ";
$result = mysqli_query($mysqli, $sql);
$row = mysqli_fetch_assoc($result);



$sql2 = "SELECT * FROM Laundromat_NotificationIds WHERE LaundromatID = ".$row['ID']." AND OneSignal = '".$_POST['ID']."' ";
$result = mysqli_query($mysqli, $sql2);

if ($result->num_rows == 0) {
	
	$mysqli->query("INSERT INTO Laundromat_NotificationIds (LaundromatID, OneSignal, Platform) VALUES (".$row['ID'].", '".$_POST['ID']."', 'IOS');");
	
	
}




$_SESSION['OneSignalPID'] = $_POST['ID'];




?>