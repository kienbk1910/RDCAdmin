<?php
// Filename: /module/Application/src/Application/Model/User.php
namespace Application\Email;
use Application\Model\Task;
use Application\Config\Config;
use Utility\Date\Date;

// Define application environment
defined('APPLICATION_ENV') || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

/**
* 
*/
class MailHelper 
{
	const EMAIL_SYSTEM_NAME = "quanly@rdc.vn";
	const EMAIL_SYSTEM_PASS  = "0UWE]#28&MgT";
    const EMAIL_TEMPLETE_PATH = "./data/email/";
    const EMAIL_SUBJECT_FILTER_TEMPLATE = "[quanly.rdc.vn] [Hồ Sơ Số %d - %s] %s";
    const FROMFULLNAME = "RDC supporter";
    const REAL_SERVER_SITE = "http://quanly.rdc.vn";
    const MESSAGE_CREATE_SUBJECT = " Thông Báo Tạo Hồ Sơ";
    const MESSAGE_MODIFY_SUBJECT = " Thông Báo Thay Đổi Thông Tin Hồ Sơ";
    
    const MESSAGE_CREATE_CONTENT = " Thông báo về việc tạo hồ sơ";
    const MESSAGE_MODIFY_CONTENT = " Thông báo về việc thay đổi thông tin hồ sơ";
    
	/*public static function testMail(){
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
				$mail->From = MailHelper::EMAIL_SYSTEM_NAME;
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

	}*/
function server_parse($socket, $response)
{
   $server_response = '';
   while ( substr($server_response,3,1) != ' ' )
   {
      if( !( $server_response = fgets($socket, 256) ) )
      {
         echo "Couldn't get mail server response codes";
      }
   }

   if( !( substr($server_response, 0, 3) == $response ) )
   {
      echo "Ran into problems sending Mail. Response: $server_response";
   }
}

/****************************************************************************
*        Function:                 smtpmail
*        Description:         This is a functional replacement for php's builtin mail
*                                                function, that uses smtp.
*        Usage:                        The usage for this function is identical to that of php's
*                                                built in mail function.
****************************************************************************/
function  smtpmail($mail_to, $subject, $message, $headers='',$smtp_host, $smtp_username, $smtp_password, 

$admin_email)
{
//global $smtp_host, $smtp_username, $smtp_password, $admin_email;
//echo $to_mail.$subject.$message.$headers.$smtp_host.$smtp_username.$smtp_password;

        //
        // Fix any bare linefeeds in the message to make it RFC821 Compliant.
        //
        $message = preg_replace("/(?<!\r)\n/si", "\r\n", $message);
   /*echo "SMTP_HOST".$smtp_host;
   echo "<br>\nSMTP_USER".$smtp_user;
   echo "<br>\nSMTP_PW".$smtp_password;
   echo "<br>\nADMIN".$admin_email; */

        if ($headers != "")
        {
                if(is_array($headers))
                {
                        if(sizeof($headers) > 1)
                        {
                                $headers = join("\r\n", $headers);
                        }
                        else
                        {
                                $headers = $headers[0];
                        }
                }
                $headers = chop($headers);

                //
                // Make sure there are no bare linefeeds in the headers
                //
                $headers = preg_replace("/(?<!\r)\n/si", "\r\n", $headers);
                //
                // Ok this is rather confusing all things considered,
                // but we have to grab bcc and cc headers and treat them differently
                // Something we really didn't take into consideration originally
                //
                $header_array = explode("\r\n", $headers);
                @reset($header_array);
                $headers = "";
                $cc = '';
                $bcc = '';
                while( list(, $header) = each($header_array) )
                {
                        if( preg_match("/^cc:/si", $header) )
                        {
                                $cc = preg_replace("/^cc:(.*)/si", "\\1", $header);
                        }
                        else if( preg_match("/^bcc:/si", $header ))
                        {
                                $bcc = preg_replace("/^bcc:(.*)/si", "\\1", $header);
                                $header = "";
                        }
                        $headers .= $header . "\r\n";
                }
                $headers = chop($headers);
                $cc = explode(",", $cc);
                $bcc = explode(",", $bcc);
        }


        if(trim($mail_to) == "")
        {
                exit();
        }
        if(trim($subject) == "")
        {
                die("No email Subject specified");
        }

        $mail_to_array = explode(",", $mail_to);

        //
        // Ok we have error checked as much as we can to this point let's get on
        // it already.
        //
        if( !$socket = fsockopen($smtp_host, 25, $errno, $errstr, 20) )
        {
                die("Could not connect to smtp host : $errno : $errstr");
        }
        $this->server_parse($socket, "220");

        if( !empty($smtp_username) && !empty($smtp_password) )
        {
                // Send the RFC2554 specified EHLO.
                // This improved as provided by SirSir to accomodate
                // both SMTP AND ESMTP capable servers
                fputs($socket, "EHLO " . $smtp_host . "\r\n");
                 $this->server_parse($socket, "250");

                fputs($socket, "AUTH LOGIN\r\n");
                 $this->server_parse($socket, "334");
                fputs($socket, base64_encode($smtp_username) . "\r\n");
                 $this->server_parse($socket, "334");
                fputs($socket, base64_encode($smtp_password) . "\r\n");
                 $this->server_parse($socket, "235");
        }
        else
        {
                // Send the RFC821 specified HELO.
                fputs($socket, "HELO " . $smtp_host . "\r\n");
                 $this->server_parse($socket, "250");
        }

        // From this point onward most server response codes should be 250
        // Specify who the mail is from....
        fputs($socket, "MAIL FROM: <" . $admin_email . ">\r\n");
         $this->server_parse($socket, "250");

        // Specify each user to send to and build to header.
        $to_header = "To: ";
        @reset( $mail_to_array );
        while( list( , $mail_to_address ) = each( $mail_to_array ))
        {
                //
                // Add an additional bit of error checking to the To field.
                //
                $mail_to_address = trim($mail_to_address);
                if ( preg_match('/[^ ]+\@[^ ]+/', $mail_to_address) )
                {
                        fputs( $socket, "RCPT TO: <$mail_to_address>\r\n" );
                        $this->server_parse( $socket, "250" );
                }
                $to_header .= "<$mail_to_address>, ";
        }
        // Ok now do the CC and BCC fields...
        @reset( $bcc );
        while( list( , $bcc_address ) = each( $bcc ))
        {
                //
                // Add an additional bit of error checking to bcc header...
                //
                $bcc_address = trim( $bcc_address );
                if ( preg_match('/[^ ]+\@[^ ]+/', $bcc_address) )
                {
                        fputs( $socket, "RCPT TO: <$bcc_address>\r\n" );
                        $this->server_parse( $socket, "250" );
                }
        }
        @reset( $cc );
        while( list( , $cc_address ) = each( $cc ))
        {
                //
                // Add an additional bit of error checking to cc header
                //
                $cc_address = trim( $cc_address );
                if ( preg_match('/[^ ]+\@[^ ]+/', $cc_address) )
                {
                        fputs($socket, "RCPT TO: <$cc_address>\r\n");
                         $this->server_parse($socket, "250");
                }
        }
        // Ok now we tell the server we are ready to start sending data
        fputs($socket, "DATA\r\n");

        // This is the last response code we look for until the end of the message.
         $this->server_parse($socket, "354");

        // Send the Subject Line...
        fputs($socket, "Subject: $subject\r\n");

        // Now the To Header.
        fputs($socket, "$to_header\r\n");

        // Now any custom headers....
        fputs($socket, "$headers\r\n\r\n");

        // Ok now we are ready for the message...
        fputs($socket, "$message\r\n");

        // Ok the all the ingredients are mixed in let's cook this puppy...
        fputs($socket, ".\r\n");
         $this->server_parse($socket, "250");

        // Now tell the server we are done and close the socket...
        fputs($socket, "QUIT\r\n");
        fclose($socket);
        return TRUE;
    }

