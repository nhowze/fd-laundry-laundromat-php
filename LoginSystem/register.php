<?php
include_once("cooks.php");
//session_start();

	include_once("db.php");
	
	include '../includes/simple_html_dom.php';

	
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;
	
	require '../includes/PHPMailer-master/src/Exception.php';
	require '../includes/PHPMailer-master/src/PHPMailer.php';
	require '../includes/PHPMailer-master/src/SMTP.php';
	

	

	 $con=mysqli_connect($server, $db_user, $db_pwd,$db_name) //connect to the database server
	or die ("Could not connect to mysql because ".mysqli_error());
mysqli_query($con,"SET NAMES 'utf8'");
	mysqli_select_db($con,$db_name)  //select the database
	or die ("Could not select to mysql because ".mysqli_error());


$sqlct = "SELECT * FROM Contact WHERE ID = 5 ";
$contactinf = mysqli_query($con, $sqlct);
$contactinf = mysqli_fetch_assoc($contactinf);


//prevent sql injection
$username=mysqli_real_escape_string($con,$_POST["username"]);
$password=mysqli_real_escape_string($con,$_POST["password"]);
$email=mysqli_real_escape_string($con,$_POST["email"]);
$bname=mysqli_real_escape_string($con,$_POST["bname"]);
$cname=mysqli_real_escape_string($con,$_POST["cname"]);
$phone=mysqli_real_escape_string($con,$_POST["phone"]);
//check if user exist already
$query="select * from ".$table_name." where username='$username'";
$result=mysqli_query($con,$query) or die('error');
if (mysqli_num_rows($result))
  {
      
     $_SESSION['errormessage'] = "Error: Username already exist";
  echo'<script>location.href = "../register.php";</script>'; 
      
 die();
  }
  //check if user exist already
$query="select * from ".$table_name." where email='$email'";
$result=mysqli_query($con,$query) or die('error');
if (mysqli_num_rows($result))
  {
      
      $_SESSION['errormessage'] = "Error: Email address already exist";
  echo'<script>location.href = "../register.php";</script>';
      
      
die();

  }
  
	$activ_key = sha1(mt_rand(10000,99999).time().$email);
	
	if(phpversion() >= 5.5)
			{
				$hashed_password=password_hash($password,PASSWORD_DEFAULT);
			}
	else
			{
				$hashed_password = crypt($password,'987654321');   //Hash used to suppress  PHP notice
			}
	
			if($username != '' &&  $bname != '' && $cname != '' && preg_match('/^[\w-]+$/', $username)){
	$query="insert into ".$table_name."(username,password,email,activ_key,Name,Contact_Name,Phone,Terms) values ('$username','$hashed_password','$email','$activ_key','$bname','$cname','$phone','True')";
	
	$_SESSION['errormessage'] = "Your account has successfully been created. ";
	}else{
	
	     $_SESSION['errormessage'] = "Invalid Username";
  echo'<script>location.href = "../register.php";</script>'; 
	
	
	}

	
	if (!mysqli_query($con,$query))
	  {
		die('Error: ' . mysqli_error());

	  }

  
         
         //start email



$html = file_get_html("https://".$_SERVER['HTTP_HOST']."/Laundromats/Emails/registrationemailtemplate.php");


// first check if $html->find exists

$cells = $html->find('html');

if(!empty($cells)){
	
	
	foreach($cells as $cell) {


$mail             = new PHPMailer(); // defaults to using php "mail()"

//$body             = "<a href='".$pdflink2."' target ='_blank'>View Report</a>";
//$body             = preg_replace('/\.([^\.]*$)/i','',$body);


$mail->AddReplyTo($contactinf['Email'], $contactinf['Name']);
$mail->SetFrom($contactinf['Email'], $contactinf['Name']);
$mail->AddReplyTo($contactinf['Email'], $contactinf['Name']);
$address = $email;
$mail->AddAddress($email, $row['Name']);

$mail->Subject    = "Welcome to ".$contactinf['Name']."! | Laundromat Registration";;


$mail->isHTML(true);
$mail->Body = $cell->outertext;

//$mail->AddAttachment($pdflink);      // attachment


if(!$mail->Send()) {
	
//	echo("Error! Please try again.");
	
}else{
	
//	echo("Successfully sent!");
	
}


	}
	
	
}

//end email 
    
    
         
         
         
         echo'<script>location.href = "../login.php";</script>';
	 
?>