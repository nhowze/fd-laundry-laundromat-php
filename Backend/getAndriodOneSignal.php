<?php 
include_once("LoginSystem/cooks.php");
//session_start();
include_once('LoginSystem/db.php');
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';


$_POST['User'] = str_replace('"',"",$_POST['User']);


if($_POST['urlname'] != "https://".$_SERVER['SERVER_NAME']."/Laundromats/logout.php" && $_POST['urlname'] != "https://www.".$_SERVER['SERVER_NAME']."/Laundromats/logout.php"){
	
	
	


$sql = "SELECT * FROM Laundromat WHERE ID = '".$_POST['User']."' ";
$result = mysqli_query($mysqli, $sql);
$row = mysqli_fetch_assoc($result);



$sql2 = "SELECT * FROM Laundromat_NotificationIds WHERE LaundromatID = ".$row['ID']." AND OneSignal = '".$_POST['ID']."' ";
$result = mysqli_query($mysqli, $sql2);

if ($result->num_rows == 0) {
	
	$mysqli->query("INSERT INTO Laundromat_NotificationIds (LaundromatID, OneSignal, Platform) VALUES (".$row['ID'].", '".$_POST['ID']."', 'Android');");
	
	
}



}else{
	
	
	
	
	if(isset($_POST['User'] ) && isset($_POST['ID'])){
		$_POST['User'] = str_replace('"',"",$_POST['User']);
		
		$mysqli->query("DELETE FROM Laundromat_NotificationIds WHERE LaundromatID = ".$_POST['User']." AND OneSignal = '".$_POST['ID']."' ");
		
		
	}
	
	
	
}






?>