    function SendMail($frommail,$tomail,$subject,$message,$fromfullname = MailHelper::FROMFULLNAME)
    {
          $from= $fromfullname." <".$frommail.">";
          $headers ="Return-Path: ".$fromfullname." <".$frommail.">\r\n";
          $headers.="From: $from\nX-Mailer: ".$fromfullname."\r\n";
          $headers .="Mime-Version: 1.0\r\n";
          $headers .="Content-type: text/html; charset=utf-8\r\n";
          $smtp_host ='mail.rdc.vn';//Dia chi mail server
          $admin_email = MailHelper::EMAIL_SYSTEM_NAME;//User duoc khai bao tren mail server
          $smtp_username = MailHelper::EMAIL_SYSTEM_NAME;//User duoc khai bao tren mail server
          $smtp_password = MailHelper::EMAIL_SYSTEM_PASS;//Pass cua email nay
          /* Using APPLICATION_ENV to ignore localhost */
          if (APPLICATION_ENV != "development") {
              $result = $this->smtpmail($tomail,$subject,$message,$headers,$smtp_host, $smtp_username, $smtp_password, $admin_email);
          }
    }

    function notify_to_user($task, $user, $type, $action) {
        $agency = $user['agency'];
        $provider = $user['provider'];
        $validator = new \Zend\Validator\EmailAddress();
        $email = NULL;
        $getcontent = file_get_contents(MailHelper::EMAIL_TEMPLETE_PATH.'createtask.html');
        if ($action == Config::NOTIFY_CREATE) {
            $subject = sprintf(MailHelper::EMAIL_SUBJECT_FILTER_TEMPLATE, $task['id'], $task['certificate'], MailHelper::MESSAGE_CREATE_SUBJECT);
            $getcontent = str_replace('{|message|}', MailHelper::MESSAGE_CREATE_CONTENT, $getcontent);
        } else {
            $subject = sprintf(MailHelper::EMAIL_SUBJECT_FILTER_TEMPLATE, $task['id'], $task['certificate'], MailHelper::MESSAGE_MODIFY_SUBJECT);
            $getcontent = str_replace('{|message|}', MailHelper::MESSAGE_MODIFY_CONTENT, $getcontent);
        }
        $getcontent = str_replace('{|trang_thai|}', "Nhận hồ sơ", $getcontent);
        $getcontent = str_replace('{|ma_ho_so|}', $task['id'], $getcontent);
        $getcontent = str_replace('{|thanh_toan|}', 0, $getcontent);
        $getcontent = str_replace('{|custumer|}', $task['custumer'], $getcontent);
        $getcontent = str_replace('{|certificate|}', $task['certificate'], $getcontent);
        if ($type == Config::AGENCY_TYPE) {
            $getcontent = str_replace('{|link|}', MailHelper::REAL_SERVER_SITE. "/tasks/orderdetail/" .$task['id'], $getcontent);
            $getcontent = str_replace('{|name|}', $agency->username, $getcontent);
            $getcontent = str_replace('{|ten_khach_hang|}', $agency->username, $getcontent);
            $getcontent = str_replace('{|gia_thoa_thuan|}', number_format($task['cost_sell']), $getcontent);
            $getcontent = str_replace('{|du_no|}', number_format($task['cost_sell']), $getcontent);
            $getcontent = str_replace('{|ngay_nhan|}', Date::changeDateSQLtoVN($task['date_open']), $getcontent);
            $getcontent = str_replace('{|ngay_hen|}', Date::changeDateSQLtoVN($task['date_end']), $getcontent);
            $getcontent = str_replace('{|doi_tuong|}', "Nhà Cung Cấp", $getcontent);
            $email = $agency->email;
        } else if ($type == Config::PROVIDER_TYPE) {
            $getcontent = str_replace('{|link|}', MailHelper::REAL_SERVER_SITE. "/tasks/taskdetail/" .$task['id'], $getcontent);
            $getcontent = str_replace('{|name|}', $provider->username, $getcontent);
            $getcontent = str_replace('{|ten_khach_hang|}', $provider->username, $getcontent);
            $getcontent = str_replace('{|gia_thoa_thuan|}', number_format($task['cost_buy']), $getcontent);
            $getcontent = str_replace('{|du_no|}', number_format($task['cost_buy']), $getcontent);
            $getcontent = str_replace('{|ngay_nhan|}', Date::changeDateSQLtoVN($task['date_open_pr']), $getcontent);
            $getcontent = str_replace('{|ngay_hen|}', Date::changeDateSQLtoVN($task['date_end_pr']), $getcontent);
            $getcontent = str_replace('{|doi_tuong|}', "Khách Hàng", $getcontent);
            $email = $provider->email;
        }

        if ($validator->isValid($email)) {
            // email appears to be valid
            $this->SendMail(MailHelper::EMAIL_SYSTEM_NAME, $email, $subject, $getcontent);
        } else {
            // email is invalid; print the reasons
            foreach ($validator->getMessages() as $message) {
                return "$message";
            }
        }
        //echo $getcontent;
        return NULL;
    }

