<?php

include_once("../LoginSystem/cooks.php");

include_once '../includes/db_connect.php';
include_once '../includes/functions.php';

//session_start();
 $sql = "SELECT * FROM Laundromat WHERE email = '".$_SESSION['username']."' ";
$result = mysqli_query($mysqli, $sql);
$row = mysqli_fetch_assoc($result);

function getLatLong($address){
	if(!empty($address)){
		//Formatted address
		$formattedAddr = str_replace(' ','+',$address);
		//Send request and receive json data by address
		$geocodeFromAddr = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$formattedAddr.'&sensor=false&key=');
		
		$output = json_decode($geocodeFromAddr);
		//Get latitude and longitute from json data
		
		
		$data['latitude']  = $output->results[0]->geometry->location->lat;
		$data['longitude'] = $output->results[0]->geometry->location->lng;
		
		//Return latitude and longitude of the given address
		if(!empty($data)){
			return $data;
		}else{
			return false;
		}
	}else{
		return false;
	}
}





$username = $row['username']."-addon-".rand(1,99999999)."-".date("Y-m-d");



$add = $_POST['street-address']. " ". $_POST['unit']. " ". $_POST['city'] . ", ". $_POST['state']. " ". $_POST['zip'];


$address = $add;
$latLong = getLatLong($address);


$latitude = $latLong['latitude']?$latLong['latitude']:'Not found';
$longitude = $latLong['longitude']?$latLong['longitude']:'Not found';

      
      
 


$sql = "INSERT INTO Laundromat (Subscription,SubscriptionType, Type, Address, Unit, City, State, Zip, Lat, Longi, Name, Phone, Contact_Name, activ_status, username, email,StripeAccount,Stripe_Customer_ID,SubscriptionID,CardName,GroupID,AccountType, Terms, Profile_Pic)


VALUES ('".$row['Subscription']."','".$row['SubscriptionType']."', '".$row['Type']."', '".$_POST['street-address']."', '".$_POST['unit']."', '".$_POST['city']."', '".$_POST['state']."', '".$_POST['zip']."', '".$latitude."', '".$longitude."','".$row['Name']." | ".$_POST['nickname']."','".$_POST['phone']."','".$_POST['cname']."', 1, '".$username."', '".$row['email']."@".$_POST['nickname']."','".$row['StripeAccount']."','".$row['Stripe_Customer_ID']."','".$row['SubscriptionID']."','".$row['CardName']."','".$row['ID']."','Addon', '".$row['Terms']."', '".$row['Profile_Pic']."')";



$mysqli->query($sql);



$_SESSION['savemess'] = "You have successfully created a new location!";



header('Location: resetlocation.php');
?>