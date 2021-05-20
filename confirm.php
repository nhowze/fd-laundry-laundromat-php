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
//echo($plugin['HTML']);




$sql = "SELECT * FROM Laundromat WHERE email = '".$_SESSION['username']."' ";
$result = mysqli_query($mysqli, $sql);
$row = mysqli_fetch_assoc($result);


$sql = "SELECT * FROM Laundromat WHERE GroupID = '".$row['GroupID']."' AND AccountType = 'Main' ";
$result = mysqli_query($mysqli, $sql);
$row = mysqli_fetch_assoc($result);



if($row['GroupID'] == 0){

$mysqli->query("UPDATE Laundromat SET GroupID = '".$row['ID']."'  WHERE email = '".$_SESSION['username']."' AND AccountType ='Main'  ");

}

$sql = "SELECT * FROM Laundromat WHERE email = '".$_SESSION['username']."' ";
$result = mysqli_query($mysqli, $sql);
$laundromatinf = mysqli_fetch_assoc($result);


if($laundromatinf['Type'] == "Test"){

$sql2 = "SELECT * FROM `Keys` WHERE `ID` = 3 ";
$result2 = mysqli_query($mysqli, $sql2);
$keys = mysqli_fetch_assoc($result2);


$sql2 = "SELECT * FROM `Keys` WHERE `ID` = 4 ";
$result2 = mysqli_query($mysqli, $sql2);
$keysecret = mysqli_fetch_assoc($result2);


}else{

$sql2 = "SELECT * FROM `Keys` WHERE `ID` = 11 ";
$result2 = mysqli_query($mysqli, $sql2);
$keys = mysqli_fetch_assoc($result2);

$sql2 = "SELECT * FROM `Keys` WHERE `ID` = 12 ";
$result2 = mysqli_query($mysqli, $sql2);
$keysecret = mysqli_fetch_assoc($result2);


}



//discount calculation end


$sql2 = "SELECT * FROM `Balance_Rate` WHERE `ID` = 5 ";
$result2 = mysqli_query($mysqli, $sql2);
$MonthFeeText= mysqli_fetch_assoc($result2);


$sql2 = "SELECT * FROM `Balance_Rate` WHERE `ID` = 6 ";
$result2 = mysqli_query($mysqli, $sql2);
$ServiceFeeText = mysqli_fetch_assoc($result2);



\Stripe\Stripe::setApiKey($keysecret['Key']);
$error = '';
$success = '';
try {
	
	
	$subscription = \Stripe\Subscription::retrieve($row['SubscriptionID']);
	

}catch (Exception $e) {
	$error = $e->getMessage();
	
	
}



if($row['SubscriptionID'] != "" && $row['Address'] != "" && $row['City'] != "" && $row['State'] != "" && $row['Zip'] != "" && $row['StripeAccount'] != "" && $row['Stripe_Customer_ID'] != ""){
	
	
	if($subscription['status'] == "active" || $subscription['status'] == "trialing"){
	
header('Location: homeinit.php');
	
}

}

if($row["Profile_Pic"] != ""){
	$profilepic = $row["Profile_Pic"];
}else{
	$profilepic ="images/avatar.jpg";
}








