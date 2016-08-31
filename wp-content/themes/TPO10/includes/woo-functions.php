<?php
//////////////////////////////////////////////////////////
//														//
//														//
//														//
//			 Custom Woocommerce Functions. 				//
//														//
//														//
//														//
//////////////////////////////////////////////////////////

//Actions
//add_action( 'woocommerce_order_status_processing', 'check_if_any_items_electronic', 10, 2 ); //removed 24 April so that I can auto-complete all orders, not just electronic ones.
add_action( 'woocommerce_order_status_completed', 'check_type_of_product', 10, 2 );
add_action( 'woocommerce_payment_complete', 'perform_post_payment_duties', 10, 2 );
add_action( 'woocommerce_payment_complete', 'gravity_pdf', 10, 2 );

add_action('woocommerce_order_status_processing', 'zendesk_update_order');
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
add_action('woocommerce_before_main_content', 'my_theme_wrapper_start', 10);
add_action('woocommerce_after_main_content', 'my_theme_wrapper_end', 10);




//Filters
add_filter( 'woocommerce_variation_option_name', 'display_price_in_variation_option_name' );

//WooCommerce Theme Integration
function my_theme_wrapper_start() {
  echo '<div class="main_content_area">';
}

function my_theme_wrapper_end() {
  echo '</div>';
}


//Add prices to variations
function display_price_in_variation_option_name( $term ) {
global $wpdb, $product;

$term_temp = $term;
$term = strtolower($term);
$term = str_replace(' ', '-', $term);

$result = $wpdb->get_col( "SELECT slug FROM {$wpdb->prefix}terms WHERE name = '$term'" );

$term_slug = ( !empty( $result ) ) ? $result[0] : $term;

$query = "SELECT postmeta.post_id AS product_id
FROM {$wpdb->prefix}postmeta AS postmeta
LEFT JOIN {$wpdb->prefix}posts AS products ON ( products.ID = postmeta.post_id )
WHERE postmeta.meta_key LIKE 'attribute_%'
AND postmeta.meta_value = '$term_slug'
AND products.post_parent = $product->id";

$variation_id = $wpdb->get_col( $query );

$parent = wp_get_post_parent_id( $variation_id[0] );

if ( $parent > 0 ) {
$_product = new WC_Product_Variation( $variation_id[0] );
$testVariable = $_product->get_variation_attributes();
$itemPrice = strip_tags (woocommerce_price( $_product->get_price() ));
$getPrice = $_product->get_price();
$itemPriceInt = (int) $getPrice;
$term = $term_temp;

//this is where you can actually customize how the price is displayed
	if($itemPriceInt > 0){
		return $term . ' (' . $itemPrice . ' incl. GST)';
	}
	else {
		return $term . ' (' . $itemPrice . ')';
	}
	
}
return $term;

} 


function perform_post_payment_duties ($order_id){
	//create box folder
	$folderName = $order_id;
	$parentFolder = '1169288163';
	$urltopost = 'https://www.paratus.com.au/wp-content/themes/goodchoice/includes/paratus-box-api/boxapi/example.php';
	$body = array(
						'action' => 'create_folder',
						'folder_name' => $folderName,
						'parent_folder' => $parentFolder,
					 );
					 	$to = 'sonahj00@gmail.com';
			$subject = 'Post Payment duties';
			$message = 'Data: <br/>'.print_r($body, true);
			wp_mail( $to, $subject, $message); 
			
	$request = new WP_Http();
	$response = $request->post($urltopost, array('body' => $body, 'blocking' => false));

	//create Xero Invoice
	create_xero_invoice($order_id);
}


