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
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		
		<style>
.btn {
  background-color: #8ebebc;
  border: none;
  color: white;
  padding: 12px 16px;
  font-size: 25px;;
  cursor: pointer;
}

/* Darker background on mouse-over */
.btn:hover {
  background-color: red;
}
</style>
		
					<script src="http://code.jquery.com/jquery-latest.min.js"></script>
		<script>

function validateForm() {
    


var pname = document.getElementById("product").value;


var neval = new Array();
    
    <?php 
    
    $sql = "SELECT * FROM Products WHERE Laundromat = '".$row['ID']."' AND Active = 'True' ";
$result = mysqli_query($mysqli, $sql);
    
    	while($row4 = $result->fetch_assoc()) {
    echo'neval.push("'.$row4['Product_name'].'");';
    	}
    
    ?>



if(neval.includes(pname) == true){
    
    alert("This product name already exist. Please choose another name.");
    
    return false;
}




var file= document.getElementById('fileToUpload').files[0].name;
       var reg = /(.*?)\.(jpg|jpeg|png|gif|GIF|PNG|JPEG|JPG)$/;
       if(!file.match(reg))
       {

event.preventDefault();
    	   alert("Invalid File Type");
    	   return false;
       }else{

document.getElementById("myForm2").submit();
}


}

</script>
<script>



	function validateForm2() {

		var pname2 = document.getElementById("oname").value;

		var neval2 = new Array();
	    
	    <?php 
	    
	    $sql = "SELECT * FROM Options WHERE LaundromatID = '".$row['ID']."' AND Active = 'True' ";
	$result = mysqli_query($mysqli, $sql);
	    
	    	while($row4 = $result->fetch_assoc()) {
	    echo'neval2.push("'.$row4['Name'].'");';
	    	}
	    
	    ?>



	if(neval2.includes(pname2) == true){
	    
	    alert("This option name already exist. Please choose another name.");
	    
	    return false;
	}


}


