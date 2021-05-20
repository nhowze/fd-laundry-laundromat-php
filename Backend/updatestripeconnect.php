<?php 

include_once("../LoginSystem/cooks.php");
//session_start();
include_once '../includes/db_connect.php';
include_once '../includes/functions.php';
require_once('../includes/stripe-php-master/init.php');




$sql = "SELECT * FROM Laundromat WHERE email = '".$_SESSION['username']."' ";
$result = mysqli_query($mysqli, $sql);
$row = mysqli_fetch_assoc($result);

if($_SESSION['username'] == "contactus@icitechnologies.com"){

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

define('CLIENT_ID', 'ca_DDu3UsRpsnOVRFAaRE4KRGo4HrOluFmt');
define('API_KEY', $keys['Key']);
define('TOKEN_URI', 'https://connect.stripe.com/oauth/token');
define('AUTHORIZE_URI', 'https://connect.stripe.com/oauth/authorize');
if (isset($_GET['code'])) { // Redirect w/ code
	$code = $_GET['code'];
	$token_request_body = array(
			'client_secret' => API_KEY,
			'grant_type' => 'authorization_code',
			'client_id' => CLIENT_ID,
			'code' => $code,
	);
	$req = curl_init(TOKEN_URI);
	curl_setopt($req, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($req, CURLOPT_POST, true );
	curl_setopt($req, CURLOPT_POSTFIELDS, http_build_query($token_request_body));
	// TODO: Additional error handling
	$respCode = curl_getinfo($req, CURLINFO_HTTP_CODE);
	$resp = json_decode(curl_exec($req), true);
	curl_close($req);
//	echo $resp['access_token'];
//	echo($resp['stripe_user_id']);

	$mysqli->query("UPDATE Laundromat SET StripeAccount = '".$resp['stripe_user_id']."' WHERE GroupID = ".$row['GroupID']." ");

}



echo'
<script>
window.location.href = "../account.php";
		
</script>';





?>