function check_if_any_items_electronic($order_id){
		if (!is_Null){
				$order = NULL;
			}
		global $post;
		$order = new WC_Order($order_id);
		$items = $order->get_items();
		$OrderItemIds = array_keys($items);
		$numberOfItems = $order->get_item_count();
		$counter = 0;
		$order_status = $order->status;
		$userID = $order->customer_user;
		$adviserEmail = $order->billing_email;
		$billingAddressFormatted = $order->get_formatted_billing_address();
		$billingAddress = $order->get_billing_address();
		$billingName = $order->billing_first_name.' '.$order->billing_last_name;//$billingFormatted;//
		$billingCompany = $order->billing_company;
		$billing_phone = $order->billing_phone;
		if (!is_null($order->billing_address_1)){
			$billingAddress1 = $order->billing_address_1;
		}
		else {
			$billingAddress1 = '';
		}
		
		if (!is_null($order->billing_address_2)){
			$billingAddress2 = $order->billing_address_2;
		}
		else {
			$billingAddress2 = '';
		}
		
		if (!is_null($order->billing_city)){
			$billingCity = $order->billing_city;
		}
		else {
			$billingCity = '';
		}
		
		if (!is_null($order->billing_state)){
			$billingState = $order->billing_state;
		}
		else {
			$billingState = '';
		}
		
		if (!is_null($order->billing_postcode)){
			$billingPostcode = $order->billing_postcode;
		}
		else {
			$billingPostcode = '';
		}
		
		foreach ($items as $item){
			
			$orderItemId = $OrderItemIds[$counter];
			$product = $order->get_product_from_item($item);
			$isVirtual = $product->is_virtual();
			if($isVirtual){ //check if electronic delivery
			//do nothing if virtual
			}
			else{
				//item is not virtual and is either paper delivery or premium service.
				//post data to server
				$emailToAdmin = 1;
				post_item_data_to_server($order_id, $orderItemId, $adviserEmail, $userID, $item, $billingAddressFormatted, $billingAddress, $billingName, $billingCompany, $billing_phone, $billingAddress1, $billingAddress2, $billingCity, $billingState, $billingPostcode);
			}
			
			//check if last order by 
			if($counter == $numberOfItems) {
				$isLastItem = 1;
				//this is last item - therefore it is time to mark order as 'complete'				
			}
			else {
				$isLastItem = 0;
			}
			
			$counter = $counter + 1;
		}

}

function mark_order_as_complete( $order_status, $order_id ) {

		$order = new WC_Order( $order_id );

		$order_status = 'complete';

		return $order_status;
	}

function mark_order_as_dispatching( $order_status, $order_id ) {

		$order = new WC_Order( $order_id );

		$order_status = 'dispatching';

		return $order_status;
	}
	
