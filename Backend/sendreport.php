<?php

include_once("../LoginSystem/cooks.php");
//session_start();
include_once('../LoginSystem/db.php');
include_once '../includes/db_connect.php';
include_once '../includes/functions.php';
require_once('../includes/stripe-php-master/init.php');
require_once '../Libraries/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../includes/PHPMailer-master/src/Exception.php';
require '../includes/PHPMailer-master/src/PHPMailer.php';
require '../includes/PHPMailer-master/src/SMTP.php';



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


if(isset($_SESSION['passconfirm'])){
	
	unset($_SESSION['passconfirm']);
}



$sql = "SELECT * FROM Laundromat WHERE ID = '".$_GET['laundromatID']."' ";
$row= mysqli_query($mysqli, $sql);
$row= mysqli_fetch_assoc($row);




$mind = date('m/d/Y', strtotime($_GET['mindate']));
$maxd = date('m/d/Y', strtotime($_GET['maxdate']));

$mind2 = date('Y-m-d', strtotime($_GET['mindate']));
$maxd2 = date('Y-m-d', strtotime($_GET['maxdate']));


$pdfhtml = '<style>
		
table{
width:100%;
}
tr{
height:40px;
}
		
td, th{
text-align:center;
font-size:80%;
height:40px;
		
}
</style><div style="text-align:center;">';


if($_GET["report"] == "transfers"){			//transfers
	
	$stattrip = "Recent Payment Transfers";
	
	$sql ="SELECT * FROM Laundromat_Transfer_History WHERE UserID = '".$row['ID']."'  AND (`Date` BETWEEN '".$mind2."' AND  '".$maxd2."') ORDER BY Date, Time";
	$result = mysqli_query($mysqli, $sql);
	
	
	if ($result->num_rows > 0) {
		
		
		$pdfhtml = $pdfhtml.'<img width="50" height "50" src="images/delivrmat.png" style="display:block; text-align:center; margin-right: auto; margin-left:auto; ">
<h2>'.$contactinf['Name'].' Payment Transfers</h2>
<table style="width:100%; text-align:center">
<tr><td colspan="3">Laundromat: '.$row['Name'].'</td></tr>
<tr><td colspan="3">Date: '.$mind.' - '.$maxd.'</td></tr></table>
<br>

<div style="width:100%; border-bottom:solid;"></div>



<table><tr><th>Date</th>
<th>Time</th>
<th>Amount</th></tr>';
		
		
		while($rowtable = $result->fetch_assoc()) {
			
			$rowtable['Time'] = date('g:i A', strtotime($rowtable['Time']));
			$rowtable['Date'] = date('m/d/Y', strtotime($rowtable['Date']));
			
			
			
			$rowtable['Amount'] = number_format($rowtable['Amount'], 2);
			
			
			$pdfhtml = $pdfhtml.'<tr>
					
					<td>'.$rowtable['Date'].'</td>
					<td>'.$rowtable['Time'].'</td>
					<td>$'.number_format($rowtable['Amount'], 2).'</td>
							
				</tr>';
			
		}
		
		$pdfhtml = $pdfhtml.'</table>';
	}else{
		
		$pdfhtml = $pdfhtml.'There were zero transfers initiated by '.$row['Name'].' between '.$mind.' and '.$maxd.'. ';
		
	}
	
}else if($_GET["report"] == "orders"){			//orders
	
	$stattrip = "Recent Orders";
	
	
	$sql ="SELECT * FROM OrderGroup  WHERE  Laundromat_ID = '".$row['ID']."' AND (`Date` BETWEEN '".$mind2."' AND  '".$maxd2."') ORDER BY Date, Pickup_Time";
	$results= mysqli_query($mysqli, $sql);
	
	
	
	if ($results->num_rows > 0) {
		
		
		$pdfhtml = $pdfhtml.'<img width="50" height "50" src="images/delivrmat.png" style="display:block;  text-align:center; margin-right: auto; margin-left:auto;">
<h2>'.$contactinf['Name'].' Laundromat Report</h2>
<table style="width:100%; text-align:center">
<tr><td colspan="3">Laundromat: '.$row['Name'].'</td></tr>
<tr><td colspan="3">Date: '.$mind.' - '.$maxd.'</td></tr></table>
<br>
<div style="width:100%; border-bottom:solid;"></div>

<table><tr><th>Order #</th><th>Date</th><th>Time</th><th>Customer</th><th>Delivery</th><th>Items</th><th>Delivery Fee</th><th>Sales Tax</th><th>Min Service Fee</th><th>'.$contactinf['Name'].' Fee</th><th>Laundromat Fee</th><th>Discount</th><th>Total Price</th></tr>';
		
		
		while($rowtable = $results->fetch_assoc()) {
			
			
			
			$sql = "SELECT * FROM users WHERE id = '".$rowtable['UserID']."' ";
			$result = mysqli_query($mysqli, $sql);
			$userinfo = mysqli_fetch_assoc($result);
			
		
			$sqlp = "SELECT * FROM PromoCodes WHERE ID = '".$rowtable['PromoID']."' ";
			$resultp = mysqli_query($mysqli, $sqlp);
			$promo = mysqli_fetch_assoc($resultp);
				
				
				$rowtable['Date'] = date('m/d/y', strtotime($rowtable['Date']));
				$rowtable['Time'] = date('g:i A', strtotime($rowtable['Time']));
				
				
				$delivrmatfee =  $rowtable['DelivrmatFee'];
				$laundromatfee = $rowtable['LaundromatFee'];
				 
				
				
				$pdfhtml = $pdfhtml.'<tr>
<td>'.$rowtable['OrderNum'].'</td>
<td>'.$rowtable['Date'].'</td>
<td>'.$rowtable['Time'].'</td>
<td>'.$userinfo['First_Name'].' '.$userinfo['Last_Name'].'</td>
<td>'.$rowtable['Delivery'].'</td>
<td>$'.number_format($rowtable['ItemTotal'], 2).'</td>
<td>$'.number_format($rowtable['DeliveryTotal'], 2).'</td>
<td>$'.number_format($rowtable['SalesTax'], 2).'</td>
<td>$'.number_format($rowtable['ServiceFee'], 2).'</td>
<td>$'.number_format($delivrmatfee,  2).'</td>
<td>$'.number_format($laundromatfee,  2).'</td>
<td>'.$promo['Description'].'</td>
<td>$'.number_format($rowtable['TotalPrice'],  2).'</td>
		
				</tr>';
				
			
			
			
			
		}
		
		$pdfhtml = $pdfhtml.'</table>';
	}else{
		
		$pdfhtml = $pdfhtml.'There were zero orders completed by '.$row['Name'].' between '.$mind.' and '.$maxd.'. ';
		
	}
	
}
	
