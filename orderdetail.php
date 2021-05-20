<?php

include_once("LoginSystem/cooks.php");
//session_start();
include_once('LoginSystem/db.php');
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';
require_once('includes/stripe-php-master/init.php');


unset($_SESSION['confirmmessage']);





if ( !isset($_SESSION['login']) || $_SESSION['login'] !== true) {

if(empty($_SESSION['access_token']) || empty($_SESSION['access_token']['oauth_token']) || empty($_SESSION['access_token']['oauth_token_secret'])){

if ( !isset($_SESSION['token'])) {

if ( !isset($_SESSION['fb_access_token'])) {

 header('Location: login.php');

exit;
}
}
}
}

if(isset($_SESSION['passconfirm'])){
	
	unset($_SESSION['passconfirm']);
}


$sqlct = "SELECT * FROM Contact WHERE ID = 5 ";
$contactinf = mysqli_query($mysqli, $sqlct);
$contactinf = mysqli_fetch_assoc($contactinf);

$sql = "SELECT * FROM SocialNetworks WHERE Social_Name = 'Twitter' ";
$result = mysqli_query($mysqli, $sql);
$twitter = mysqli_fetch_assoc($result);
$twitter = $twitter['URL'];

$sql = "SELECT * FROM SocialNetworks WHERE Social_Name = 'Facebook' ";
$result = mysqli_query($mysqli, $sql);
$facebook = mysqli_fetch_assoc($result);
$facebook = $facebook['URL'];

$sql = "SELECT * FROM SocialNetworks WHERE Social_Name = 'Google' ";
$result = mysqli_query($mysqli, $sql);
$google = mysqli_fetch_assoc($result);
$google = $google['URL'];


$sql = "SELECT * FROM SocialNetworks WHERE Social_Name = 'Instagram' ";
$result = mysqli_query($mysqli, $sql);
$instagram = mysqli_fetch_assoc($result);
$instagram = $instagram['URL'];


$sql = "SELECT * FROM SocialNetworks WHERE Social_Name = 'Laundromat' ";
$result = mysqli_query($mysqli, $sql);
$plugin = mysqli_fetch_assoc($result);
	echo($plugin['HTML']);



$sql = "SELECT * FROM Laundromat WHERE email = '".$_SESSION['username']."' ";
$result = mysqli_query($mysqli, $sql);
$row = mysqli_fetch_assoc($result);


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

//discount calculation end


\Stripe\Stripe::setApiKey($keys['Key']);
$error = '';
$success = '';
try {
	
	
	$subscription = \Stripe\Subscription::retrieve($row['SubscriptionID']);
	
	
}catch (Exception $e) {
	$error = $e->getMessage();
	
	
}

if($row['SubscriptionID'] == "" || $row['Address'] == "" || $row['City'] == "" || $row['State'] == "" || $row['Zip'] == "" || $row['StripeAccount'] == "" || $row['Stripe_Customer_ID'] == ""){
	
	
	echo'<script>
			
window.location.href = "confirm.php";
</script>';
	
	
}


if($subscription['status'] != "active" && $subscription['status'] != "trialing"){
	echo'<script>
			
window.location.href = "confirm.php";
</script>';
	
	
}


if($row["Profile_Pic"] != ""){
    $profilepic = $row["Profile_Pic"];
}else{
$profilepic ="images/avatar.jpg";
}

if(isset($_GET['orderID'])){
	
	$_SESSION['orderID'] = $_GET['orderID'];
	
}else{
	
	$_GET['orderID'] = $_SESSION['orderID'];
	
}

//echo($_SESSION['orderID']);
$sqlnum = "SELECT * FROM OrderGroup WHERE OrderNum = '".$_SESSION['orderID']."' ";
$resultnum = mysqli_query($mysqli, $sqlnum);
$ordersummary = mysqli_fetch_assoc($resultnum);



$sql = "SELECT * FROM users WHERE id = '".$ordersummary['UserID']."' ";
$confirm= mysqli_query($mysqli, $sql);
$confirm= mysqli_fetch_assoc($confirm);




