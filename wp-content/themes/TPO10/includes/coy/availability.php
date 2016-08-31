<?php

if (isset($_POST['companyName']))
{
	//$client = new SoapClient( "http://localhost:8080/RegistrationService?wsdl" );
	$client = new SoapClient( "https://www.ecompanies.com.au/RegistrationService?wsdl" );
	$addRequest = new stdClass();
	$addRequest->companyName = $_POST['companyName'];

	try
	{
		$result = $client->checkAvailability($addRequest);

		$return = $result->return;

		//php will return different things, so check the return type
		if (empty($return))
		{
			print("<h1>Congratulations, your company is available!</h1>");
		}
		else if (is_array($return))
		{
			print("<h1>Sorry, your name is considered identical to the following registered state business names:</h1>");
			foreach ($return as $r)
			{
				print("$r->name registered in $r->businessNumber<br/>");
			}
		}
		else
		{
			print("<h1>Sorry, your name is considered identical to the following registered company:</h1>");
			print("$return->name - $return->businessNumber<br/>");
		}
	} catch (SoapFault $soapFault) {
		echo "Fault $soapFault";
	}
}
?>

<h2>Check name availability</h2>
<form action="availability.php" method="POST">
Enter your company name: <input type="text" name="companyName"/><input type="submit" name="submit"/>
</form>

