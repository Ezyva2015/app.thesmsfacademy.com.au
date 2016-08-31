<?php  
/** 
* Template Name: Code Testing 
*/
error_reporting(1);
?>
<div>
<?php // get_header()  ?>
</div>
<br><br><br><br> 
<div style="color:whit;">   
<?php    

// $attachments = array( WP_CONTENT_DIR . '/uploads/file_to_attach.zip' );
// $headers = 'From: My Name <noreply@thesmsfacademy.com.au>' . "\r\n";
// if(wp_mail( 'mrjesuserwinsuarez@gmail.com', 'subject', 'message', $headers)) {
// 	echo "mail sent <br>";
// } else {
// 	echo "mail not sent <br>";
// };





	 $form_id = 1;
	 $lead_id = 2;

	$to = array(
	    'mrjesuserwinsuarez@gmail.com',
	    'michael@automationlab.com.au'
	);
    // $to = "mrjesuserwinsuarez@gmail.com,support@automationlab.com.au,aarond@thesmsfacademy.com.au"; 
    $subject = "no template in the configuration will be used (because no rule/condition is met)"; 
    $message = "No pdf to generate form id: $form_id and lead id: $lead_id \r\n ";
  
    $headers =  'From: My Name <noreply@thesmsfacademy.com.au>' . "\r\n";  
    $headers .= array('Content-Type: text/html; charset=UTF-8');	
     
    if(wp_mail( $to , $subject, $message, $headers)) { 
    	echo "sent <br>";
    } else {
    	echo "not sent <br>";
   	}; 




 
	// $to = "mrjesuserwinsuarez@gmail.com";
	// $subject = "HTML email";

	// $message = "
	// <html>
	// <head>
	// <title>HTML email</title>
	// </head>
	// <body>
	// <p>This email contains HTML Tags!</p>
	// <table>
	// <tr>
	// <th>Firstname</th>
	// <th>Lastname</th>
	// </tr>
	// <tr>
	// <td>John</td>
	// <td>Doe</td>
	// </tr>
	// </table>
	// </body>
	// </html>
	// ";

	// // Always set content-type when sending HTML email
	// $headers = "MIME-Version: 1.0" . "\r\n";
	// $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

	// // More headers
	// $headers .= 'From: <noreply@thesmsfacademy.com.au>' . "\r\n"; 

	// if(mail($to,$subject,$message,$headers)){
	// 	echo "email sent";
	// } else {
	// 	echo "email not sent";
	// }

 

	// require 'inc/PHPMailer-master/PHPMailerAutoload.php';   
	// $mail = new PHPMailer;  
	// $mail->setFrom('michael@automationlab.com.au', 'Mailer');
	// $mail->addAddress('mrjesuserwinsuarez@gmail.com', 'Jesus User');     // Add a recipient  
	// $mail->addReplyTo('michael@automationlab.com.au', 'Information');  
	// $mail->isHTML(true);                                  // Set email format to HTML 
	// $mail->Subject = 'Here is the subject';
	// $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
	// $mail->AltBody = 'This is the body in plain text for non-HTML mail clients'; 
	// if(!$mail->send()) {
	//     echo 'Message could not be sent.';
	//     echo 'Mailer Error: ' . $mail->ErrorInfo;
	// } else {
	//     echo 'Message has been sent';
	// }




  
	// $to = "mrjesuserwinsuarez@gmail.com";
	// $subject = "My subject";
	// $txt = "Hello world!";
	// $headers = "From: noreply@thesmsfacademy.com.au"; 

	// if(mail($to,$subject,$txt,$headers)) { 
	// 	echo "sent"; 
	// } else { 
	// 	echo "not sent"; 
	// }   
	  




















	function get_template_url() { 
		echo "string";	 
		global $wpdb;  
		$mylink = $wpdb->get_row( "SELECT * FROM wp_tpl_docs WHERE lead_id = 1830 and form_id = 73 ", ARRAY_A ); 
		echo "<pre>"; 
		print_r($mylink); 
		echo "<br><br><br><br>"; 
		echo $mylink['file_url'] . '<br>';   
		return $mylink['file_url'];
	}
		



	?>
</div>


<br><br><br><br>


<?php //phpinfo(); ?>