?>
<!DOCTYPE HTML>
<!--
	Prologue by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<head>
	     <link rel="icon" 
      type="image/jpg" 
      href="images/applogo.png">
	    
		<title><?php echo $contactinf['Name'];?> | Laundromat Order Details</title>
		
		
			
							<?php 	
		
		echo'
		<meta name="description" content="The '.$contactinf['Name'].' Laundromat Portal allows launromats to manage their laundry options(products), funds, delivery hours, and much more!">
		<meta name="application-name" content="'.$contactinf['Name'].' Laundromat Portal">
		<meta name="author" content="ICI Technologies LLC">
		<meta name="keywords" content="laundromat orders details,Laundromat app,Laundromat portal,'.$contactinf['Name'].' laundromat,about '.$contactinf['Name'].' laundromat,'.$contactinf['Name'].',laundry app,laundry delivery app,laundry delivery,deliver laundry,laundry delivery service,delivery my laundry,laundry service,laundry pickup,pickup my laundry,
		laundromat delivery service,laundromat app,laundromat pickup">';  
		
		
				$actual_link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		
		
		echo'<!-- Twitter Card data -->
		<meta name="twitter:title" content="'.$contactinf['Name'].' | Laundromat Account" >
		<meta name="twitter:card" content="summary" >
		<meta name="twitter:site" content="@publisher_handle" >
		<meta name="twitter:description" content="The '.$contactinf['Name'].' Laundromat Portal allows launromats to manage their laundry options(products), funds, delivery hours, and much more!" >
		<meta name="twitter:creator" content="@author_handle" >
		<meta name="twitter:image" content="https://'.$_SERVER['SERVER_NAME'].'/images/app-logo.png" >
		
		
		
		<!-- Open Graph data -->
		<meta property="og:title" content="'.$contactinf['Name'].' | Laundromat Account" />
		<meta property="og:url" content="'.$actual_link.'" />
		<meta property="og:image" content="https://'.$_SERVER['SERVER_NAME'].'/images/app-logo.png" />
		<meta property="og:description" content="The '.$contactinf['Name'].' Laundromat Portal allows launromats to manage their laundry options(products), funds, delivery hours, and much more!" /> 
		<meta property="og:site_name" content="'.$contactinf['Name'].' Laundromat Portal" />';
		
		
		?>
		
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="assets/css/main.css" />
		
				<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
			
		<script type='text/javascript' src="https://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/jstree.min.js"></script>
			<script src="http://code.jquery.com/jquery-latest.min.js"></script>
		
		
		
	
		
		
		<style>
    
    td,th{
        
        font-size:90%;
        
    }
    
</style>
		
				<style>
		

.quantity {
    border: solid 1px rgba(0, 0, 0, 0.15);
   
   width:100%;
   background:white;
   vertical-align:middle;
   border-radius: 0.35em;
   
   
}
.quantity input {
    border: 0;
    text-align:center;


vertical-align:middle;
}

		
	
/* The container */
.container2 {
    display: block;
    position: relative;
    padding-left: 35px;
    margin-bottom: 12px;
    cursor: pointer;
   font-weight:bold;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
}

/* Hide the browser's default checkbox */
.container2 input {
    position: absolute;
    opacity: 0;
    cursor: pointer;
}

/* Create a custom checkbox */
.checkmark {
    position: absolute;
    top: 0;
    left: 0;
    height: 25px;
    width: 25px;
    background-color: #eee;
}

/* On mouse-over, add a grey background color */
.container2:hover input ~ .checkmark {
    background-color: #ccc;
}

/* When the checkbox is checked, add a blue background */
.container2 input:checked ~ .checkmark {
    background-color: #2196F3;
}

/* Create the checkmark/indicator (hidden when not checked) */
.checkmark:after {
    content: "";
    position: absolute;
    display: none;
}

/* Show the checkmark when checked */
.container2 input:checked ~ .checkmark:after {
    display: block;
}

/* Style the checkmark/indicator */
.container2 .checkmark:after {
    left: 9px;
    top: 5px;
    width: 5px;
    height: 10px;
    border: solid white;
    border-width: 0 3px 3px 0;
    -webkit-transform: rotate(45deg);
    -ms-transform: rotate(45deg);
    transform: rotate(45deg);
}

.checkmark{

background:#C0C0C0;

}





</style>


<?php 

require_once 'includes/Mobile-Detect-master/Mobile_Detect.php';
$detect = new Mobile_Detect;

if($detect->isMobile()) {
	echo'
					<style>
					td, th{
					    font-size:75%;
					    vertical-align:middle;
					}
					</style>';
}

?>

		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<!-- Matomo -->
<script type="text/javascript">
  var _paq = _paq || [];
  /* tracker methods like "setCustomDimension" should be called before "trackPageView" */
  _paq.push(['trackPageView']);
  _paq.push(['enableLinkTracking']);
  (function() {
    var u="//www.icitechnologies.com/piwik/";
    _paq.push(['setTrackerUrl', u+'piwik.php']);
    _paq.push(['setSiteId', '6']);
    var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
    g.type='text/javascript'; g.async=true; g.defer=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
  })();
