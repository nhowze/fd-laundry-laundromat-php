<?php

include_once("LoginSystem/cooks.php");
//session_start();
include_once('LoginSystem/db.php');
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';
require_once('includes/stripe-php-master/init.php');
//require('pdf/html_table.php');
require_once 'Libraries/vendor/autoload.php';

//echo($_SESSION['orderID']);
$sqlnum = "SELECT * FROM OrderGroup WHERE OrderNum = '".$_GET['orderID']."' ";
$resultnum = mysqli_query($mysqli, $sqlnum);
$ordersummary = mysqli_fetch_assoc($resultnum);

$sql = "SELECT * FROM Laundromat WHERE ID = '".$ordersummary['Laundromat_ID']."' ";
$result = mysqli_query($mysqli, $sql);
$row = mysqli_fetch_assoc($result);


$sql = "SELECT * FROM users WHERE id = '".$ordersummary['UserID']."' ";
$confirm= mysqli_query($mysqli, $sql);
$confirm= mysqli_fetch_assoc($confirm);


$sqlct = "SELECT * FROM Contact WHERE ID = 5 ";
$contactinf = mysqli_query($mysqli, $sqlct);
$contactinf = mysqli_fetch_assoc($contactinf);

$ordate = date('m/d/Y',strtotime($ordersummary['Date']));

$sql2 = "SELECT * FROM Orders WHERE OrderNum = '".$ordersummary['OrderNum']."' ";
$result2 = mysqli_query($mysqli, $sql2);


$receipt = '<style>

table, tr, td, th{

font-size:90%;

}

</style>
<div id="receipt" style="text-align:center; padding:5% !important; margin:0 !important; display: block; font-size:auto;  ">

