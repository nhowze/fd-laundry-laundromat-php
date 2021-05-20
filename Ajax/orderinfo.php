<?php

include_once("../LoginSystem/cooks.php");
session_start();
include_once('../LoginSystem/db.php');
include_once '../includes/db_connect.php';
include_once '../includes/functions.php';

?>

<html>

<head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	</head><body>
	
	<?php
	
	
	$sql = "SELECT * FROM Laundromat WHERE email = '".$_SESSION['username']."' ";
	$result = mysqli_query($mysqli, $sql);
	$row = mysqli_fetch_assoc($result);
	
	
	
	
	$sqlnum = "SELECT * FROM OrderGroup WHERE OrderNum = '".$_SESSION['orderID']."' ";
	$resultnum = mysqli_query($mysqli, $sqlnum);
	$ordersummary = mysqli_fetch_assoc($resultnum);
	
	
	
	
	
	if($ordersummary['Delivery'] =="False" && $ordersummary['Status'] == "Order Complete"){
	
	echo'
<script>

	 var divExist = document.getElementById("laundrytouser");

if(divExist){

	divExist.style.display = "none";
	
}
	 
	 
	</script>';
	
	
	}
	
	
	
	
	$odate = date('m/d/Y',strtotime($ordersummary['Date']));
	
	$firsttime = date('h:i A',strtotime($ordersummary['Pickup_Time']));
	
	
	$secondtime =  date('h:i A',strtotime($ordersummary['Delivery_Time']));
	
	
	$sql = "SELECT * FROM users WHERE id = '".$ordersummary['UserID']."' ";
	$confirm= mysqli_query($mysqli, $sql);
	$confirm= mysqli_fetch_assoc($confirm);
	
	
	$Phone = substr_replace($confirm['Phone'], "(", 0, 0);
	$Phone = substr_replace($Phone, ")", 4, 0);
	$Phone = substr_replace($Phone, "-", 8, 0);
	$Phone = substr_replace($Phone, " ", 5, 0);
	
	preg_match("/iPhone|Android|iPad|iPod|webOS/", $_SERVER['HTTP_USER_AGENT'], $matches);
	$os = current($matches);
//	print_r($os);
	echo'


		<table style="wdith:100%;">
						<th  >Order Details</th>
<th colspan="2">';

	if($os == "Android"){
		echo'<a class="button" style="display:inline; font-size:80%;" id="print" href="https://'.$_SERVER['SERVER_NAME'].'/Laundromats/receipts.php?orderID='.$ordersummary['OrderNum'].'"><i class="fa fa-print" style=""></i> Receipt</a>';
	}else if($os == "iPhone" || $os == "iPad"){
		echo'<a class="button" style="display:inline; font-size:80%;" id="print" href="https://'.$_SERVER['SERVER_NAME'].'/Laundromats/receipts.php?orderID='.$ordersummary['OrderNum'].'"><i class="fa fa-print" style=""></i> Receipt</a>';
	}

echo'</th>

<tr>
						<td>Order Number:</td>
						<td>'.$ordersummary['OrderNum'].'</td>
						</tr>

<tr>
						<td>Customer Name:</td>
						<td>'.$confirm['First_Name'].' '.$confirm['Last_Name'].'</td>
						</tr>


<tr>
						<td>Phone:</td>
						<td><a href="tel:'.$confirm['Phone'].'">'.$Phone.'</a></td>
						</tr>





						<tr>
						<td>Status:</td>
						<td>'.$ordersummary['Status'].'</td>
						</tr>
						
<tr>
						<td>Confirmation Code:</td>
						<td>'.$ordersummary['Laundro_Code'].'</td>
						</tr>



							<tr>
						<td>Date:</td>
						<td>'.$odate.'</td>
						</tr>';
						
	if(date('h:i:s',strtotime($ordersummary['Pickup_Time'])) != "00:00:00"){
							echo'<tr>
						<td>Initial Order Time:</td>
						<td>'.$firsttime.'</td>
						</tr>';
	}
	
	$itime = date('h:i:s',strtotime($ordersummary['Initial_Pickup_Start']));
	if($itime != "00:00:00"){
		
		$itime = date('h:i A',strtotime($ordersummary['Initial_Pickup_Start']));
							echo'<tr>
						<td>Initial Pickup Time:</td>
						<td style="vertical-align:middle;">'.$itime.'</td>
						</tr>';
	}	
							
							
				echo'		</table>
						
						';
						
						
						
						
						$sql2 = "SELECT * FROM Orders WHERE OrderNum = '".$ordersummary['OrderNum']."' ";
