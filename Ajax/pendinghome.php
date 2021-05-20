<?php

include_once("../LoginSystem/cooks.php");
//session_start();
include_once('../LoginSystem/db.php');
include_once '../includes/db_connect.php';
include_once '../includes/functions.php';

 
$sql = "SELECT * FROM Laundromat WHERE email = '".$_SESSION['username']."' ";
$result = mysqli_query($mysqli, $sql);
$row = mysqli_fetch_assoc($result);

		
		
		
							$sqlrecent = "SELECT * FROM OrderGroup WHERE Laundromat_ID = ".$row['ID']." AND Status <> 'Rejected' AND Status <> 'Waiting Approval'  ORDER BY CASE Status 
WHEN  'Received'  THEN '0'
WHEN  'Approved'  THEN '1'
WHEN 'In Progress' THEN '2'
WHEN 'Laundry Complete' THEN '3'
WHEN 'Order Complete' THEN '4'
END,
Date DESC, Pickup_Time DESC";
$resultrecent = mysqli_query($mysqli, $sqlrecent);
							
							
								require_once '../includes/Mobile-Detect-master/Mobile_Detect.php';
$detect = new Mobile_Detect;
							
							echo'<table id="orders"><th colspan="2" style="color:white; text-align:center;">Orders</th>';
							
							
							
							if ($resultrecent->num_rows > 0) {
								while($row4 = $resultrecent->fetch_assoc()) {
								
									
									$sqluser = "SELECT * FROM users WHERE id = '".$row4['UserID']."' ";
									$resultuser = mysqli_query($mysqli, $sqluser);
									$rowuser = mysqli_fetch_assoc($resultuser);
									
									
							
							$dateform = date('m/d/Y', strtotime($row4['Date']));
							$timeformpick = date('h:i A',strtotime($row4['Pickup_Time']));
							$timeformdelivr = date('h:i A',strtotime($row4['Delivery_Time']));
							
							echo'<tr style="padding:0;">
						
						<td style="width:50%;" >
<ul class="actions" style="list-style-type:none; padding:0; ">


<li>'.$rowuser['First_Name'].' '.$rowuser['Last_Name'].'</li>
<li>Status: '.$row4['Status'].'</li>


</ul></td>
						<td style="width:50%;"><ul class="actions" style="list-style-type:none; padding:0;">


						<li>#: '.$row4['OrderNum'].'</li>
				        
						
<li><form action="orderdetail.php" method="get" enctype="multipart/form-data">
						<input type="hidden" name="orderID" value="'.$row4['OrderNum'].'">
						<button type="submit" class="btn"><i class="fa fa-search" > View Order</i></button>
						
						</form></li>';
						
							
						
						echo'</ul></td></tr>';
	
							
							
						}
						
						
							}
								echo'</table>';
								
								?>