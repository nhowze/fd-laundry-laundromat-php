<?php

include_once("../LoginSystem/cooks.php");
//session_start();
include_once '../includes/db_connect.php';
include_once '../includes/functions.php';
require_once '../Libraries/vendor/autoload.php';

include '../includes/simple_html_dom.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../includes/PHPMailer-master/src/Exception.php';
require '../includes/PHPMailer-master/src/PHPMailer.php';
require '../includes/PHPMailer-master/src/SMTP.php';

$sqlct = "SELECT * FROM Contact WHERE ID = 5 ";
$contactinf = mysqli_query($mysqli, $sqlct);
$contactinf = mysqli_fetch_assoc($contactinf);


$sqlnum = "SELECT * FROM OrderGroup WHERE ID = '".$_POST['oid']."' ";
$resultnum = mysqli_query($mysqli, $sqlnum);
$ordersummary = mysqli_fetch_assoc($resultnum);

$sql = "SELECT * FROM Laundromat WHERE email = '".$_SESSION['username']."' ";
$result = mysqli_query($mysqli, $sql);
$row = mysqli_fetch_assoc($result);


$sqlus = "SELECT * FROM users WHERE id = '".$ordersummary['UserID']."' ";
$resultus = mysqli_query($mysqli, $sqlus);
$rowus = mysqli_fetch_assoc($resultus);

 
$_SESSION['confirmtr'] = $ordersummary['ID'];


if($ordersummary['Status'] != "Order Complete"){


	
	
	
	if($_POST['confirm'] == $ordersummary['User_Code']){
		
		
		
		
		$ordersummary['User_CodeTimes'] = $ordersummary['User_CodeTimes'] + 0;
		
		
		$sqlord = "UPDATE OrderGroup SET User_CodeTimes = ".$ordersummary['User_CodeTimes'].", Status = 'Order Complete'  WHERE ID = '".$_POST['oid']."' ";
		$mysqli->query($sqlord);
		
		$_SESSION['confirmmessage'] = "The correct code was entered! Please transfer the laundry to ".$rowus['First_Name'].".";
		
		
		//update balance
		
	
		
		$balance = $row['Balance'] + $ordersummary['LaundromatFee'];
		
		
		$mysqli->query("UPDATE Laundromat SET Balance = ".$balance."  WHERE email = '".$_SESSION['username']."' ");
		//
		
		
		
		
		//send receipt
		
		
		$html = file_get_html("https://".$_SERVER['SERVER_NAME']."/Users/Emails/emailreceipt.php?orderID=".$ordersummary['OrderNum']);
		
		
		
		
		// first check if $html->find exists
		
		$cells = $html->find('html');
		
		if(!empty($cells)){
			
			
			foreach($cells as $cell) {
		
		
		$mail             = new PHPMailer(); // defaults to using php "mail()"
		
		//$body             = "<a href='".$pdflink2."' target ='_blank'>View Report</a>";
		//$body             = preg_replace('/\.([^\.]*$)/i','',$body);
		
		
		$mail->AddReplyTo($contactinf['Email'],$contactinf['Name']);
		$mail->SetFrom($contactinf['Email'], $contactinf['Name']);
		$mail->AddReplyTo($contactinf['Email'],$contactinf['Name']);
		$address = $rowus['email'];
		$mail->AddAddress($rowus['email']);
		
		$mail->Subject    = $contactinf['Name']." Receipt";
		
		
		$mail->isHTML(true);
		$mail->Body    = $cell->outertext;
	//	$mail->AddAttachment($pdflink);      // attachment
		
		
		
		if(!$mail->Send()) {
			
			//$_SESSION['report'] = "There was an error sending your report. Please try again.";
			
		}else{
			
			//$_SESSION['report'] = "Your report was successfully sent!";
			
		}
		
		
		
		
				
				
			//	echo $cell->outertext; 
				
				
			}
			
		}
		
		
		//end receipt
		
		
		
		
	}else{
		
		
		$ordersummary['User_CodeTimes'] = $ordersummary['User_CodeTimes'] + 1;
		
		
		$sqlord = "UPDATE OrderGroup SET User_CodeTimes = ".$ordersummary['User_CodeTimes']." WHERE ID = '".$_POST['oid']."' ";
		$mysqli->query($sqlord);
		
		$_SESSION['confirmmessage'] = "You have entered the wrong confirmation code.";
		
	}
	
	




}

?>