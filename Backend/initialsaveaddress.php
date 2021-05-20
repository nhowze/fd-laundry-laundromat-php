<?php

include_once("../LoginSystem/cooks.php");

include_once '../includes/db_connect.php';
include_once '../includes/functions.php';

//session_start();
 

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






$add = $_POST['street-address']. " ". $_POST['unit']. " ". $_POST['city'] . ", ". $_POST['state']. " ". $_POST['zip'];


$address = $add;
$latLong = getLatLong($address);


$latitude = $latLong['latitude']?$latLong['latitude']:'Not found';
$longitude = $latLong['longitude']?$latLong['longitude']:'Not found';

      
      
      $sql = "UPDATE Laundromat SET Address = '".$_POST['street-address']."', Unit = '".$_POST['unit']."', City = '".$_POST['city']."', State = '".$_POST['state']."', Zip = '".$_POST['zip']."', Lat = '".$latitude."', Longi = '".$longitude."'



WHERE email = '".$_SESSION['username']."' ";


$mysqli->query($sql);





header('Location: ../confirm.php');
?>