function check_type_of_product($order_id){
	create_xero_invoice($order_id);
		if (!is_Null){
				$order = NULL;
			}
		global $post;
		$order = new WC_Order($order_id);
		$items = $order->get_items();
		$OrderItemIds = array_keys($items);
		$numberOfItems = $order->get_item_count();
		$counter = 0;
		foreach ($items as $item){
			$orderItemId = $OrderItemIds[$counter];
			$product = $order->get_product_from_item($item);
			$productAttributes = $product->get_attributes();
			if(!is_null($productAttributes['webinarid']['value'])){
				$webinarId = $productAttributes['webinarid']['value']; 
			}
			else{
				$webinarId = NULL;
			}
			
			if(!is_null($webinarId)){
				  $billingAddress = $order->get_formatted_billing_address();
				  $firstName = $item['item_meta']['firstName'][0];
				  $lastName = $item['item_meta']['lastName'][0];
				  $email = $item['item_meta']['email'][0];
				  
				  $citrix = new CitrixAPI('5d8ab3cea37233d7d97dc1db5994fc9c','8876575418305764356');
				  $registerAttendee = $citrix->createRegistrant($webinarId, $firstName, $lastName, $email);
					
			}
			else{
							$userID = $order->customer_user;
							$adviserEmail = $order->billing_email;
							$billingAddressFormatted = $order->get_formatted_billing_address();
							$billingAddress = $order->get_billing_address();
							$billingName = $order->billing_first_name.' '.$order->billing_last_name;//$billingFormatted;//
							$billingCompany = $order->billing_company;
							$billing_phone = $order->billing_phone;
							if (!is_null($order->billing_address_1)){
								$billingAddress1 = $order->billing_address_1;
							}
							else {
								$billingAddress1 = '';
							}
							
							if (!is_null($order->billing_address_2)){
								$billingAddress2 = $order->billing_address_2;
							}
							else {
								$billingAddress2 = '';
							}
							
							if (!is_null($order->billing_city)){
								$billingCity = $order->billing_city;
							}
							else {
								$billingCity = '';
							}
							
							if (!is_null($order->billing_state)){
								$billingState = $order->billing_state;
							}
							else {
								$billingState = '';
							}
							
							if (!is_null($order->billing_postcode)){
								$billingPostcode = $order->billing_postcode;
							}
							else {
								$billingPostcode = '';
							}
				
				//if virtual product, post data to server as well.
				//$isVirtual = $product->is_virtual();
				//if($isVirtual){ 
					//$emailToAdmin = 0;
					
					//post_item_data_to_server($order_id, $orderItemId, $adviserEmail, $userID, $item, $billingAddressFormatted, $billingAddress, $billingName, $billingCompany, $billing_phone, $billingAddress1, $billingAddress2, $billingCity, $billingState, $billingPostcode, $emailToAdmin);
				//}
				//24 April 2014 - Altered so that all orders post data when complete so that I can auto-complete all orders, not just electronic ones.
				post_item_data_to_server($order_id, $orderItemId, $adviserEmail, $userID, $item, $billingAddressFormatted, $billingAddress, $billingName, $billingCompany, $billing_phone, $billingAddress1, $billingAddress2, $billingCity, $billingState, $billingPostcode, $emailToAdmin);
				generate_docs_on_data_server($order_id, $orderItemId, $product, $adviserEmail, $userID, $item, $billingAddressFormatted, $billingAddress, $billingName, $billingCompany, $billing_phone, $billingAddress1, $billingAddress2, $billingCity, $billingState, $billingPostcode);
			}
		
			$counter = $counter + 1;		
		}
		
				  
		$order = NULL;
}

