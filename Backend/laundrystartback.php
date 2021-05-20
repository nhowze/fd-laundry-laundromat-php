<?php

include_once("../LoginSystem/cooks.php");
//session_start();
include_once '../includes/db_connect.php';
include_once '../includes/functions.php';


$sqlct = "SELECT * FROM Contact WHERE ID = 5 ";
$contactinf = mysqli_query($mysqli, $sqlct);
$contactinf = mysqli_fetch_assoc($contactinf);


$sql = "SELECT * FROM `Keys` WHERE ID = 9 ";
$taxkey= mysqli_query($mysqli, $sql);
$taxkey= mysqli_fetch_assoc($taxkey);

require  __DIR__ . '/../includes/tax/vendor/autoload.php';
$client = TaxJar\Client::withApiKey($taxkey['Key']);


$sqlnum = "SELECT * FROM OrderGroup WHERE ID = '".$_POST['oid']."' ";
$resultnum = mysqli_query($mysqli, $sqlnum);
$ordersummary = mysqli_fetch_assoc($resultnum);


$sql = "SELECT * FROM users WHERE username = '".$ordersummary['Username']."' ";
$result = mysqli_query($mysqli, $sql);
$row = mysqli_fetch_assoc($result);


$sqll = "SELECT * FROM Laundromat WHERE ID = ".$ordersummary['Laundromat_ID']." ";
$laundromat= mysqli_query($mysqli, $sqll);
$laundromat = mysqli_fetch_assoc($laundromat);



$sql = "SELECT * FROM `TaxCodes` WHERE ID = 4";
$result = mysqli_query($mysqli, $sql);
$taxjar1 = mysqli_fetch_assoc($result);



$_SESSION['confirmtr'] = $ordersummary['ID'];


