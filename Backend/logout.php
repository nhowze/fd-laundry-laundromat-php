<?php
include_once("../LoginSystem/cooks.php");
//session_start();

$sql = "SELECT * FROM Laundromat WHERE email = '".$_SESSION['username']."' ";
$result = mysqli_query($mysqli, $sql);
$row = mysqli_fetch_assoc($result);


echo'<div id="user" style="visibility: hidden;">'.$row['ID'].'</div>';



if(isset($_SESSION['OneSignalPID'])){

	$mysqli->query("DELETE FROM Laundromat_NotificationIds WHERE  LaundromatID = ".$row['ID']." AND  OneSignal ='".$_SESSION['OneSignalPID']."' ");
}


unset($_COOKIE[$cookie_name]);
if (isset($_SESSION['login'])) {

unset($_SESSION['login']);

}

if (isset($_SESSION['admin'])) {

unset($_SESSION['admin']);

}


//clear twitter access tokens
if (isset($_SESSION['access_token'])) {

unset ($_SESSION['access_token']);

}

if (isset($_SESSION['access_token']['oauth_token_secret'])) {

unset ($_SESSION['access_token']['oauth_token_secret']);

}

if (isset($_SESSION['access_token']['oauth_token'])) {

unset ($_SESSION['access_token']['oauth_token']);

}


if ($_SESSION['token']) {

unset ($_SESSION['token']);

}

session_start();
session_destroy();


echo'<script>



window.location.href = "../login.php";



</script>';


?>
