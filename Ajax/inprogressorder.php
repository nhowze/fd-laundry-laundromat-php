<?php

include_once("../LoginSystem/cooks.php");
//session_start();
include_once '../includes/db_connect.php';
include_once '../includes/functions.php';

 
$sqlnum = "SELECT * FROM OrderGroup WHERE ID = '".$_SESSION['confirmtr']."' ";
$resultnum = mysqli_query($mysqli, $sqlnum);
$ordersummary = mysqli_fetch_assoc($resultnum);
?>


<html>
<head>

</head>
<body>

<?php 



if($ordersummary['Status'] == "Received"){
	
	
	echo'
						<form class="laundrystart" >
						<input type="hidden" name="oid" value="'.$ordersummary['ID'].'">
						<input type="submit" value="Start Laundry" onClick="this.style.display=\'none\'; ">
						</form>
						';
	
}else if($ordersummary['Status'] == "In Progress"){
	
	
	
	
	
	echo'
						<form class="laundryfinished" >
						<input type="hidden" name="oid" value="'.$ordersummary['ID'].'">
						<input type="submit" value="Laundry Finished" onClick="this.style.display=\'none\'; ">
						</form>
						';
	
	
}else if($ordersummary['Status'] == "Laundry Complete" && $ordersummary['Delivery'] == "False"){
	
	
	
	$sqlus = "SELECT * FROM users WHERE id = '".$ordersummary['UserID']."' ";
	$resultus = mysqli_query($mysqli, $sqlus);
	$rowus = mysqli_fetch_assoc($resultus);
	
	echo'<h3>Transfer Laundry To Customer</h3><br>';
	
	
	if(isset($_SESSION['confirmmessage'])){
		
		echo'<h4 style="color:red;">'.$_SESSION['confirmmessage'].'</h4>';
		unset($_SESSION['confirmmessage']);
	}
	
	echo'
						<form class="laundrytouser" >
						<input type="hidden" name="oid" value="'.$ordersummary['ID'].'">
						<input type="text" name="confirm" placeholder="Confirmation Code" autocomplete="off" required><br>
						<input type="submit" value="Confirm Laundry Transfer to '.$rowus['First_Name'].'"  >
						</form>
						';
	
}else if($ordersummary['Status'] == "Laundry Complete" && $ordersummary['Delivery'] == "True"){
	
	
	echo'<h4>Wait for driver to pick up laundry.</h4>';
	
	
}else{
	
	
	echo'<h4>Order Complete</h4>';
	
	
}





?>

</body>
</html>