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
	echo($plugin['HTML']);




$sql = "SELECT * FROM Laundromat WHERE email = '".$_SESSION['username']."' ";
$result = mysqli_query($mysqli, $sql);
$row = mysqli_fetch_assoc($result);




$sql = "SELECT * FROM Laundromat WHERE GroupID = ".$row['GroupID']." AND AccountType = 'Main' ";
$result = mysqli_query($mysqli, $sql);
$maininf = mysqli_fetch_assoc($result);



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


$weeko = date("g:i a", strtotime($row['Week_Opening_Time']));
$weekc = date("g:i a", strtotime($row['Week_Closing_Time']));
$weekendo = date("g:i a", strtotime($row['Weekend_Opening_Time']));
$weekendc = date("g:i a", strtotime($row['Weekend_Closing_Time']));

if($row['Monday'] == "Open"){
$mondaycheck = "checked";
}else{
    
    $mondaycheck = "";
}


if($row['Tuesday'] == "Open"){
$tuesdaycheck = "checked";
}else{
    
    $tuesdaycheck = "";
}



if($row['Wednesday'] == "Open"){
$wednesdaycheck = "checked";
}else{
    
    $wednesdaycheck = "";
}


if($row['Thursday'] == "Open"){
$thursdaycheck = "checked";
}else{
    
    $thursdaycheck = "";
}


if($row['Friday'] == "Open"){
$fridaycheck = "checked";
}else{
    
    $fridaycheck = "";
}


if($row['Saturday'] == "Open"){
$saturdaycheck = "checked";
}else{
    
    $saturdaycheck = "";
}