</script>

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
    font-size:100%;
   width:50%;
   background:white;
   vertical-align:middle;
   border-radius: 0.35em;
   padding-left:5%;
}
.quantity input {
    border: 0;
    text-align:center;
vertical-align:middle;
}

		
		
		.quantity2 {
    border: solid 1px rgba(0, 0, 0, 0.15);
    font-size:100%;
   padding-left:5%;
   background:white;
   vertical-align:middle; 
   border-radius: 0.35em;
}
.quantity2 input {

width:70%;
    border: 0;
    text-align:center;
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
								<li><a href="orders.php" id="portfolio-link"style="color:white;"><span >Pending Orders</span></a></li>
								
								
								<li><a href="products.php" id="contact-link"style="color:white;"><span ><img src="../images/app-logo-transparent.png" style="width:10%;" alt="" />Products</span></a></li>
							
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
					<section id="portfolio" class="two" >	<table style="width:100%; margin:0; padding:0; width:100%;  top:0; position:fixed; min-height:60px;">
					    
					    <th style="color:white; font-size:100%;  background: #44525a; text-align:center; height:60px;">Products</th>
					    
					    <tr>
					    <td>
<div class="container" style="text-align:left;  padding:0; margin-top:-0.5%; width:100%;  min-height:450px; width:100% !important; ">
						
						
						
						
																		<script>

					 $(function() {
						  $("form.confirmp").submit(function(event) {
						    event.preventDefault(); // Prevent the form from submitting via the browser
						    var form = $(this);
						    $.ajax({
						      type: "post",
						      url: "Backend/accountconfirmpassword-products.php",
						      data: form.serialize()
						    }).done(function(data) {
						      // Optionally alert the user of success here...
						  
						$("#ajaxModal").load("Backend/redirectaccountconfirmpassword-products.php");
    
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
						
						

require_once 'includes/Mobile-Detect-master/Mobile_Detect.php';
	$detect = new Mobile_Detect;
if($detect->isMobile()) {
	

		echo'<div class="container" style="text-align:left;  padding:0; min-height:450px; margin-top:5%; width:100%;  min-height:450px; width:100% !important; ">';
	
}else{
	
		echo'<div class="container" style="text-align:left;  padding:0; margin-top:-0.5%; width:100%;  min-height:450px; width:100% !important; ">';

}

		echo'<header id="pducts"><br><Br>
						<h3 style="text-align:center; font-weight:bold;">Add Product</h3>
						</header>';


                            if(isset($_SESSION['sm'])){
                                
                                echo'<h4>'.$_SESSION['sm'].'</h4>';
                                
                                unset($_SESSION['sm']);
                            }
                            
                            if(isset($_SESSION['rm'])){
                                
                                echo'<h4>'.$_SESSION['rm'].'</h4>';
                                
                                unset($_SESSION['rm']);
                            }
                            
						echo'<form method="post"  enctype="multipart/form-data" onsubmit="return validateForm()"   action="Backend/addproduct.php">
						<table style="margin-left:5%; margin-right:5%;">
						
						<tr>
						<td>Product Name:</td>';
						
						
						if($detect->isMobile()) {
						echo'<td><input type="text"  name="product" id="product" style="width:50%;"  required></td>';
						
						}else{
						    
						   	echo'<td><input type="text" name="product"  id="product" style="width:50%;"  required></td>'; 
						    
						}
						
						echo'</tr>
						
						<tr>
						<td>Price:</td>';
						
						if($detect->isMobile()) {
							
							echo'<td><div class="quantity">$<input type="number" style="width:47%;" name="pricep" min="0.01" step="0.01"  required /></div></td>';
						}else{
							
						
						echo'<td> <div class="quantity">$<input type="number" style="width:48.5%;" name="pricep" min="0.01" step="0.01"  required /></div></td>';
						
						}
						
							echo'</tr>
							
							
							<tr>
							<td>Quantity Type:</td>
							
							<td>
							<select style="width:50%;" name="qtype" required>
							<option value="Item">Individual Item</option>
							<option value="Pound">Per Pound</option>
							</select>
							
							</td>
							</tr>
							
							<tr>
						<td>Product Image:</td>
						<td><input type="file" name="fileToUpload" id="fileToUpload" accept="image/*" capture="camera" required></td>
							</tr>
						
						
					
						
						
					<!--		<tr>
						<td>Short Description:</td>
						<td><input type="text" name="desc" required></td>
							</tr>  -->
						
						<tr>
						<td colspan="2"><input type="submit" value="Add Product" style="font-size:80%;"></td>
						</tr>
						</table>
						</form>';
						
						
						
						
						echo'<div id="plist"><header ><br><Br>
						<h3 style="text-align:center; font-weight:bold;">My Products</h3>
						</header>';
						
						
						if(isset($_SESSION['productmsg'])){
						    
						    echo'<h3>'.$_SESSION['productmsg'].'</h3>';
						    unset($_SESSION['productmsg']);
						}
						 
						
						$sqlrecent = "SELECT * FROM Products WHERE Laundromat ='".$row['ID']."'AND Active = 'True' ";
$resultrecent = mysqli_query($mysqli, $sqlrecent);
						
							if ($resultrecent->num_rows > 0) {
							    echo'<table>
						
						<th>Name</th><th>Price</th><th>Remove</th>';
							    
								while($row4 = $resultrecent->fetch_assoc()) {
						
									
									echo'<script>
									
							function showdiv'.$row4['ID'].'(){
									
									
									var elements =	document.getElementsByClassName("optionb");
										 for(var i = 0, length = elements.length; i < length; i++) {
      
          												elements[i].style.display = "none";
       
    																				}

	document.getElementById("'.$row4['ID'].'").style.display = "block";

									}
									
									</script>';
									
									
									
						echo'<tr style="border-top:solid;">
						
						<td >'.$row4['Product_name'].'</td>
						<td style="width:40%;">$'.$row4['Price'].' /'.$row4['Type'].'</td>

						

					    <td ><form method="post" action="Backend/removep.php">
					    <input type="hidden" name="pid" value="'.$row4['ID'].'">';
					    
					    				require_once 'includes/Mobile-Detect-master/Mobile_Detect.php';
$detect = new Mobile_Detect;

	
	    
					    echo'<button type="submit" class="btn" value="Remove" ><i class="fa fa-trash"></i></button>



						 </form></td>
						
						</tr>
<tr >
<td colspan="3">



<button style="font-size:70%;"  onclick="showdiv'.$row4['ID'].'()">Add Option</button>';
					    
					    
					    $sqlo = "SELECT * FROM Options WHERE ProductID ='".$row4['ID']."' AND LaundromatID ='".$row4['Laundromat']."' AND Active = 'True'";
					    $roworesults= mysqli_query($mysqli, $sqlo);
					    
					    if ($roworesults->num_rows > 0) {
					    	
					    	echo'<br><br><table style="width:100%;">';
					    	
					    	while($rowo = $roworesults->fetch_assoc()) {

echo'<form method="post" action="Backend/removeoption.php" enctype="multipart/form-data">

<input type="hidden" name="oid" value="'.$rowo['ID'].'">

<tr >
<td>- '.$rowo['Name'].'</td>
<td>$'.$rowo['Price'].'</td>';


	
	echo'<td><button type="submit" class="btn" value="Remove"  /><i class="fa fa-trash"></i></button<</td>';
	


echo'</tr>

</form>';


					    	}
					    	echo'</table>';
					    }


echo'<div id="'.$row4['ID'].'" style="display:none;"  class="optionb"><br>
<h3>Add Extra Option</h3><form method="post" action="Backend/saveoption.php" enctype="multipart/form-data" onsubmit="return validateForm2()">

<input type="hidden" name="productid" value="'.$row4['ID'].'">
';
					    if($detect->isMobile()) {
					    	
					    	echo'<br>
<table>
<tr><td>Name:</td> <td><input type="text" id="oname" name="oname" placeholder=""  required></td></tr>
<tr><td >Price:</td><td><div class="quantity2">$<input type="number" name="pricep" min="0.01" step="0.01"  required /></div></td></tr>
<tr><td></td><td ><input type="submit" value="Save" style="font-size:100%;"></td></tr>
</table>
';
					    	
					    	
					    }else{
					    
echo'
<table>
<tr>

<td >Name<br><input type="text" id="oname" name="oname" placeholder="" style="font-size:70%;" required></td>
<td>Price<br><div class="quantity2">$<input type="number"  name="pricep" min="0.01" step="0.01"  required /></div></td>
<td style="vertical-align:bottom;"><input type="submit" value="Save" style="font-size:70%;"></td>

</tr>
</table>
';


					    }

echo'</form></div>

</td>
</tr>


';
						
						
								}
								echo'	</table>';
								
							}else{	
							echo'You have not added a product yet.';	
							}
						
						
						
						
						
						
						
				?>			


</div>

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