<img width="50" height "50" src="images/delivrmat.png" style="display:block; margin-left:7%; ">
<h2>'.$contactinf['Name'].' Receipt</h2>
<table style="width:100%; text-align:center">
<tr><td colspan="3">Laundromat: '.$ordersummary['Name'].'</td></tr>
<tr><td colspan="3">Customer Name: '.$confirm['First_Name'].' '.$confirm['Last_Name'].'</td></tr>
<tr><td colspan="3">Order # '.$ordersummary['OrderNum'].'</td></tr>
<tr><td colspan="3">Date: '.$ordate.'</td></tr></table>
<br>';


	if($ordersummary['Status'] == "Received" ||  $ordersummary['Status'] == "In Progress" || $ordersummary['Laundry_Complete'] == 1){


		$receipt = $receipt.'<table style="width:100%; text-align:center;">
						<tr><th style="text-align:left;">QTY</th>
						<th style="text-align:left;">Product Name</th>
						<th style="text-align:left;">Price</th></tr>
						';
						
						
						while($row2 = $result2->fetch_assoc()) {
						
							$receipt = $receipt.' <tr style="border-top:solid;" class="initialitem">
						
						<td style="text-align:left;">';
						
						if($row2['Type'] == "Item"){
						$qty =  number_format($row2['QTY'],0);
						
						
						if($row2['QTY'] == 1){
						
						$receipt = $receipt.''.$qty.' item';
						
						}else{
							
							$receipt = $receipt.''.$qty.' items';
							
						}
						
						}else{
							if($row2['QTY'] == 1){
								
							$receipt = $receipt.''.$row2['QTY'].' lb';
							
							}else{
								
								$receipt = $receipt.''.$row2['QTY'].' lbs';
							}
						
						}
						$receipt = $receipt.'</td>
						<td style="text-align:left; ">'.$row2['Product_Name'].'</td>';

						if($row2['Type'] == "Item"){
							
							$receipt = $receipt.' <td style="text-align:left; ">$'.$row2['Price'].' /Item</td>';
						}else{

							$receipt = $receipt.' <td style="text-align:left; ">$'.$row2['Price'].' /lbs</td>';
						
						}
						
						$receipt = $receipt.' </tr>';
						
						
						
						//options begin
						
						$sql = "SELECT * FROM Products WHERE ID = ".$row2['ProductID']." AND Laundromat = ".$row['ID']." ";
						$result = mysqli_query($mysqli, $sql);
						$result= mysqli_fetch_assoc($result);
						$result= $result['ID'];
						
						
						
						
						$sql2 = "SELECT * FROM Options WHERE ID IN (SELECT OptionID FROM OptionsPost WHERE ProductID = ".$result." AND Ordernum = '".$row2['Ordernum']."') ";
						
						$addonsr= mysqli_query($mysqli, $sql2);
						
						if(mysqli_num_rows($addonsr) > 0){
						
							$receipt = $receipt.' <tr ><td colspan="3">';
							
							
							
							
							$receipt = $receipt.' <h3 style="padding:0; margin:0;">Add-ons </h3>';
						
						
						while($rowaddon = $addonsr->fetch_assoc()) {
						
							$receipt = $receipt.'<table>
				
<tr style="padding:0;">
<td>- '.$rowaddon['Name'].' | $'.$rowaddon['Price'].'</td>
</tr>';
						
						}
							
						$receipt = $receipt.' </table>
</td></tr>';
						}
							
							//options end
						
						
						}
						
						
						
						$receipt = $receipt.'<tr><td colspan="3" style="border-bottom:solid;"></td></tr>';
						
						
						if(!is_null($ordersummary['PromoID'])){
							
							
							$sqlcov2 = "SELECT * FROM PromoCodes WHERE ID = ".$ordersummary['PromoID']." ";
							$resultcov2 = mysqli_query($mysqli, $sqlcov2);
							$resultcov2= mysqli_fetch_assoc($resultcov2);
							
						
							
							$receipt = $receipt.' <tr>
						<td style="text-align:left;"><Br></td>
						<td style="text-align:left; ">Promo Code</td>
						<td style="text-align:left;">'.$resultcov2['Description'].'</td>
						</tr>';
							
							
							
						}
						
						
						
						$receipt = $receipt.' <tr>
						<td style="text-align:left;"><Br></td>
						<td style="text-align:left; ">Item Total</td>
						<td style="text-align:left;">$'.$ordersummary['ItemTotal'].'</td>
						</tr>';
						
						
						
						if($ordersummary['ServiceFee'] != 0.00){
							
							$receipt = $receipt.' <tr>
						<td style="text-align:left;"></td>
						<td style="text-align:left;">Minimum Order Fee</td>
						<td style="text-align:left;">$'.$ordersummary['ServiceFee'].'</td>
						</tr>';
							
						}
						
						
						
						if(!is_null($ordersummary['PromoID'])){
							
							
							$sqlcov = "SELECT * FROM PromoCodes WHERE ID = ".$ordersummary['PromoID']." ";
							$resultcov = mysqli_query($mysqli, $sqlcov);
							$resultcov= mysqli_fetch_assoc($resultcov);
							
							
							if($resultcov['Type'] == "Percentage"){
								
								$discount = $resultcov['AmountOff'] * $ordersummary['TotalPrice'];
								$discount = number_format ($discount, 2);
								$receipt = $receipt.' <tr>
						<td style="text-align:left;"></td>
						<td style="text-align:left;">Discount</td>
						<td style="text-align:left;">-$'.$discount.'</td>
						</tr>';
								
								
								
								
							}else if($resultcov['Type'] == "Money"){
								
								
								$discount = $resultcov['AmountOff'];
								$discount = number_format ($discount, 2);
								$receipt = $receipt.' <tr>
						<td style="text-align:left;"></td>
						<td style="text-align:left;">Discount</td>
						<td style="text-align:left;">-$'.$discount.'</td>
						</tr>';
								
								
								
							}else if($resultcov['Type'] == "Delivery"){
								
								$discount = $ordersummary['DeliveryTotal'];
								$discount = number_format ($discount, 2);
							}
							
							
							
							
						}
						
						
						
						if(!is_null($ordersummary['PromoID']) && $resultcov['Type'] == "Delivery"){
							
							
							
							
							
							$receipt = $receipt.' <tr>
								
						<td style="text-align:left;"></td>
						<td style="text-align:left;">Delivery Fee</td>
						<td style="text-align:left;">$0.00</td>
								
						</tr>';
							
							
							
						}else{
							
							
							$receipt = $receipt.' <tr>
								
						<td style="text-align:left;"></td>
						<td style="text-align:left;">Delivery Fee</td>
						<td style="text-align:left;">$'.$ordersummary['DeliveryTotal'].'</td>
								
						</tr>';
							
							
							
						}
						
						
						if($ordersummary['Laundry_Complete'] == 0){
							
							$receipt = $receipt.' <tr>
						<td style="text-align:left;"></td>
						<td style="text-align:left;">Est. Tax</td>
						<td style="text-align:left;">$'.$ordersummary['SalesTax'].'</td>
						</tr>';
							
						}else{
							
							$receipt = $receipt.' <tr>
						<td style="text-align:left;"></td>
						<td style="text-align:left">Tax</td>
						<td style="text-align:left;">$'.$ordersummary['SalesTax'].'</td>
						</tr>';
							
							
						}
						
						
						if(is_null($ordersummary['PromoID'])){
							
							
							$receipt = $receipt.' <tr>
									
						<td style="text-align:left;"></td>
						<td style="text-align:left;">Total</td>
						<td style="text-align:left;">$'.$ordersummary['TotalPrice'].'</td>
		
						</tr>';
							
							
						}else{
							
							if($resultcov['Type'] == "Delivery"){
								
								$tots = $ordersummary['TotalPrice'] - $ordersummary['DeliveryTotal'];
								
							}else{
								
								$tots = $ordersummary['TotalPrice'] - $discount;
								
							}
							$tots= number_format ($tots, 2);
							$receipt = $receipt.'<tr>
<td style="text-align:left;"></td>
<td style="text-align:left;">Total</td>
<td style="text-align:left;">$'.$tots.'</td>


								
						</tr>';
							
						}

						
						
}
						
$receipt = $receipt.' </table>
<br>

<table style="width:100%; text-align:center"><tr id="addins"><td colspan="3"><h3>Delivery Address</h3></td></tr>
<tr><td colspan="3">'.$confirm['First_Name'].' '.$confirm['Last_Name'].'</td></tr>
<tr><td colspan="3">'.$confirm['Address'].' '.$confirm['Unit'].'</td></tr>
<tr><td colspan="3">'.$confirm['City'].', '.$confirm['State'].'</td></tr>
<tr><td colspan="3">'.$confirm['Zip'].'</td></tr>
<tr><td colspan="3">'.$confirm['Special_Instructions'].'</td></tr>
';
						
						
						
$receipt = $receipt.'</table>
<br>
<a href="https://'.$_SERVER['SERVER_NAME'].'" style="text-align:center;">www.'.$_SERVER['SERVER_NAME'].'</a>


</div>';

echo($receipt);


			
						

?>