?>


	
	<script type="text/javascript" src="https://js.stripe.com/v1/"></script>
        <!-- jQuery is used only for this example; it isn't required to use Stripe -->
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
        <script type="text/javascript">
            // this identifies your website in the createToken call below
   Stripe.setPublishableKey("<?php echo $keys['Key']; ?>");
            function stripeResponseHandler(status, response) {
                if (response.error) {
                    // re-enable the submit button
                    $('.submit-button').removeAttr("disabled");
                    // show the errors on the form
                    $(".payment-errors").html(response.error.message);
                } else {
                    var form$ = $("#payment-form").attr('action', 'Backend/intitialstripesubscriptionsetup.php');
                    
                    
                    // token contains id, last4, and card type
                    var token = response['id'];
                    // insert the token into the form so it gets submitted to the server
                    form$.append("<input type='hidden' name='stripeToken' value='" + token + "' />");
                    // and submit
                    form$.get(0).submit();
                }
            }
            $(document).ready(function() {
                $("#payment-form").submit(function(event) {
                    // disable the submit button to prevent repeated clicks
                    $('.submit-button').attr("disabled", "disabled");
                    // createToken returns immediately - the supplied callback submits the form if there are no errors
                    Stripe.createToken({
                        number: $('.card-number').val(),
                        cvc: $('.card-cvc').val(),
                        exp_month: $('.card-expiry-month').val(),
                        exp_year: $('.card-expiry-year').val()
                    }, stripeResponseHandler);
                    return false; // submit from callback
                });
            });
        </script>
        
        
      


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
	    
		<title><?php echo $contactinf['Name']; ?> | Laundromat Account</title>
		
		<link rel="stylesheet" href="https://rawgit.com/anhr/InputKeyFilter/master/InputKeyFilter.css" type="text/css">		
	<script type="text/javascript" src="https://rawgit.com/anhr/InputKeyFilter/master/Common.js"></script>
	<script type="text/javascript" src="https://rawgit.com/anhr/InputKeyFilter/master/InputKeyFilter.js"></script>




  <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
    <script type="text/javascript" src="http://rawgit.com/vitmalina/w2ui/master/dist/w2ui.min.js"></script>
    <link rel="stylesheet" type="text/css" href="http://rawgit.com/vitmalina/w2ui/master/dist/w2ui.min.css" />
		
		
	
		
		
		
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="assets/css/main.css" />
		
		
		
				<script src="http://code.jquery.com/jquery-latest.min.js"></script>
		<script>

function myvalFunction() {

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
</script>
		<style>
		    
		    input[type="submit"],
	input[type="reset"],
	input[type="button"],
	.button {
	    padding-left:20px !important; 
	    padding-right:20px !important;
	    
	}
		    
		</style>
	
	


	
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
	
		<style>
		    
		    #addid:hover, #phoneid:hover, #inittimehead:hover, #totaltimehead:hover{
		        
		        
		        color: #4acaa8;
		        
		    }
		    
		    
		</style>
		
		<style>
