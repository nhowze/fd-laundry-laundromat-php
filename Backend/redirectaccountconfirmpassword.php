<?php

include_once("../LoginSystem/cooks.php");
include_once '../includes/db_connect.php';
include_once '../includes/functions.php';

if(isset($_SESSION['passconfirm'])){
	
	 

	echo' <script>

window.location.href = "account.php";       //this is pulled via ajax.. don\'t add ../

</script>';
	
}


if(isset($_SESSION['wrongpass'])){
	
	
	echo''.$_SESSION['wrongpass'].'



';
	
	unset($_SESSION['wrongpass']);
}



?>