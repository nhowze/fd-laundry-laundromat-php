<?php require_once('../couch/cms.php'); 

include_once 'includes/db_connect.php';
//include_once("../Users/LoginSystem/cooks.php");
//session_start();


include_once 'includes/functions.php';
include_once('LoginSystem/db.php');


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
	  <cms:template title='Laundromat Home' order='7'>

</cms:template>
		<title><?php echo $contactinf['Name'];?> | Laundromat Portal</title>
		
		
		
		
						<?php 	
		
		echo'
<meta name="description" content="The '.$contactinf['Name'].' Laundromat Portal allows launromats to manage their laundry options(products), funds, delivery hours, and much more!">
<meta name="application-name" content="'.$contactinf['Name'].' Laundromat Portal">
<meta name="author" content="ICI Technologies LLC">
<meta name="keywords" content="Laundromat app,Laundromat portal,'.$contactinf['Name'].' laundromat,about '.$contactinf['Name'].' laundromat,'.$contactinf['Name'].',laundry app,laundry delivery app,laundry delivery,deliver laundry,laundry delivery service,delivery my laundry,laundry service,laundry pickup,pickup my laundry,
laundromat delivery service,laundromat app,laundromat pickup">';  


		$actual_link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";


echo'<!-- Twitter Card data -->
<meta name="twitter:title" content="'.$contactinf['Name'].' App" >
<meta name="twitter:card" content="summary" >
<meta name="twitter:site" content="@publisher_handle" >
<meta name="twitter:description" content="The '.$contactinf['Name'].' Laundromat Portal allows launromats to manage their laundry options(products), funds, delivery hours, and much more!" >
<meta name="twitter:creator" content="@author_handle" >
<meta name="twitter:image" content="https://'.$_SERVER['HTTP_HOST'].'/images/app-logo.png" >



<!-- Open Graph data -->
<meta property="og:title" content="'.$contactinf['Name'].' App" />
<meta property="og:url" content="'.$actual_link.'" />
<meta property="og:image" content="https://'.$_SERVER['HTTP_HOST'].'/images/app-logo.png" />
<meta property="og:description" content="The '.$contactinf['Name'].' Laundromat Portal allows launromats to manage their laundry options(products), funds, delivery hours, and much more!" /> 
<meta property="og:site_name" content="'.$contactinf['Name'].' Laundromat Portal" />';
		
		
		$sql = "SELECT * FROM SocialNetworks WHERE Social_Name = 'Laundromat' ";
$result = mysqli_query($mysqli, $sql);
$plugin = mysqli_fetch_assoc($result);
	echo($plugin['HTML']);
		
		?>
		
		
		
		
		
		
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="assets/css/main.css" />
	</head>
	<body class="is-preload">

		<!-- Header -->
			<div id="header">

				<div class="top">

					<!-- Logo -->
						<div id="logo">
							<img src="../images/app-logo-transparent.png" style="width:50%;" alt="" />
							<h1 id="title"><?php echo $contactinf['Name'];?> <br>Laundromats</h1>
							
						</div>

					<!-- Nav -->
						<nav id="nav">
							<ul>
								<li><a href="<?php echo "https://".$contactinf['Website'] ?>" id="top-link" style="color:white;"><span><?php echo $contactinf['Name'];?> Home</span></a></li>
								
								<li><a href="laundromatportal" id="portfolio-link" style="color:white;"><span><img src="../images/app-logo-transparent.png" style="width:10%;" alt="" />About Laundromat Portal</span></a></li>
								<li ><a href="faq" style="color:white;"><span>FAQ</span></a></li>
							<li><a href="#app" id="portfolio-link" style="color:white;"><span>Download Laundromat App</span></a></li>
								
							<li><a href="#pricing" id="portfolio-link" style="color:white;"><span>Pricing</span></a></li>
									
							</ul>
						</nav>

				</div>

				<div class="bottom">

					<!-- Social Icons -->
						<ul class="icons">
						
						

				</div>

			</div>

		<!-- Main -->
			<div id="main">

				<!-- Intro -->
				<?php 
				
				
				require_once 'includes/Mobile-Detect-master/Mobile_Detect.php';
				$detect = new Mobile_Detect;
				
				if($detect->isMobile()) {
					
					echo'<section id="top" class="one dark cover" style="background: URL(images/Laundry2.png); background-repeat: no-repeat;
    background-size: 100% 100%;">
						<div class="container">

<header>
								<h2 class="alt" style="color:black; font-weight:bold;">Learn about '.$contactinf['Name'].'\'s Laundromat Portal</h2>
								<!--<p style="color:black; font-weight:bold;">"'.$contactinf['Name'].' is a great way for laundromats to conect with potential customers."</p>-->

							<footer>';
					
				}else{
					
					echo'<section id="top" class="one dark cover" style="background: URL(images/launback.jpg); background-repeat: no-repeat;
    background-size: 100% 100%;">
						<div class="container" style="margin-top:5%;">

<header>
								<h2 class="alt" style="color:black; font-weight:bold;">Learn about '.$contactinf['Name'].'\'s Laundromat Portal</h2>
								<p style="color:black; font-weight:bold;">"'.$contactinf['Name'].' is a great way for laundromats to conect with potential customers."</p>
	    <ul class="actions special"  style="list-style-type:none;">
<li style="display:inline;"><a href="https://www.amazon.com/ICI-Technologies-LLC-Laundromat-Delivrmat/dp/B07K2B9966" target="_blank"><img src="images/amazon-appstore-badge-english-black.png" style="width:200px;"></a></li>
<li style="display:inline;"><a href="https://play.google.com/store/apps/details?id=com.brommko.android.laundromatDelivrmat" target="_blank"><img src="../images/playstore1.png" style="width:200px;"></a></li>
<li style="display:inline;"><a href="https://itunes.apple.com/gb/app/laundromat-delivrmat/id1426741546?mt=8" target="_blank"><img src="../images/appstore1.png" style="width:200px;"></a></li>

							</ul>
							<footer>';
				}
					
					
					if(isset($_SESSION['errormessage'])){
					
					echo'<h3 style="color:black; font-weight:bold;">'.$_SESSION['errormessage'].'</h3>';
					unset($_SESSION['errormessage']);
					}
					?>

							
							    

								
							</footer>

						</div>
					</section>
					
					<?php
					
			
				    
			echo'<section  class="two" id="app">
						<div class="container" >	
					<h3 style="font-weight:bold;">Download the Laundromat '.$contactinf['Name'].' app!</h3><br>
		    <ul class="actions special"  style="list-style-type:none;">
