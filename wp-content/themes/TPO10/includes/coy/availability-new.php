<?php

if (isset($_POST['companyName']))
{
$client = new SoapClient( "https://www.ecompanies.com.au/RegistrationService?wsdl", array('cache_wsdl' => WSDL_CACHE_NONE) );
$addRequest = new stdClass();
$addRequest->userName = "info@thesmsfacademy.com.au";
$addRequest->password = "Superannuation0";
$addRequest->companyName = $_POST['companyName']; 

echo "trying....";

try
{
	$result = $client->companyNameCheck($addRequest);
	print("Result is:<br/><pre> ");  
	print_r($result->return);
	print("</pre> ");  
} 
catch (SoapFault $soapFault) 
{
	echo "Fault $soapFault";
}
}

?>

<h2>Check name availability</h2>
<form action="availability-new.php" method="POST">
Enter your company name: <input type="text" name="companyName"/><input type="submit" name="submit"/>
</form>
