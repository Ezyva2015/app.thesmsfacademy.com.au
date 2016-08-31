<?php
//////////////////////////////////////////////////////////
//														//
//														//
//														//
//					 Create Xero Invoices. 				//
//														//
//														//
//														//
//////////////////////////////////////////////////////////

function create_xero_invoice($order_id){
//create Xero Invoice
$to = 'tim@paratus.com.au';
						$subject = 'Started Xero Invoice Method';
						$message = '';
						wp_mail( $to, $subject, $message); 
		$data = array();
		$order = new WC_Order($order_id);
		$items = $order->get_items();
		$OrderItemIds = array_keys($items);
		$numberOfItems = $order->get_item_count();
		$data['firstName'] = $order->billing_first_name;
		$data['lastName'] = $order->billing_last_name;
		$data['emailAddress'] = $order->billing_email;
		$data['date'] = "01/01/2014";
		$data['status'] = "DRAFT";
		
		if(!is_null($order->billing_company)){
			$data['name'] = $order->billing_company;
		}
		else {
			$data['name'] = $order->billing_first_name.' '.$order->billing_last_name;
		}
		
		if (!is_null($order->billing_address_1)){
			$data['streetLevel'] = $order->billing_address_1;
			$data['postLevel'] = $order->billing_address_1;
		}
		else {
			$data['streetLevel'] = '';
			$data['postLevel']  = '';
		}
		
		if (!is_null($order->billing_address_2)){
			$data['streetStreet'] = $order->billing_address_2;
			$data['postStreet'] = $order->billing_address_2;
		}
		else {
			$data['streetStreet'] = '';
			$data['postStreet'] = '';
		}
		
		if (!is_null($order->billing_city)){
			$data['streetSuburb'] = $order->billing_city;
			$data['postSuburb'] = $order->billing_city;
		}
		else {
			$data['streetSuburb'] = '';
			$data['postSuburb'] = '';
		}
		
		if (!is_null($order->billing_state)){
			$data['streetState'] = $order->billing_state;
			$data['postState'] = $order->billing_state;
		}
		else {
			$data['streetState'] = '';
			$data['postState'] = '';
		}
		
		if (!is_null($order->billing_postcode)){
			$data['streetPostcode'] = $order->billing_postcode;
			$data['postPostcode'] = $order->billing_postcode;
		}
		else {
			$data['streetPostcode'] = '';
			$data['postPostcode'] = '';
		}
	
		$data['contact'] = array (
		"Name" 			=> $data['name'],
		"FirstName" 	=> $data['firstName'],
		"LastName" 		=> $data['lastName'],
		"EmailAddress"	=> $data['emailAddress'],
		"Addresses"		=> array (
			"Address" => array (
						"AddressType" => "STREET",
						"AddressLine1" => $data['streetLevel'],
						"AddressLine2" => $data['streetStreet'],
						"City" => $data['streetSuburb'],
						"Region" => $data['streetState'],
						"PostalCode" => $data['streetPostcode']
							),
			"Address" => array (
						"AddressType" => "POBOX",
						"AddressLine1" => $data['postLevel'],
						"AddressLine2" => $data['postStreet'],
						"City" => $data['postSuburb'],
						"Region" => $data['postState'],
						"PostalCode" => $data['postPostcode']
							)
		
		)
	
	);
		
		$counter = 0;
		$data['submitfile'] = "submit-nsf.php";
		$data['orderServiceType'] = $item['item_meta']['Service Type'][0];
		$data['Reference'] = $order_id;	
		foreach ($items as $item){
			$orderItemId = $OrderItemIds[$counter];
			$product_id = $item['product_id'];
			$product = $order->get_product_from_item($item);
			$product_sku = $product->get_sku();
			$lastTwoLetters = substr($product_sku, -2);
			if($lastTwoLetters == "ED"){
				$data['orderServiceType'] = "Electronic Delivery";
			}
			elseif($lastTwoLetters == "PD") {
				$data['orderServiceType'] = "Paper Delivery";
			}
			else{
				$data['orderServiceType'] = "Premium Service";
			}
			
			
			switch($product_id){
				case "1005": //NSF
					$description = "Documentation for the establishment of ".$item['item_meta']['fundName'][0];
					$itemCode = 'NSF-'.$lastTwoLetters;
					$taxType = "OUTPUT";
					$itemPrice = $item['line_subtotal'];
					$hasCompany = 0;
				break;
				
				case "1149": //NSFCOY
					$description = "Documentation for the establishment of ".$item['item_meta']['fundName'][0]." and incorporation of ".$item['item_meta']['companyName'][0]." ".$item['item_meta']['companySuffix'][0];
					$itemCode = 'NSFCOY-'.$lastTwoLetters;
					$taxType = "OUTPUT";
					$itemPrice = $item['line_subtotal'] - 444;
					$hasCompany = 1;
				break;
				
				case "1128": //COY
					$description = "Documentation for the incorporation of ".$item['item_meta']['companyName'][0]." ".$item['item_meta']['companySuffix'][0];
					$itemCode = 'COY-'.$lastTwoLetters;
					$taxType = "OUTPUT";
					$itemPrice = $item['line_subtotal'] - 444;
					$hasCompany = 1;
				break;
				
				case "958": //SDV
					$description = "Documentation to update the trust deed for ".$item['item_meta']['fundName'][0];
					$itemCode = 'SDV-'.$lastTwoLetters;
					$taxType = "OUTPUT";
					$itemPrice = $item['line_subtotal'];
					$hasCompany = 0;
				break;
				
				case "965": //Borrowing
					$description = "Documentation to implement a limited recourse borrowing arrangement for ".$item['item_meta']['fundName'][0];
					$itemCode = 'LRBA-'.$lastTwoLetters;
					$taxType = "OUTPUT";
					$itemPrice = $item['line_subtotal'];
					$hasCompany = 0;
				break;
				
				case "1338": //Pension
					$description = "Documentation for the the commencement of a SMSF pension for ".$item['item_meta']['fundName'][0];
					$itemCode = 'PSN-'.$lastTwoLetters;
					$taxType = "OUTPUT";
					$itemPrice = $item['line_subtotal'];
					$hasCompany = 0;
				break;
				
				case "1330": //COT
					$description = "Documentation for the the commencement of a SMSF pension for ".$item['item_meta']['fundName'][0];
					$itemCode = 'COT-'.$lastTwoLetters;
					$taxType = "OUTPUT";
					$itemPrice = $item['line_subtotal'];
					$hasCompany = 0;
				break;
			}

			$lineItem = array(
						 "Quantity" => "1.0000",
						 "ItemCode" => $itemCode,
						 "Description" => $description,
						 "UnitAmount" => $itemPrice,
						 "TaxType" => $taxType
					 );
					 
			
			$data['lineAmountTypes'] = "Inclusive";
			$data['lineItems'] = 	array(
								"LineItem" => array ()
							);
			
			$data['date'] = '';
							
			$data['lineItems']['LineItem'][] = $lineItem;
			
			if($hasCompany == 1){
			$lineItem = array(
						 "Quantity" => "1.0000",
						 "ItemCode" => "ASIC",
						 "Description" => "ASIC Fee for Incorporation of ".$item['item_meta']['companyName'][0]." ".$item['item_meta']['companySuffix'][0],
						 "UnitAmount" => "444.0000",
						 "TaxType" => "EXEMPTOUTPUT"
					 );
			
			$data['lineItems']['LineItem'][] = $lineItem;
			
			}
				
		}

	$request = new WP_Http();
					$response = $request->post('http://www.paratus.com.au/wp-content/themes/goodchoice/includes/post-xero.php', array('body' => $data, 'blocking' => false));

}

?>