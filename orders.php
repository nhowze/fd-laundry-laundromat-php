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
	    
		<title><?php echo $contactinf['Name'];?> | Laundromat Orders</title>
		
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
							 
							 				 			  <?php
							 
							 	if($row['SubscriptionType'] == "gold" && $row['AccountType'] == "Main"){
						    
						    echo'<li><a href="addlocation.php" id="contact-link"style="color:white;"><span >Add Location</span></a></li>';
						    
						    
						}
							 
							 ?>
							 
							 <li><a href="payments.php" style="color:white;"><span >Payment History</span></a></li>
								<li><a href="orders.php" id="portfolio-link"style="color:white;"><span ><img src="../images/app-logo-transparent.png" style="width:10%;" alt="" />Pending Orders</span></a></li>
								
								
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
					<section id="portfolio" class="two"><table style="width:100%;  top:0; position:fixed; min-height:60px; z-index: 2;"><th style="color:white; background: #44525a; font-size:100%;  text-align:center;">Pending Orders</th></table>
					

			

						<?php
						require_once 'includes/Mobile-Detect-master/Mobile_Detect.php';
							$detect = new Mobile_Detect;
						
						if($detect->isMobile()) {
							
							
							echo'<div class="container" id="ajaxdiv" style="text-align:left; margin-top:10%; min-height:450px;">';
							
						}else{
							
							
							echo'<div class="container" id="ajaxdiv" style="text-align:left;">';
							
						}
						
						
					

							$sqlrecent = "SELECT * FROM OrderGroup WHERE Laundromat_ID = ".$row['ID']." AND Status = 'Waiting Approval' ORDER BY Date DESC, Pickup_Time DESC";
$resultrecent = mysqli_query($mysqli, $sqlrecent);
							
							
								require_once 'includes/Mobile-Detect-master/Mobile_Detect.php';
$detect = new Mobile_Detect;
							
							echo'<table>';
							
							if ($resultrecent->num_rows > 0) {
								while($row4 = $resultrecent->fetch_assoc()) {
								
								if($detect->isMobile()) {
							$dateform = date('m/d/Y', strtotime($row4['Date']));
							$timeformpick = date('h:i A',strtotime($row4['Pickup_Time']));
							$timeformdelivr = date('h:i A',strtotime($row4['Delivery_Time']));
							
							echo'<tr >
						
						
						
						
						<td style="vertical-align:middle; ">
						<h4>'.$row4['Name'].'</h4>
						<p>Status: '.$row4['Status'].'
						<br>Date: '.$dateform.'
						<Br>Initial Pickup Time: '.$timeformpick.'
				        <Br>Delivery | Pickup Time: '.$timeformdelivr.'
						
						
						
						<Br</p>';
						
						
						if($row4['Status']  != "Approved"){
						    
						    echo'
						    
						   <table >
						   <tr>
						    <td ><form action="Backend/accept.php" method="post">
						<input type="hidden" name="orderID" value="'.$row4['OrderNum'].'">
						<button type="submit" style="background:green; font-size:100%;"  class="btn"><i class="fa fa-check"></i></button>
						
						</form></td>
						
						<td >	<form action="Backend/decline.php" method="post">
						<input type="hidden" name="orderID" value="'.$row4['OrderNum'].'">
						<button type="submit" style="background:red;  font-size:100%;"  class="btn"><i class="fa fa-trash"></i></button>
						
						</form></td>
						    </tr></table>
						    
						    ';
						}else{
						echo'<form action="orderdetail.php" method="post" enctype="multipart/form-data">
						<input type="hidden" name="orderID" value="'.$row4['OrderNum'].'">
						<input type="submit" value="View Order">
						
						</form>';
						
								}
						
						echo'</td></tr>';
}else{
    
    
    
    
    
    		$dateform = date('m/d/Y', strtotime($row4['Date']));
							$timeformpick = date('h:i A',strtotime($row4['Pickup_Time']));
							$timeformdelivr = date('h:i A',strtotime($row4['Delivery_Time']));
							
							echo'<tr >
						
						
						
						
						<td style="vertical-align:middle; ">
						<h4>'.$row4['Name'].'</h4>
						<p>Status: '.$row4['Status'].'
						<br>Date: '.$dateform.'
						<Br>Initial Pickup Time: '.$timeformpick.'
				        <Br>Delivery | Pickup Time: '.$timeformdelivr.'
						
						
						
						<Br</p>
						
						</td>
						<td style="vertical-align:middle; width:30%;">';
						$stat = "Waiting Approval";
						
						if($row4['Status']  != "Approved"){
						
						
						echo'<form action="Backend/accept.php" method="post">
						<input type="hidden" name="orderID" value="'.$row4['OrderNum'].'">
						<button type="submit" style="background:green; font-size:100%;"  class="btn"><i class="fa fa-check"></i></button>
						
						</form>
						<br>
							<form action="Backend/decline.php" method="post">
						<input type="hidden" name="orderID" value="'.$row4['OrderNum'].'">
						<button type="submit" style="background:red;  font-size:100%;"  class="btn"><i class="fa fa-trash"></i></button>
						
						</form>';
						
						}else{
						    
						    
						    echo'<form action="orderdetail.php" method="post">
						<input type="hidden" name="orderID" value="'.$row4['OrderNum'].'">
						<input type="submit" value="View Order">
						
						</form>';
						    
						    
						}
						
						
						echo'</td></tr>';
    
    
    
    
    
    
}		
							
							
						}
						
						
							}else{
							    
							    echo'No Pending Orders';
							    
							    
							}
								echo'</table>';
								
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

	<script>
function updateOrders() {
  setInterval(function(){ 
	
	  $("#ajaxdiv").load("Ajax/pendingajax.php");

	  }, 2000);
}


	updateOrders()
	



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