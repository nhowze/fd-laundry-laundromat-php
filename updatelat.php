<?php

include_once("LoginSystem/cooks.php");

include_once 'includes/db_connect.php';
include_once 'includes/functions.php';

//session_start();


$sql = "UPDATE Laundromat SET Lat = '".$_POST['latitude']."', Longi = '".$_POST['longitude']."'

WHERE email = '".$_SESSION['username']."' ";


$mysqli->query($sql);



?>