    function notify_modify_to_agency($task, $user, $key, $old_value, $new_value) {
        $reporter = $user['reporter'];
        $assign = $user['assign'];
        $agency = $user['agency'];
        $provider = $user['provider'];
        $validator = new \Zend\Validator\EmailAddress();
        $email = NULL;
        $getcontent = file_get_contents(MailHelper::EMAIL_TEMPLETE_PATH.'modify_task_agency.html');

        $subject = sprintf(MailHelper::EMAIL_SUBJECT_FILTER_TEMPLATE, $task['id'], $task['certificate'], MailHelper::MESSAGE_MODIFY_SUBJECT);
        $getcontent = str_replace('{|name|}', $agency->username, $getcontent);
        /* add hightlight base on key,old value, new value */
        $getcontent = str_replace("{|". $key ."|}", "<span style=\"text-decoration: line-through;\"> ". $old_value ." </span> <strong> <font color=red>". $new_value. "</font></strong>", $getcontent);
        if ($key == Config::cost_sell_id) {
            $getcontent = str_replace("{|du_no_kh|}", "<strong> <font color=red>{|du_no_kh|}</font></strong>", $getcontent);
        } else if ($key == Config::cost_buy_id) {
            $getcontent = str_replace("{|du_no_cc|}", "<strong> <font color=red>{|du_no_cc|} </font></strong>", $getcontent);
        }
        /* add other values */
        $getcontent = str_replace('{|message|}', MailHelper::MESSAGE_MODIFY_CONTENT, $getcontent);
        $getcontent = str_replace('{|process_id|}', "Nhận hồ sơ", $getcontent);
        $getcontent = str_replace('{|ma_ho_so|}', $task['id'], $getcontent);
        $getcontent = str_replace('{|link|}', MailHelper::REAL_SERVER_SITE. "/manager-tasks/detail/" .$task['id'], $getcontent);
        $getcontent = str_replace('{|thanh_toan|}', 0, $getcontent);
        $getcontent = str_replace('{|ten_khach_hang|}', $agency->username, $getcontent);
        $getcontent = str_replace('{|ten_nha_cung_cap|}', $provider->username, $getcontent);
    
        $getcontent = str_replace('{|cost_sell|}', number_format($task['cost_sell']), $getcontent);
        $getcontent = str_replace('{|cost_buy|}', number_format($task['cost_buy']), $getcontent);
        $getcontent = str_replace('{|date_open|}', Date::changeDateSQLtoVN($task['date_open']), $getcontent);
        $getcontent = str_replace('{|date_end|}', Date::changeDateSQLtoVN($task['date_end']), $getcontent);
        $getcontent = str_replace('{|agency_note|}', $task['agency_note'], $getcontent);
        
        $getcontent = str_replace('{|date_open_pr|}', Date::changeDateSQLtoVN($task['date_open_pr']), $getcontent);
        $getcontent = str_replace('{|date_end_pr|}', Date::changeDateSQLtoVN($task['date_end_pr']), $getcontent);
        $getcontent = str_replace('{|provider_note|}', $task['provider_note'], $getcontent);
        
        $getcontent = str_replace('{|du_no_kh|}', $task['custumer_debt'], $getcontent);
        $getcontent = str_replace('{|du_no_cc|}', $task['provider_debt'], $getcontent);
    
        $getcontent = str_replace('{|thanh_toan_kh|}', $task['pay_custumer'], $getcontent);
        $getcontent = str_replace('{|thanh_toan_cc|}', $task['pay_provider'], $getcontent);
        /* viet add */
        $getcontent = str_replace('{|custumer|}', $task['custumer'], $getcontent);
        $getcontent = str_replace('{|certificate|}', $task['certificate'], $getcontent);
    
        $getcontent = str_replace('{|reporter_id|}', $reporter->username, $getcontent);
        $getcontent = str_replace('{|assign_id|}', $assign->username, $getcontent);
        $getcontent = str_replace('{|agency_id|}', $agency->username, $getcontent);
        $getcontent = str_replace('{|provider_id|}', $provider->username, $getcontent);
        
        if ($validator->isValid($reporter->email) && $validator->isValid($assign->email)) {
            // email appears to be valid
            $this->SendMail(MailHelper::EMAIL_SYSTEM_NAME, $reporter->email, $subject, $getcontent);
            $this->SendMail(MailHelper::EMAIL_SYSTEM_NAME, $assign->email, $subject, $getcontent);
        } else {
            // email is invalid; print the reasons
            foreach ($validator->getMessages() as $message) return "$message";
        }
        //echo $getcontent;
        return NULL;
    }

