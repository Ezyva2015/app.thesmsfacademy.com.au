<?PHP
class Emails {
	static function sendUploadEmail($email, $orderNumber, $fullName, $firstName, $orderType, $subject) {
			echo 'sending email...<br/>';
				/*************************
					SEND EMAIL START
				**************************
				*/
				try {			
				$mail = new PHPMailer(); // defaults to using php "mail()"
				$mail->IsSMTP();
				$mail->Host = "localhost";
				//$entityDocuments = 'D:\\documentation_output\\pdf_versions\\'.$entityId.'.zip';
				//echo $entityDocuments;
				//$body = file_get_contents('phpmailer/examples/contents.html',FILE_USE_INCLUDE_PATH);
				//$body = preg_replace('/[\]/','',$body);
				
				//echo $body;
				$mail->SetFrom('orders@paratus.com.au', 'Paratus Orders');

				$mail->AddReplyTo("orders@paratus.com.au","Paratus Orders");
				
				$orderType = $orderType;
				
				
				if($orderType == "SMSF Deed Update") {
					
				}
				else {
					
				}
				
				
				
				//$address = $adviserEmail;
				$mail->AddAddress($email, $fullName);
				
				//Add PDF instructions
				$mail->AddAttachment($_SERVER['DOCUMENT_ROOT'].'/wp-content/uploads/Uploading_a_file_to_the_Paratus_website.pdf', "Upload Instructions.pdf");
								
				$mail->Subject    = $subject;
				
				$body = '<html> 
                <head> 
                    <style type="text/css" media="screen"> 
					body {font-family:arial, verdana, sans-serif; font-size: 10pt;} 
                    </style> 
                </head> 
                    <body> 
					';
				$body = $body.'Dear '.$firstName.'<br/><br/>Thank you for ordering your documentation from Paratus. So we can proceed to the next stage, we require you to upload a copy of the fund\'s current deed (if you haven\'t already done so).';
				$body = $body.'<br/><br/>If you are uploading a file for the first time, we have included a set of instructions for you to follow (see attachment called \'Upload Instructions.pdf\').<br/>';
				$body = $body.'<br/><br/>Should you have any further questions regarding this order, please don\'t hesitate to contact us and quote your order reference: '.$orderNumber.'. <br/><br/><br/>Kind Regards,<br/><br/><b>The Paratus Team</b><br/><br/><b>Ph: 1800 72 72 887</b><br/><b>Email: orders@paratus.com.au</b>';
				$body = $body.'</body></html>'; 
				
				$mail->MsgHTML($body);
							
				//$mail->SMTPDebug  = 1; // enables SMTP debug information (for testing)
                       // 1 = errors and messages
                       // 2 = messages only
				
				
				$mail->Send();
					
				} 
				
				 			
				catch (phpmailerException $e) {
							
						  echo $e->errorMessage()."Mailer Error: " . $mail->ErrorInfo.print_r(error_get_last(), true); //Pretty error messages from PHPMailer
						} 
				catch (Exception $e) {
						
						  echo $e->getMessage()."Mailer Error: " . $mail->ErrorInfo.print_r(error_get_last(), true); //Boring error messages from anything else!
						}
				//if(!$mail->Send()) {
				 // echo "Mailer Error: " . $mail->ErrorInfo.print_r(error_get_last(), true);
				  
			//	} else {
				//  echo "Message sent!";
			//	}

				
				$mail = NULL;
				/*************************
					SEND EMAIL END
				**************************
				*/
					
			
		}		
}
?>		