<?php

include_once("../LoginSystem/cooks.php");
//session_start();
include_once('../LoginSystem/db.php');
include_once '../includes/db_connect.php';
include_once '../includes/functions.php';

?>

<html>

<head>

				<style>
		

.quantity {
    border: solid 1px rgba(0, 0, 0, 0.15);
   
   width:100%;
   background:white;
   vertical-align:middle;
   border-radius: 0.35em;
   
   
}
.quantity input {
    border: 0;
    text-align:center;


vertical-align:middle;
}

		
		</style>

</head>

<body>



<?php 

if(isset($_SESSION['orderID'])){



}else{
	
	
}

$sql = "SELECT * FROM Laundromat WHERE email = '".$_SESSION['username']."' ";
$result = mysqli_query($mysqli, $sql);
$row = mysqli_fetch_assoc($result);




$sqlnum = "SELECT * FROM OrderGroup WHERE OrderNum = '".$_SESSION['orderID']."' ";
$resultnum = mysqli_query($mysqli, $sqlnum);
$ordersummary = mysqli_fetch_assoc($resultnum);



$sql = "SELECT * FROM users WHERE id = '".$ordersummary['UserID']."' ";
$confirm= mysqli_query($mysqli, $sql);
$confirm= mysqli_fetch_assoc($confirm);

		$odate = date('m/d/Y',strtotime($ordersummary['Date']));
						
						$firsttime = date('h:i A',strtotime($ordersummary['Pickup_Time']));
						
						
						$secondtime =  date('h:i A',strtotime($ordersummary['Delivery_Time']));

echo'<div id="actiondiv" style="width:100%; margin-right:auto; margin-left:auto;">';
		

if($ordersummary['Status'] != "Received"){
		
	echo'<script>
		
var Exist = document.getElementById("actionTable");
		
//alert(Exist);
		
function detailLoad() {
  location.reload();
}
		
		
if(Exist){
		
		
document.getElementById("actionTable").style.display = "none";
		
}
		
</script>';
	
	
}
	
if($ordersummary['Status'] != "Received"){
	
	echo'<script>
								
var Exist = document.getElementById("actionTable");
								
//alert(Exist);
								
function detailLoad() {
  location.reload();
}
								
								
if(Exist){
								
								
document.getElementById("actionTable").remove();
document.getElementById("containcheck").remove();								
}
								
</script>';
	
	
}




										
if($ordersummary['Status'] == "Received"){


	
	
	
	
		
		echo'<script>

var Exist1 = document.getElementById("actionTable");
var Exist2 = document.getElementById("containcheck");

//alert(Exist);

function detailLoad() {
  location.reload();
}


if(!Exist1 && !Exist2){


detailLoad();

}

</script>';
		
		
		
	
	
	
	echo'	<input type="submit" value="Start Laundry" onClick="this.style.display=\'none\'; ">
						</form>
						';
	
}else if($ordersummary['Status'] == "In Progress"){
	
	echo'
						<form  action="Backend/laundryfinishback.php" method="post" >
						<input type="hidden" name="oid" value="'.$ordersummary['ID'].'">
						<input type="submit" value="Laundry Finished" onClick="this.style.display=\'none\'; ">
						</form>
						';
	
	
}else if($ordersummary['Status'] == "Laundry Complete" && $ordersummary['Delivery'] == "False"){
	
	
	if(isset($_SESSION['confirmmessage'])){
		
		echo'<h4 style="color:red;">'.$_SESSION['confirmmessage'].'</h4>';
		unset($_SESSION['confirmmessage']);
	}
	
	echo'
						<form class="laundrytouser" id="laundrytouser" >
						<input type="hidden" name="oid" value="'.$ordersummary['ID'].'">
						<input type="text" name="confirm" autocomplete="off" placeholder="Confirmation Code" required><br>
						<input type="submit" value="Confirm Laundry Transfer to '.$ordersummary['Username'].'"  >
						</form>
						';
	
}else if($ordersummary['Status'] == "Laundry Complete" && $ordersummary['Delivery'] == "True"){
	
	
	echo'<h4>Wait for driver to pick up laundry.</h4>';
	
	
}
						    										
						    										
						    										
						$Phone = substr_replace($confirm['Phone'], "(", 0, 0);
						$Phone = substr_replace($Phone, ")", 4, 0);
						$Phone = substr_replace($Phone, "-", 8, 0);
						$Phone = substr_replace($Phone, " ", 5, 0);
						    										
						    										
						    										
						echo'
						    										</div>';
						    								
								
								
								
								
								
						?>
						</body></html>
						
						