</script>
<!-- End Matomo Code -->
		
	</head>
	<body class="is-preload">

		<!-- Header -->
			<div id="header" style="height:100%;  min-height:800px; background: #44525a;">

				<div class="top">

					<!-- Logo -->
						<div id="logo">
							<img src="../images/app-logo-transparent.png" style="width:30%;" alt="" />
							<h1 id="title">Welcome <br><?php echo $row['Name'];?></h1>
							
						</div>

						<!-- Nav -->
						<nav id="nav" >
							<ul>
								<li><a href="home.php" id="top-link"style="color:white;"><span >Home</span></a></li>
							 
							 
							 
							 <li><a href="payments.php" style="color:white;"><span >Payment History</span></a></li>
								<li><a href="orders.php" id="portfolio-link"style="color:white;"><span >Pending Orders</span></a></li>
								
								
								<li><a href="products.php" id="contact-link"style="color:white;"><span >Products</span></a></li>
								<li><a href="supplies.php" id="contact-link"style="color:white;"><span >Supplies</span></a></li>
								<li><a href="account.php" id="contact-link"style="color:white;"><span >My Account</span></a></li>
						<?php
								
	$sqlc = "SELECT COUNT(*) as Total FROM Laundromat WHERE GroupID = '".$row['GroupID']."' ";
$resultco = mysqli_query($mysqli, $sqlc);
$resultco = mysqli_fetch_assoc($resultco);
							
								if($resultco['Total'] > 1){
								    
								  echo'<li><a href="maininit.php" id="contact-link"style="color:white;"><span >Change Store Locations</span></a></li>';
								    
								}
								
								?>
								<li><a href="logout.php" id="about-link"style="color:white;"><span >Logout</span></a></li>
								
							</ul>
						</nav>

				</div>

				<div class="bottom">

			

				</div>

			</div>

		<!-- Main -->
			<div id="main">

				
	<script>

					 $(function() {
						  $("form.laundrytouser").submit(function(event) {
						    event.preventDefault(); // Prevent the form from submitting via the browser
						    var form = $(this);
						    $.ajax({
						      type: "post",
						      url: "Backend/laundrytouserback.php",
						      data: form.serialize()
						    }).done(function(data) {
						      // Optionally alert the user of success here...
						   
						$("#actiondiv").load("Ajax/inprogressorder.php");

						    }).fail(function(data) {
						      // Optionally alert the user of an error here...
						    });

						  });


						});

						
					</script>
					
					<script>

					 $(function() {
						  $("form.laundrystart").submit(function(event) {
						    event.preventDefault(); // Prevent the form from submitting via the browser
						    var form = $(this);
						    $.ajax({
						      type: "post",
						      url: "Backend/laundrystartback.php",
						      data: form.serialize()
						    }).done(function(data) {
						      // Optionally alert the user of success here...
						 
						$("#actiondiv").load("Ajax/inprogressorder.php");

location.reload();

						    }).fail(function(data) {
						        
						      // Optionally alert the user of an error here...
						    });

						  });


						});

						
					</script>
					
					
						<script>

					 $(function() {
						  $("form.laundryfinished").submit(function(event) {
						    event.preventDefault(); // Prevent the form from submitting via the browser
						    var form = $(this);
						    $.ajax({
						      type: "post",
						      url: "Backend/laundryfinishback.php",
						      data: form.serialize()
						    }).done(function(data) {
						      // Optionally alert the user of success here...
						   
						$("#actiondiv").load("Ajax/inprogressorder.php");
						location.reload();
						
						    }).fail(function(data) {
						      // Optionally alert the user of an error here...

alert(data);
							      
						    });

						  });


						});

						
					</script>
					
				<!-- Portfolio -->
					<section id="portfolio" class="two"><table style="width:100%;  top:0; position:fixed; min-height:60px; z-index: 2;"><th style="color:white; font-size:100%; background: #44525a; text-align:center;">Order</th></table>
						<div class="container" style=" min-height:450px;">

		<?php 
							
		
							
							if(isset($_SESSION['ReportMessage'])){
								
								echo'<br><br><h4 style="color: green;">'.$_SESSION['ReportMessage'].'</h4>';
								
								
								unset($_SESSION['ReportMessage']);
							}
							
							
							
						
						$odate = date('m/d/Y',strtotime($ordersummary['Date']));
						
						$firsttime = date('h:i A',strtotime($ordersummary['Pickup_Time']));
						
						
						$secondtime =  date('h:i A',strtotime($ordersummary['Delivery_Time']));
						
						
						if($ordersummary['Status'] == "Approved" ||   $ordersummary['Status'] == "Driver In Transit" || $ordersummary['Status'] == "Driver In Transit With Laundry"	&& $ordersummary['Laundry_Complete'] == 0 ){
							
							
							
							echo'<script>

setInterval(function() {
  // method to be executed;

$("#reloaddiv").load("Back/backreload.php");


}, 5000);


							</script>';
							
echo'<div id="reloaddiv">




</div>';	
							
							
							
						}
						
				
							
							echo'