function generate_docs_on_data_server($order_id, $orderItemId, $product, $adviserEmail, $userID, $item, $billingAddressFormatted, $billingAddress, $billingName, $billingCompany, $billing_phone, $billingAddress1, $billingAddress2, $billingCity, $billingState, $billingPostcode){
				
				  
				  
					$product_id = $item['product_id'];
					
					$trusteeType = $item['item_meta']['trusteeType'][0];
					$bareTrusteeType = $item['item_meta']['bareTrusteeType'][0];
				
				
					$isVirtual = $product->is_virtual();
				 
				
			
					
					if($isVirtual){ //check if electronic delivery
							//post_virtual_product_to_data_server_item($orderItemId, $adviserEmail, $userID, $item, $billingAddressFormatted, $billingAddress, $billingName, $billingCompany, $billing_phone, $billingAddress1, $billingAddress2, $billingCity, $billingState, $billingPostcode); //9 Oct 2013 - I commented this out because it was causing post_to_data_server to run more than once on multi-item orders.
					}
				
					
							
					if ($product_id == '1005') { //check if new smsf with either individual trustees or a corporate trustee which is already registered.
							
						$urltopost = "http://172.31.5.172/complete-nsf.php";	//NEW SERVER
							
							
					
					}
					
					if ($product_id == '1149') { //check if new smsf with a corporate trustee which needs to be registered as well.
							
						$urltopost = "http://172.31.5.172/complete-nsf.php";	//NEW SERVER
							
					
					}
					
					if ($product_id == '1128') { //check if new smsf with a corporate trustee which needs to be registered as well.
							
						$urltopost = "http://172.31.5.172/complete-coy.php";	//NEW SERVER
					
					}
					

					if ($product_id == '958') { //check if deed upgrade 
						$urltopost = "http://172.31.5.172/complete-sdv.php";					
					}
					
					
					$body = array(
						'orderNumber' => $order_id,
						'billingAddress' => $billingAddress,
						'orderItemID' => $orderItemId,
						'product_id'  => $product_id,
						'trusteeType' => $trusteeType,
						'emailToAdmin' => $emailToAdmin,
					 );
					 
					 
					if ($product_id == '965') { //check if borrowing
						$urltopost = "http://172.31.5.172/complete-borrowing.php";					
					
					
					$body = array(
						'orderNumber' => $order_id,
						'billingAddress' => $billingAddress,
						'orderItemID' => $orderItemId,
						'product_id'  => $product_id,
						'trusteeType' => $trusteeType,
						'bareTrusteeType' => $bareTrusteeType,
						'emailToAdmin' => $emailToAdmin,
					 );	
					}
					
					if ($product_id == '1975') { //check if related party borrowing
						$urltopost = "http://172.31.5.172/complete-borrowingRP.php";					
					
					
					$body = array(
						'orderNumber' => $order_id,
						'billingAddress' => $billingAddress,
						'orderItemID' => $orderItemId,
						'product_id'  => $product_id,
						'trusteeType' => $trusteeType,
						'bareTrusteeType' => $bareTrusteeType,
						'emailToAdmin' => $emailToAdmin,
					 );	
					}
					
					
					if ($product_id == '1338') { //check if pension
						$urltopost = "http://172.31.5.172/complete-pension.php";					
						
						$body = array(
						'orderNumber' => $order_id,
						'billingAddress' => $billingAddress,
						'orderItemID' => $orderItemId,
						'product_id'  => $product_id,
						'pensionType' => $item['item_meta']['pensionType'][0],
					 );
					}
					
					if ($product_id == '1330') { //check if change of trustee
						$urltopost = "http://172.31.5.172/complete-cot.php";					
						
						$body = array(
						'orderNumber' => $order_id,
						'billingAddress' => $billingAddress,
						'orderItemID' => $orderItemId,
						'product_id'  => $product_id,
					 );
					}
					
					if ($product_id == '2631') { //check if change of trustee
						$urltopost = "http://172.31.5.172/complete-fut.php";					
						
						$body = array(
						'orderNumber' => $order_id,
						'billingAddress' => $billingAddress,
						'orderItemID' => $orderItemId,
						'product_id'  => $product_id,
						'trusteeType' => $trusteeType,
						'estDate'	  => $item['item_meta']['estDate'][0],
					 );
					}
					
					$request = new WP_Http();
					$response = $request->post($urltopost, array('body' => $body, 'blocking' => false));
					
}

