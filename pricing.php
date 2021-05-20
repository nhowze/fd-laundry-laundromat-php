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
	    
		<title><?php echo $contactinf['Name']; ?> | Laundromat Login</title>
		
		
		
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
							
									
									
								<li><a href="index.php" id="portfolio-link" style="color:white;"><span >Home</span></a></li>
								<li><a href="pricing.php" id="portfolio-link" style="color:white;"><span ><img src="../images/app-logo-transparent.png" style="width:10%;" alt="" />Pricing</span></a></li>
								
								
								<li><a href="login.php" id="contact-link" style="color:white;"><span >Login</span></a></li>
								
								<li><a href="register.php" id="about-link" style="color:white;"><span >Sign Up</span></a></li>
									
									
							</ul>
						</nav>

				</div>

				<div class="bottom">

	

				</div>

			</div>

		<!-- Main -->
			<div id="main">

				

				<!-- Portfolio -->
					<section id="portfolio" class="two"><table style="width:100%;  top:0; position:fixed; min-height:60px; z-index: 2;"><th style="color:white; font-size:100%; background: #44525a; text-align:center;"><?php echo $contactinf['Name']; ?> Pricing</th></table>
						<div class="container" style=" min-height:450px; margin-top:10%;">

							

						
<img src="images/applogo.png" alt="Italian Trulli" style="width:30%;"><br><br>
			<h4>Contact <?php echo $contactinf['Name']; ?> for a quote today!<br></h4><a class="button" href="mailto:<?php echo $contactinf['Email']; ?>">Request Quote</a><br><br>
			
		

				

								<h2 style="font-weight:bold;">Benefits</h2>
							

							<p>Check out the different benefits of joining <?php echo $contactinf['Name']; ?>.</p>

							<div class="row">
								<div class="col-4 col-12-mobile">
									<article class="item">
										<a  class="image fit"><img src="images/potential.jpg" alt="" />
										
										<header>
											<h3>REACH MORE POTENTIAL CUSTOMERS!</h3>
										</header>
										</a>
										
									</article>
								
								</div>
								<div class="col-4 col-12-mobile">
									<article class="item">
										<a  class="image fit"><img src="images/inrevenue.png" alt="" />
										
										<header>
											<h3>INCREASE YOUR MONTHLY REVENUE!</h3>
										</header>
										
										
										</a>
										
									</article>
								
								</div>
								<div class="col-4 col-12-mobile">
									<article class="item">
										<a  class="image fit"><img src="images/storefront2.png" alt="" />
										<header>
											<h3>BRING THE BUSINESS RIGHT TO YOUR STORE FRONT!</h3>
										</header></a>
									</article>
									
								</div>
							</div>

						</div>
					</section>
			

			</div>

		<!-- Footer -->
			<div id="footer">
			    
			    <?php
			    
			    					    					require_once 'includes/Mobile-Detect-master/Mobile_Detect.php';
$detect = new Mobile_Detect;

	if(!$detect->isMobile()) {
			    
	echo'	<h2>Download the Laundromat '.$contactinf['Name'].' app!</h2><br>
		    <ul class="actions special"  style="list-style-type:none;">
<li style="display:inline;"><a href="https://play.google.com/store/apps/details?id=com.brommko.android.laundromatDelivrmat" target="_blank"><img src="../images/playstore1.png" style="width:200px;"></a></li>
<li style="display:inline;"><a href="https://itunes.apple.com/gb/app/laundromat-delivrmat/id1426741546?mt=8" target="_blank"><img src="../images/appstore1.png" style="width:200px;"></a></li>
							</ul>';
							
	}
							
							?>
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