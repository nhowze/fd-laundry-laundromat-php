<?php

include_once("../LoginSystem/cooks.php");

include_once '../includes/db_connect.php';
include_once '../includes/functions.php';

//session_start();


require_once('../includes/stripe-php-master/init.php');

function correctImageOrientation($filename) {
	if (function_exists('exif_read_data')) {
		$exif = exif_read_data($filename);
		if($exif && isset($exif['Orientation'])) {
			$orientation = $exif['Orientation'];
			if($orientation != 1){
				$img = imagecreatefromjpeg($filename);
				$deg = 0;
				switch ($orientation) {
					case 3:
						$deg = 180;
						break;
					case 6:
						$deg = 270;
						break;
					case 8:
						$deg = 90;
						break;
				}
				if ($deg) {
					$img = imagerotate($img, $deg, 0);
				}
				// then rewrite the rotated image back to the disk as $filename
				imagejpeg($img, $filename, 95);
			} // if there is some rotation necessary
		} // if have the exif orientation info
	} // if function exists
}

error_reporting(E_ERROR);


$sql = "SELECT * FROM Laundromat WHERE email = '".$_SESSION['username']."' ";
$result = mysqli_query($mysqli, $sql);
$row = mysqli_fetch_assoc($result);


$sql = "SELECT * FROM Laundromat WHERE GroupID = ".$row['GroupID']." AND AccountType = 'Main' ";
$result = mysqli_query($mysqli, $sql);
$maininf = mysqli_fetch_assoc($result);

if($row['AccountType'] == "Addon"){   
$_POST['email'] = $maininf['email']."@".$_POST['bname'];
$_POST['bname'] = $maininf['Name']." | ".$_POST['bname'];
}


if($row['Type'] == "Test"){

$sql2 = "SELECT * FROM `Keys` WHERE `ID` = 4 ";
$result2 = mysqli_query($mysqli, $sql2);
$keys = mysqli_fetch_assoc($result2);


$sql2 = "SELECT * FROM `Keys` WHERE `ID` = 8 ";
$result2 = mysqli_query($mysqli, $sql2);
$keys2 = mysqli_fetch_assoc($result2);
$subscription2 = $keys2['Key'];


}else{

$sql2 = "SELECT * FROM `Keys` WHERE `ID` = 12 ";
$result2 = mysqli_query($mysqli, $sql2);
$keys = mysqli_fetch_assoc($result2);


$sql2 = "SELECT * FROM `Keys` WHERE `ID` = 14 ";
$result2 = mysqli_query($mysqli, $sql2);
$keys2 = mysqli_fetch_assoc($result2);
$subscription2 = $keys2['Key'];

}




$sql = "SELECT * FROM Laundromat WHERE username = '".$_POST['username']."' AND ID <> ".$row['ID']." ";
$resultus = mysqli_query($mysqli, $sql);

$sql = "SELECT * FROM Laundromat WHERE email = '".$_POST['email']."' AND ID <> ".$row['ID']." ";
$resultem = mysqli_query($mysqli, $sql);




if ($resultus->num_rows == 0 && $resultem->num_rows == 0) {


if($row["AccountType"] == "Main"){

try {
	
	\Stripe\Stripe::setApiKey($keys['Key']);

	
	if($_POST['email'] != ""){
		\Stripe\Customer::update($row['Stripe_Customer_ID'], [
				'email' => $_POST['email'],
		]);
	}
	
}catch (Exception $e) {
	$error = $e->getMessage();
	
//	echo($error);
	
}
	
	
}
	
	

if($_FILES["fileToUpload"]["name"] != ""){




$tfname = "../laundryfiles/";

$target_dir = $_SERVER["DOCUMENT_ROOT"]."/Laundromats/laundryfiles/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$temp = explode(".", $_FILES["fileToUpload"]["name"]);
$newfilename = $tfname.round(microtime(true)) . '.' . end($temp);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
     //   echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
       
        $uploadOk = 0;
    }
}



