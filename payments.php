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
	    
		<title><?php echo $contactinf['Name'];?> | Laundromat Products</title>
		<link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.7.0/css/all.css' integrity='sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ' crossorigin='anonymous'>
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
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="assets/css/main.css" />
		
					<script src="http://code.jquery.com/jquery-latest.min.js"></script>
		<script>

function myvalFunction() {


if( document.getElementById("fileToUpload").files.length > 0 ){
    
if(document.getElementById('fileToUpload').files[0].name){
var file= document.getElementById('fileToUpload').files[0].name;
       var reg = /(.*?)\.(jpg|jpeg|png|gif|GIF|PNG|JPEG|JPG)$/;
       if(!file.match(reg))
       {

event.preventDefault();
    	   alert("Invalid File");
    	   return false;
       }else{

document.getElementById("myForm2").submit();




}
}

}

}
</script>

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
							 
							 <li><a href="payments.php" style="color:white;"><span ><img src="../images/app-logo-transparent.png" style="width:10%;" alt="" />Payment History</span></a></li>
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
<style>
    
    td{
     
        vertical-align:middle;
           <?php
    
    				require_once 'includes/Mobile-Detect-master/Mobile_Detect.php';
$detect = new Mobile_Detect;

	if($detect->isMobile()) {
	    
	    echo'font-size:80%;';
	}
    
    ?>
    }
 
</style>
		<!-- Main -->
			<div id="main" >

				

				<!-- Portfolio -->
					<section id="portfolio" class="two" ><table style="width:100%;  top:0; position:fixed; min-height:65px; z-index: 2;   padding:0; margin:0;">
					    <th style="color:white; font-size:100%;  background: #44525a; text-align:center; height:60px;">Payment History</th><tr><td style="padding:0; margin:0;">
					
			
<?php

require_once 'includes/Mobile-Detect-master/Mobile_Detect.php';
	$detect = new Mobile_Detect;


	
	echo'<div class="container" style="text-align:left;  padding:0; margin:0; width:100%;  min-height:450px; width:100% !important; ">';
	
//start report div
echo'<div style="width:100%;">';
$mindate = date("Y-m-d", strtotime("-1 days"));
$maxdate = date("Y-m-d");






echo'
<style>

td, tr, table, th{

vertical-align:middle !important;

}

</style>

<form method="get" action="Backend/sendreport.php" onsubmit="validateF()" enctype="multipart/form-data">
<input type="hidden" value="'.$row['ID'].'" name="laundromatID">
<table style="width:100% !important; table-layout:fixed;">
<th  style="font-size:90%;" >Request Report</th> <th>Date Range</th>
		

<tr>
<td style="vertical-align:bottom !important;padding-top:3%; padding-left:5%;"><select name="report" style="font-size:80%;"  required>
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

$sql2 ="SELECT * FROM Laundromat_Transfer_History WHERE UserID = '".$row['ID']."' ORDER BY Date DESC, Time DESC";
$result2 = mysqli_query($mysqli, $sql2);


if ($result2->num_rows > 0) {
	
	
	echo'<table style="margin-left:5%; margin-right:5%;">
<tr><th>Date</th>
<th>Time</th>
<th>Amount</th></tr>
';
	
	
	while($rowpayment = $result2->fetch_assoc()) {
		
		$rowpayment['Time'] = date('g:i A', strtotime($rowpayment['Time']));
		$rowpayment['Date'] = date('m-d-Y', strtotime($rowpayment['Date']));
		echo'<tr>
		
					<td>'.$rowpayment['Date'].'</td>
					<td>'.$rowpayment['Time'].'</td>
					<td>$ '.$rowpayment['Amount'].'</td>
					<td></td>
				</tr>';
		
		
	}
	
	
	
	echo'</table>';
	
}else{
	
	echo'
<table style="margin-left:5%; margin-right:5%;">
<tr>
<td>No previous payment transfers</td>
</tr>
</table>
';
	
}



?>

						</div></td></tr></table>
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
function validateF(){
	
	var min = document.getElementById("mindate").value;
	var max = document.getElementById("maxdate").value;
	
	if(max < min){
		event.preventDefault();
		alert("Invalid Date Range");
		return false;
		
	}
	
	
	
}

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