    function notify_modify_to_provider($task, $user, $key, $old_value, $new_value) {
        $reporter = $user['reporter'];
        $assign = $user['assign'];
        $agency = $user['agency'];
        $provider = $user['provider'];
        $validator = new \Zend\Validator\EmailAddress();
        $email = NULL;
        $getcontent = file_get_contents(MailHelper::EMAIL_TEMPLETE_PATH.'modify_task_provider.html');
    
        $subject = sprintf(MailHelper::EMAIL_SUBJECT_FILTER_TEMPLATE, $task['id'], $task['certificate'], MailHelper::MESSAGE_MODIFY_SUBJECT);
        $getcontent = str_replace('{|name|}', $provider->username, $getcontent);
        /* add hightlight base on key,old value, new value */
        $getcontent = str_replace("{|". $key ."|}", "<span style=\"text-decoration: line-through;\"> ". $old_value ." </span> <strong> <font color=red>". $new_value. "</font></strong>", $getcontent);
        if ($key == Config::cost_sell_id) {
            $getcontent = str_replace("{|du_no_kh|}", "<strong> <font color=red>{|du_no_kh|}</font></strong>", $getcontent);
        } else if ($key == Config::cost_buy_id) {
            $getcontent = str_replace("{|du_no_cc|}", "<strong> <font color=red>{|du_no_cc|} </font></strong>", $getcontent);
        }
        /* add other values */
        $getcontent = str_replace('{|message|}', MailHelper::MESSAGE_MODIFY_CONTENT, $getcontent);
        $getcontent = str_replace('{|process_id|}', "Nhận hồ sơ", $getcontent);
        $getcontent = str_replace('{|ma_ho_so|}', $task['id'], $getcontent);
        $getcontent = str_replace('{|link|}', MailHelper::REAL_SERVER_SITE. "/manager-tasks/detail/" .$task['id'], $getcontent);
        $getcontent = str_replace('{|thanh_toan|}', 0, $getcontent);
        $getcontent = str_replace('{|ten_khach_hang|}', $agency->username, $getcontent);
        $getcontent = str_replace('{|ten_nha_cung_cap|}', $provider->username, $getcontent);
    
        $getcontent = str_replace('{|cost_sell|}', number_format($task['cost_sell']), $getcontent);
        $getcontent = str_replace('{|cost_buy|}', number_format($task['cost_buy']), $getcontent);
        $getcontent = str_replace('{|date_open|}', Date::changeDateSQLtoVN($task['date_open']), $getcontent);
        $getcontent = str_replace('{|date_end|}', Date::changeDateSQLtoVN($task['date_end']), $getcontent);
        $getcontent = str_replace('{|agency_note|}', $task['agency_note'], $getcontent);
        
        $getcontent = str_replace('{|date_open_pr|}', Date::changeDateSQLtoVN($task['date_open_pr']), $getcontent);
        $getcontent = str_replace('{|date_end_pr|}', Date::changeDateSQLtoVN($task['date_end_pr']), $getcontent);
        $getcontent = str_replace('{|provider_note|}',$task['provider_note'], $getcontent);
    
        $getcontent = str_replace('{|du_no_kh|}', $task['custumer_debt'], $getcontent);
        $getcontent = str_replace('{|du_no_cc|}', $task['provider_debt'], $getcontent);
    
        $getcontent = str_replace('{|thanh_toan_kh|}', $task['pay_custumer'], $getcontent);
        $getcontent = str_replace('{|thanh_toan_cc|}', $task['pay_provider'], $getcontent);
        /* viet add */
        $getcontent = str_replace('{|custumer|}', $task['custumer'], $getcontent);
        $getcontent = str_replace('{|certificate|}', $task['certificate'], $getcontent);
    
        $getcontent = str_replace('{|reporter_id|}', $reporter->username, $getcontent);
        $getcontent = str_replace('{|assign_id|}', $assign->username, $getcontent);
        $getcontent = str_replace('{|agency_id|}', $agency->username, $getcontent);
        $getcontent = str_replace('{|provider_id|}', $provider->username, $getcontent);
    
        if ($validator->isValid($reporter->email) && $validator->isValid($assign->email)) {
            // email appears to be valid
            $this->SendMail(MailHelper::EMAIL_SYSTEM_NAME, $reporter->email, $subject, $getcontent);
            $this->SendMail(MailHelper::EMAIL_SYSTEM_NAME, $assign->email, $subject, $getcontent);
        } else {
            // email is invalid; print the reasons
            foreach ($validator->getMessages() as $message) return "$message";
        }
        //secho $getcontent;
        return NULL;
    }

