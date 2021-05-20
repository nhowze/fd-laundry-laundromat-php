<?php
include_once("../LoginSystem/cooks.php");
include_once '../includes/db_connect.php';
include_once '../includes/functions.php';

//session_start();
 

if($_POST['mondaycheck'] == "on"){
    
     $_POST['mondaycheck'] = "Open";
    
}else{
    
    $_POST['mondaycheck'] = "Closed";
    
}

if($_POST['tuesdaycheck'] == "on"){
    
    $_POST['tuesdaycheck'] = "Open";
    
}else{
    
    $_POST['tuesdaycheck'] = "Closed";
    
}


if($_POST['wednesdaycheck'] == "on"){
    
    $_POST['wednesdaycheck'] = "Open";
    
}else{
    
    $_POST['wednesdaycheck'] = "Closed";
    
}



if($_POST['thursdaycheck'] == "on"){
    
    $_POST['thursdaycheck'] = "Open";
    
}else{
    
    $_POST['thursdaycheck'] = "Closed";
}



if($_POST['fridaycheck'] == "on"){
    
    $_POST['fridaycheck'] = "Open";
    
}else{
    
    $_POST['fridaycheck'] = "Closed";
}


if($_POST['saturdaycheck'] == "on"){
    
    $_POST['saturdaycheck'] = "Open";
    
}else{
    
    $_POST['saturdaycheck'] = "Closed";
}


if($_POST['sundaycheck'] == "on"){
    
    $_POST['sundaycheck'] = "Open";
    
}else{
    
    $_POST['sundaycheck'] = "Closed";
}

$_POST['weekopening'] = date('H:i:s', strtotime($_POST['weekopening1']));
$_POST['weekclosing'] = date('H:i:s', strtotime($_POST['weekclosing1']));
$_POST['weekendopening'] = date('H:i:s', strtotime($_POST['weekendopening2']));
$_POST['weekendclosing'] = date('H:i:s', strtotime($_POST['weekendclosing2']));

$sqlst = "UPDATE Laundromat SET 

Monday = '".$_POST['mondaycheck']."',
Tuesday= '".$_POST['tuesdaycheck']."',
Wednesday = '".$_POST['wednesdaycheck']."',
Thursday = '".$_POST['thursdaycheck']."',
Friday = '".$_POST['fridaycheck']."',
Saturday = '".$_POST['saturdaycheck']."',
Sunday = '".$_POST['sundaycheck']."',
Week_Opening_Time = '".$_POST['weekopening']."',
Week_Closing_Time = '".$_POST['weekclosing']."',
Weekend_Opening_Time = '".$_POST['weekendopening']."',
Weekend_Closing_Time = '".$_POST['weekendclosing']."'

WHERE email = '".$_SESSION['username']."' ";


$mysqli->query($sqlst);
$_SESSION['hoursmsg'] = "Store Hours Saved!";
header('Location: ../account.php#hours');

?>