$result2 = mysqli_query($mysqli, $sql2);

						
							
						echo'<table>
						
						<th>QTY</th>
						<th>Product Name</th>
						<th>Price</th>
						';
						
						
						while($row2 = $result2->fetch_assoc()) {
						
						echo'<tr style="border-top:solid;">
						
						<td style="width:25%;">';
						
						if($row2['Type'] == "Item"){
						$qty =  number_format($row2['QTY'],0);
						
						if($row2['QTY'] == 1){
							
							echo''.$qty.' item';
							
						}else{
							
							echo''.$qty.' items';
						}
						
						}else{
						
							if($row2['QTY'] == 1){
							echo'	'.$row2['QTY'].' lb';
							}else{
								
								echo'	'.$row2['QTY'].' lbs';
							}
						
						}
						echo'</td>
						<td>'.$row2['Product_Name'].'</td>';



						if($row2['Type'] == "Item"){
							
							echo' <td style="text-align:left; width:30%;">$'.$row2['Price'].' /Item</td>';
						}else{
							
							echo' <td style="text-align:left; width:30%;">$'.$row2['Price'].' /lbs</td>';
							
						}
						
						echo'</tr>';
						
						
						
						//options begin
						
						$sql = "SELECT * FROM Products WHERE ID = ".$row2['ProductID']." AND Laundromat = ".$row['ID']." ";
						$result = mysqli_query($mysqli, $sql);
						$result= mysqli_fetch_assoc($result);
						$result= $result['ID'];
						
						
						
						
						$sql2 = "SELECT * FROM Options WHERE ID IN (SELECT OptionID FROM OptionsPost WHERE ProductID = ".$result." AND Ordernum = '".$row2['Ordernum']."') ";
						
						$addonsr= mysqli_query($mysqli, $sql2);
						
						if(mysqli_num_rows($addonsr) > 0){
						
							echo'<tr ><td colspan="3">';
							
							
							
							
							echo'<h3>Add-ons </h3><table style=" max-width:600px; margin:0; padding:0;">';
						
						
						while($rowaddon = $addonsr->fetch_assoc()) {
						
							echo'<table style="margin:0; padding:0;">
				
<tr style="margin:0; padding:0;">
<td>- '.$rowaddon['Name'].' | 
$'.$rowaddon['Price'].'</td>
</tr>';
						
						}
							
						echo'</table>
</td></tr>';
						}
							
							//options end
						
						
						}
						
						
						if(!is_null($ordersummary['PromoID'])){
							
							
							$sqlcov2 = "SELECT * FROM PromoCodes WHERE ID = ".$ordersummary['PromoID']." ";
							$resultcov2 = mysqli_query($mysqli, $sqlcov2);
							$resultcov2= mysqli_fetch_assoc($resultcov2);
							
							echo'<tr><td colspan="3" style="text-align:center;">Promo Code:
		
'.$resultcov2['Description'].'
														</td></tr>';
						}
						
						echo'<tr style="border-top:solid;">
									
						<td></td>
						<td>Items</td>
						<td>$'.$ordersummary['ItemTotal'].'</td>
									
						</tr>';
						
						
						if($ordersummary['ServiceFee'] != 0.00){
							
							echo'<tr>
						<td></td>
						<td>Minimum Order Fee</td>
						<td>$'.$ordersummary['ServiceFee'].'</td>
						</tr>';
							
						}
						
						
						
						if(!is_null($ordersummary['PromoID']) && $resultcov2['Type'] != "Delivery"){
							
							
							
							
							$discount = $resultcov['AmountOff'] * $ordersummary['TotalPrice'];
							$discount = number_format ($discount, 2);
							echo'<tr>
						<td></td>
						<td>Discount</td>
						<td>-$'.$ordersummary['DiscountAmount'].'</td>
						</tr>';
							
							
							
							
							
						}
						
						
						
						
						
						echo'<tr>
									
						<td></td>
						<td>Delivery Fee</td>
						<td>$'.$ordersummary['DeliveryTotal'].'</td>
									
						</tr>';
						
						
						
						
						if($ordersummary['Laundry_Complete'] == 0){
							
							echo'<tr>
						<td></td>
						<td>Est. Tax</td>
						<td>$'.$ordersummary['SalesTax'].'</td>
						</tr>';
							
						}else{
							
							echo'<tr>
						<td></td>
						<td>Tax</td>
						<td>$'.$ordersummary['SalesTax'].'</td>
						</tr>';
							
							
						}
						
						
									if($ordersummary['Laundry_Complete'] == 1){
							echo'<tr>
								
						<td></td>
						<td>Service Fee:</td>
						<td>-$'.$ordersummary['LaundromatFee'].'</td>
										
						</tr>';
						}
						
						
						echo'<tr>
								
						<td></td>
						<td>Order Total</td>
						<td>$'.($ordersummary['TotalPrice']-$ordersummary['LaundromatFee']).'</td>
								
						</tr>';
						
						
						
						
						
						
			
						
						
						echo'</table>';
	
	
	
	
	
	
						
						?>

						</body>
						
						</html>