<?php require_once('../couch/cms.php'); 
//include_once("../Users/LoginSystem/cooks.php");
//session_start();
include_once 'includes/db_connect.php';

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
	  <cms:template title='Laundromat FAQ' order='8'>

</cms:template>
		<title><?php echo $contactinf['Name']; ?> | Laundromat Frequently Asked Questions</title>
		
		
		
		
						<?php 	
		
		echo'
<meta name="description" content="The '.$contactinf['Name'].' Laundromat Portal allows launromats to manage their laundry options(products), funds, delivery hours, and much more!">
<meta name="application-name" content="'.$contactinf['Name'].' Laundromat Portal">
<meta name="author" content="ICI Technologies LLC">
<meta name="keywords" content="'.$contactinf['Name'].' laundromat faq,'.$contactinf['Name'].' laundromat frequently asked questions,Laundromat app,Laundromat portal,'.$contactinf['Name'].' laundromat,about '.$contactinf['Name'].' laundromat,'.$contactinf['Name'].',laundry app,laundry delivery app,laundry delivery,deliver laundry,laundry delivery service,delivery my laundry,laundry service,laundry pickup,pickup my laundry,
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
							<h1 id="title"><?php echo $contactinf['Name']; ?> <br>Laundromats</h1>
							
						</div>

					<!-- Nav -->
						<nav id="nav">
							<ul>
								<li><a href="<?php echo "https://".$contactinf['Website'] ?>" id="top-link" style="color:white;"><span><?php echo $contactinf['Name']; ?> Home</span></a></li>
								
								<li><a href="laundromatportal" id="portfolio-link" style="color:white;"><span>About Laundromat Portal</span></a></li>
								
								<li ><a href="faq" style="color:white;"><span><img src="../images/app-logo-transparent.png" style="width:10%;" alt="" />FAQ</span></a></li>
								
							<li><a href="laundromatportal#app" id="portfolio-link" style="color:white;"><span>Download Laundromat App</span></a></li>
								
							<li><a href="laundromatportal#pricing" id="portfolio-link" style="color:white;"><span>Pricing</span></a></li>
									
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


					

		
				
				
				
					<section id="about" class="three">
						<div class="container"><br>

							<header>
								<h2 style="font-weight:bold;">Frequently Asked Questions</h2>
							</header>

			
			<ul style="text-align:left;">
								<li><a href="#1">How long does it take for funds to transfer to my stripe account?</a></li>
									<li><a href="#2">How long does it take for funds to transfer from my stripe account to my bank account?</a></li>
									
									<li><a href="#3">What if a item of clothing is lost?</a></li>
									<li><a href="#4">What if we damage a item of clothing?</a></li>
							</ul>
			
			
			
			<div id="1" style=" text-align:left;">
			    <h2>How long does it take for funds to transfer to my stripe account?</h2>
			    
			    	<p>
							    Typically it takes 2 days for earned funds to become available in your Stripe Payment account. 
							</p>
							<h4>All Stripe accounts can have balances in two states:</h4>
							<ul>
							    <li><strong>pending</strong>, meaning the funds are not yet available to pay out</li>
							     <li><strong>available</strong>, meaning the funds can be paid out now</li>
							    
							</ul>
							
							<p>
							    The charged amount, less any Stripe fees, is initially reflected on the pending balance, and becomes available on a 2-day rolling basis. (This timing can vary by country and account.) Available funds can be paid out to a bank account or debit card. Payouts reduce the Stripe account balance accordingly.
							</p>
			    
			</div>
			
			
			<div id="2" style=" text-align:left;">
			    <h2>How long does it take for funds to transfer from my stripe account to my bank account?</h2>
			    
			    
			    <p>
			        To receive funds for payments you’ve processed, Stripe makes deposits (payouts) from your available account balance into your bank account. This account balance is comprised of different types of transactions (e.g., payments, refunds, etc.).
			        
			    </p>
			    
			    <p>
			        Payout availability depends on a number of factors such as the industry and country you’re operating in, and the risks involved. When you start processing live payments from your customers with Stripe, you will not receive your first payout until 7–10 days after your first successful payment is received. The first payout usually takes a little longer in order to establish the Stripe account. Subsequent payouts are then processed according to your account’s <a href="https://stripe.com/docs/payouts#payout-schedule" target="_blank" style="text-decoration:underline;">payout schedule</a>.
			        
			    </p>
			    
			    
			    <p>
			        You can view a list of all of your payouts and the date that they are expected to be received in your bank account in the <a target="_blank" href="https://dashboard.stripe.com/payouts" style="text-decoration:underline;">Dashboard</a>.
			        
			    </p>
			    
			    
			    
			</div>
			
			<div id="3" style=" text-align:left;">
			    <h2>What if a item of clothing is lost?</h2>
			    
			     <p>
						        If you wish to report a missing or stolen item, you must be able to provide a specific description of the
