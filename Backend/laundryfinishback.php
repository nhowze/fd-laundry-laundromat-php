<?php

include_once("../LoginSystem/cooks.php");
//session_start();
include_once '../includes/db_connect.php';
include_once '../includes/functions.php';

$sqlct = "SELECT * FROM Contact WHERE ID = 5 ";
$contactinf = mysqli_query($mysqli, $sqlct);
$contactinf = mysqli_fetch_assoc($contactinf);

require_once('../includes/stripe-php-master/init.php');

$sqlnum = "SELECT * FROM OrderGroup WHERE ID = ".$_POST['oid']." ";
$resultnum = mysqli_query($mysqli, $sqlnum);
$ordersummary = mysqli_fetch_assoc($resultnum);

$_SESSION['confirmtr'] = $ordersummary['ID'];



$sql = "SELECT * FROM users WHERE username = '".$ordersummary['Username']."' ";
$result = mysqli_query($mysqli, $sql);
$user = mysqli_fetch_assoc($result);


$sql = "SELECT * FROM users WHERE username = '".$ordersummary['Username']."' ";
$result = mysqli_query($mysqli, $sql);
$row = mysqli_fetch_assoc($result);


$sql = "SELECT * FROM Laundromat WHERE email = '".$_SESSION['username']."' ";
$result = mysqli_query($mysqli, $sql);
$launinfo = mysqli_fetch_assoc($result);

