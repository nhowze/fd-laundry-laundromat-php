<?php

include_once("LoginSystem/cooks.php");
//session_start();
include_once('LoginSystem/db.php');
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';
require_once('includes/stripe-php-master/init.php');


if ( !isset($_SESSION['login']) || $_SESSION['login'] !== true) {

if(empty($_SESSION['access_token']) || empty($_SESSION['access_token']['oauth_token']) || empty($_SESSION['access_token']['oauth_token_secret'])){

if ( !isset($_SESSION['token'])) {

if ( !isset($_SESSION['fb_access_token'])) {

 header('Location: index.php');

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




$sqlnum = "SELECT COUNT(Status) as Total FROM OrderGroup WHERE Laundromat_ID = '".$row['ID']."' AND Status = 'In Progress' AND Date(Date) = Date(NOW()) ";
$resultnum = mysqli_query($mysqli, $sqlnum);
$inprogress = mysqli_fetch_assoc($resultnum);

$sqlnum = "SELECT COUNT(Status) as Total FROM OrderGroup WHERE Laundromat_ID = '".$row['ID']."' AND Status = 'Order Complete' AND Date(Date) = Date(NOW()) ";
$resultnum = mysqli_query($mysqli, $sqlnum);
$ordercompleted = mysqli_fetch_assoc($resultnum);


$sqlnum = "SELECT COUNT(Status) as Total FROM OrderGroup WHERE Laundromat_ID = '".$row['ID']."' AND Status = 'Waiting Approval' AND Date(Date) = Date(NOW()) ";
$resultnum = mysqli_query($mysqli, $sqlnum);
$pendingapproval = mysqli_fetch_assoc($resultnum);





$sqlnum = "SELECT COUNT(Status) as Total FROM OrderGroup WHERE Laundromat_ID = '".$row['ID']."' AND Status = 'In Progress' AND Month(Date) = Month(NOW()) ";
$resultnum = mysqli_query($mysqli, $sqlnum);
$inprogress2 = mysqli_fetch_assoc($resultnum);

$sqlnum = "SELECT COUNT(Status) as Total FROM OrderGroup WHERE Laundromat_ID = '".$row['ID']."' AND Status = 'Order Complete' AND Month(Date) = Month(NOW()) ";
$resultnum = mysqli_query($mysqli, $sqlnum);
$ordercompleted2 = mysqli_fetch_assoc($resultnum);


$sqlnum = "SELECT COUNT(Status) as Total FROM OrderGroup WHERE Laundromat_ID = '".$row['ID']."' AND Status = 'Waiting Approval' AND Month(Date) = Month(NOW()) ";
$resultnum = mysqli_query($mysqli, $sqlnum);
$pendingapproval2 = mysqli_fetch_assoc($resultnum);


$sqlnum = "SELECT COUNT(Status) as Total FROM OrderGroup WHERE Laundromat_ID = '".$row['ID']."' AND Status = 'In Progress' AND Year(Date) = Year(NOW()) ";
$resultnum = mysqli_query($mysqli, $sqlnum);
$inprogress3 = mysqli_fetch_assoc($resultnum);

$sqlnum = "SELECT COUNT(Status) as Total FROM OrderGroup WHERE Laundromat_ID = '".$row['ID']."' AND Status = 'Order Complete' AND Year(Date) = Year(NOW()) ";
$resultnum = mysqli_query($mysqli, $sqlnum);
$ordercompleted3 = mysqli_fetch_assoc($resultnum);


$sqlnum = "SELECT COUNT(Status) as Total FROM OrderGroup WHERE Laundromat_ID = '".$row['ID']."' AND Status = 'Waiting Approval' AND Year(Date) = Year(NOW()) ";
$resultnum = mysqli_query($mysqli, $sqlnum);
$pendingapproval3 = mysqli_fetch_assoc($resultnum);


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
	    
		<title><?php echo $contactinf['Name'];?> | Laundromat Home</title>
		
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		
		<style>
		
.btn {

  border: none;
  color: white;
  padding: 12px 16px;
  font-size: 100%;
  cursor: pointer;
}
		
		
		</style>
		
		
	
		
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
		
		
		<style>
	
		tr:nth-child(even) {background: rgba(205, 185, 156,0.2)}
  tr:nth-child(odd) {background: white}
		
		</style>
		
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
			<div id="header" style="height:100%; min-height:800px; background: #44525a;">

				<div class="top" >

					<!-- Logo -->
						<div id="logo">
							<img src="../images/app-logo-transparent.png" style="width:30%;" alt="" />
							<h1 id="title">Welcome <br><?php echo $row['Name'];?></h1>
							
						</div>

					<!-- Nav -->
						<nav id="nav" >
							<ul>
								<li><a href="home.php" id="top-link"style="color:white;"><span ><img src="../images/app-logo-transparent.png" style="width:10%;" alt="" />Home</span></a></li>
							 
							 	 <?php
							 
							 	if($row['SubscriptionType'] == "gold" &&  $row['AccountType'] == "Main"){
						    
						    echo'<li><a href="addlocation.php" id="contact-link"style="color:white;"><span >Add Location</span></a></li>';
						    
						    
						}
							 
							 ?>
							 
							 <li><a href="payments.php" style="color:white;"><span >Payment History</span></a></li>
								<li><a href="orders.php" id="portfolio-link"style="color:white;"><span >Pending Orders</span></a></li>
								
								
								<li><a href="products.php" id="contact-link"style="color:white;"><span >Products</span></a></li>
								<li><a href="account.php" id="contact-link"style="color:white;"><span >My Account</span></a></li>
								
								<?php
								
	$sqlc = "SELECT COUNT(*) as Total FROM Laundromat WHERE GroupID = '".$row['GroupID']."' ";
$resultco = mysqli_query($mysqli, $sqlc);
$resultco = mysqli_fetch_assoc($resultco);
							
								if($resultco['Total'] > 1){
								    
								  echo'<li><a href="Backend/resetlocation.php" id="contact-link"style="color:white;"><span >Change Store Locations</span></a></li>';
								    
								}
								
								?>
								
								<li><a href="Backend/logout.php" id="about-link"style="color:white;"><span >Logout</span></a></li>
								
							</ul>
						</nav>

				</div>

				<div class="bottom">

			

				</div>

			</div>

		<!-- Main -->
			<div id="main">

				

				<!-- Portfolio -->
					<section id="portfolio" class="two">	<table style="width:100%;  top:0; position:fixed; min-height:65px; z-index: 2; margin:0;">
					    <th style="color:white; background: #44525a; text-align:center; height:60px;">Home</th>
					
					
					<tr><td style="padding:0; margin;0;">
						<div class="container" style="text-align:left;  padding:0; margin-top:-0.5%; width:100%;  min-height:450px; width:100% !important; ">

						



					<?php	
					
			
							
						
									require_once 'includes/Mobile-Detect-master/Mobile_Detect.php';
$detect = new Mobile_Detect;

	if($detect->isMobile()) {
					echo'
					<style>
					td, th{
					    font-size:85%;
					    vertical-align:middle;
					}
					</style>';
					}
					
					
			
					
					
						echo'<div class="container" style="text-align:left;  padding:0; margin-top:-0.5%; width:100%;  min-height:450px; width:100% !important; ">';
					
					//start report div
					echo'<div style="width:100%;">';
					$mindate = date("Y-m-d", strtotime("-1 days"));
					$maxdate = date("Y-m-d");
					
					
					
					if(isset($_SESSION['report'])){
						
						
						if($_SESSION['report'] == "There was an error sending your report. Please try again."){
							echo'<h4 style="color: red;">'.$_SESSION['report'].'</h4>';
						}else{
							
							echo'<h4 style="color:green;">'.$_SESSION['report'].'</h4>';
						}
						
						
						unset($_SESSION['report']);
					}
					
					
					echo'
<style>
		
td, tr, table, th{
		
vertical-align:middle;
		
}
		
</style>
		
<form method="get" action="Backend/sendreport.php" onsubmit="validateF()" enctype="multipart/form-data">
<input type="hidden" value="'.$row['ID'].'" name="laundromatID">
<table style="width:100% !important; table-layout:fixed;">
<th  style="font-size:90%;" >Request Report</th> <th>Date Range</th>
		
		
<tr>
<td style="vertical-align:bottom !important; padding-left:5%;"><select name="report" style="font-size:80%;"  required>
<option value="">Choose Report</option>
<option value="orders">Orders</option>
<option value="transfers">Payment Transfers</option>
</select></td>
<td style="width:50%; font-size:75%; padding-right:5%;">From: <input type="date" name="mindate" id="mindate"  value="'.$mindate.'"" style="font-size:80%; display: inline-block" required></td></tr>
<tr><td style="vertical-align:bottom !important;  padding-left:5%;"><input type="submit" style="font-size:80%;"  value="Request Report"></td>
<td style="width:50%; font-size:75%;  padding-right:5%;">
To: &nbsp; &nbsp; &nbsp;<input type="date" name="maxdate"  id="maxdate" value="'.$maxdate.'" style="font-size:80%; display: inline-block;"   required> </td>
</tr>
</table>
		
</form>
		
</div>';
					
					//end report div
					
					
							if(isset($_SESSION['report'])){

	
	if($_SESSION['report'] == "There was an error sending your report. Please try again."){
		echo'<h4 style="color: red;">'.$_SESSION['report'].'</h4>';
	}else{
		
		echo'<h4 style="color:green;">'.$_SESSION['report'].'</h4>';
	}
	
	
	unset($_SESSION['report']);
}
					
				
					
					
					
						echo'<div id="user" style="visibility: hidden; top:0; padding:0; margin:0;">'.$row['ID'].'</div>';
						
									
									
											require_once 'includes/Mobile-Detect-master/Mobile_Detect.php';
$detect = new Mobile_Detect;




	if($detect->isMobile()) {
						
						echo'<div id="ajaxDiv">';

}else{
    
    	echo'<div style="max-height:700px; overflow-Y:auto;" id="ajaxDiv">';
    
}
						


						

							$sqlrecent = "SELECT * FROM OrderGroup WHERE Laundromat_ID = ".$row['ID']." AND Status <> 'Rejected' AND Status <> 'Waiting Approval'  ORDER BY CASE Status 
WHEN  'Received'  THEN '0'
WHEN  'Approved'  THEN '1'
WHEN 'In Progress' THEN '2'
WHEN 'Laundry Complete' THEN '3'
WHEN 'Order Complete' THEN '4'
END,
Date DESC, Pickup_Time DESC";
$resultrecent = mysqli_query($mysqli, $sqlrecent);
							
							
								require_once 'includes/Mobile-Detect-master/Mobile_Detect.php';
$detect = new Mobile_Detect;
							
							echo'<table id="orders"><th colspan="2" style="color:white; text-align:center;">Orders</th>';
							
							
							
							if ($resultrecent->num_rows > 0) {
								while($row4 = $resultrecent->fetch_assoc()) {
								
								
									$sqluser = "SELECT * FROM users WHERE id = '".$row4['UserID']."' ";
									$resultuser = mysqli_query($mysqli, $sqluser);
									$rowuser = mysqli_fetch_assoc($resultuser);
									
									
									
							$dateform = date('m/d/Y', strtotime($row4['Date']));
							$timeformpick = date('h:i A',strtotime($row4['Pickup_Time']));
							$timeformdelivr = date('h:i A',strtotime($row4['Delivery_Time']));
							
							echo'<tr style="padding:0;">
						
						<td style="width:50%;" >
<ul class="actions" style="list-style-type:none; padding:0;">


<li>'.$rowuser['First_Name'].' '.$rowuser['Last_Name'].'</li>
<li>Status: '.$row4['Status'].'</li>


</ul></td>
						<td style="width:50%;">
					<ul class="actions" style="list-style-type:none; padding:0;">


						<li>#: '.$row4['OrderNum'].'</li>
				        
						
<li><form action="orderdetail.php" method="get" enctype="multipart/form-data">
						<input type="hidden" name="orderID" value="'.$row4['OrderNum'].'">
						<button type="submit" class="btn"><i class="fa fa-search" > View Order</i></button>
						
						</form></li>';
						
							
						
						echo'</ul></td></tr>';
	
							
							
						}
						
						
							}
								echo'</table>';
								
								?>
							
</div>	</div> 

</td></tr></table>
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
	<script>
function updateOrders() {
  setInterval(function(){ 
	
	  $("#ajaxDiv").load("Ajax/pendinghome.php");

	  }, 2000);
}


	updateOrders()
	



</script>


<?php //echo'<script src="https://'.$_SERVER['SERVER_NAME'].'/Laundromats/Print/print.js"></script>'; ?>
<!-- <script src="https://printjs-4de6.kxcdn.com/print.min.js"></script>-->
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