    function notify_modify_to_admin($task, $user, $key, $old_value, $new_value) {
        $reporter = $user['reporter'];
        $assign = $user['assign'];
        $agency = $user['agency'];
        $provider = $user['provider'];
        $validator = new \Zend\Validator\EmailAddress();
        $email = NULL;
        $getcontent = file_get_contents(MailHelper::EMAIL_TEMPLETE_PATH.'modify_task_admin.html');
    
        $subject = sprintf(MailHelper::EMAIL_SUBJECT_FILTER_TEMPLATE, $task['id'], $task['certificate'], MailHelper::MESSAGE_MODIFY_SUBJECT);
    
        /* add hightlight base on key,old value, new value */
        $getcontent = str_replace("{|". $key ."|}", "<span style=\"text-decoration: line-through;\"> ". $old_value ." </span> <strong> <font color=red>". $new_value. "</font></strong>", $getcontent);
        if ($key == Config::cost_sell_id) {
            $getcontent = str_replace("{|du_no_kh|}", "<strong> <font color=red>{|du_no_kh|}</font></strong>", $getcontent);
        } else if ($key == Config::cost_buy_id) {
            $getcontent = str_replace("{|du_no_cc|}", "<strong> <font color=red>{|du_no_cc|} </font></strong>", $getcontent);
        }
        /* add other values */
        $getcontent = str_replace('{|message|}', MailHelper::MESSAGE_MODIFY_CONTENT, $getcontent);
        $getcontent = str_replace('{|process_id|}', "Nhận hồ sơ", $getcontent);
        $getcontent = str_replace('{|ma_ho_so|}', $task['id'], $getcontent);
        $getcontent = str_replace('{|link|}', MailHelper::REAL_SERVER_SITE. "/manager-tasks/detail/" .$task['id'], $getcontent);
        $getcontent = str_replace('{|thanh_toan|}', 0, $getcontent);
        $getcontent = str_replace('{|ten_khach_hang|}', $agency->username, $getcontent);
        $getcontent = str_replace('{|ten_nha_cung_cap|}', $provider->username, $getcontent);
    
        $getcontent = str_replace('{|cost_sell|}', number_format($task['cost_sell']), $getcontent);
        $getcontent = str_replace('{|cost_buy|}', number_format($task['cost_buy']), $getcontent);
        $getcontent = str_replace('{|date_open|}', Date::changeDateSQLtoVN($task['date_open']), $getcontent);
        $getcontent = str_replace('{|date_end|}', Date::changeDateSQLtoVN($task['date_end']), $getcontent);
        $getcontent = str_replace('{|agency_note|}', $task['agency_note'], $getcontent);
    
        $getcontent = str_replace('{|date_open_pr|}', Date::changeDateSQLtoVN($task['date_open_pr']), $getcontent);
        $getcontent = str_replace('{|date_end_pr|}', Date::changeDateSQLtoVN($task['date_end_pr']), $getcontent);
        $getcontent = str_replace('{|provider_note|}', $task['provider_note'], $getcontent);

        $getcontent = str_replace('{|du_no_kh|}', $task['custumer_debt'], $getcontent);
        $getcontent = str_replace('{|du_no_cc|}', $task['provider_debt'], $getcontent);

        $getcontent = str_replace('{|thanh_toan_kh|}', $task['pay_custumer'], $getcontent);
        $getcontent = str_replace('{|thanh_toan_cc|}', $task['pay_provider'], $getcontent);
        /* viet add */
        $getcontent = str_replace('{|custumer|}', $task['custumer'], $getcontent);
        $getcontent = str_replace('{|certificate|}', $task['certificate'], $getcontent);
    
        $getcontent = str_replace('{|reporter_id|}', $reporter->username, $getcontent);
        $getcontent = str_replace('{|assign_id|}', $assign->username, $getcontent);
        $getcontent = str_replace('{|agency_id|}', $agency->username, $getcontent);
        $getcontent = str_replace('{|provider_id|}', $provider->username, $getcontent);
    
        if ($validator->isValid($reporter->email) && $validator->isValid($assign->email)) {
            // email appears to be valid
            $this->SendMail(MailHelper::EMAIL_SYSTEM_NAME, $reporter->email, $subject, $getcontent);
            $this->SendMail(MailHelper::EMAIL_SYSTEM_NAME, $assign->email, $subject, $getcontent);
        } else {
            // email is invalid; print the reasons
            foreach ($validator->getMessages() as $message) return "$message";
        }
        //echo $getcontent;
        return NULL;
    }

