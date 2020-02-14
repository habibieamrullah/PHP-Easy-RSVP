<?php

require("phpmailer.php");
require("smtp.php");


function sendmail($recipient, $subject, $message){
	
	global $emailhost;
	global $emailusername;
	global $emailpassword;
	global $websitetitle;
	
    $message = str_replace("\\r\\n", "", $message);
    $message = stripslashes($message);
    $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
    try {
        //Server settings
        //$mail->SMTPDebug = 1;                                 // Enable verbose debug output
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = $emailhost;  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = $emailusername;       // SMTP username
        $mail->Password = $emailpassword;                           // SMTP password
        $mail->SMTPSecure = 'SSL';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;                                    // TCP port to connect to
    
        $mail->setFrom($emailusername, $websitetitle);
        $mail->AddReplyTo($emailusername, $websitetitle);
        $mail->From = $emailusername;
        
    	//Recipients
    	$mail->addAddress($recipient);     // Add a recipient
    
        $mailbody = $message;
    
        //Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body    = $mailbody;
        $mail->AltBody = strip_tags($mailbody);
    
        $mail->send();
        //echo 'ok';
    } catch (Exception $e) {
        echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
    }
}
