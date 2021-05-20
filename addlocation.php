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
	    
		<title><?php echo $contactinf['Name']; ?> | Laundromat Home</title>
		
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
								<li><a href="homeinit.php" id="top-link"style="color:white;"><span >Home</span></a></li>
							 
							 	<?php
							 
							 
							 if($row['SubscriptionType'] == "gold"){
							 	echo'<li><a href="addlocation.php" id="top-link"style="color:white;"><span >Add New Location</span></a></li>';
							 }else{
							     echo'<li><a  id="top-link"style="color:white; cursor:pointer;" onclick="alert(\'A gold membership is required to add multiple store locations.\');"><span >Add New Location</span></a></li>';
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
					<section id="portfolio" class="two">	<table style="width:100%;  top:0; position:fixed; min-height:60px; z-index: 2;"><th style="color:white; background: #44525a; text-align:center;">Add New Location</th></table>
						<div class="container"  style="min-height:450px; text-align:left;"><br>

						

<form method="post" action="Backend/addlocback.php" enctype="multipart/form-data">
    
    
   <input type="text" name="nickname" placeholder="Location Nickname" required> 
   (Will Appear: <?php echo $row['Name']; ?> | "Location Nickname")<br><br>
    <input type="text" name="cname" placeholder="Contact Name" required>
  <br>  Phone number:  <input type="number" name="phone"  min="1000000000" max="9999999999"   required>

<br><br>
Store Address:<input type="text" id="street-address" name="street-address" placeholder="Address" value=" " required>	
					Unit:<input type="text"  placeholder="Unit" id="unit"  name="unit">
					City:<input type="text" value=" " placeholder="City" id="city" name="city"  required>
					State:<input type="text" value=" " placeholder="State" id="state"  name="state" required>
					Zip:<input type="text" value=" " placeholder="Zip" id="zip"  name="zip" required>
    
    <br>
<input type="submit">
</form>



							

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
						</ul>';
						
						?>
				<!-- Copyright -->
					<?php echo'<ul class="copyright">
						<li><a href="http://icitechnologies.com" target="_blank">&copy;
ICI Technologies LLC All rights reserved.</a></li>
<li><a href="https://'.$_SERVER['HTTP_HOST'].'/legal/delivrmat-privacy-policy.php">Privacy Policy</a></li>
<li><a href="https://'.$_SERVER['HTTP_HOST'].'/legal/delivrmat-terms-conditions.php">Terms</a></li>

					</ul>'; ?>

			</div>


	<script src="//ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="//d79i1fxsrar4t.cloudfront.net/jquery.liveaddress/5.1/jquery.liveaddress.min.js"></script>
<script>var liveaddress = $.LiveAddress({
	key: "13690045101805762",
	debug: true,
	target: "US",
	addresses: [{
		address1: '#street-address',
		locality: '#city',
		administrative_area: '#state',
		postal_code: '#zip',
		country: '#country'
	}]
});
</script>
<script src="<?php echo $_SERVER['HTTP_HOST']; ?>/Laundromats/Print/print.js"></script>
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