if($ordersummary['Status'] != "In Progress"){



if($_POST['inventorylist'] != "True"){

$_POST['inventorylist'] = "False";

}
    
    
    	foreach($_POST as $key => $value)
			{
				
				
				
				if($key != "oid"){
					
					$key = str_replace('_', ' ', $key);
    
   $sqlord = "UPDATE Orders SET QTY = '".$value."'  WHERE Ordernum = '".$ordersummary['OrderNum']."' AND Product_Name = '".$key."' ";
   
 //  echo($sqlord);
$mysqli->query($sqlord); 





}

}
    

$sql = "SELECT * FROM Orders WHERE Ordernum =  '".$ordersummary['OrderNum']."'";
$resultt = mysqli_query($mysqli, $sql);

$itemtotal = 0;

while($rowt = $resultt->fetch_assoc()) {

	
	$sql2 = "SELECT * FROM Products WHERE ID =  ".$rowt['ProductID']." AND Laundromat = ".$rowt['Laundromat_num']." ";
	$resulto2 = mysqli_query($mysqli, $sql2);
	$rowo2 = mysqli_fetch_assoc($resulto2);
	
	
	
	//startpost
	$sql = "SELECT * FROM OptionsPost WHERE Ordernum =  '".$rowt['Ordernum']."' AND ProductID = ".$rowo2['ID']." ";
	$resulto = mysqli_query($mysqli, $sql);

	if(mysqli_num_rows($resulto) > 0){
		$rowtotal =0;
		$rowtotalop =0;
		while($rowt2= $resulto->fetch_assoc()) {
			
			$sql2 = "SELECT * FROM Options WHERE ProductID =  ".$rowt2['ProductID']." AND LaundromatID = ".$rowt['Laundromat_num']." AND ID = ".$rowt2['OptionID']." ";
			$resulto2t = mysqli_query($mysqli, $sql2);
			$resulto2t= mysqli_fetch_assoc($resulto2t);
			
			
			//echo''.$resulto2t['Price'] .' + '.+  $rowt['Price']. " * ".$rowt['QTY']."<br><Br>";
			
			$rowtotalop = $resulto2t['Price'] + $rowtotalop;
			
			
			
		}
		$rowtotal= ($rowt['Price'] * $rowt['QTY'])  + $rowtotalop;
	//	echo($rowtotal);
	}else{
	//$rowo = mysqli_fetch_assoc($resulto);
	
		$rowtotal = $rowt['QTY'] * $rowt['Price'];
		
	
	}
	
	
	//end post

	
	$itemtotal = $itemtotal + $rowtotal;
	
	
	
	
	
}


$finaltotal = $itemtotal;



//calculate if minimum order is met

if($itemtotal < 15){
	
	$mindifference = 15 - $itemtotal;
	
	$sqldiff= "UPDATE OrderGroup SET ServiceFee = '".$mindifference."'  WHERE OrderNum = '".$ordersummary['OrderNum']."'  ";
	
	$mysqli->query($sqldiff); 
	
	$finaltotal = $finaltotal + $mindifference;
	
}




/**
$taxrates = $client->ratesForLocation($row['Zip'], [
		'city' => $row['City'],
		'state' => $row['State'],
		'country' => 'US'
]);
**/


$t2 = $finaltotal + $ordersummary['DeliveryTotal'];
$taxrates = $client->taxForOrder([
		'from_country' => 'US',
		'from_zip' => $row['Zip'],
		'from_state' => $row['State'],
		'to_country' => 'US',
		'to_zip' => $laundromat['Zip'],
		'to_state' => $laundromat['State'],
		'amount' => $t2,
		'shipping' => $ordersummary['DeliveryTotal'],
		'line_items' => [
				[
						'quantity' => 1,
						'unit_price' => $finaltotal,
						'product_tax_code' => $taxjar1['Code']
				]
		]
]);



$taxtotal = $taxrates->amount_to_collect;









$sqlh = "SELECT * FROM PromoHistory WHERE UserID = '".$ordersummary['UserID']."' AND ExpireDate >= DATE(NOW()) ORDER BY ExpireDate";
$resulth= mysqli_query($mysqli, $sqlh);



if ($resulth->num_rows > 0) {	//avaiable promo code
	
	echo'<br><br><div >';
	
		$rowh= mysqli_fetch_assoc($resulth);
		
		
		
		$sqlc = "SELECT * FROM PromoCodes WHERE ID = '".$rowh['PromoID']."' ";
		$resultc = mysqli_query($mysqli, $sqlc);
		$rowc = mysqli_fetch_assoc($resultc);
		
		$expire = date("n-d-Y", strtotime($rowc['Expire_Date']));
	
	
		
		if($itemtotal >= $rowc['Min'] || ($mindifference + $itemtotal) >= $rowc['Min']){	//use promo code
		
			if($rowc['Type'] == "Percentage"){
				$discount= $itemtotal* $rowc['AmountOff'];
			
			}else if($rowc['Type'] == "Money"){
				
				$discount = $rowc['AmountOff'];
				
			}else if($rowc['Type'] == "Delivery"){
				
				
				
				$discount = 0;
				
				$ordersummary['DeliveryTotal'] = $ordersummary['DeliveryTotal'] - $ordersummary['DeliveryTotal'];
				
				
				
				}
				
			
				$finaltotal = $itemtotal + $taxtotal + $ordersummary['DeliveryTotal'] - $discount;
			
			
			
				$sqlord = "UPDATE OrderGroup SET Inventory_List = '".$_POST['inventorylist']."', DeliveryTotal = '".$ordersummary['DeliveryTotal']."', DiscountAmount ='".$discount."', PromoID = '".$rowc['ID']."', SalesTax = '".$taxtotal."', Status = 'In Progress', ItemTotal = '".$itemtotal."', TotalPrice = '".$finaltotal."'  WHERE ID = '".$_POST['oid']."' ";
		$mysqli->query($sqlord);
		$_SESSION['confirmmessage'] = $ordersummary['ItemTotal']." ".$rowc['Min'];
		
		$promodisc = $rowc['AmountOff'];
		$promodisctype = $rowc['Type'];
		
		
		$_SESSION['testsql'] = $sqlord;
		
		
		
		
		
		}else{		//doesn't meet minimum amount
			
			
			$finaltotal = $itemtotal + $taxtotal + $ordersummary['DeliveryTotal'];
			
			
			$sqlord = "UPDATE OrderGroup SET Inventory_List = '".$_POST['inventorylist']."', SalesTax = '".$taxtotal."', Status = 'In Progress', ItemTotal = '".$itemtotal."', TotalPrice = '".$finaltotal."'  WHERE ID = '".$_POST['oid']."' ";
			$mysqli->query($sqlord);
			$_SESSION['confirmmessage'] = "";
			
		}
		
		
		
		
		
	
	
}else{	//no available codes
		
	
	$finaltotal = $itemtotal + $taxtotal + $ordersummary['DeliveryTotal'];
		
$sqlord = "UPDATE OrderGroup SET Inventory_List = '".$_POST['inventorylist']."', SalesTax = '".$taxtotal."', Status = 'In Progress', ItemTotal = '".$itemtotal."', TotalPrice = '".$finaltotal."'  WHERE ID = '".$_POST['oid']."' ";
$mysqli->query($sqlord);
$_SESSION['confirmmessage'] = "";


}




//taxjar create order
try {


$datef = date("Y-m-d", strtotime($ordersummary['Date']));
$itotal = $itemtotal + $ordersummary['DeliveryTotal'] + $ordersummary['ServiceFee'];


if(isset($promodisc)){
	
	
	if($promodisctype == "Delivery"){
		
		$itotal = $itotal - $ordersummary['DeliveryTotal'];
	if($row['Type'] != "Test"){
$order = $client->createOrder([
		'transaction_id' => $ordersummary['ID'],
		'transaction_date' => $datef,
	//	'customer_id' => $row['id'],
		'from_country' => 'US',
		'from_zip' => $row['Zip'],
		'from_state' => $row['State'],
		'from_city' => $row['City'],
		'from_street' => $row['Address']." ".$row['Unit'],
		'to_country' => 'US',
		'to_zip' => $laundromat['Zip'],
		'to_state' => $laundromat['State'],
		'to_city' => $laundromat['City'],
		'to_street' => $laundromat['Address'],
		'amount' => $itotal,
		'shipping' => 0.0,
		'sales_tax' => $taxtotal,
		
		
]);






$order = $client->updateOrder([
		'transaction_id' => $ordersummary['ID'],
		'amount' => $itotal,
		'shipping' => 0.0,
		'line_items' => [
				[
						'quantity' => 1,
						'product_identifier' => $ordersummary['ID'],
						'description' => $contactinf['Name']." Order",
						'unit_price' => $itemtotal,
						'discount' => 0.0,
						'sales_tax' => $taxtotal
				]
		]
]);

}

	}else if($promodisctype == "Percentage"){
		
		$tots = $promodisc* ($itotal - $ordersummary['DeliveryTotal']);
		$itotal = $itotal - $tots;
		if($row['Type'] != "Test"){
		$order = $client->createOrder([
				'transaction_id' => $ordersummary['ID'],
				'transaction_date' => $datef,
			//	'customer_id' => $row['id'],
				'from_country' => 'US',
				'from_zip' => $row['Zip'],
				'from_state' => $row['State'],
				'from_city' => $row['City'],
				'from_street' => $row['Address']." ".$row['Unit'],
				'to_country' => 'US',
				'to_zip' => $laundromat['Zip'],
				'to_state' => $laundromat['State'],
				'to_city' => $laundromat['City'],
				'to_street' => $laundromat['Address'],
				'amount' => $itotal,
				'shipping' => $ordersummary['DeliveryTotal'],
				'sales_tax' => $taxtotal,
				
				
		]);
		
		
		
		
		
		
		$order = $client->updateOrder([
				'transaction_id' => $ordersummary['ID'],
				'amount' => $itotal,
				'shipping' => $ordersummary['DeliveryTotal'],
				'line_items' => [
						[
								'quantity' => 1,
								'product_identifier' => $ordersummary['ID'],
								'description' => $contactinf['Name']." Order",
								'unit_price' => $itemtotal,
								'discount' => $tots,
								'sales_tax' => $taxtotal
						]
				]
		]);
		
		}
		
	}else if($promodisctype == "Money"){
		
		
		
		$itotal = $itotal - $promodisc;
	
		if($row['Type'] != "Test"){
		$order = $client->createOrder([
				'transaction_id' => $ordersummary['ID'],
				'transaction_date' => $datef,
			//	'customer_id' => $row['id'],
				'from_country' => 'US',
				'from_zip' => $row['Zip'],
				'from_state' => $row['State'],
				'from_city' => $row['City'],
				'from_street' => $row['Address']." ".$row['Unit'],
				'to_country' => 'US',
				'to_zip' => $laundromat['Zip'],
				'to_state' => $laundromat['State'],
				'to_city' => $laundromat['City'],
				'to_street' => $laundromat['Address'],
				'amount' => $itotal,
				'shipping' => $ordersummary['DeliveryTotal'],
				'sales_tax' => $taxtotal,
				
				
		]);
		
		
		
		
		
		
		$order = $client->updateOrder([
				'transaction_id' => $ordersummary['ID'],
				'amount' => $itotal,
				'shipping' => $ordersummary['DeliveryTotal'],
				'line_items' => [
						[
								'quantity' => 1,
								'product_identifier' => $ordersummary['ID'],
								'description' => $contactinf['Name']." Order",
								'unit_price' => $itemtotal,
								'discount' => $promodisc,
								'sales_tax' => $taxtotal
						]
				]
		]);
		
		}
		
	}




}else{
	
	if($row['Type'] != "Test"){
	
	$order = $client->createOrder([
			'transaction_id' => $ordersummary['ID'],
			'transaction_date' => $datef,
		//	'customer_id' => $row['id'],
			'from_country' => 'US',
			'from_zip' => $row['Zip'],
			'from_state' => $row['State'],
			'from_city' => $row['City'],
			'from_street' => $row['Address']." ".$row['Unit'],
			'to_country' => 'US',
			'to_zip' => $laundromat['Zip'],
			'to_state' => $laundromat['State'],
			'to_city' => $laundromat['City'],
			'to_street' => $laundromat['Address'],
			'amount' => $itotal,
			'shipping' => $ordersummary['DeliveryTotal'],
			'sales_tax' => $taxtotal,
			
			
	]);
	
	
	
	
	
	
	$order = $client->updateOrder([
			'transaction_id' => $ordersummary['ID'],
			'amount' => $itotal,
			'shipping' => $ordersummary['DeliveryTotal'],
			'line_items' => [
					[
							'quantity' => 1,
							'product_identifier' => $ordersummary['ID'],
							'description' =>  $contactinf['Name']." Order",
							'unit_price' => $itemtotal,
							'discount' => 0.0,
							'sales_tax' => $taxtotal
					]
			]
	]);
	
	
	}
	
	
}


} catch (TaxJar\Exception $e) {
	// 406 Not Acceptable � transaction_id is missing
	echo $e->getMessage();
	
	// 406
	echo $e->getStatusCode();
}
//end taxjar



//OneSignal Start






$playerid = array();
if($row['OneSignal'] != ""){

array_push($playerid,$row['OneSignal']);

}


$fields = array(
		'app_id' => '4ab03baa-ba83-4456-9aec-20722a178737',
		'include_player_ids' => $playerid,
		'contents' => array("en" =>"Laundry in progress"),
		'headings' => array("en"=>"Your laundry order has started!"),
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






}


?>