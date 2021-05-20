<?php

include_once("../LoginSystem/cooks.php");

include_once '../includes/db_connect.php';
include_once '../includes/functions.php';

//session_start();
 

$sql = "SELECT * FROM Laundromat WHERE email = '".$_SESSION['username']."' ";
$result = mysqli_query($mysqli, $sql);
$row = mysqli_fetch_assoc($result);




//$sqll = "DELETE FROM Options WHERE ID = '".$_POST['oid']."' ";

$sqll = "UPDATE  Options SET Active = 'False' WHERE ID = '".$_POST['oid']."' ";


$mysqli->query($sqll);


$_SESSION['productmsg'] = "Addon Option Removed";


header('Location: ../products.php#plist');

?>