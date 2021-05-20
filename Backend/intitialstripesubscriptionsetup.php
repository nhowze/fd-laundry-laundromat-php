<?php
include_once("../LoginSystem/cooks.php");
//session_start();
include_once '../includes/db_connect.php';
include_once '../includes/functions.php';
require_once('../includes/stripe-php-master/init.php');

$sql = "SELECT * FROM `Keys` WHERE ID = 9 ";
$taxkey= mysqli_query($mysqli, $sql);
$taxkey= mysqli_fetch_assoc($taxkey);


require_once('../includes/tax/vendor/autoload.php');

$client = TaxJar\Client::withApiKey($taxkey['Key']);


$sql = "SELECT * FROM Laundromat WHERE email = '".$_SESSION['username']."' ";
$result = mysqli_query($mysqli, $sql);
$row = mysqli_fetch_assoc($result);


if($row['Type'] == "Test"){

$sql2 = "SELECT * FROM `Keys` WHERE `ID` = 4 ";
$result2 = mysqli_query($mysqli, $sql2);
$keys = mysqli_fetch_assoc($result2);





if($_POST['package'] == "starter"){           //starter
    
    $subscription2 = "price_1GszSWI0sYN2aap9uDNlcbR6";
    $subscriptiontype="starter";
}else if($_POST['package'] == "standard"){     //standard
    
   $subscription2 = "price_1GszSqI0sYN2aap9riBzW1FN"; 
   $subscriptiontype="standard";
}else if($_POST['package'] == "gold"){     //gold
    
    $subscription2 = "price_1GszT6I0sYN2aap9DED6cucJ";
    $subscriptiontype="gold";
}


}else{

$sql2 = "SELECT * FROM `Keys` WHERE `ID` = 12 ";
$result2 = mysqli_query($mysqli, $sql2);
$keys = mysqli_fetch_assoc($result2);





if($_POST['package'] == "starter"){           //starter
    
    $subscription2 = "price_1GszNvI0sYN2aap9cxMWzSZc";
    $subscriptiontype="starter";
}else if($_POST['package'] == "standard"){     //standard
    
   $subscription2 = "price_1GuOmlI0sYN2aap9oNoHxUhk"; 
   $subscriptiontype="standard";
}else if($_POST['package'] == "gold"){     //gold
    
    $subscription2 = "price_1GuOlyI0sYN2aap9LoZs08kf";
    $subscriptiontype="gold";
}


}


$sql2 = "SELECT * FROM `Balance_Rate` WHERE `ID` = 10 ";
$result2 = mysqli_query($mysqli, $sql2);
$keys2 = mysqli_fetch_assoc($result2);
$rate = $keys2['Key'];







$sql = "SELECT * FROM `TaxCodes` WHERE ID = 1";
$result = mysqli_query($mysqli, $sql);
$taxjar1 = mysqli_fetch_assoc($result);

$sql = "SELECT * FROM `TaxCodes` WHERE ID = 2";
$result = mysqli_query($mysqli, $sql);
$taxjar2 = mysqli_fetch_assoc($result);





if(isset($_SESSION['errmsg1'])){
unset($_SESSION['errmsg1']);
}


//start subscription



try {
	
	\Stripe\Stripe::setApiKey($keys['Key']);
	
	if($row['Stripe_Customer_ID'] == ''){
	// Create a Customer:
	$customer = \Stripe\Customer::create([
		'source' => $_POST['stripeToken'],
		'email' =>  $row['email'],
		'customer' => $customer->id,
		'description' => "Laundromat",
		"metadata" => array(
				"name" => $row['Name'],
				"tel" => $row['Phone'],
				"street" => $row['Address'],
				"city" => $row['City'],
				"state" => $row['State'],
				"zip" => $row['Zip']
		),
]);




$customerid = $customer->id;




  
$subscription = \Stripe\Subscription::create([
  "customer" => $customer,
  'proration_behavior' => 'always_invoice',
  "items" => [
    ["plan" => $subscription2],
  ],
]);



//taxjar create subscription


$taxrates = $client->taxForOrder([
		'to_country' => 'US',
		'to_zip' => $row['Zip'],
		'to_state' => $row['State'],
		'amount' => $rate['Rate'],
		'shipping' => 0,
		'line_items' => [
				[
						'quantity' => 1,
						'unit_price' => $rate['Rate'],
						'product_tax_code' => $taxjar2['Code']
				]
		]
]);



$taxtotal2 = $taxrates->amount_to_collect;


$final2 = $taxtotal2+ $rate['Rate'];


$datef = date("Y-m-d");
if($row['Type'] != "Test"){

$order = $client->createOrder([
		'transaction_id' => 'LaundromatSub'.$row['ID'],
		'transaction_date' => $datef,
		'to_country' => 'US',
		'to_zip' => $row['Zip'],
		'to_state' => $row['State'],
		'to_city' => $row['City'],
		'to_street' => $row['Address'],
		'amount' => $final2,
		'shipping' => 0,
		'sales_tax' => $taxtotal2
		
		
]);


$order = $client->updateOrder([
		'transaction_id' => 'LaundromatSub'.$row['ID'],
		'amount' => $rate['Rate'],
		'shipping' => 0.0,
		'line_items' => [
				[
						'quantity' => 1,
						'product_identifier' => $uniqueidorder,
						'description' => "Laundromat Subscriptions",
						'unit_price' => $rate['Rate'],
						'discount' => 0.0,
						'sales_tax' => $taxtotal2
				]
		]
]);


}

$mysqli->query("UPDATE Laundromat SET SubscriptionID = '".$subscription['id']."', Subscription = '".$subscription2."', Stripe_Customer_ID = '".$customerid."',  CardName = '".$_POST['cardname']."', SubscriptionType = '".$subscriptiontype."' WHERE email = '".$_SESSION['username']."' ");


//header("Location: confirm.php");
//header("Location: sendSupplyReceipt.php?OrderID=".$uniqueidorder);

}else{


	$customer = \Stripe\Customer::update($row['Stripe_Customer_ID'], [
		'source' => $_POST['stripeToken'],
]);


$subscription = \Stripe\Subscription::create([
	"customer" => $customer,
	"trial_period_days" => 0,
	"items" => [
	  ["plan" => $subscription2],
	],
  ]);


$mysqli->query("UPDATE Laundromat SET CardName = '".$_POST['cardname']."',Subscription = '".$subscription2."', Stripe_Customer_ID = '".$customerid."',  CardName = '".$_POST['cardname']."', SubscriptionType = '".$subscriptiontype."', SubscriptionID = '".$subscription['id']."' WHERE email = '".$_SESSION['username']."' ");
}


header("Location: ../confirm.php");
}catch (Exception $e) {
	$error = $e->getMessage();
	

	$_SESSION['errmsg1'] = "Your purchase of was declined. Please use a different payment method.";
	//echo($error);
	//die($error);

		header("Location: ../confirm.php");
	
}




?>