<li style="display:inline;"><a href="https://www.amazon.com/ICI-Technologies-LLC-Laundromat-Delivrmat/dp/B07K2B9966" target="_blank"><img src="images/amazon-appstore-badge-english-black.png" style="width:200px;"></a></li>
<li style="display:inline;"><a href="https://play.google.com/store/apps/details?id=com.brommko.android.laundromatDelivrmat" target="_blank" ><img src="../images/playstore1.png" style="width:200px;"></a></li>
<li style="display:inline;"><a href="https://itunes.apple.com/gb/app/laundromat-delivrmat/id1426741546?mt=8" target="_blank"><img src="../images/appstore1.png" style="width:200px;"></a></li>


							</ul>
				</div>';
				
				
				
				
				?>
							
							
				<!-- Portfolio -->
					<section id="portfolio" class="two">
						<div class="container">

							<header>
								<h2 style="font-weight:bold;">Benefits</h2>
							</header>

							<p>Check out the different benefits of joining <?php echo $contactinf['Name'];?>.</p>

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
					

				
				</section>
				<!-- About Me -->
				
					<section id="about" class="three">
						<div class="container" id="pricing">

							<header>
								<h2 style="font-weight:bold;">Laundromat Portal Pricing</h2>
							</header>

				
			<?php echo'<h4>Contact '.$contactinf['Name'].' for a quote today!<br></h4><a class="button" href="mailto:sales@'.$_SERVER['HTTP_HOST'].'">Request Quote</a>'; ?>


						</div>
					</section>
				
				
				
					<section id="about" class="three">
						<div class="container">

							<header>
								<h2 style="font-weight:bold;">About Me</h2>
							</header>

							<?php echo'<a href="#" class="image featured"><img src="https://'.$_SERVER['HTTP_HOST'].'/images/Dry+Cleaning+Pick+up+and+Delivery.jpeg" style="width:80%; margin-left:auto; margin-right:auto;" alt="" /></a>
							<p style="text-align:left;">Welcome to '.$contactinf['Name'].', the 
#1 laundry delivery service. '.$contactinf['Name'].' started off as a small laundry delivery service which originated in Birmingham, Alabama. We will pickup, wash and deliver back your laundry all with a click of a button.
"'.$contactinf['Name'].' connects users to laundromats near them."
</p>
'; ?>
						</div>
					</section>

			

			</div>

		<!-- Footer -->
			<div id="footer">
		<h3 style="font-weight:bold;">Download the Laundromat <?php echo $contactinf['Name'];?> app!</h3><br>
		    <ul class="actions special"  style="list-style-type:none;">
		    <li style="display:inline;"><a href="https://www.amazon.com/ICI-Technologies-LLC-Laundromat-Delivrmat/dp/B07K2B9966" target="_blank"><img src="images/amazon-appstore-badge-english-black.png" style="width:200px;"></a></li>
<li style="display:inline;"><a href="https://play.google.com/store/apps/details?id=com.brommko.android.laundromatDelivrmat" target="_blank" ><img src="../images/playstore1.png" style="width:200px;"></a></li>
<li style="display:inline;"><a href="https://itunes.apple.com/gb/app/laundromat-delivrmat/id1426741546?mt=8" target="_blank" ><img src="../images/appstore1.png" style="width:200px;"></a></li>
							</ul>
				<!-- Copyright -->
				
				    <?php
								echo'<!-- Social Icons -->
						<ul class="icons">
							<li><a href="'.$twitter.'" class="icon fa-twitter" target="_blank"><span class="label">Twitter</span></a></li>
							<li><a href="'.$facebook.'" class="icon fa-facebook" target="_blank"><span class="label">Facebook</span></a></li>
							<li><a href="'.$instagram.'" class="icon fa-instagram"><span class="label">Instagram</span></a></li>
							<li><a href="mailto:contactus@'.$_SERVER['HTTP_HOST'].'" class="icon fa-envelope"><span class="label">Email</span></a></li>
						</ul>'; ?>
				
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
<?php COUCH::invoke(); ?>