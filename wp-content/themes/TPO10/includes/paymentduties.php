<?php
add_action( 'woocommerce_payment_complete', 'perform_post_payment_duties', 10, 2 );
	
	
	
	function perform_post_payment_duties ($order_id){
		//create box folder
		$folderName = $order_id;
		$parentFolder = '1169288163';
		$urltopost = 'http://www.paratus.com.au/wp-content/themes/goodchoice/includes/paratus-box-api/boxapi/example.php';
		$body = array(
		'action' => 'create_folder',
		'folder_name' => $folderName,
		'parent_folder' => $parentFolder,
		); 

		$request = new WP_Http();
    	$response = $request->post($urltopost, array('body' => $body, 'blocking' => false));
		

		 
		
	}
	
	?>