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


$tfname = "../productfiles/";

$target_dir = $_SERVER["DOCUMENT_ROOT"]."/Laundromats/productfiles/";
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


/**
// Check file size
if ($_FILES["fileToUpload"]["size"] > 50000000000) {
	echo "Sorry, your file is too large.";
	$uploadOk = 0;
}**/


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
    

    		
    	$tfname2 = str_replace("../","",$newfilename);

    		$sqll = "INSERT INTO Products (Laundromat, Product_name, Price, Image, Type, StripeID) VALUES (".$row['ID'].", '".$_POST['product']."', '".$_POST['pricep']."','".$tfname2."', '".$_POST['qtype']."', '".$sku1->id."')";


$mysqli->query($sqll);



$_SESSION['sm'] = "Your product has been successfully added!";


  


    } else {
        $_SESSION['sm'] = "Sorry, there was an error adding your product.";
    }


}


header('Location: ../products.php');
?>