<div id="actiondiv" style="width:100%; margin-right:auto; margin-left:auto; margin-top:10%;">';
							
							
						


								if($ordersummary['Status'] != "Received"){
echo'<div id="ajaxupdate">
';
								}				
								
						
						if($ordersummary['Status'] == "Received"){
						    
						
						    
						    	echo'
						<form class="laundrystart" ><input type="hidden" name="oid" value="'.$ordersummary['ID'].'">
						';
						
						
						
	$sql = "SELECT * FROM Orders WHERE Ordernum = '".$ordersummary['OrderNum']."'  ";
$resulto = mysqli_query($mysqli, $sql);

						
						
						
						
						if(mysqli_num_rows($resulto) == 0){
						    
						   
						    
						}else{
						    
							
							
							
						    echo'<table id="actionTable">

<label class="container2" id="containcheck" style="display:inline;">
						
  <input type="checkbox"  name="inventorylist" id="inventorylist" value="True">
  <span class="checkmark"></span> Select if the customer included a inventory list.
</label>

';
						    	while($row2 = $resulto->fetch_assoc()) {
						    
						    		
						    		if($row2['Type'] == "Pound"){
						    		
						    		
				echo'<tr ><td>'.$row2['Product_Name'].'<div class="quantity"><input type="number" name="'.$row2['Product_Name'].'" style="width:70%;"  min="1" step="0.01" required> lbs</div></td></tr>';
						
						    		}else{
						
				echo'<tr ><td>'.$row2['Product_Name'].'<div class="quantity"><input type="number" name="'.$row2['Product_Name'].'" style="width:70%;" min="1" step="1" required> items</div></td></tr>';
						    		}
						    		
						    		
						  /**  		//options start
						    		
						    		$sql3 = "SELECT * FROM OptionsPost WHERE Ordernum = '".$ordersummary['OrderNum']."' AND ProductID = ".$row2['ProductID']." ";
						    		$resulto3= mysqli_query($mysqli, $sql3);
						    		if(mysqli_num_rows($resulto3) > 0){
						    		while($row3 = $resulto3->fetch_assoc()) {
						    			
						    			$sql4 = "SELECT * FROM Options WHERE ID = ".$row3['OptionID']." ";
						    			$confirm4= mysqli_query($mysqli, $sql4);
						    			$confirm4= mysqli_fetch_assoc($confirm4);
						    			
						    			
echo'<tr>
<td style="padding-left:20%;">'.$confirm4['Name'].'</td>
<td>$'.$confirm4['Price'].'</td>
</tr>';
						    	}		
						    		
						    		}   
						    		
						    		//end options		**/
						    		
						    		
						
						    		
						    	}
						 echo'</table>';
						}
						
						
						
						
						
					echo'<div id="ajaxupdate">
<input type="hidden" name="oid" value="'.$ordersummary['ID'].'" >

	<input type="submit" value="Start Laundry" onClick="this.style.display=\'none\'; ">
						</form>
						';
						    
						}else if($ordersummary['Status'] == "In Progress"){
						    
						    	echo'
						<form action="Backend/laundryfinishback.php" method="post"   >
						<input type="hidden" name="oid" value="'.$ordersummary['ID'].'">
						<input type="submit" value="Laundry Finished" onClick="this.style.display=\'none\'; ">
						</form>
						';
						    
						    
						}else if($ordersummary['Status'] == "Laundry Complete" && $ordersummary['Delivery'] == "False"){
							
							$sqlus = "SELECT * FROM users WHERE id = '".$ordersummary['UserID']."' ";
							$resultus = mysqli_query($mysqli, $sqlus);
							$rowus = mysqli_fetch_assoc($resultus);
							
							
							echo'<h3>Transfer Laundry To Customer</h3><br>';
							
							
							if(isset($_SESSION['confirmmessage'])){
								
								echo'<h4 style="color:red;">'.$_SESSION['confirmmessage'].'</h4>';
								unset($_SESSION['confirmmessage']);
							}
							
							
							echo'
						<form class="laundrytouser" id="laundrytouser" >
						<input type="hidden" name="oid" value="'.$ordersummary['ID'].'">
						<input type="text" name="confirm" autocomplete="off" placeholder="Confirmation Code" required><br>
						<input type="submit" value="Confirm Laundry Transfer to '.$rowus['First_Name'].'"  >
						</form>
						';
							
						}else if($ordersummary['Status'] == "Laundry Complete" && $ordersummary['Delivery'] == "True"){
							
							
							echo'<h4>Wait for driver to pick up laundry.</h4>';
							
							
						}
						
						
						
						$Phone = substr_replace($confirm['Phone'], "(", 0, 0);
						$Phone = substr_replace($Phone, ")", 4, 0);
						$Phone = substr_replace($Phone, "-", 8, 0);
						$Phone = substr_replace($Phone, " ", 5, 0);
						
						preg_match("/iPhone|Android|iPad|iPod|webOS/", $_SERVER['HTTP_USER_AGENT'], $matches);
						$os = current($matches);
						//print_r($os);
						
						echo'
						</div></div>
					<br>



