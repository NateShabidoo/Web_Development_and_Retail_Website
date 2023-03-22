<?php
//include("config.php");
require 'config.php';

if(!isset($_GET["code"])) {
	exit("Can not find page1");
}


$code = $_GET["code"];  //code was retrieved successfully (checked it)

$getEmailQuery = mysqli_query($conn, "SELECT email_reset FROM resetPasswords WHERE code = '$code'");  //checked and this sql code works
if(mysqli_num_rows($getEmailQuery) == 0) {
	exit("Can not find page2");   //this error not thrown since 5/27/22 morning
}



if(isset($_POST["password"])) {
	$pw = $_POST["password"];   //checked and pw was successfully set

	$row = mysqli_fetch_array($getEmailQuery);
	$email = $row["email_reset"];
	//echo $email; $email is retrieved correctly I checked
	
	$query = "UPDATE User SET password = '$pw' where email = '$email'";
	$query_run = mysqli_query($conn, $query);
	
	if($query_run)
	{
	  $query = mysqli_query($conn, "DELETE FROM resetPasswords WHERE code='$code'");
	  exit("Password updated, Please login with new password");
	    
	}
	else 
		{
		exit("Password not updated");	
    }
    
}
//	$query2 = "DELETE FROM resetpasswords WHERE code='$code'";
//	$query_run2 = mysqli_query($conn, $query);
/*	if($query) {
		$query = mysqli_query($conn, "DELETE FROM resetpasswords WHERE code='$code'");
        exit("Password updated");
	}
	else {
		exit("Something went wrong with last query");
	}
}*/

?>
<!--<!DOCTYPE html>
<html>
<head>
</head>
<title></title>
<body>-->
<form method="POST">
	<input type="password" name="password" placeholder="New Password">
	<br>
	<input type="submit" name="submit" value="Update password">
</form>
<!--</body>
</html>-->