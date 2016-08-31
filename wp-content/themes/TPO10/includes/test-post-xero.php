<?php
error_reporting(-1);
ini_set('display_errors', 'on');

	$data['name'] = "ABC Accounting Pty Ltd";
	$data['firstName'] = "Joe";
	$data['lastName'] = "Bloggs";
	$data['emailAddress'] = "test@test.com";
	$data['date'] = "01/01/2014";
	$data['status'] = "DRAFT";
	$data['streetLevel'] = "Level 7";
	$data['streetStreet'] = "333 Collins Street";
	$data['streetSuburb'] = "Melbourne";
	$data['streetState'] = "Victoria";
	$data['streetPostcode'] = "3000";
	$data['postLevel'] = "Level 7";
	$data['postStreet'] = "333 Collins Street";
	$data['postSuburb'] = "Melbourne";
	$data['postState'] = "Victoria";
	$data['postPostcode'] = "3000";
	$data['itemCode'] = "NSF-PD";
	$data['itemDescription'] = "Documents for ABCDEF Fund";
	$data['itemPrice'] = "121.0000";
	$data['itemTaxType'] = "OUTPUT";
	$data['submitfile'] = "submit-nsf.php";
	$data['orderServiceType'] = "Paper Delivery";
	$data['Reference'] = "999999";
	
	$ch = curl_init('http://www.paratus.com.au/wp-content/themes/goodchoice/includes/post-xero.php');
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	
	$response = curl_exec($ch);
	echo $response;
?>