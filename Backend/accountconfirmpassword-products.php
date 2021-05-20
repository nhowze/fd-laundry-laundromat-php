<?php

include_once("../LoginSystem/cooks.php");
include_once '../includes/db_connect.php';
include_once '../includes/functions.php';

include_once("../LoginSystem/db.php");
 
$con=mysqli_connect($server, $db_user, $db_pwd,$db_name) //connect to the database server
or die ("Could not connect to mysql because ".mysqli_error());

mysqli_select_db($con,$db_name)  //select the database
or die ("Could not select to mysql because ".mysqli_error());



$sql = "SELECT * FROM Laundromat WHERE email = '".$_SESSION['username']."' ";
$result = mysqli_query($mysqli, $sql);
$row = mysqli_fetch_assoc($result);

//Pickup password to compare with encrypted password
$query="select password,email FROM Laundromat WHERE ID = '".$row['GroupID']."' ";
$result=mysqli_query($con,$query) or die('error');
$db_field = mysqli_fetch_assoc($result);
//3.3 $hashed_password=crypt($password,$db_field['password']);


$username=mysqli_real_escape_string($con,$db_field["email"]);
$password=mysqli_real_escape_string($con,$_POST["cpassword"]);


if(phpversion() >= 5.5)
{
	if(password_verify($password, $db_field['password']))
	{
		
		//once password is verified migrate to password_hash from crypt
		if(strlen($db_field['password']) < 60)
		{
			$hashed_password=password_hash($password,PASSWORD_DEFAULT);
			$query = "update " . $table_name . "	 set password='$hashed_password' where email='$username' and email='$db_field[email]'";
			//echo $query;
			$result = mysqli_query($con,$query) or die('error updating password hash');
		}
		
		$query="select * from ".$table_name." where email='$username'and activ_status in(1)";
		$result=mysqli_query($con,$query) or die('error');
		if(mysqli_num_rows($result))
		{
			
			//success
			$_SESSION['passconfirm'] = "success";
			
			
		}
		else
		{
			
			//   not activated
			
			$_SESSION['errormessage'] = "Error: User Account not yet activated.Check your mail for activation details.";
			echo'<script>location.href = "../login.php";</script>';
			
			
		}
		
	}
	else
	{
		
		
		$_SESSION['wrongpass'] = "Wrong Password";
		
		
	}
	
}
else
{
	$hashed_password=crypt($password,$db_field['password']);
	$query="select * from ".$table_name." where email='$username' and password='$hashed_password'";
	$result=mysqli_query($con,$query) or die('error');
	if (mysqli_num_rows($result))  //if passwords match then check actvation status
	{
		$query="select * from ".$table_name." where email='$username' and password='$hashed_password' and activ_status in(1)";
		$result=mysqli_query($con,$query) or die('error');
		if(mysqli_num_rows($result))
		{
			//success
			$_SESSION['passconfirm'] = "success";
			
			
		}
		else
		{
			//   not activated
			
			$_SESSION['errormessage'] = "Error: User Account not yet activated.Check your mail for activation details.";
			echo'<script>location.href = "../login.php";</script>';
		}
		
	}
	else
	{
		//wrong password
		
		$_SESSION['wrongpass'] = "Wrong Password";
		
	}
	
}












?>