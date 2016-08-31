<?php

	// Include the class file
	require_once("xero.php");
	require_once("functions.php");
	require_once("config.php");

	class OrderTracking {
		static function logToFile($text) {
			$date = date('Y-m-d');
			$filename = "xero_$date.log";
			//file_put_contents(Config::APP_LOG_PATH_TRACKING.$filename, $text, FILE_APPEND);
		}
		
		static function addToXero($data) {
			$submitFile = $data['submitfile'];
			$submissionType = Functions::getXeroSubmissionType($submitFile);
			if (!$submissionType) {
				// not an appropriate submission. stop processing Xero
				echo "not a xero submission type<br/>";
				return;
			}
			echo "submissionType: $submissionType<br/>";
			
			$orderServiceType = $data['orderServiceType'];
			echo "orderServiceType: $orderServiceType<br/>";
			
			$orderType = Functions::getXeroOrderServiceType($orderServiceType);
			echo "orderType: $orderType<br/>";
			
			//$token = $data['token'];
			//echo 'token: '.$token.'<br/>';
			
			// get token settings
			//$tokenSettings = Functions::getXeroTokenSettings($token);
			
			// get contact name
			//$contactName = $tokenSettings["contactName"];
			$contactName = 'TimFoster';
			echo "contactName: $contactName<br/>";
			
			// get item number
			//$itemNumber = $tokenSettings['itemNumbers'][$submissionType][$orderType];
			$itemNumber = 'NSF-ED';
			echo "itemNumber: $itemNumber<br/>";
			
			$invoiceNumber = OrderTracking::createInvoice($data, $contactName, $itemNumber);
			echo "invoiceNumber: $invoiceNumber<br/>";
			
			// append to text log
			$logText = strftime('%Y-%m-%d %I:%M:%S %p')."\r\n";
			$logText .= "Contact Name: $contactName\r\n";
			$logText .= "Item Number: $itemNumber\r\n";
			$logText .= "Invoice Number: $invoiceNumber\r\n";
			$logText .= "\r\n";
			OrderTracking::logToFile($logText);
		}
	
		static function createInvoice($data, $contactName, $itemNumber ) {
			$xero = new Xero( 
				Config::XERO_KEY, 
				Config::XERO_SECRET, 
				Config::XERO_PATH_PUBLIC_CERT, 
				Config::XERO_PATH_PRIVATE_KEY );
				
			$date = strftime('%Y-%m-%d');
			
			// The input format for creating a new invoice (or credit note) see http://blog.xero.com/developer/api/invoices/
			$new_invoice = array(
				array(
					"Type" => "ACCREC",
					"Contact" => $data['contact'],
					"Date" => $data['date'],
					"Status" => $data['status'],
					"LineAmountTypes" => $data['lineAmountTypes'],
					"LineItems"=> $data['lineItems'],
					"Reference" => $data['Reference']
				)
			);

			// Raise an invoice
			$invoice_result = $xero->Invoices( $new_invoice );
			
			OrderTracking::logToFile(json_encode($new_invoice)."\r\n");
			
			OrderTracking::logToFile(json_encode($invoice_result)."\r\n\r\n");
			
			$invoiceNumber = $invoice_result['Invoices']['Invoice']['InvoiceNumber'];

			return $invoiceNumber;
		}
		
		
		static function createWPInvoice( $contactName, $itemNumber ) {
			$xero = new Xero( 
				Config::XERO_KEY, 
				Config::XERO_SECRET, 
				Config::XERO_PATH_PUBLIC_CERT, 
				Config::XERO_PATH_PRIVATE_KEY );
				
			$date = strftime('%Y-%m-%d');
			
			// The input format for creating a new invoice (or credit note) see http://blog.xero.com/developer/api/invoices/
			$new_invoice = array(
				array(
					"Type" => "ACCREC",
					"Contact" => array(
						"Name" => $contactName
					),
					"Date" => $date,
					"DueDate" => $date,	// remove?
					"Status" => "DRAFT",
					"Reference" => "ABC Super Fund NSF-ED",
					"Account" => "Sales",
					"LineAmountTypes" => "Exclusive",
					"LineItems"=> array(
						"LineItem" => array(
							array(
								"Description" => "Test Description of transaction",
								"Quantity" => "1.0000",
								"ItemCode" => $itemNumber
							)
						)
					)
				)
			);

			// Raise an invoice
			$invoice_result = $xero->Invoices( $new_invoice );
			
			OrderTracking::logToFile(json_encode($new_invoice)."\r\n");
			
			OrderTracking::logToFile(json_encode($invoice_result)."\r\n\r\n");
			
			$invoiceNumber = $invoice_result['Invoices']['Invoice']['InvoiceNumber'];

			return $invoiceNumber;
		}
	}

?>