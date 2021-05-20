<?php

include_once("../LoginSystem/cooks.php");
//session_start();
include_once('../LoginSystem/db.php');
include_once '../includes/db_connect.php';
include_once '../includes/functions.php';

$sqlnum = "SELECT * FROM OrderGroup WHERE OrderNum = '".$_SESSION['orderID']."' ";
$resultnum = mysqli_query($mysqli, $sqlnum);
$ordersummary = mysqli_fetch_assoc($resultnum);

if($ordersummary['Status'] == "Received"){
	
echo'<script>

location.reload();


</script>';


}
 
?>