$pdfhtml = $pdfhtml.'</div>';
	

	$mpdf = new \Mpdf\Mpdf([
			'mode' => 'utf-8',
			//	'format' => [100, 200],
			'orientation' => 'P',
			'table_error_report' => false
	]);
	

	
	$pdflink = 'reports/'.rand().$row['id'].'.pdf';
	$pdflink2 = 'https://'.$_SERVER['SERVER_NAME'].'/Laundromats/'.$pdflink;
	
	$mpdf->AddPage();
	$mpdf->shrink_tables_to_fit=1;
	$mpdf->WriteHTML($pdfhtml);
	$mpdf->Output($pdflink,'F');
	
	
	
	

	
	
	$mail             = new PHPMailer(); // defaults to using php "mail()"
	
	
	
	
	$mail->AddReplyTo($contactinf['Email'],$contactinf['Name']);
	$mail->SetFrom($contactinf['Email'], $contactinf['Name']);
	$mail->AddReplyTo($contactinf['Email'],$contactinf['Name']);
	$address = $row['email'];
	$mail->AddAddress($row['email'], $row['Name']);
	
	$mail->Subject    = $contactinf['Name']." Laundromat | ".$stattrip." Report";
	
	
	$mail->isHTML(true);  
	$mail->Body    = "Your request has finished processsing. Your report is attached. <a href='".$pdflink2."' target ='_blank'>View Report</a>";
	$mail->AltBody = 'Your request has finished processsing. Your report is attached. <br>Link for report: '.$pdflink2;
	$mail->AddAttachment($pdflink);      // attachment

	
	
	if(!$mail->Send()) {
		
		$_SESSION['report'] = "There was an error sending your report. Please try again.";
		
	}else{
		
		$_SESSION['report'] = "Your report was successfully sent!";
		
	}

	
	header("Location: ../home.php");
	
	
?>

