<?php
// Filename: /module/Application/src/Application/Model/User.php
namespace Application\Email;
/**
* 
*/
class MailHelper 
{
	const EMAIL_SYSTEM_NAME = "rdc@kienbk1910.com";
	const EMAIL_SYSTEM_PASS  = "123456789";
	public static function testMail(){
				$mail = new \PHPMailer();
					
				// set mailer to use SMTP
				$mail->IsSMTP();
				$mail->SMTPDebug = 2;	
				// As this email.php script lives on the same server as our email server
				// we are setting the HOST to localhost
				 $mail->Debugoutput = 'html';
				$mail->Host = "mail.kienbk1910.com";  // specify main and backup server
				$mail->Port = 25;	
				$mail->SMTPAuth = true;     // turn on SMTP authentication
				$mail->CharSet        =  "utf-8";
				// When sending email using PHPMailer, you need to send from a valid email address
				// In this case, we setup a test email account with the following credentials:
				// email: contact@domain.com
				// pass: password
				$mail->Username = MailHelper::EMAIL_SYSTEM_NAME;  // SMTP username
				$mail->Password = MailHelper::EMAIL_SYSTEM_PASS; // SMTP password
					
				// $email is the user's email address the specified
				// on our contact us page. We set this variable at
				// the top of this page with:
				// $email = $_REQUEST['email'] ;
				$mail->From = "rdc@kienbk1910.com";
				$mail->FromName="RDC";
				$mail->IsHTML(true);
				$mail->AddAddress("kienbk1910@gmail.com", "Ngọc Vinh");
			//	$mail->AddCC('vudung.rdc@gmail.com','Vu Dung');
			
			
				$mail->Subject = "[RDC Admin] RDC";
				
				
				$mail->Body    = "Testmail";			
				if(!$mail->Send())
				{
					 echo "Message could not be sent. <p>";
					echo "Mailer Error: " . $mail->ErrorInfo;
					return false;
				}
				return true;

	}
}