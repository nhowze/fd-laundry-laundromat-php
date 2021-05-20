<?php

include_once("../LoginSystem/cooks.php");
//session_start();
include_once('../LoginSystem/db.php');
include_once '../includes/db_connect.php';
include_once '../includes/functions.php';
 



$sql = "SELECT * FROM Laundromat WHERE email = '".$_SESSION['username']."' ";
$result = mysqli_query($mysqli, $sql);
$row = mysqli_fetch_assoc($result);




$sqlrecent = "SELECT * FROM OrderGroup WHERE Laundromat_ID = ".$row['ID']." AND Status = 'Waiting Approval' ORDER BY Date DESC, Pickup_Time DESC";
$resultrecent = mysqli_query($mysqli, $sqlrecent);


require_once '../includes/Mobile-Detect-master/Mobile_Detect.php';
$detect = new Mobile_Detect;

echo'<table>';

if ($resultrecent->num_rows > 0) {
	while($row4 = $resultrecent->fetch_assoc()) {
		
		if($detect->isMobile()) {
			$dateform = date('m/d/Y', strtotime($row4['Date']));
			$timeformpick = date('h:i A',strtotime($row4['Pickup_Time']));
			$timeformdelivr = date('h:i A',strtotime($row4['Delivery_Time']));
			
			echo'<tr >
					
					
					
					
						<td style="vertical-align:middle; ">
						<h4>'.$row4['Name'].'</h4>
						<p>Status: '.$row4['Status'].'
						<br>Date: '.$dateform.'
						<Br>Initial Pickup Time: '.$timeformpick.'
				        <Br>Delivery | Pickup Time: '.$timeformdelivr.'
				        		
				        		
				        		
						<Br</p>';
			
			
			if($row4['Status']  != "Approved"){
				
				echo'
						
						   <table >
						   <tr>
						    <td ><form action="Backend/accept.php" method="post">
						<input type="hidden" name="orderID" value="'.$row4['OrderNum'].'">
						
								<button type="submit" style="background:green; font-size:100%;"  class="btn"><i class="fa fa-check"></i></button>
						</form></td>
								
						<td >	<form action="Backend/decline.php" method="post">
						<input type="hidden" name="orderID" value="'.$row4['OrderNum'].'">
							<button type="submit" style="background:red; font-size:100%;"  class="btn"><i class="fa fa-trash"></i></button>
								
						</form></td>
						    </tr></table>
								
						    ';
			}else{
				echo'<form action="orderdetail.php" method="post" enctype="multipart/form-data">
						<input type="hidden" name="orderID" value="'.$row4['OrderNum'].'">
						<input type="submit" value="View Order">
								
						</form>';
				
			}
			
			echo'</td></tr>';
		}else{
			
			
			
			
			
			$dateform = date('m/d/Y', strtotime($row4['Date']));
			$timeformpick = date('h:i A',strtotime($row4['Pickup_Time']));
			$timeformdelivr = date('h:i A',strtotime($row4['Delivery_Time']));
			
			echo'<tr >
					
					
					
					
						<td style="vertical-align:middle; ">
						<h4>'.$row4['Name'].'</h4>
						<p>Status: '.$row4['Status'].'
						<br>Date: '.$dateform.'
						<Br>Initial Pickup Time: '.$timeformpick.'
				        <Br>Delivery | Pickup Time: '.$timeformdelivr.'
				        		
				        		
				        		
						<Br</p>
				        		
						</td>
						<td style="vertical-align:middle; width:30%;">';
			$stat = "Waiting Approval";
			
			if($row4['Status']  != "Approved"){
				
				
				echo'<form action="Backend/accept.php" method="post">
						<input type="hidden" name="orderID" value="'.$row4['OrderNum'].'">
						<button type="submit" style="background:green; font-size:100%;"  class="btn"><i class="fa fa-check"></i></button>
								
						</form>
						<br>
							<form action="Backend/decline.php" method="post">
						<input type="hidden" name="orderID" value="'.$row4['OrderNum'].'">
					
								<button type="submit" style="background:red;  font-size:100%;"  class="btn"><i class="fa fa-trash"></i></button>
						</form>';
				
			}else{
				
				
				echo'<form action="orderdetail.php" method="post">
						<input type="hidden" name="orderID" value="'.$row4['OrderNum'].'">
						<input type="submit" value="View Order">
								
						</form>';
				
				
			}
			
			
			echo'</td></tr>';
			
			
			
			
			
			
		}
		
		
	}
	
	
}else{
	
	echo'No Pending Orders';
	
	
}
echo'</table>';






?>