<?php

include_once("../LoginSystem/cooks.php");
include_once '../includes/db_connect.php';
include_once '../includes/functions.php';

if(isset($_SESSION['passconfirm'])){
	
	 

	echo' <script>

window.location.href = "products.php";

</script>';
	
}


if(isset($_SESSION['wrongpass'])){
	
	
	echo''.$_SESSION['wrongpass'].'



';
	
	unset($_SESSION['wrongpass']);
}



?>