<div id="detailDivAjax" >
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
						echo'</table>';
						
						
						
						
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
							
							
						
				
						
						echo'</table></div>';
						
		
						
						echo'<div style="text-align:center;">
										
<button class="button" id="reportbutton" onClick="onReport()">Report Issue</button>
										
<p id="reportheader" style="display:none;">Report Issue</p></div>
										
										
<div id="reportDiv" style="display:none; text-align:center;">
										
<form action="Backend/reportissue.php" method="post" onsubmit="valReport()">
										
										
<input type="hidden" name="OrderID" value="'.$ordersummary['ID'].'">
		
<select name="problem" id="problem" required>
<option value="">Choose Issue</option>
<option value="Damaged Items">Damaged Items</option>
<option value="Missing Items">Missing Items</option>
<option value="Other">Other</option>
<option value="Report Driver">Report Driver</option>
</select><br>
<input type="submit" style="text-align:center;" value="Report Issue">
</form>
		
		
		
</div>
		
<script>
		
function onReport(){
		
	document.getElementById("reportDiv").style.display = "block";
	document.getElementById("reportbutton").style.display = "none";
	document.getElementById("reportheader").style.display = "block";
}
		
		
</script>
		
		
		
<br><br></div>';
						
						?>





						</div>
					</section>

			

			

			</div>

		<!-- Footer -->
		<div id="footer">
	<?php


					echo'<!-- Social Icons -->
						<ul class="icons">
							<li><a href="'.$twitter.'" class="icon fa-twitter" target="_blank"><span class="label">Twitter</span></a></li>
							<li><a href="'.$facebook.'" class="icon fa-facebook" target="_blank"><span class="label">Facebook</span></a></li>
							<li><a href="'.$instagram.'" class="icon fa-instagram"><span class="label">Instagram</span></a></li>
							<li><a href="mailto:'.$contactinf['Email'].'" class="icon fa-envelope"><span class="label">Email</span></a></li>
						</ul>
						
						
				<!-- Copyright -->
					<ul class="copyright">
						<li><a href="http://icitechnologies.com" target="_blank">&copy;
ICI Technologies LLC All rights reserved.</a></li>
<li><a href="https://'.$_SERVER['SERVER_NAME'].'/legal/delivrmat-privacy-policy.php">Privacy Policy</a></li>
<li><a href="https://'.$_SERVER['SERVER_NAME'].'/legal/delivrmat-terms-conditions.php">Terms</a></li>

					</ul>';
?>
			</div>







<script type="text/javascript">

  function checkForm(form)
  {
    //
    // validate form fields
    //

    form.myButton.disabled = true;
    return true;
  }

</script>



	<script>
function updateOrders() {
  setInterval(function(){ 


	  var divExist = document.getElementById("laundrytouser");


		if(!divExist){
			
	  $("#ajaxupdate").load("Ajax/orderactionform.php");

		}



	  
	 $("#detailDivAjax").load("Ajax/orderinfo.php");
	  
	  }, 3000);





  
}





	
	updateOrders();
	
	

	


</script>




		<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/jquery.scrolly.min.js"></script>
			<script src="assets/js/jquery.scrollex.min.js"></script>
			<script src="assets/js/browser.min.js"></script>
			<script src="assets/js/breakpoints.min.js"></script>
			<script src="assets/js/util.js"></script>
			<script src="assets/js/main.js"></script>

	</body>
</html>