//function post_to_data_server($order_id){
function post_item_data_to_server($order_id, $orderItemId, $adviserEmail, $userID, $item, $billingAddressFormatted, $billingAddress, $billingName, $billingCompany, $billing_phone, $billingAddress1, $billingAddress2, $billingCity, $billingState, $billingPostcode, $emailToAdmin){
		//if $emailToAdmin is true, then email docs to admin rather than to client.
	 
		$orderDate = date('Y-m-d H:i:s');

		$billingArray = array (
		0 => $billingAddress1,
		1 => $billingAddress2,
		2 => $billingCity,
		3 => $billingState,
		4 => $billingPostcode
	
		);
		
		$deedVersion = '2014-1';
		$constitutionVersion = '2013-1';
		
		//$itemData = print_r($item, true);
			$product_name = $item['name'];
			$product_id = $item['product_id'];
			$trusteeType = $item['item_meta']['trusteeType'][0];		  
			$nameArray = explode(' ',trim($billingName));
			$firstName = $nameArray[0];	  
			
			switch ($product_id) {
				case '1005'://NSF with individual trustees or pre-registered corporate trustee
					if ($trusteeType == 'Individuals'){
						$body = nsf_individual_post_Data($item, $order_id, $deedVersion, $constitutionVersion, $billingArray, $billingName, $billingCompany, $billing_phone, $orderItemId, $adviserEmail, $userID, $orderDate);
					}
					if ($trusteeType == 'Company - Already Registered'){
						$body = nsf_corp_already_registered_post_Data($item, $order_id, $deedVersion, $constitutionVersion, $billingArray, $billingName, $billingCompany, $billing_phone, $orderItemId, $adviserEmail, $userID, $orderDate);
					}	
					
					 $urltopost = "http://172.31.5.172/submit-nsf.php";	
					 $requestNSF = new WP_Http();
					 $response = $requestNSF->post($urltopost, array('body' => $body, 'blocking' => false));

					break;
				
				case '1149'://NSF new corporate trustee registration
					$body = nsf_and_corp_post_data($item, $order_id, $deedVersion, $constitutionVersion, $billingArray, $billingName, $billingCompany, $billing_phone, $orderItemId, $adviserEmail, $userID, $orderDate);
					$urltopost = "http://172.31.5.172/submit-nsfcoy.php";	
					$requestNSFCO = new WP_Http();
					$response = $requestNSFCO->post($urltopost, array('body' => $body, 'blocking' => false));
					$to = 'tim@paratus.com.au';
						$subject = 'NSFCO Data';
						$message = 'Data: <br/>'.print_r($body, true);
						wp_mail( $to, $subject, $message); 
					break;

				
				case '958': //SDV
					if ($trusteeType == 'Individuals'){
						$body = sdv_indiv_post_Data($item, $order_id, $deedVersion, $constitutionVersion, $billingArray, $billingName, $billingCompany, $billing_phone, $orderItemId, $adviserEmail, $userID, $orderDate);
					}
					if ($trusteeType == 'Company - Already Registered'){
						$body = sdv_corp_post_Data($item, $order_id, $deedVersion, $constitutionVersion, $billingArray, $billingName, $billingCompany, $billing_phone, $orderItemId, $adviserEmail, $userID, $orderDate);
					}
					
					$urltopost = "http://172.31.5.172/submit-sdv.php";	
					$requestSDV = new WP_Http();
					$response = $requestSDV->post($urltopost, array('body' => $body, 'blocking' => false));
					break;
					
				
				case '1128'://New company registration
					$body = corp_post_Data($item, $order_id, $deedVersion, $constitutionVersion, $billingArray, $billingName, $billingCompany, $billing_phone, $orderItemId, $adviserEmail, $userID, $orderDate);
					$urltopost = "http://172.31.5.172/submit-coy.php";	
					$requestCOY = new WP_Http();
					$response = $requestCOY->post($urltopost, array('body' => $body, 'blocking' => false));
					break;
					
				case '1338'://New pension
					$body = pension_post_Data($item, $order_id, $deedVersion, $constitutionVersion, $billingArray, $billingName, $billingCompany, $billing_phone, $orderItemId, $adviserEmail, $userID, $orderDate);
					$urltopost = "http://172.31.5.172/submit-pension.php";	
					$requestPSN = new WP_Http();
					$response = $requestPSN->post($urltopost, array('body' => $body, 'blocking' => false));
					break;
					
				case '965'://New Borrowing - Bank
					$body = borrowing_post_Data($item, $order_id, $deedVersion, $constitutionVersion, $billingArray, $billingName, $billingCompany, $billing_phone, $orderItemId, $adviserEmail, $userID, $orderDate);
					$urltopost = "http://172.31.5.172/submit-borrowing.php";	
					$requestBNK = new WP_Http();
					$response = $requestBNK->post($urltopost, array('body' => $body, 'blocking' => false));
					break;
					
				case '1975'://New Borrowing - Related Party
					$body = borrowing_rp_post_Data($item, $order_id, $deedVersion, $constitutionVersion, $billingArray, $billingName, $billingCompany, $billing_phone, $orderItemId, $adviserEmail, $userID, $orderDate);
					$urltopost = "http://172.31.5.172/submit-borrowingRP.php";	
					$requestRP = new WP_Http();
					$response = $requestRP->post($urltopost, array('body' => $body, 'blocking' => false));
					 $to = 'tim@paratus.com.au';
						$subject = 'RP Borrowing Data';
						$message = 'Data: <br/>'.print_r($body, true);
						wp_mail( $to, $subject, $message); 
					break;	
					
					
					
				case '1330'://New Change of Trustee
					$body = cot_post_Data($item, $order_id, $deedVersion, $constitutionVersion, $billingArray, $billingName, $billingCompany, $billing_phone, $orderItemId, $adviserEmail, $userID, $orderDate);
					$urltopost = "http://172.31.5.172/submit-cot.php";	
					$requestCOT = new WP_Http();
					$response = $requestCOT->post($urltopost, array('body' => $body, 'blocking' => false));
					   // $to = 'tim@paratus.com.au';
						// $subject = 'Deed Rule';
						// $message = 'Data: <br/>'.print_r($body, true);
						// wp_mail( $to, $subject, $message); 
					break;
					
				case '2631'://New Fixed Unit Trust
					if ($trusteeType == 'Individuals'){
						$body = fut_individual_post_Data($item, $order_id, $billingArray, $billingName, $billingCompany, $billing_phone, $product_id, $adviserEmail, $userID, $orderDate);
					}
					if ($trusteeType == 'Company - Already Registered'){
						$body = fut_corp_already_registered_post_Data($item, $order_id, $billingArray, $billingName, $billingCompany, $billing_phone, $product_id, $adviserEmail, $userID, $orderDate);
					}	
					if ($trusteeType == 'Company'){
						$body = fut_corp_already_registered_post_Data($item, $order_id, $billingArray, $billingName, $billingCompany, $billing_phone, $product_id, $adviserEmail, $userID, $orderDate);
					}
					
					 $urltopost = "http://172.31.5.172/submit-fut.php";	
					 $requestNSF = new WP_Http();
					 $response = $requestNSF->post($urltopost, array('body' => $body, 'blocking' => false));
					  $to = 'tim@paratus.com.au';
						$subject = 'Deed Rule';
						$message = 'Data: <br/>'.print_r($body, true);
						wp_mail( $to, $subject, $message);
					break;	
				//2631
				
			}
	}