/* The container */
.container2 {
    display: block;
    position: relative;
    padding-left: 35px;
    margin-bottom: 12px;
    cursor: pointer;
    font-size: 22px;
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
     border:solid;
     border-color: #2196F3;
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
</style>


<style>

 div.w2ui-time{
 
 color:black;
 
 }
</style>
	

		<script>
		function validateForm() {
		    
		    var weekopen1 = document.forms["myForm"]["weekopening1"].value;
		    var weekclose1 = document.forms["myForm"]["weekclosing1"].value;
		    var weekendopen2 = document.forms["myForm"]["weekendopening2"].value;
		    var weekendclose2 = document.forms["myForm"]["weekendclosing2"].value;
		    
	
		 
		  
		   
		    
		    
		    
var fromdt="2013/05/29 " + weekendopen2;
var todt="2013/05/29 " + weekendclose2;
var from = new Date(fromdt);
var to = new Date(todt);

if (from >= to){
  alert("Invalid Store Hours");   
  
  
  return false;
}	    
		    
		    
		    var fromdt2="2013/05/29 " + weekopen1;
var todt2="2013/05/29 " + weekclose1;
var from2 = new Date(fromdt2);
var to2 = new Date(todt2);

if (from2 >= to2){
  alert("Invalid Store Hours");   
  
  
  return false;
}	
		    
		     
		}
		</script>
		
		

        <!-- jQuery is used only for this example; it isn't required to use Stripe -->
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
		
		
		
		
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
			<div id="header" style="height:100%;  min-height:700px; background: #44525a;">

				<div class="top">

					<!-- Logo -->
						<div id="logo">
							<img src="../images/app-logo-transparent.png" style="width:30%;" alt="" />
							<h1 id="title">Welcome <br><?php echo $row['Name'];?></h1>
							
						</div>

					<!-- Nav -->
						<nav id="nav">
							<ul>
								<li><a href="confirm.php" id="top-link"><span style="color:white;"><img src="../images/app-logo-transparent.png" style="width:10%;" alt="" />Setup Account</span></a></li>
							 
							
								
								<li><a href="Backend/logout.php" id="about-link"><span style="color:white;">Logout</span></a></li>
								
							</ul>
						</nav>

				</div>

				<div class="bottom">

			

				</div>

			</div>

		<!-- Main -->
			<div id="main">

				
		<!-- images/inrevenue.png -->
				
				
				<!-- Portfolio -->
					<section id="portfolio" class="two"><table style="width:100%;  top:0; position:fixed; min-height:60px; z-index: 2;"><th style="color:white; font-size:100%; background: #44525a; text-align:center;">Setup Account</th></table>
						<div class="container" style=" min-height:450px; margin-top:0%;"><br>
											<?php
										
											if(isset($_SESSION['errmsg']) || isset($_SESSION['errmsg1'])){
												
												echo'<h4 style="color:red;">Your purchase of was declined. Please use a different payment method.</h4>';
												
												unset($_SESSION['errmsg']);
												unset($_SESSION['errmsg1']);
											}
											
											
											
											
if($row['Stripe_Customer_ID'] == '' || $subscription['status'] == "incomplete" || $subscription['status'] == "incomplete_expired" ||
		$subscription['status'] == "past_due"|| $subscription['status'] == "canceled" || $subscription['status'] == "unpaid" ||
		$row['SubscriptionID'] == ""){	
							
									require_once 'includes/Mobile-Detect-master/Mobile_Detect.php';
$detect = new Mobile_Detect;


	

					echo'<div class="row" >
								<div class="col-4 col-12-mobile">
									<article class="item">
								
									
									<div style="height:250px; background:white;">
										<a  class="image fit"><img src="images/wekker-2.gif" style="width:100%; max-height:250px;" alt="" />
										</div>
									
										<header>
											<h2>Starter</h2>
											<h3 style="font-weight:bold;">$50/month  +  5% Service Fee</h3>
<h3>Try for 30 days free!</h3>

<br><h3 style="font-weight:bold;">Features</h3>


<table>

<tr>
<td>Add Your Drivers</td>
<td>&#10004;</td>
</tr>

<tr>
<td>FD Delivery Service</td>
<td>&#x2716;</td>
</tr>

<tr>
<td>Multiple Locations</td>
<td>&#x2716;</td>
</tr>

</table>
										</header>
											
										</a>
										
									</article>
								
								</div>
								
								<div class="col-4 col-12-mobile">
									<article class="item">
									<div style="height:250px;  background:white;">
										<a  class="image fit"><img src="images/potential.jpg" style="width:100%; max-height:250px;" alt="" />
										</div>
										<header >
											<h2>Standard</h2>
											<h3 style="font-weight:bold;">$100/month +  2.5% Service Fee</h3>
<h3>&nbsp;</h3>

<br><h3 style="font-weight:bold;">Features</h3>


<table>

<tr>
<td>Add Your Drivers</td>
<td>&#10004;</td>
</tr>

<tr>
<td>FD Delivery Service</td>
<td>&#10004;</td>
</tr>

<tr>
<td>Multiple Locations</td>
<td>&#x2716;</td>
</tr>

</table>

										</header>
										</a>
										
									</article>
								
								</div>
								
								
								
								<div class="col-4 col-12-mobile">
									<article class="item">
									<div style="height:250px;  background:white;">
										<a  class="image fit"><img src="images/potential.jpg" style="width:100%; max-height:250px;" alt="" />
										</div>
										<header >
											<h2>Gold</h2>
											<h3 style="font-weight:bold;">$250/ Month</h3>
<h3>&nbsp;</h3>

<br><h3 style="font-weight:bold;">Features</h3>


<table>

<tr>
<td>Add Your Drivers</td>
<td>&#10004;</td>
</tr>

<tr>
<td>FD Delivery Service</td>
<td>&#10004;</td>
</tr>

<tr>
<td>Multiple Locations</td>
<td>&#10004;</td>
</tr>

</table>

										</header>
										</a>
										
									</article>
								
								</div>
								
								
								
								
								
							
							</div>';
					
											
							
							?>
							
							
							
							
							
							
							
					
							<?php
							
							
									require_once 'includes/Mobile-Detect-master/Mobile_Detect.php';
$detect = new Mobile_Detect;


						echo'<div class="container" style="text-align:left; padding-top:5%;">';
						

						
			
						
					
						
						$sql= "SELECT * FROM Supplies ";

						$resultorder= mysqli_query($mysqli, $sql);
						
						
						
						
						
				
							
echo'<div><form method="post" action="Backend/intitialstripesubscriptionsetup.php" name="orderForm" enctype="multipart/form-data" id="payment-form">';
			
						
						
echo'<h2>Add Card & Submit Payment</h2>
<div id="transferdiv">';

						if(isset($_SESSION['errmsg'])){
							
							echo'<h4 style="font-weight:bold;">'.$_SESSION['errmsg'].'</h4>';
							unset($_SESSION['errmsg']);
						}


echo'


					
</div>



<div class="form-row">
						<label>Select Package</label>
						<select name="package" required>
						<option value="">Choose a Package</option>
						<option value="starter">Starter</option>
						<option value="standard">Standard</option>
						<option value="gold">Gold</option>
						</select>
						</div>



						<div class="form-row">
						<label>Card Name</label>
						<input type="text" name="cardname" value="'.$row['CardName'].'" required/>
						</div>
						
						<div class="form-row">
						<label>Card Number</label>
						<input type="text" size="20" maxlength="20" autocomplete="off" class="card-number" placeholder="XXXX - XXXX - XXXX - XXXX" required/>
						</div>
						<div class="form-row">
						<label>CVC</label>
						<input type="text" size="4" maxlength="4" autocomplete="off" class="card-cvc" placeholder="XXX" required/>
						</div>
						<div class="form-row">
						<label>Expiration (MM/YYYY)</label>
					
						</div>
							<table  style="max-width:40%;"> <tr>
						
						<td ><input type="text" size="2" maxlength="2" style="width:80px;" class="card-expiry-month" placeholder="XX" required/></td>
						
						<td ><span> / </span></td>
						
						<td ><input type="text" size="4" maxlength="4" style="width:100px;" class="card-expiry-year" placeholder="XXXX" required/></td>
						</tr>
						</table>
						<table>



<tr><td style="vertical-align:bottom;"><input type="submit" class="submit-button" ></td><td> 



</td></tr>
</table>

						
						
						
					</form></div>


';

					}
					
					
					if($row['StripeAccount'] ==""){
						
					
					echo'<div ><h2>Connect a <a href="https://dashboard.stripe.com/register" target="_blank" style="font-weight:bold;">Stripe Account*</a></h2><br><h4>Connect a Stripe Payment account to safely transfer funds to your bank account.</h4>
<a class="button"   href="https://connect.stripe.com/oauth/authorize?response_type=code&client_id=ca_DDu3UsRpsnOVRFAaRE4KRGo4HrOluFmt&scope=read_write&redirect_uri=https://'.$_SERVER['HTTP_HOST'].'/Laundromats/Backend/initialstripeconnect.php">Connect Stripe Account</a>
					</div>';
					
					}
					
					if($row['Address'] =="" || $row['City'] =="" || $row['State'] =="" || $row['Zip'] == ""){
						
							echo'<div id="address" style="text-align:left; padding:5%;">
							<h2>Address*</h2>



<form action="Backend/initialsaveaddress.php" method="post"  enctype="multipart/form-data">Address:<input type="text" id="street-address" name="street-address" value="'.$row['Address'].'" required><br>	
					Unit:<input type="text" id="unit" value="'.$row['Unit'].'" name="unit"><br>	
					City:<input type="text" id="city" name="city" value="'.$row['City'].'" required><br>
					State:<input type="text" id="state" value="'.$row['State'].'" name="state" required><br>
					Zip:<input type="text" id="zip" value="'.$row['Zip'].'" name="zip" required><br>
					
						<br>
					<input type="submit" value="Save">
					</form></div>';
								
					}
					
								
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