    function notify_to_admin($task, $user, $action) {
        $reporter = $user['reporter'];
        $assign = $user['assign'];
        $agency = $user['agency'];
        $provider = $user['provider'];
        $validator = new \Zend\Validator\EmailAddress();
        $email = NULL;
        $getcontent = file_get_contents(MailHelper::EMAIL_TEMPLETE_PATH.'createtask_admin.html');
        if ($action == Config::NOTIFY_CREATE) {
            $subject = sprintf(MailHelper::EMAIL_SUBJECT_FILTER_TEMPLATE, $task['id'], $task['certificate'], MailHelper::MESSAGE_CREATE_SUBJECT);
            $getcontent = str_replace('{|message|}', MailHelper::MESSAGE_CREATE_CONTENT, $getcontent);
        } else {
            $subject = sprintf(MailHelper::EMAIL_SUBJECT_FILTER_TEMPLATE, $task['id'], $task['certificate'], MailHelper::MESSAGE_MODIFY_SUBJECT);
            $getcontent = str_replace('{|message|}', MailHelper::MESSAGE_MODIFY_CONTENT, $getcontent);
        }
        $getcontent = str_replace('{|trang_thai|}', "Nhận hồ sơ", $getcontent);
        $getcontent = str_replace('{|ma_ho_so|}', $task['id'], $getcontent);
        $getcontent = str_replace('{|link|}', MailHelper::REAL_SERVER_SITE. "/manager-tasks/detail/" .$task['id'], $getcontent);
        $getcontent = str_replace('{|thanh_toan|}', 0, $getcontent);
        $getcontent = str_replace('{|ten_khach_hang|}', $agency->username, $getcontent);
        $getcontent = str_replace('{|ten_nha_cung_cap|}', $provider->username, $getcontent);

        $getcontent = str_replace('{|gia_mua|}', number_format($task['cost_sell']), $getcontent);
        $getcontent = str_replace('{|gia_ban|}', number_format($task['cost_buy']), $getcontent);
        $getcontent = str_replace('{|ngay_nhan_kh|}', Date::changeDateSQLtoVN($task['date_open']), $getcontent);
        $getcontent = str_replace('{|ngay_hen_kh|}', Date::changeDateSQLtoVN($task['date_end']), $getcontent);

        $getcontent = str_replace('{|ngay_nhan_cc|}', Date::changeDateSQLtoVN($task['date_open_pr']), $getcontent);
        $getcontent = str_replace('{|ngay_hen_cc|}', Date::changeDateSQLtoVN($task['date_end_pr']), $getcontent);

        $getcontent = str_replace('{|du_no_kh|}', number_format($task['cost_sell']), $getcontent);
        $getcontent = str_replace('{|du_no_cc|}', number_format($task['cost_buy']), $getcontent);

        $getcontent = str_replace('{|thanh_toan_kh|}', 0, $getcontent);
        $getcontent = str_replace('{|thanh_toan_cc|}', 0, $getcontent);
        /* viet add */
        $getcontent = str_replace('{|custumer|}', $task['custumer'], $getcontent);
        $getcontent = str_replace('{|certificate|}', $task['certificate'], $getcontent);
        
        if ($validator->isValid($reporter->email) && $validator->isValid($assign->email)) {
            // email appears to be valid
            $this->SendMail(MailHelper::EMAIL_SYSTEM_NAME, $reporter->email, $subject, $getcontent);
            $this->SendMail(MailHelper::EMAIL_SYSTEM_NAME, $assign->email, $subject, $getcontent);
        } else {
            // email is invalid; print the reasons
            foreach ($validator->getMessages() as $message) {
                return "$message";
            }
        }
        //echo $getcontent;
        return NULL;
    }

     function notify_add_comment($task,$user_comment, $comment,$type) {
        $validator = new \Zend\Validator\EmailAddress();
        $email = NULL;
        $getcontent = file_get_contents(MailHelper::EMAIL_TEMPLETE_PATH.'add_comment.html');
        $subject = sprintf(MailHelper::EMAIL_SUBJECT_FILTER_TEMPLATE, $task['id'], $task['certificate'], "Thêm Bình Luận");
       // $getcontent = str_replace('{|link|}', "Nhận hồ sơ", $getcontent);
        $getcontent = str_replace('{|task_info|}', $task['id']." - ".$task['custumer']." - ".$task['certificate'], $getcontent);
        $getcontent = str_replace('{|comment|}', $comment, $getcontent);
        $getcontent = str_replace('{|user|}', $user_comment, $getcontent);
        $getcontent_tmp = str_replace('{|name|}', $task['reporter_name'], $getcontent);
        $getcontent_tmp = str_replace('{|link|}', MailHelper::REAL_SERVER_SITE. "/manager-tasks/detail/" .$task['id'], $getcontent_tmp);
        if ($validator->isValid($task['reporter_email'])) {
            $this->SendMail(MailHelper::EMAIL_SYSTEM_NAME, $task['reporter_email'], $subject, $getcontent_tmp);
        }
        $getcontent_tmp = str_replace('{|name|}', $task['assign_name'], $getcontent);
        $getcontent_tmp = str_replace('{|link|}', MailHelper::REAL_SERVER_SITE. "/manager-tasks/detail/" .$task['id'], $getcontent_tmp);

        if($validator->isValid($task['assign_email'])){
               $this->SendMail(MailHelper::EMAIL_SYSTEM_NAME, $task['assign_email'], $subject, $getcontent_tmp);
        }
        if($type == Config::PAY_CUSTUMER){
             $getcontent_tmp = str_replace('{|name|}', $task['agency_name'], $getcontent);
             $getcontent_tmp = str_replace('{|link|}',MailHelper::REAL_SERVER_SITE. "/tasks/orderdetail/" .$task['id'], $getcontent_tmp);
             if ($validator->isValid($task['agency_email'])) {
                    $this->SendMail(MailHelper::EMAIL_SYSTEM_NAME, $task['agency_email'], $subject, $getcontent_tmp);
             }
        }
        if($type == Config::PAY_PROVIDER){
             $getcontent_tmp = str_replace('{|name|}', $task['provider_name'], $getcontent);
             $getcontent_tmp = str_replace('{|link|}',MailHelper::REAL_SERVER_SITE. "/tasks/taskdetail/" .$task['id'], $getcontent_tmp);
             if ($validator->isValid($task['provider_email'])) {
                    $this->SendMail(MailHelper::EMAIL_SYSTEM_NAME, $task['provider_email'], $subject, $getcontent_tmp);
             }
        }
        //echo $getcontent;
        return NULL;
    }
    function notify_add_pay($task,$user_action, $pay,$type) {
        $validator = new \Zend\Validator\EmailAddress();
        $email = NULL;
        $getcontent = file_get_contents(MailHelper::EMAIL_TEMPLETE_PATH.'add_pay.html');
        $subject = sprintf(MailHelper::EMAIL_SUBJECT_FILTER_TEMPLATE, $task['id'], $task['certificate'], "Thêm Thanh Toán");
       // $getcontent = str_replace('{|link|}', "Nhận hồ sơ", $getcontent);
        $getcontent = str_replace('{|task_info|}', $task['id']." - ".$task['custumer']." - ".$task['certificate'], $getcontent);
      
        $getcontent = str_replace('{|user|}', $user_action, $getcontent);
        $getcontent = str_replace('{|money|}',number_format($pay->money), $getcontent);
        $getcontent = str_replace('{|money_option|}', ($pay->money_option == 1)? "Tiền Mặt":"Chuyển Khoản", $getcontent);
        $getcontent = str_replace('{|date_pay|}',Date::changeDateSQLtoVN($pay->date_pay), $getcontent);
        $getcontent = str_replace('{|note|}', $pay->note,$getcontent);
        
        $getcontent_tmp = str_replace('{|name|}', $task['reporter_name'], $getcontent);
        $getcontent_tmp = str_replace('{|link|}', MailHelper::REAL_SERVER_SITE. "/manager-tasks/detail/" .$task['id'], $getcontent_tmp);
        if ($validator->isValid($task['reporter_email'])) {
            $this->SendMail(MailHelper::EMAIL_SYSTEM_NAME, $task['reporter_email'], $subject, $getcontent_tmp);
        }
        $getcontent_tmp = str_replace('{|name|}', $task['assign_name'], $getcontent);
        $getcontent_tmp = str_replace('{|link|}', MailHelper::REAL_SERVER_SITE. "/manager-tasks/detail/" .$task['id'], $getcontent_tmp);

        if($validator->isValid($task['assign_email'])){
               $this->SendMail(MailHelper::EMAIL_SYSTEM_NAME, $task['assign_email'], $subject, $getcontent_tmp);
        }
        if($type == Config::PAY_CUSTUMER){
             $getcontent_tmp = str_replace('{|name|}', $task['agency_name'], $getcontent);
             $getcontent_tmp = str_replace('{|link|}',MailHelper::REAL_SERVER_SITE. "/tasks/orderdetail/" .$task['id'], $getcontent_tmp);
             if ($validator->isValid($task['agency_email'])) {
                    $this->SendMail(MailHelper::EMAIL_SYSTEM_NAME, $task['agency_email'], $subject, $getcontent_tmp);
             }
        }
        if($type == Config::PAY_PROVIDER){
             $getcontent_tmp = str_replace('{|name|}', $task['provider_name'], $getcontent);
             $getcontent_tmp = str_replace('{|link|}',MailHelper::REAL_SERVER_SITE. "/tasks/taskdetail/" .$task['id'], $getcontent_tmp);
             if ($validator->isValid($task['provider_email'])) {
                    $this->SendMail(MailHelper::EMAIL_SYSTEM_NAME, $task['provider_email'], $subject, $getcontent_tmp);
             }
        }
        
        //echo $getcontent;
        return NULL;
    }
   