add_filter( 'woocommerce_payment_complete_order_status', 'virtual_order_payment_complete_order_status', 10, 2 );
 
function virtual_order_payment_complete_order_status( $order_status, $order_id ) {
  $order = new WC_Order( $order_id );
 
  if ( 'processing' == $order_status &&
       ( 'on-hold' == $order->status || 'pending' == $order->status || 'failed' == $order->status ) ) {
 
    $virtual_order = null;
 
    if ( count( $order->get_items() ) > 0 ) {
 
      foreach( $order->get_items() as $item ) {
 
        if ( 'line_item' == $item['type'] ) {
 
          $_product = $order->get_product_from_item( $item );
 
          
        }
      }
    }
 
    // virtual order, mark as completed
   
      return 'completed';
    
  }
 
  // non-virtual order, return original status
  return $order_status;
}
	
 
function zendesk_update_order( $order_id )
{
	
	$orders = new WC_Order( $order_id );
	
	$items = $orders->get_items();
	
	$set_plan = false;
	$plan = '';
	
	if ( !empty( $items ) )
	{
		foreach ( $items as $item )
		{
			$product_variation_id = $item['variation_id'];
			
			if ( $product_variation_id == 2400 )
			{
				$plan = 'Starter';
				$set_plan = true;
				break;
			}
			elseif ( $product_variation_id == 2401 )
			{
				$plan = 'Standard';
				$set_plan = true;
				break;
			}
			elseif ( $product_variation_id == 2402 )
			{
				$plan = 'Platinum';
				$set_plan = true;
				break;
			}
			else
			{
				//THIS ORDER HAS NO ITEMS WITH PACKAGE PLAN
				$plan = '';
			}
		}

		if ( $set_plan == true )
		{
			//STORE PURCHASED PACKAGE PLAN FOR FUTURE REFERENCE
			update_post_meta( $order_id, 'Plan', $plan );
			
			//START PROCESSING ZENDESK REQUESTS
			zendesk_process_user( $order_id );
		}
	}
}
?>