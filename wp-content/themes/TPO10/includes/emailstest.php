<?PHP
require_once $_SERVER['DOCUMENT_ROOT'].'/classes/phpmailer/PHPMailerAutoload.php';
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
				echo 'past the mail object';
				//$body = file_get_contents('phpmailer/examples/contents.html',FILE_USE_INCLUDE_PATH);
				//$body = preg_replace('/[\]/','',$body);
				
				//echo $body;
				$mail->SetFrom('orders@paratus.com.au', 'Paratus Orders');

				$mail->AddReplyTo("orders@paratus.com.au","Paratus Orders");
				
				
				
				
				
				//$address = $adviserEmail;
				$mail->AddAddress('tim@justsuper.com.au', 'Tim Foster');
				
								
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
				$body = $body.'<br/><br/>To upload documents to Paratus, please follow these instructions:<br/>';
				$body = $body.'<ul>';
				$body = $body.'<li>1. Click <a href=\'www.paratus.com.au/my-account/view-order/?order='.$orderNumber.'\'>here</a> to view your order details (You may be asked to login again).</li>';
				$body = $body.'<li>2. At the top of the Order Details page, you will see a button titled \'Choose File\' - Click on this and browse to find the file you wish to upload. Note that allowed filetypes are doc, docx, and pdf online.</li>';
				$body = $body.'<li>3. You will see a list of your orders, with the most recent orders at the top. In the far right column titled \'Order Actions\' click on this icon <img src=\'http://www.paratus.com.au/wp-content/uploads/upload.png\' height=\'24\' width=\'24\'/></li>';
				$body = $body.'<li>4. Once you have selected the file you wish to upload, click the button titled \'Upload\'.</li>';
				$body = $body.'<li>5. That\'s it!</li>';
				$body = $body.'</ul>';
				$body = $body.'<br/><br/>Should you have any further questions regarding this order, please don\'t hesitate to contact us and quote your order reference: '.$orderNumber.'. <br/><br/><br/>Kind Regards,<br/><br/><b>The Paratus Team</b><br/><br/><b>Ph: 1800 72 72 887</b><br/><b>Email: orders@paratus.com.au</b>';
				$body = $body.'</body></html>'; 
				
				$mail->MsgHTML($body);
							
				$mail->SMTPDebug  = 1; // enables SMTP debug information (for testing)
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
				if(!$mail->Send()) {
				 echo "Mailer Error: " . $mail->ErrorInfo.print_r(error_get_last(), true);
				  
				} else {
				 echo "Message sent!";
				}

				
				$mail = NULL;
				/*************************
					SEND EMAIL END
				**************************
				*/
					
			
		

?>		