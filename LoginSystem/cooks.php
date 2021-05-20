<?php

include_once '../includes/db_connect.php';

$sqlct = "SELECT * FROM Contact WHERE ID = 5 ";
$contactinf = mysqli_query($mysqli, $sqlct);
$contactinf = mysqli_fetch_assoc($contactinf);

ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_secure', 1);
//ini_set('session.save_path', $_SERVER["DOCUMENT_ROOT"].'/Laundromats/LoginSystem/cook');
ini_set('session.gc_probability', 1);
ini_set('session.gc_divisor', 100000000);



session_start();

$cookie_name = "delivrmatlan";
$cookie_value = $_SESSION['username'];


setcookie($cookie_name, $cookie_value, time() + 31556952, $_SERVER["DOCUMENT_ROOT"].'/Laundromats/LoginSystem/cook', $_SERVER["SERVER_NAME"]."/Laundromats/", TRUE, TRUE); // 86400 = 1 day





if(isset($_SESSION['username']) && $_SESSION['username'] != ""){
	$_COOKIE["delivrmatlan"] = $_SESSION['username'];
$_SESSION['login'] == true;
	
	$mysqli->query("UPDATE Laundromat SET Last_Active = NOW() WHERE email = '".$_SESSION['username']."' ");
	
	
}

function startsWith ($string, $startString) 
{ 
    $len = strlen($startString); 
    return (substr($string, 0, $len) === $startString); 
} 



?>