    function notify_delete_pay($task,$user_action, $pay,$type) {
        $validator = new \Zend\Validator\EmailAddress();
        $email = NULL;
        $getcontent = file_get_contents(MailHelper::EMAIL_TEMPLETE_PATH.'add_pay.html');
        $subject = sprintf(MailHelper::EMAIL_SUBJECT_FILTER_TEMPLATE, $task['id'], $task['certificate'], "Xóa Thanh Toán");
       // $getcontent = str_replace('{|link|}', "Nhận hồ sơ", $getcontent);
        $getcontent = str_replace('{|task_info|}', $task['id']." - ".$task['custumer']." - ".$task['certificate'], $getcontent);
      
        $getcontent = str_replace('{|user|}', $user_action, $getcontent);
        $getcontent = str_replace('{|money|}',"<span style='text-decoration:line-through;color: red'>".number_format($pay->money)."</span>", $getcontent);
        $getcontent = str_replace('{|date_pay|}',"<span style='text-decoration:line-through;color: red'>".Date::changeDateSQLtoVN($pay->date_pay)."</span>", $getcontent);
        $getcontent = str_replace('{|note|}',"<span style='text-decoration:line-through;color: red'>".$pay->note."</span>", $getcontent);
        $getcontent = str_replace('{|money_option|}',"<span style='text-decoration:line-through;color: red'>". (($pay->money_option == 1)? "Tiền Mặt":"Chuyển Khoản")."</span>", $getcontent);
        
        

        $getcontent_tmp = str_replace('{|name|}', $task['reporter_name'], $getcontent);
        $getcontent_tmp = str_replace('{|link|}', MailHelper::REAL_SERVER_SITE. "/manager-tasks/detail/" .$task['id'], $getcontent_tmp);
        if ($validator->isValid($task['reporter_email'])) {
            $this->SendMail(MailHelper::EMAIL_SYSTEM_NAME, $task['reporter_email'], $subject, $getcontent_tmp);
        }
        $getcontent_tmp = str_replace('{|name|}', $task['assign_name'], $getcontent);
        $getcontent_tmp = str_replace('{|link|}', MailHelper::REAL_SERVER_SITE. "/manager-tasks/detail/" .$task['id'], $getcontent_tmp);

        if($validator->isValid($task['assign_email'])){
               $this->SendMail(MailHelper::EMAIL_SYSTEM_NAME, $task['assign_email'], $subject, $getcontent_tmp);
        }
        if($type == Config::PAY_CUSTUMER){
             $getcontent_tmp = str_replace('{|name|}', $task['agency_name'], $getcontent);
             $getcontent_tmp = str_replace('{|link|}',MailHelper::REAL_SERVER_SITE. "/tasks/orderdetail/" .$task['id'], $getcontent_tmp);
             if ($validator->isValid($task['agency_email'])) {
                    $this->SendMail(MailHelper::EMAIL_SYSTEM_NAME, $task['agency_email'], $subject, $getcontent_tmp);
             }
        }
        if($type == Config::PAY_PROVIDER){
             $getcontent_tmp = str_replace('{|name|}', $task['provider_name'], $getcontent);
             $getcontent_tmp = str_replace('{|link|}',MailHelper::REAL_SERVER_SITE. "/tasks/taskdetail/" .$task['id'], $getcontent_tmp);
             if ($validator->isValid($task['provider_email'])) {
                    $this->SendMail(MailHelper::EMAIL_SYSTEM_NAME, $task['provider_email'], $subject, $getcontent_tmp);
             }
        }
        
        //echo $getcontent;
        return NULL;
    }
      function notify_edit_pay($task,$user_action, $pay,$pay_new,$type) {
        $validator = new \Zend\Validator\EmailAddress();
        $email = NULL;
        $getcontent = file_get_contents(MailHelper::EMAIL_TEMPLETE_PATH.'add_pay.html');
        $subject = sprintf(MailHelper::EMAIL_SUBJECT_FILTER_TEMPLATE, $task['id'], $task['certificate'], "Chỉnh Sửa Thanh Toán");
       // $getcontent = str_replace('{|link|}', "Nhận hồ sơ", $getcontent);
        $getcontent = str_replace('{|task_info|}', $task['id']." - ".$task['custumer']." - ".$task['certificate'], $getcontent);
      
        $getcontent = str_replace('{|user|}', $user_action, $getcontent);
        if($pay->money != $pay_new->money){
              $getcontent = str_replace('{|money|}',"<span style='text-decoration:line-through;color: red'>".number_format($pay->money)."</span>"."<span style='color: #3c8dbc;'>".number_format($pay_new->money)."</span>", $getcontent);
        }else{
              $getcontent = str_replace('{|money|}',number_format($pay->money), $getcontent);
        }
        if(Date::changeDateSQLtoVN($pay->date_pay) != Date::changeDateSQLtoVN($pay_new->date_pay)){
             $getcontent = str_replace('{|date_pay|}',"<span style='text-decoration:line-through;color: red'>".Date::changeDateSQLtoVN($pay->date_pay)."</span>"."<span style='color: #3c8dbc;'>".Date::changeDateSQLtoVN($pay_new->date_pay)."</span>", $getcontent);
        }else{
           $getcontent = str_replace('{|date_pay|}',Date::changeDateSQLtoVN($pay->date_pay), $getcontent);
        }
        if($pay->note != $pay_new->note){
              $getcontent = str_replace('{|note|}',"<span style='text-decoration:line-through;color: red'>".$pay->note."</span>"."<span style='color: #3c8dbc;'>".$pay_new->note."</span>", $getcontent);
        }else{
              $getcontent = str_replace('{|note|}',$pay->note, $getcontent);
        }
        if($pay->money_option != $pay_new->money_option){
              $getcontent = str_replace('{|money_option|}',"<span style='text-decoration:line-through;color: red'>". (($pay->money_option == 1)? "Tiền Mặt":"Chuyển Khoản")."</span>"."<span style='color: #3c8dbc;'>".(($pay_new->money_option == 1)? "Tiền Mặt":"Chuyển Khoản")."</span>", $getcontent);
        }else{
              $getcontent = str_replace('{|money_option|}', ($pay->money_option == 1)? "Tiền Mặt":"Chuyển Khoản", $getcontent);
        }
        

        $getcontent_tmp = str_replace('{|name|}', $task['reporter_name'], $getcontent);
        $getcontent_tmp = str_replace('{|link|}', MailHelper::REAL_SERVER_SITE. "/manager-tasks/detail/" .$task['id'], $getcontent_tmp);
        if ($validator->isValid($task['reporter_email'])) {
            $this->SendMail(MailHelper::EMAIL_SYSTEM_NAME, $task['reporter_email'], $subject, $getcontent_tmp);
        }
        $getcontent_tmp = str_replace('{|name|}', $task['assign_name'], $getcontent);
        $getcontent_tmp = str_replace('{|link|}', MailHelper::REAL_SERVER_SITE. "/manager-tasks/detail/" .$task['id'], $getcontent_tmp);

        if($validator->isValid($task['assign_email'])){
               $this->SendMail(MailHelper::EMAIL_SYSTEM_NAME, $task['assign_email'], $subject, $getcontent_tmp);
        }
        if($type == Config::PAY_CUSTUMER){
             $getcontent_tmp = str_replace('{|name|}', $task['agency_name'], $getcontent);
             $getcontent_tmp = str_replace('{|link|}',MailHelper::REAL_SERVER_SITE. "/tasks/orderdetail/" .$task['id'], $getcontent_tmp);
             if ($validator->isValid($task['agency_email'])) {
                    $this->SendMail(MailHelper::EMAIL_SYSTEM_NAME, $task['agency_email'], $subject, $getcontent_tmp);
             }
        }
        if($type == Config::PAY_PROVIDER){
             $getcontent_tmp = str_replace('{|name|}', $task['provider_name'], $getcontent);
             $getcontent_tmp = str_replace('{|link|}',MailHelper::REAL_SERVER_SITE. "/tasks/taskdetail/" .$task['id'], $getcontent_tmp);
             if ($validator->isValid($task['provider_email'])) {
                    $this->SendMail(MailHelper::EMAIL_SYSTEM_NAME, $task['provider_email'], $subject, $getcontent_tmp);
             }
        }
        
        //echo $getcontent;
        return NULL;
    }
}