<?php


include_once("LoginSystem/cooks.php");
//session_start();

include_once 'includes/db_connect.php';
include_once 'includes/functions.php';


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

$sqlct = "SELECT * FROM Contact WHERE ID = 5 ";
$contactinf = mysqli_query($mysqli, $sqlct);
$contactinf = mysqli_fetch_assoc($contactinf);

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
	    
		<title><?php echo $contactinf['Name']; ?> | Laundromat</title>
		
		
			<style>
		    
		    input[type="submit"],
	input[type="reset"],
	input[type="button"],
	.button {
	    padding-left:10px !important; 
	    padding-right:10px !important;
	    
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
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="assets/css/main.css" />
		
		
			<script>
		function validateForm() {

                        var password1 = document.forms["myForm"]["password"].value;
			var password2 = document.forms["myForm"]["cpassword"].value;

			var agreement = document.getElementById("agreement");


			if(!agreement.checked){

				alert("You must agree to <?php echo $contactinf['Name']; ?>'s terms and conditions before signing up for an account.");
				return false;
			}


if(password1 != password2){

alert("Passwords don't match");
return false;
}


}
</script>

	<style>
		    
		    input[type="submit"],
	input[type="reset"],
	input[type="button"],
	.button {
	    padding-left:10px !important; 
	    padding-right:10px !important;
	    
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
		<script src='https://www.google.com/recaptcha/api.js'></script>
	</head>
	<body class="is-preload">

		<!-- Header -->
			<div id="header" style="height:100%; min-height:800px;background: #44525a;">

				<div class="top">

					<!-- Logo -->
						<div id="logo">
							<img src="../images/app-logo-transparent.png" style="width:50%;" alt="" />
							<h1 id="title"><?php echo $contactinf['Name']; ?> <br>Laundromats</h1>
							
						</div>

					<!-- Nav -->
						<nav id="nav">
							<ul>
								
								<li><a href="index.php" id="portfolio-link" style="color:white;"><span >Home</span></a></li>
								<li><a href="pricing.php" id="portfolio-link" style="color:white;"><span >Pricing</span></a></li>
								
								
								<li><a href="login.php" id="contact-link" style="color:white;"><span >Login</span></a></li>
								
								<li><a href="register.php" id="about-link" style="color:white;"><span ><img src="../images/app-logo-transparent.png" style="width:10%;" alt="" />Sign Up</span></a></li>
								
							</ul>
						</nav>

				</div>

				<div class="bottom">

			

				</div>

			</div>

		<!-- Main -->
			<div id="main">

				

				<!-- Portfolio -->
					<section id="portfolio" class="two"><table style="width:100%;  top:0; position:fixed; min-height:60px; z-index: 2;"><th style="color:white; font-size:100%; background: #44525a; text-align:center;">Laundromat Sign Up</th></table>
						<div class="container" style=" min-height:450px; margin-top:5%;">
<br>
							<header>
								
									<h2 style="font-weight:bold;">Sign Up</h2>
								<h2><?php 

if(isset($_SESSION['errormessage'])){
echo'<h3>'.$_SESSION['errormessage'].'</h3>';



unset($_SESSION['errormessage']);

}
?></h2>
								
								
							</header>

						

						
							
							
								<form action="LoginSystem/register.php" method="post" name="myForm" id="register_form" enctype="multipart/form-data" onsubmit="return validateForm()">
										    
										    
										    <input type="text" name="bname" placeholder="Business Name"  required>
										    
										     <input type="text" name="cname" placeholder="Contact Name"  required>
										     
										    Phone number:  <input type="number" name="phone"  min="1000000000" max="9999999999"   required>
										      
										      
										    <input type="text" name="username" placeholder="Username" id="username" onchange="validate()" required>
										    
										    
										    
										    <input type="email" name="email" placeholder="Email" required>
										    
										    
										    <input type="password" name="password" placeholder="Password" required>
										    
										   <input type="password" name="cpassword" placeholder="Confirm Password" required>
										   
										   <?php echo'<a href="https://'.$_SERVER['HTTP_HOST'].'/legal/delivrmat-terms-conditions.php" target="_blank">Terms & Conditions</a><br>'; ?>
										   						   <label class="container2" style="display:inline;">
						
  <input type="checkbox"  name="agreement" id="agreement">
  <span class="checkmark"></span> I agree to the following terms and conditions.
</label>
										   
										     <div class="g-recaptcha" data-sitekey="6LeaHHMUAAAAAIRMM2QIa0O66VJO2RtY18oBsXqf" data-callback="enableBtn"></div>
										   
										   
										    <input type="submit" id="button1" value="Register" disabled>
										    
										    
										</form>
													<script>
function enableBtn(){
    document.getElementById("button1").disabled = false;
   }
</script>

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
			<script>

function validate(){

    var str = document.getElementById("username").value;
str = str.replace(/\s+/g, '-').toLowerCase();

document.getElementById("username").value = str;
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