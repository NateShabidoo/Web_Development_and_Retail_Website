<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'config.php';

if(isset($_POST["email"])) {
	
	$emailTo = $_POST["email"];
	
    $code = uniqid(true);
    
    $query = "INSERT INTO resetPasswords VALUES ('$code', '$emailTo', '')";
    $query_run = mysqli_query($conn, $query);
    
    	if(!$query_run) {
		exit("Error");
	    }

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->isSMTP();                                   //Send using SMTP
    $mail->Host       = 'mail.justnormalworkingstudents.com';//
    $mail->SMTPAuth   = true;                     //Enable SMTP authentication
    $mail->Username   = 'admin@justnormalworkingstudents.com'; //  SMTP username
    $mail->Password   = '#P@$$w0rD!';   //SMTP password  
    $mail->SMTPSecure = 'ssl';   //PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    

    //Recipients
    $mail->setFrom('admin@justnormalworkingstudents.com', 'justnormalworkingstudents.com');
    $mail->addAddress($emailTo);     //Add a recipient
    $mail->addReplyTo('no-reply@justnormalworkingstudents.com', 'No Reply');

    //Content
    $url = "http://" . $_SERVER["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]) . "resetlink.php?code=$code";
    $mail->isHTML(true);                   //Set email format to HTML
    $mail->Subject = 'Your Password Reset Link';
    $mail->Body    = "<h2>You Requested a Password Reset</h2> Click <a href='$url'>this Link</a> to Reset";
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 'Password Reset Link has been sent, it may take upt to 5 minutes, you may need to check spam folder';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
exit();
}
?>
<!--<!DOCTYPE html>
<html>
<head>
</head>
<title></title>
<body>-->
<form method="POST">
<input type="text" name="email" placeholder="email">
<br>
<input type="submit" name="submit" value="Reset email">

</form><!--
</body>
</html>-->