if($row['Type'] == "Test"){

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

$sql2t = "SELECT * FROM `Balance_Rate` WHERE `ID` = 2 ";
$delivrmatratef= mysqli_query($mysqli, $sql2t);
$delivrmatratef = mysqli_fetch_assoc($delivrmatratef);

$sql2f = "SELECT * FROM `Balance_Rate` WHERE `ID` = 1 ";
$laundromatratef= mysqli_query($mysqli, $sql2f);
$laundromatratef = mysqli_fetch_assoc($laundromatratef);


$startersql = "SELECT * FROM `Balance_Rate` WHERE `ID` = 7 ";
$starter= mysqli_query($mysqli, $startersql);
$starter = mysqli_fetch_assoc($starter);


$standardsql = "SELECT * FROM `Balance_Rate` WHERE `ID` = 8 ";
$standard= mysqli_query($mysqli, $standardsql);
$standard = mysqli_fetch_assoc($standard);


$goldsql = "SELECT * FROM `Balance_Rate` WHERE `ID` = 9 ";
$gold= mysqli_query($mysqli, $goldsql);
$gold = mysqli_fetch_assoc($gold);


if($ordersummary['Status'] != "Laundry Complete"){

	
	if($launinfo['SubscriptionType'] == "starter"){
	    

	    
	    	$dfee =  ($ordersummary['ItemTotal'] - $ordersummary['DiscountAmount'])*$starter['Rate'];
	$lfee = (1-$delivrmatratef['Rate']) * $ordersummary['ItemTotal'];
	    
	}else if($launinfo['SubscriptionType'] == "standard"){
	    
	    	$dfee =  ($ordersummary['ItemTotal'] - $ordersummary['DiscountAmount'])*$standard['Rate'];
	$lfee = (1-$delivrmatratef['Rate']) * $ordersummary['ItemTotal'];
	    
	}else if($launinfo['SubscriptionType'] == "gold"){
	    
	    	$dfee =  ($ordersummary['ItemTotal'] - $ordersummary['DiscountAmount'])*$gold['Rate'];
	$lfee = (1-$delivrmatratef['Rate']) * $ordersummary['ItemTotal'];
	    
	}
	

	
	
	
	$sqlord = "UPDATE OrderGroup SET Status = 'Laundry Complete', Laundry_Complete = 1, LaundromatFee = '".$lfee."', DelivrmatFee = '".$dfee."'  WHERE ID = ".$_POST['oid']." ";
$mysqli->query($sqlord);





//discount calculation start
if(!is_null($ordersummary['PromoID'])){
	
	$sqlpromo = "SELECT * FROM PromoCodes WHERE ID = ".$ordersummary['PromoID']." ";
	$resultpromo = mysqli_query($mysqli, $sqlpromo);
	$resultpromo= mysqli_fetch_assoc($resultpromo);
	
	
	if($resultpromo['Type'] == "Percentage"){		//percentage discount
		
		
		$total =	number_format($ordersummary['TotalPrice'] -  ($resultpromo['AmountOff'] * $ordersummary['TotalPrice']), 2);
		
	}else if($resultpromo['Type'] == "Delivery"){	//delivery discount
		
		
		$total =	number_format(($ordersummary['TotalPrice'] -  $ordersummary['DeliveryTotal']), 2);
		
	}else if($resultpromo['Type'] == "Money"){			//money discount
		
		
		$total =	number_format($ordersummary['TotalPrice'] - $resultpromo['AmountOff'], 2);
	}
	
	
	
	
	
}else{
	
	$total =	number_format($ordersummary['TotalPrice'], 2);
	
}



$total = $total * 100;

//discount calculation end


	\Stripe\Stripe::setApiKey($keys['Key']);
	$error = '';
	$success = '';
	try {


			
			
			$charge = \Stripe\Charge::create(array("amount" => $total,
					"currency" => "usd",
					"description" => $ordersummary['Name'],
					"receipt_email" => "garb@delivrmat.com",
					'customer' => $user['Stripe']));
			
			





$sqlord = "UPDATE OrderGroup SET Payment_Status = 'Approved'  WHERE ID = ".$_POST['oid']." ";
$mysqli->query($sqlord);

$_SESSION['confirmmessage'] = "";





if($ordersummary['Delivery'] == "False"){


$sql = "SELECT * FROM users WHERE username = '".$ordersummary['Username']."' ";
$result = mysqli_query($mysqli, $sql);
$row = mysqli_fetch_assoc($result);




$playerid = array();
if($row['OneSignal'] != ""){
	
	array_push($playerid,$row['OneSignal']);
	
}



$fields = array(
		'app_id' => '4ab03baa-ba83-4456-9aec-20722a178737',
		'include_player_ids' => $playerid,
		'contents' => array("en" =>"It is ready for pickup at ".$ordersummary['Name']."."),
		'headings' => array("en"=>"Your laundry has finished!"),
		'url' => 'https://'.$_SERVER['SERVER_NAME'].'/Users/orderdetail.php?orderID='.$ordersummary['OrderNum'],
);

$fields = json_encode($fields);
//print("\nJSON sent:\n");
//print($fields);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
		'Authorization: Basic M2ZNDYtMjA4ZGM2ZmE5ZGFj'));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, FALSE);
curl_setopt($ch, CURLOPT_POST, TRUE);
curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

$response = curl_exec($ch);
curl_close($ch);
//print_r($response);

// End OneSignal





}else{
	
	
	
	
	$sql = "SELECT * FROM users WHERE username = '".$ordersummary['Username']."' ";
	$result = mysqli_query($mysqli, $sql);
	$row = mysqli_fetch_assoc($result);
	
	$playerid = array();
if($row['OneSignal'] != ""){

array_push($playerid,$row['OneSignal']);

}


	$fields = array(
			'app_id' => '4ab03baa-ba83-4456-9aec-20722a178737',
			'include_player_ids' => $playerid,
			'contents' => array("en" =>"A ".$contactinf['Name']." Driver will pick up your laundry soon."),
			'headings' => array("en"=>"Your laundry has finished!"),
			'url' => "https://".$_SERVER['SERVER_NAME']."/Users/orderdetail.php?orderID=".$ordersummary['OrderNum'],
	);
	
	$fields = json_encode($fields);
	//print("\nJSON sent:\n");
	//print($fields);
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
			'Authorization: Basic M2ZNDYtMjA4ZGM2ZmE5ZGFj'));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($ch, CURLOPT_HEADER, FALSE);
	curl_setopt($ch, CURLOPT_POST, TRUE);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	
	$response = curl_exec($ch);
	curl_close($ch);
	//print_r($response);
	
	// End OneSignal
	}
	
	
	
	}
	catch (Exception $e) {
		$error = $e->getMessage();
		
//	$_SESSION['paymessage'] =	$error;
		
		$sqlords = "UPDATE OrderGroup SET Payment_Status = 'Declined'  WHERE ID = ".$_POST['oid']." ";
$mysqli->query($sqlords);
		
		
		
		
		
			$sql = "SELECT * FROM users WHERE username = '".$ordersummary['Username']."' ";
	$result = mysqli_query($mysqli, $sql);
	$row = mysqli_fetch_assoc($result);
	
	$playerid = array();
if($row['OneSignal'] != ""){

array_push($playerid,$row['OneSignal']);

}

	$fields = array(
			'app_id' => '4ab03baa-ba83-4456-9aec-20722a178737',
			'include_player_ids' => $playerid,
			'contents' => array("en" =>"Please update your payment method to receive your laundry."),
			'headings' => array("en"=>"Your payment method was declined."),
			'url' => 'https://'.$_SERVER['SERVER_NAME'].'/Users/orderdetail.php?orderID='.$ordersummary['OrderNum'].'#updatep',
	);
	
	$fields = json_encode($fields);
	//print("\nJSON sent:\n");
	//print($fields);
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
			'Authorization: Basic M2ZNDYtMjA4ZGM2ZmE5ZGFj'));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($ch, CURLOPT_HEADER, FALSE);
	curl_setopt($ch, CURLOPT_POST, TRUE);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	
	$response = curl_exec($ch);
	curl_close($ch);
	//print_r($response);
	
	// End OneSignal
		
		
		
		
		
		
		
		$_SESSION['paymessage'] = "The customer's payment method was declined. We have contacted the customer to chagne their payment method. Try again later!";
		//   echo($error);
		
	}
	
	
}
	
	
	$redirect = "https://".$_SERVER['SERVER_NAME']."/Laundromats/orderdetail.php?oid=".$ordersummary['ID'];

	header("Location: ".$redirect);


?>