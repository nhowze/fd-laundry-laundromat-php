<?php
include_once("LoginSystem/cooks.php");
//session_start();

include_once 'includes/functions.php';
include_once('LoginSystem/db.php');

include 'includes/simple_html_dom.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'includes/PHPMailer-master/src/Exception.php';
require 'includes/PHPMailer-master/src/PHPMailer.php';
require 'includes/PHPMailer-master/src/SMTP.php';


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
	    
		<title><?php echo $contactinf['Name']; ?> | Laundromat Reset Password</title>
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
	
		<?php

$con=mysqli_connect($server, $db_user, $db_pwd,$db_name) //connect to the database server
or die ("Could not connect to mysql because ".mysqli_error());

mysqli_select_db($con,$db_name)  //select the database
or die ("Could not select to mysql because ".mysqli_error());

//prevent sql injection
$username = mysqli_real_escape_string($con,$_POST["username"]);
$email = mysqli_real_escape_string($con,$_POST["email"]);

$username = trim($username);
$email = trim($email);


    $query = "select * from " . $table_name . " where email='$email'";


$result = mysqli_query($con,$query) or die('error');
$row = mysqli_fetch_array($result);
//update user's activation key with new key
$re_activ_key = sha1(mt_rand(10000,99999).time().$email);
$activ_key = $row['activ_key'];

if (mysqli_num_rows($result)) {
    //Update the activation status to 2-Reset in progress and new activation key 
    $query = "update " . $table_name . "	 set activ_status='2' , activ_key='$re_activ_key' where  email='$email'";
    $result = mysqli_query($con,$query) or die('error');

  

$to = $row['email'];



         
 $subject = $contactinf['Name']." Reset Password";
         
    
  $message = "<h3>Hi ".$row['Name'] ."! </h3>
        <h3>Your account password has been reset</h3><br /> <a class=\"button\" href=\"https://".$_SERVER['HTTP_HOST']."/Laundromats/passwordresetform.php?k=$re_activ_key\"> Please Click to set a new password</a><br /> <br /> ";
           
        
      $bodencode = urlencode($message);

$html = file_get_html("https://".$_SERVER['HTTP_HOST']."/Laundromats/Emails/resetpasswordtemplate.php?message=".$bodencode);
         
           
           // first check if $html->find exists

$cells = $html->find('html');

if(!empty($cells)){
	
	
	foreach($cells as $cell) {
           
           
         $mail             = new PHPMailer(); // defaults to using php "mail()"
         
         
         
         $mail->AddReplyTo($contactinf['Email'], $contactinf['Name']);
         $mail->SetFrom($contactinf['Email'], $contactinf['Name']);
         $mail->AddReplyTo($contactinf['Email'], $contactinf['Name']);
         $address = $to;
         $mail->AddAddress($to, $row['First_Name']);
         
         $mail->Subject    = $subject;
         
         
         $mail->isHTML(true);
         $mail->Body    = $cell->outertext;
         
         
         
         
         
         if($mail->Send()) {
         	
         	$_SESSION['errormessage1'] = "Check your email in order to reset password.";
         	
         }
             
    	}
	}

        
  
} else {
    //echo json_encode( array('result'=>0,'txt'=>"User account doesn't Exist"));
    $_SESSION['errormessage'] = "The username or email is not associated with an account.";
echo'<script>location.href = "forgotpassword.php";</script>';
}
?>
	
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
								
								
								<li><a href="index.php" id="portfolio-link" style="color:white;"><span style="color:white;">Home</span></a></li>
								<li><a href="pricing.php" id="portfolio-link" style="color:white;"><span style="color:white;">Pricing</span></a></li>
								
								
								<li><a href="login.php" id="contact-link" style="color:white;"><span style="color:white;">Login</span></a></li>
								<li><a href="register.php" id="about-link" style="color:white;"><span >Sign Up</span></a></li>
							<!--	<li><a href="register.php" id="about-link" style="color:white;"><span style="color:white;">Sign Up</span></a></li>-->
								
								
								
							</ul>
						</nav>

				</div>

				<div class="bottom">

				

				</div>

			</div>

		<!-- Main -->
			<div id="main">

				

				<!-- Portfolio -->
					<section id="portfolio" class="two"><table style="width:100%;  top:0; position:fixed; min-height:60px; z-index: 2;"><th style="color:white; font-size:100%; background: #44525a; text-align:center;">Password Reset</th></table>
							<div class="container" style=" min-height:450px; margin-top:15%;">
									<header class="major">
										<h2></h2>
										</header>
										
			<?php




            echo"<h3 style='font-weight:bold;'>Check your email in order to reset password.</h3>";
        


?>
<br><br>
<a  href="login.php" class="button special" >Return to Login</a><br><br><br>
										
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