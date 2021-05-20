<?php

include_once("../LoginSystem/cooks.php");
//session_start();
include_once('../LoginSystem/db.php');
include_once '../includes/db_connect.php';
include_once '../includes/functions.php';
require_once('../includes/stripe-php-master/init.php');






$sql = "SELECT * FROM Laundromat WHERE email = '".$_SESSION['username']."' ";
$result = mysqli_query($mysqli, $sql);
$row = mysqli_fetch_assoc($result);


$sql2 = "SELECT * FROM Laundromat WHERE GroupID = '".$row['GroupID']."' AND AccountType = 'Main' ";
$result2 = mysqli_query($mysqli, $sql2);
$row2 = mysqli_fetch_assoc($result2);


$_SESSION['username'] = $row2['email'];
unset($_SESSION['lanlocation']);



 header('Location: ../homeinit.php');


?>