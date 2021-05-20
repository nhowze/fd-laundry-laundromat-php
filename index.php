<?php

include_once("LoginSystem/cooks.php");
session_start();

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
	    
		<title><?php echo $contactinf['Name']; ?> | Laundromat Portal</title>
		

		
		
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
								
								
								<li><a href="index.php" id="portfolio-link" style="color:white;"><span ><img src="../images/app-logo-transparent.png" style="width:10%;" alt="" />Home</span></a></li>
								<li><a href="pricing.php" id="portfolio-link" style="color:white;"><span>Pricing</span></a></li>
								
								<li><a href="login.php" id="contact-link" style="color:white;"><span >Login</span></a></li>
								<li><a href="register2.php" id="about-link" style="color:white;"><span >Sign Up</span></a></li>
							<!--	<li><a href="register.php" id="about-link" style="color:white;"><span>Sign Up</span></a></li> -->
								
							</ul>
						</nav>

				</div>

				<div class="bottom">


				</div>

			</div>

		<!-- Main -->
			<div id="main">

				<!-- Intro -->
					<section id="top" style="background: #44525a; background: URL(images/Laundry2.png); background-repeat: no-repeat;
    background-size: 100% 100%;"><table style="width:100%;  top:0; position:fixed; min-height:60px; z-index: 2;"><th style="color:white; font-size:100%; background: #44525a; text-align:center;">Laundromat Portal</th></table>
						<div class="container" style="  margin-top:10%;">

							<header style="padding-top:10%;">
								<h2 class="alt" style="font-weight:bold; color: #44525a;">Welcome to <?php echo $contactinf['Name']; ?> Laundromat's Portal</h2>
								<?php 
								
								require_once 'includes/Mobile-Detect-master/Mobile_Detect.php';
								$detect = new Mobile_Detect;
								
						
								

								
							?>
								
							<footer>
							    
							    <?php
							    
							    					require_once 'includes/Mobile-Detect-master/Mobile_Detect.php';
$detect = new Mobile_Detect;


							    
							    
								echo'<a href="login.php" class="button scrolly">Login</a> &nbsp; &nbsp;
								<a href="register.php" class="button scrolly">Sign Up</a>';
								
							
								
								
								?>
								
							</footer>

						</div>
					</section>






				<!-- Portfolio -->
					<section id="portfolio" class="two">
						<div class="container">

							<header>
								<h2 style="font-weight:bold;">Benefits</h2>
							</header>

							<p>Check out the different benefits of joining <?php echo $contactinf['Name']; ?>.</p>

							<div class="row">
								<div class="col-4 col-12-mobile">
									<article class="item">
										<a  class="image fit"><img src="images/potential.jpg" alt="" />
										
										<header>
											<h3 style="font-weight:bold;">REACH MORE POTENTIAL CUSTOMERS!</h3>
										</header>
										</a>
										
									</article>
								
								</div>
								<div class="col-4 col-12-mobile">
									<article class="item">
										<a  class="image fit"><img src="images/inrevenue.png" alt="" />
										
										<header>
											<h3 style="font-weight:bold;">INCREASE YOUR MONTHLY REVENUE!</h3>
										</header>
										
										
										</a>
										
									</article>
								
								</div>
								<div class="col-4 col-12-mobile">
									<article class="item">
										<a  class="image fit"><img src="images/storefront2.png" alt="" />
										<header>
											<h3 style="font-weight:bold;">BRING THE BUSINESS RIGHT TO YOUR STORE FRONT!</h3>
										</header></a>
									</article>
									
								</div>
							</div>

						</div>
					</section>

				<!-- About Me -->
					<section id="about" class="three">
						<div class="container">

							<header>
								<h2 style="font-weight:bold;">About Me</h2>
							</header>

							<a href="#" class="image featured"><img src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/images/Dry+Cleaning+Pick+up+and+Delivery.jpeg" style="width:80%; margin-left:auto; margin-right:auto;" alt="" /></a>

							<p style="text-align:left;">Welcome to <?php echo $contactinf['Name']; ?>, the 
#1 laundry delivery service. <?php echo $contactinf['Name']; ?> started off as a small laundry delivery service which originated in Birmingham, Alabama. We will pickup, wash and deliver back your laundry all with a click of a button.
"<?php echo $contactinf['Name']; ?> connects users to laundromats near them."
</p>

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