<?php

include_once("../LoginSystem/cooks.php");
//session_start();
include_once('../LoginSystem/db.php');
include_once '../includes/db_connect.php';
include_once '../includes/functions.php';
require_once('../includes/stripe-php-master/init.php');






$sql = "SELECT * FROM Laundromat WHERE ID = '".$_GET['lid']."' ";
$result = mysqli_query($mysqli, $sql);
$row = mysqli_fetch_assoc($result);


$_SESSION['username'] = $row['email'];
$_SESSION['lanlocation'] = "true";

 header('Location: ../home.php');


?>