item such as the type of garment, brand, color, size. While we will investigate any claim of stolen or
missing items to the best of our ability, we do not offer any compensation for missing or stolen items.
As our partnering laundromats take care in individually handling and sorting garments, we find that
the vast majority of claims are in fact the fault of the customer misplacing or simply not including a
garment that they thought was in their laundry bag. We recommend including a detailed list of all items
in the bag which will be checked upon reaching one of our partnering laundromat’s facility if this is a
concern. This list will not be considered a formal form of inventory, but it will help us to identify the
items you include.
						        
						    </p>
						    
						    <p>
						        <?php echo $contactinf['Name']; ?>’s partnering laundromats carefully check all items for damages, contents, and total weight.
This happens before and after the wash-dry-fold and dry-cleaning process. We accept no financial
responsibility for any items left in the customer’s garments. We check for any items such as ink pens,
markers, highlighters, makeup, or other items which may cause serious damage to your garments but
accept no responsibility for damages that are caused by these items. The best way to ensure that
these damages never occur is to do what we do before you leave it in our care. Check each individual
item before putting it in the laundry or dry-cleaning bag; even if it doesn't have pockets. And also,
double check to make sure nothing other than your garments found its way into your laundry or dry
cleaning bag.
						        
						    </p>
						    
						    <p>
						        While we try as hard as we can to make our service as convenient for you as possible, we do not
accept responsibility for items lost or stolen if they are left for pickup or delivery at a pre-designated
area rather than a hand to hand exchange from customer to driver.
						        
						    </p>
			    
			</div>
			
			<div id="4" style=" text-align:left;">
			    <h2>What if we damage a item of clothing?</h2>
			    
			    	    <p>
						        <?php echo $contactinf['Name']; ?>’s partnering laundromats, individually inspect every item at their facility before and after they
are processed and do their best to find any items that may have been forgotten by a customer in
pockets or other areas of the laundry. However, <?php echo $contactinf['Name']; ?> – ICI Technologies LLC and <?php echo $contactinf['Name']; ?>’s
partnering laundromats are not responsible for any items left in pockets such as pens or other items
which may harm laundry during the washing or drying processes. Additionally, any items which are
purposely torn or damaged such as jeans, denim garments, etc. by the manufacturer of the garment
or the customer can never be included in any damage claim for any reason.
						        
						    </p>
						   
						    <p>
						        All of our partnering laundromats wash, dry and fold cycles use cold washes unless requested. This
means that we will never honor any claims of shrinking, color fading, or color blending. These are all
normal occurrences to some degree in all laundry processes and will never be considered a form of
damage by <?php echo $contactinf['Name']; ?> – ICI Technologies LLC or our partnering laundromats. Additionally, some stains
cannot be removed in a cold wash. We do not promise to remove any stain but make sure to
adequately spot treat any stain prior to washing and re-check the stain before drying.
						        
						    </p>
						    
						     <p>
						        There are some stains that do not appear until exposed to water or heat. Such stains typically have a
sugar base. Examples of such stains are alcohol and juices. These stains can be proved in a
laboratory. This testing is expensive, often in excess of $250. Should a stain damage claim be made,
<?php echo $contactinf['Name']; ?> - ICI Technologies LLC will send the item in question for laboratory testing. Should it be
determined that <?php echo $contactinf['Name']; ?> - ICI Technologies LLC or one of our partnering laundromats are
responsible for the stain damage in question, <?php echo $contactinf['Name']; ?> - ICI Technologies LLC will assume the testing
charge and make suitable remuneration for the item or items up to a combined value of $150. Should
the laboratory determine that the stain or discoloration is sugar based that was not apparent prior to
exposure to heat and/or water the customer assumes all responsibility for lab fees and will not be
remunerated for the damaged item. No garment will ever be sent for testing without the express written
consent of the customer and a fully refundable testing deposit of $250 be made by the
customer. Should the item be shown to have been damaged by <?php echo $contactinf['Name']; ?> - ICI Technologies LLC or
one of our partnering laundromats the testing deposit will be immediate refunded. <?php echo $contactinf['Name']; ?> - ICI
Technologies LLC and our partnering laundromats do not use sugar-based stains as an escape clause
for damaged items due to the ease with which an expert can identify the cause of a stain.
						        
						    </p>
						    
						     <p>
						        By putting any item into your laundry or dry-cleaning bags, you are guaranteeing ownership and
responsibility of that item. We highly recommend not including items that do not belong to you such
as your roommates’ or friends’ to avoid any conflict. If another party really needs a specific item to be
washed, have them set up a separate account.
						        
						    </p>
			    
			</div>
			

						</div>
					</section>

			

			</div>

		<!-- Footer -->
			<div id="footer">
		<h3 style="font-weight:bold;">Download the Laundromat <?php echo $contactinf['Name']; ?> app!</h3><br>
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
							<li><a href="mailto:'.$contactinf['Email'].'" class="icon fa-envelope"><span class="label">Email</span></a></li>
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