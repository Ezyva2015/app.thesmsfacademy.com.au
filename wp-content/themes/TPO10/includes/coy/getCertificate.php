<?php
/*

Valid Statuses are:

Incomplete
Submitted to ASIC
Submitted to ASIC - Reserved pending action by applicant
Submitted to ASIC - Manual review invoked
Submitted to ASIC - Temporarily reserved subject to ASIC decision
Failed ASIC validation
Rejected
Transmission to ASIC failed
Payment failed
Order complete

*/

$client = new SoapClient( "https://www.ecompanies.com.au/RegistrationService?wsdl" );
$addRequest = new stdClass();
$addRequest->userName = "info@thesmsfacademy.com.au";
$addRequest->password = "Superannuation0";
if(isset($_POST['orderid'])){
	$addRequest->orderId = $_POST['orderid']; //put your order id in here
} else {
	$addRequest->orderId = $_GET['orderid']; //put your order id in here
}
if(strlen($addRequest->orderId) > 0){
try
{
	$result = $client->getCertificate($addRequest);
	$return = $result->return;
	$acn = $return->acn;
	$certificate = $return->certificate;
	$companyName = $return->companyName;	
	file_put_contents($acn.".pdf", $certificate);
	//echo $certificate;
	echo 'Certificate saved on server for '.$companyName." (ACN ".$acn.")";
 
} 
catch (SoapFault $soapFault) 
{
	echo "Fault $soapFault";
}
}
else{
echo "Invalid Request";
}

//Status "Submitted to ASIC" - this means successfuly sent to ASIC
//Status "Order complete" - this means successfully registered
//Status "Rejected" - this means the order was rejected by ASIC
//Status "Incomplete" - this means the order is incomplete, and has not been sent to ASIC