// Check file size
if ($_FILES["fileToUpload"]["size"] > 50000000000) {
	echo "Sorry, your file is too large.";
	$uploadOk = 0;
}
 
 
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" && $imageFileType != "JPG" && $imageFileType != "PNG" && $imageFileType != "JPEG"
&& $imageFileType != "GIF") {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $newfilename)) {
    	correctImageOrientation($newfilename);

if($_POST['email'] == ""){
    
$email = "";
}else{
    
    $email = $_POST['email'];
}

if($_POST['phone'] == ""){
    
$phone = "";
}else{
    
    $phone = $_POST['phone'];
}


$tfname2 = str_replace("../","",$newfilename);

$mysqli->query("UPDATE Laundromat SET Profile_Pic = '".$tfname2."',email ='".$email."',Phone= '".$phone."', username = '".$_POST['username']."', Name = '".$_POST['bname']."', Contact_Name = '".$_POST['cname']."'   WHERE email = '".$_SESSION['username']."' ");
$mysqli->query("UPDATE Laundromat_Transfer_History SET Email = '".$email."' WHERE Email = '".$_SESSION['username']."' ");
$mysqli->query("UPDATE OrderGroup SET Name = '".$_POST['bname']."' WHERE Laundromat_ID = '".$row['ID']."' ");
$_SESSION['username'] = $email;


$oldfile = $row['Profile_Pic'];

if($oldfile != ""){
if (!unlink($oldfile))
  {
//  echo ("Error deleting $oldfile");
  }
else
  {
//  echo ("Deleted $oldfile");
  }

}



    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}

}else{
    
    
    
    if($_POST['email'] == ""){
    
$email = "";
}else{
    
    $email = $_POST['email'];
}

if($_POST['phone'] == ""){
    
$phone = "";
}else{
    
    $phone = $_POST['phone'];
}



    if($row['AccountType'] == "Main"){      //Update sub accounts
    
    
    
            //loop through each account, then explode string into two parts, then update accordingly
    
    $sqlsubs = "SELECT * FROM Laundromat WHERE GroupID = ".$row['GroupID']." AND AccountType = 'Addon'";
    
     
    $resultsubs = mysqli_query($mysqli, $sqlsubs);
    if ($resultsubs->num_rows > 0) {
        
								while($rowsubaccounts = $resultsubs->fetch_assoc()) {
    
  
    
    $namearray = explode( $maininf['Name'].' | ', $rowsubaccounts['Name']);
    $emailarray = explode( $maininf['email'].'@', $rowsubaccounts['email']);
    
   
    
    
    $newbname = $_POST['bname'].' | '.$namearray['1'];
    $newemailname = $_POST['email'].'@'.$emailarray['1'];
    
   // echo("UPDATE Laundromat SET email ='".$newemailname."', Name = '".$newbname."' WHERE ID = ".$rowsubaccounts['ID'].""."<Br>");
 
    $mysqli->query("UPDATE Laundromat SET email ='".$newemailname."', Name = '".$newbname."' WHERE ID = ".$rowsubaccounts['ID']."");
    
    
								}
								}
    
    }






    
$mysqli->query("UPDATE Laundromat SET email ='".$email."',Phone= '".$phone."', username = '".$_POST['username']."', Name = '".$_POST['bname']."', Contact_Name = '".$_POST['cname']."'    WHERE email = '".$_SESSION['username']."' ");
$mysqli->query("UPDATE Laundromat_Transfer_History SET Email = '".$email."' WHERE Email = '".$_SESSION['username']."' ");
$mysqli->query("UPDATE OrderGroup SET Name = '".$_POST['bname']."' WHERE Laundromat_ID = '".$row['ID']."' ");
    
    
    

    
    
    $_SESSION['username'] = $email;
    
    
    
}




}else if($resultus->num_rows > 0){
	
	
	$_SESSION['accountf'] = "The username you chose is already taken.";
	//echo($_SESSION['accountf']);
}else if($resultem->num_rows > 0){
	
	
	$_SESSION['accountf'] = "The email address you chose is already taken.";
	//echo($_SESSION['accountf']);
}


header('Location: ../account.php');
?>