if($row['Sunday'] == "Open"){
$sundaycheck = "checked";
}else{
    
    $sundaycheck = "unchecked";
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
	    
		<title><?php echo $contactinf['Name'];?> | Laundromat Account</title>
		
		<link rel="stylesheet" href="https://rawgit.com/anhr/InputKeyFilter/master/InputKeyFilter.css" type="text/css">		
	<script type="text/javascript" src="https://rawgit.com/anhr/InputKeyFilter/master/Common.js"></script>
	<script type="text/javascript" src="https://rawgit.com/anhr/InputKeyFilter/master/InputKeyFilter.js"></script>




  <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
    <script type="text/javascript" src="http://rawgit.com/vitmalina/w2ui/master/dist/w2ui.min.js"></script>
    <link rel="stylesheet" type="text/css" href="http://rawgit.com/vitmalina/w2ui/master/dist/w2ui.min.css" />
		
		
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
		
		$sql2 = "SELECT * FROM `Keys` WHERE `ID` = 3 ";
$result2 = mysqli_query($mysqli, $sql2);
$keys = mysqli_fetch_assoc($result2);


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
                    var form$ = $("#payment-form").attr('action', 'Backend/updatemonthlypayment.php');
                    
                    
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
		
		
		
		
		<meta charset="utf-8" />
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
		
		
		<style>


/* The Modal (background) */
.modal {
  display: block; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  padding-top: 100px; /* Location of the box */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
  text-align:center;
  
}

/* Modal Content */
.modal-content {
  background-color: #fefefe;
  text-align:center;
  margin: auto;
  padding: 20px;
  border: 1px solid #888;
  width: 80%;
  
}


</style>
		
		
		<style>
		

.quantity {
    border: solid 1px rgba(0, 0, 0, 0.15);
    font-size:30px;
   width:100%;
   background:white;
   vertical-align:middle;
   border-radius: 0.35em;
   padding-left:5%;
   
}
.quantity input {
    border: 0;
    text-align:center;
font-size:30px;
width:70%;
vertical-align:middle;
}

		
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
			<div id="header" style="height:100%;  min-height:700px; background: #44525a;">

				<div class="top" >

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
								<li><a href="orders.php" id="portfolio-link"style="color:white;"><span >Pending Orders</span></a></li>
								
								
								<li><a href="products.php" id="contact-link"style="color:white;"><span >Products</span></a></li>
								<li><a href="account.php" id="contact-link"style="color:white;"><span ><img src="../images/app-logo-transparent.png" style="width:10%;" alt="" />My Account</span></a></li>
								
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

				<ul class="icons" >
				    
				    <?php
				    
				    if($row['AccountType'] == "Main"){
				        
			$sqlloc = "SELECT COUNT(*) as TotalLocations FROM Laundromat WHERE GroupID = ".$row['GroupID']." ";
$resultloc = mysqli_query($mysqli, $sqlloc);
$rowloc = mysqli_fetch_assoc($resultloc);
						
						
						if($row['SubscriptionType'] == "gold" && $rowloc['TotalLocations'] > 1){
						    
						    	echo'<li><a onclick="alert(\'Please delete all additional store locations before deleting this account.\')" id="dbut" href="#deletediv" style="cursor:pointer; font-size:100%; color:white; display:inline;">Delete Account</a></li>';
				
						    
						}else{
						
							echo'<li><a onclick="showd()" id="dbut" href="#deletediv" style="cursor:pointer; font-size:100%; color:white; display:inline;">Delete Account</a></li>';
				    
						    
						}
				        
			
				    }else{
				echo'<li><a onclick="showd2()" id="dbut2" href="#deletediv2" style="cursor:pointer; font-size:100%; color:white; display:inline;">Remove Location</a></li>';
				    }
				?>
				</ul>

				</div>

			</div>
			
		<!-- Main -->
			<div id="main">

				

				<!-- Portfolio -->
					<section id="portfolio" class="two" style="padding-top:0; margin-top:0;">
					<table  style="width:100%;  top:0; min-height:65px; z-index: 2;   padding:0; margin:0;">
					    
					    
					    <th style="color:white; background: #44525a; font-size:100%; height:60px; text-align:center;">Account Info</th>
					    <tr><td style="">
							    
							    <div class="container" style="text-align:left;  padding:0; margin-top:-0.5%; width:100%;  min-height:450px; width:100% !important; ">
							    
												<script>

					 $(function() {
						  $("form.confirmp").submit(function(event) {
						    event.preventDefault(); // Prevent the form from submitting via the browser
						    var form = $(this);
						    $.ajax({
						      type: "post",
						      url: "Backend/accountconfirmpassword.php",
						      data: form.serialize()
						    }).done(function(data) {
						      // Optionally alert the user of success here...
						  
						$("#ajaxModal").load("Backend/redirectaccountconfirmpassword.php");
    
						    }).fail(function(data) {
						      // Optionally alert the user of an error here...
						    });

						  });


						});

						
					</script>
							
							<?php 
							
							
							if(isset($_SESSION['wrongpass'])){
								
								unset($_SESSION['wrongpass']);
							
							}
							
							if(!isset($_SESSION['passconfirm'])){
							
								
							echo'<div id="myModal" class="modal" style="text-align: center;">

  <!-- Modal content -->
  <div class="modal-content" style="text-align: center;">
  <div id="ajaxModal" style="color:red;"></div>
    <p>This page contains sensitive information. Please re-enter your password to view this page.</p>
   
    <div style="text-align:center !important; max-width:250px; margin:auto;">
    <form class="confirmp" method="post" enctype="multipart/form-data">
    
   
    <input type="password"  name="cpassword" placeholder="Confirm Password" required>
    <br>
    <input type="submit">
    </form>
    </div>
    
    
  </div>

</div>';
							
						
							
							}
				?>			
							<?php
							
							
									require_once 'includes/Mobile-Detect-master/Mobile_Detect.php';
$detect = new Mobile_Detect;


				
						

							
							
	
							
	
if($detect->isMobile()) {
							echo'
					<span  style="width:30%; text-align:center; "  class="image avatar"><a href="account.php"><img src="'.$profilepic.'" alt="" /></a></span>';
					
							
							
}else{
    
    echo'
					<span  style="width:10%; text-align:center; "  class="image avatar"><a href="account.php"><img src="'.$profilepic.'" alt="" /></a></span>';
  
}



echo'	<form method="post" id="myForm2" name="write"  enctype="multipart/form-data" onSubmit="myvalFunction()"   action="Backend/updateaccountinfo.php">
							  <div style="margin-left:auto; margin-right:auto; width:100%;">
							  
							  
							  <input type="file" name="fileToUpload" id="fileToUpload" ></div>
							  ';
					

						if(isset($_SESSION['accountf'])){
							
							echo'<h3>'.$_SESSION['accountf'].'</h3>';
							
							unset($_SESSION['accountf']);
						}
						
						
				if($row['AccountType'] == "Main"){		
						
								echo'Business Name: <input type="text" name="bname" value="'.$row['Name'].'" required><br>';
								
				}else{
				    
				    
				    $namearray = explode( $maininf['Name'].' | ', $row['Name']);
				    
				    	echo'Business Name: <input type="text" name="bname" value="'.$namearray['1'].'" required><br>';
				    
				}
								
								echo'Contact Name: <input type="text" name="cname" value="'.$row['Contact_Name'].'" required><input type="hidden" name="username" value="'.$row['username'].'" required><br>';


if($row['AccountType'] == "Main"){

							    echo'Email: <input type="email" name="email" value="'.$row['email'].'" required>';
							    }else{
							       
							       echo'<input type="email"  style="display:none;" name="email" value="'.$maininf['email'].'" required>'; 
							        
							    }
							    
							   echo' 
							   
							    Phone (10 digits - numbers only): <input type="number" name="phone" value="'.$row['Phone'].'" min="1000000000" max="9999999999" style="width:100%;" required><br><br>
							   
							    
							    
							';


				    
				   
				        
							echo'<table><tr>
							
							<td><input type="submit" value="Save" ></td>';
							 if($row['AccountType'] == "Main"){
echo'<td><a id="changehe" class="button" onClick="showpassdiv()"  style=" font-size:100%;">Change Password</a></td>';
							echo'</tr></table></form>';
								
				    }
								
								
								
								//start password change
								
								
							
								
								
						
									
									if(isset($_SESSION['passwordmess'])){
									    
										echo'<h3>'.$_SESSION['passwordmess'].'</h3>';
								
									
									unset($_SESSION['passwordmess']);
								}
								
								
								echo'<script>
		
function showpassdiv(){
		
document.getElementById("passdiv").style.display = "block";
}
		
		
function review(){
		
 var newpass = document.getElementById("newpass").value;
var cnewpass = document.getElementById("cnewpass").value;
		
if(newpass != cnewpass){
alert("Passwords do not match. Please confirm your new password.");
event.preventDefault();
		
return false;
}
		
}
		
</script>


<div id="passdiv" style="display: none;">
<form action="LoginSystem/updatepasswordsecured.php" method="post" onsubmit="review()">
Old Password:
<input type="password" placeholder="Old Password" name="oldpassword" required>
New Password:
<input type="password" placeholder="New Password" id="newpass" name="password" required>
Confirm Password:
<input type="password" placeholder="Confirm New Password" id="cnewpass" name="cpassword" required><br>
<input type="submit">
</form>
</div><Br>
';
								
								
								
								//end password change
								
								
								
								
								
					
						
						




						
						if($detect->isMobile()) {
							
							
							echo'<table>
<th>'.$contactinf['Name'].' Balance: $'.$row['Balance'].'</th>
</table>


<h4>Transfer to your Stripe Payment account</h4>
<div id="transferdiv">';
							
							if(isset($_SESSION['errmsg'])){
								
								echo'<h4 style="font-weight:bold;">'.$_SESSION['errmsg'].'</h4>';
								unset($_SESSION['errmsg']);
							}
							
							
							echo'
<form  method="POST"  action="Backend/transferbank.php">
    		
    		
    		
						<table><tr>
						<td><div class="quantity">$<input type="number" max="'.$row['Balance'].'" min=".01" name="ammount" step=".01" value="'.$row['Balance'].'" style="width:90%;"></div></td>';
					
							
							if($row['StripeAccount']!=""){
								echo'<td> <input type="submit" value="Transfer" class="submit-button" style="font-size:80%;"></td>';
							}else{
								echo'<td> <input type="button" value="Transfer" class="submit-button" onclick="alertstripe()" style="font-size:80%;"></td>';
							}
							
							echo'</tr>

</table>
			
			
	<script>
function alertstripe(){
			
alert("You must connect a Stripe Payments account to your '.$contactinf['Name'].' account before you  can transfer funds.");
			
}
			
</script>
			
			
</form>
			

			
			
</div>';

	if($row['AccountType'] == "Main"){		
echo'<table>
<tr><th colspan="2">Connect to a different <a href="https://dashboard.stripe.com/register" target="_blank" style="font-weight:bold;">stripe account</a> to transfer funds.</th></tr>
<tr>
<td colspan="2" style="text-align:center;"><a class="button"   href="https://connect.stripe.com/oauth/authorize?response_type=code&client_id=ca_DDu3UsRpsnOVRFAaRE4KRGo4HrOluFmt&scope=read_write&redirect_uri=https://'.$_SERVER['SERVER_NAME'].'/Laundromats/Backend/updatestripeconnect.php">Connect Stripe Account</a></td>

</tr>
</table>
		
';
	}						
							
							
							
						}else{
							
						
echo'<table>
<th>'.$contactinf['Name'].' Balance: $'.$row['Balance'].'</th>
</table>
<div id="transferdiv">';

						if(isset($_SESSION['errmsg'])){
							
							echo'<h4 style="font-weight:bold;">'.$_SESSION['errmsg'].'</h4>';
							unset($_SESSION['errmsg']);
						}


echo'
<form  method="POST"  action="Backend/transferbank.php">



						<table><tr><td colspan="2">Transfer to your Stripe Payment account</td></tr><tr>
						
						
						<td><div class="quantity">$<input type="number" max="'.$row['Balance'].'" min=".01" name="ammount" step=".01" value="'.$row['Balance'].'"></div></td>
						';
						
						
						
						
						if($row['StripeAccount']!=""){
					echo'<td> <input type="submit" value="Transfer" class="submit-button"></td>';
						}else{
							echo'<td> <input type="button" value="Transfer" class="submit-button" onclick="alertstripe()"></td>';
						}
					
						echo'</tr>

</table>

						
	<script>
function alertstripe(){		

alert("You must connect a Stripe Payments account to your '.$contactinf['Name'].' account before you  can transfer funds.");

}	

</script>

   
</form>



					
</div>';

if($row['AccountType'] == "Main"){

echo'<table>
<th colspan="2">Connect to a different <a href="https://dashboard.stripe.com/register" target="_blank" style="font-weight:bold;">stripe account</a> to transfer funds.</th>
<th><a class="button"   href="https://connect.stripe.com/oauth/authorize?response_type=code&client_id=ca_DDu3UsRpsnOVRFAaRE4KRGo4HrOluFmt&scope=read_write&redirect_uri=https://'.$_SERVER['SERVER_NAME'].'/Laundromats/Backend/updatestripeconnect.php">Connect Stripe Account</a>
</th>


</table>

';
}

						}
						
						
	if($row['AccountType'] == "Main"){					
						
								echo'
						<h3 style="font-weight:bold;" id="updatepayment">Update Subscription</h3>
						<br>';
						
						if(isset($_SESSION['submsg'])){
						    
						    echo'<h3>'.$_SESSION['submsg'].'</h3>';
						    
						    unset($_SESSION['submsg']);
						}		
						
						
$sqlloc = "SELECT COUNT(*) as TotalLocations FROM Laundromat WHERE GroupID = ".$row['GroupID']." ";
$resultloc = mysqli_query($mysqli, $sqlloc);
$rowloc = mysqli_fetch_assoc($resultloc);
						
						
						if($row['SubscriptionType'] == "gold" && $rowloc['TotalLocations'] > 1){
						
						echo'<script>
						
						function validatesubscriptionupdate(){
						    
						    alert("Please delete all additional store locations before downgrading packages.");
						    
						    return false;
						    
						}
						
						</script>
						<form method="post" action="Backend/updatesubscription.php" name="subForm" 
						enctype="multipart/form-data" id="subscription-form" onsubmit="return validatesubscriptionupdate()">';
						
						}else{
								echo'<form method="post" action="Backend/updatesubscription.php" name="subForm" 
						enctype="multipart/form-data" id="subscription-form" >';
						
						}

echo'<select name="package" required>';


echo'<option value="'.$row['SubscriptionType'].'">'.ucfirst($row['SubscriptionType']).' Package</option>';



if($row['SubscriptionType'] != "starter"){
echo'<option value="starter">Starter Package</option>';
}

if($row['SubscriptionType'] != "standard"){
echo'<option value="standard">Standard Package</option>';
}

if($row['SubscriptionType'] != "gold"){
echo'<option value="gold">Gold Package</option>';
}

echo'</select>
						<br><input type="submit" value="Update">
						</form><br>';
						
						
	}					
						
						if($row['AccountType'] == "Main"){
						
						echo'
						<h3 style="font-weight:bold;" id="updatepayment">Update Payment Method</h3><br>
						';
						
						if(isset($_SESSION['carderrmsg'])){
						    
						    echo'<br><h3>'.$_SESSION['carderrmsg'].'</h3>';
						    
						    unset($_SESSION['carderrmsg']);
						}
						
						
						echo'<form method="post" action="Backend/updatemonthlypayment.php" name="orderForm" enctype="multipart/form-data" id="payment-form">



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
<input type="submit" class="submit-button" value="Update"><br>
					</form>';
						
						
						}
						
						
							echo'<div id="hours">
							<br>
							<br>';
							if(isset($_SESSION['hoursmsg'])){
							echo'<h3 >'.$_SESSION['hoursmsg'].'</h3>';
							
							    
							    unset($_SESSION['hoursmsg']);
							}
							
							echo'<style>
					
							
						td, th{
						vertical-align:middle;
				
						}
						
						
						input[type="us-time"]{
						    
						    width:100%;
						    
						}
						
						
							</style>';
							
							
							
							
							echo'<h3 style="font-weight:bold;">Store Hours</h3>
		
							
							<form  name="myForm" action="Backend/updatehours.php" method="post"  enctype="multipart/form-data" onsubmit="return validateForm()">
							
							<table style="width:100%;">
							
							<tr>
							<th>Day</th>
							<th>Open</th>
							
							</tr>
							
							
				<tr>
				<td>Monday</td>
				<td><label class="container2">
                    <input type="checkbox" name="mondaycheck" '.$mondaycheck.' >
                    <span class="checkmark"></span> 
                </label></td>
			
				</tr>
							
							<tr>
							<td>Tuesday</td>
							<td><label class="container2">
                    <input type="checkbox" name="tuesdaycheck" '.$tuesdaycheck.' >
                    <span class="checkmark"></span> 
                </label></td>
				
							</tr>
							
							<tr>
							<td>Wednesday</td>
							<td><label class="container2">
                    <input type="checkbox" name="wednesdaycheck" '.$wednesdaycheck.' >
                    <span class="checkmark"></span> 
                </label></td>
			
							</tr>
							
							<tr>
							<td>Thursday</td>
							<td><label class="container2">
                    <input type="checkbox" name="thursdaycheck" '.$thursdaycheck.' >
                    <span class="checkmark"></span> 
                </label></td>
			
							</tr>
							
							
							<tr>
							<td>Friday</td>
							<td><label class="container2">
                    <input type="checkbox" name="fridaycheck" '.$fridaycheck.' >
                    <span class="checkmark"></span> 
                </label></td>
			
							</tr>
							
							
							<tr>
							<td>Saturday</td>
							<td><label class="container2">
                    <input type="checkbox" name="saturdaycheck" '.$saturdaycheck.'>
                    <span class="checkmark"></span> 
                </label></td>
			
							</tr>
							
							<tr>
							<td>Sunday</td>
							<td><label class="container2">
                    <input type="checkbox" name="sundaycheck" '.$sundaycheck.'>
                    <span class="checkmark"></span> 
                </label></td>
			
							</tr>
							
							
							<tr>
							
								<td >Weekday Open:<input type="us-time" name="weekopening1" value="'.$weeko.'" placeholder="Opening Time" required></td><td>Weekday Close:
				<input type="us-time" name="weekclosing1" value="'.$weekc.'" placeholder="Closing Time"  required></td>
							</tr>
							
							
							
							<tr>
							
								<td >Weekend Open:<input type="us-time" name="weekendopening2" value="'.$weekendo.'" placeholder="Opening Time" required></td><td>Weekend Close:
				<input type="us-time" name="weekendclosing2" value="'.$weekendc.'" placeholder="Closing Time"  required></td>
							</tr>
							</table>
							<input type="submit" value="Save">
							</form>
							</div>
							
							<div id="address"><br><br>';
							
							if(isset($_SESSION['addressmsg'])){
							echo'<h3 >'.$_SESSION['addressmsg'].'</h3>';
							
							    
							    unset($_SESSION['addressmsg']);
							}
					echo'<table>
<th>Store Address</th>

</table>


<form action="Backend/updateaddress.php" method="post"  enctype="multipart/form-data">Address:<input type="text" id="street-address" name="street-address" value="'.$row['Address'].'" required><br>	
					Unit:<input type="text" id="unit" value="'.$row['Unit'].'" name="unit"><br>	
					City:<input type="text" id="city" name="city" value="'.$row['City'].'" required><br>
					State:<input type="text" id="state" value="'.$row['State'].'" name="state" required><br>
					Zip:<input type="text" id="zip" value="'.$row['Zip'].'" name="zip" required><br>
					
						<br>
					<input type="submit" value="Save">
					</form></div>';
								
					
					
							
							echo'<div id="deletediv" style="display:none; padding-top:20%;">';
								
									if($row['Balance'] > 0){
								
								echo'You must transfer your remaining balance to your Stripe account before deleting your account.';
								
								}else{
						
								echo'
								Are you sure you want to delete your '.$contactinf['Name'].' profile?
								<br><Br>
								<form method="post" action="Backend/deleteaccount.php">
								<input type="hidden" name="ID" value="'.$row['ID'].'">
								<input type="submit" value="Delete">
								
								
							</form>
							';
									}
								echo'</div><br><br>';
							
							
							echo'<div id="deletediv2" style="display:none; padding-top:20%;">';
								
								if($row['Balance'] > 0){
								
								echo'You must transfer your remaining balance to your Stripe account before removing this location.';
								
								}else{
								    
								echo'Are you sure you want to remove this location?
								<br><Br>
								<form method="post" action="Backend/removelocation.php">
								<input type="hidden" name="ID" value="'.$row['ID'].'">
								<input type="submit" value="Delete">
								
								
							</form>';
							
								}
								
								
								
								
								
								echo'</div><br><br>';	
							
							
								
								?>
								
							
					

			
<script>

function showd(){

	document.getElementById("deletediv").style.display = "block";
	document.getElementById("dbut").style.display = "none";
}

function showd2(){

	document.getElementById("deletediv2").style.display = "block";
	document.getElementById("dbut2").style.display = "none";
}


</script>
			</td></tr></table>
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
			
			
			</div>
<!--<script type="text/javascript">
var month = (new Date()).getMonth() + 1;
var year  = (new Date()).getFullYear();

// US Format
$('input[type=us-date]').w2field('date');
$('input[type=us-dateA]').w2field('date', { format: 'm/d/yyyy', start:  month + '/5/' + year, end: month + '/25/' + year });
$('input[type=us-dateB]').w2field('date', { format: 'm/d/yyyy', blocked: [ month+'/12/2014',month+'/13/2014',month+'/14/' + year]});
$('input[type=us-date1]').w2field('date', { format: 'm/d/yyyy', end: $('input[type=us-date2]') });
$('input[type=us-date2]').w2field('date', { format: 'm/d/yyyy', start: $('input[type=us-date1]') });
$('input[type=us-time]').w2field('time',  { format: 'h12' });
$('input[type=us-timeA]').w2field('time', { format: 'h12', start: '8:00 am', end: '4:30 pm' });
$('input[type=us-datetime]').w2field('datetime');

// EU Common Format
$('input[type=eu-date]').w2field('date',  { format: 'd.m.yyyy' });
$('input[type=eu-dateA]').w2field('date', { format: 'd.m.yyyy', start:  '5.' + month + '.' + year, end: '25.' + month + '.' + year });
$('input[type=eu-dateB]').w2field('date', { format: 'd.m.yyyy', blocked: ['12.' + month + '.' + year, '13.' + month + '.' + year, '14.' + month + '.' + year]});
$('input[type=eu-date1]').w2field('date', { format: 'd.m.yyyy', end: $('input[type=eu-date2]') });
$('input[type=eu-date2]').w2field('date', { format: 'd.m.yyyy', start: $('input[type=eu-date1]') });
$('input[type=eu-time]').w2field('time',  { format: 'h24' });
$('input[type=eu-timeA]').w2field('time', { format: 'h24', start: '8:00 am', end: '4:30 pm' });
$('input[type=eu-datetime]').w2field('datetime', { format: 'dd.mm.yyyy|h24:mm' });



</script>
<script>
        CreateDateFilter('date', {
                formatMessage: 'Please type date %s'
                , onblur: function (target) {
                    if (target.value == target.defaultValue)
                        return;
                    document.getElementById('date').innerHTML = target.value;
                }
                , min: new Date((new Date()).toString()).toISOString().match(/^(.*)T.*$/i)[1]//'2006-06-27'//10 years ago
               
                , dateLimitMessage: 'Invalid Date: Please verify that the date that you entered has not already past '
            }
        );
    </script>-->
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