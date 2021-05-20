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






$sql = "SELECT * FROM `TaxCodes` WHERE ID = 2";
$result = mysqli_query($mysqli, $sql);
$taxjar2 = mysqli_fetch_assoc($result);



$oldsubscription = $row['SubscriptionID'];

if($row['SubscriptionType'] != $_POST['package']){




//start subscription



try {
	
	\Stripe\Stripe::setApiKey($keys['Key']);
	


$subscription = \Stripe\Subscription::retrieve($row['SubscriptionID']);
\Stripe\Subscription::update($row['SubscriptionID'], [
  'cancel_at_period_end' => false,
  'proration_behavior' => 'always_invoice',
  'items' => [
    [
      'id' => $subscription->items->data[0]->id,
      'price' => $subscription2,
    ],
  ],
]);





if($row['Type'] != "Test"){
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



}



$mysqli->query("UPDATE Laundromat SET  Subscription = '".$subscription2."',   SubscriptionType = '".$subscriptiontype."' WHERE email = '".$_SESSION['username']."' ");


//header("Location: confirm.php");
//header("Location: sendSupplyReceipt.php?OrderID=".$uniqueidorder);




header("Location: ../account.php#updatepayment");

$_SESSION['submsg'] = "Subscription Updated!";


}catch (Exception $e) {
	$error = $e->getMessage();
	echo($error);

	$_SESSION['submsg'] = "Your purchase of was declined. Please use a different payment method.";
	//echo($error);
	//die($error);

	//	header("Location: ../account.php#updatepayment");
	
}


}else{
    
    $_SESSION['submsg'] = "Subscription Updated!";
    	header("Location: ../account.php#updatepayment");
    
}

?>