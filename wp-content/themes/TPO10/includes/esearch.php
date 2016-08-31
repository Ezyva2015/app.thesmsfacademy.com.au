<?php

	

	// QUERY NAME AVAILABILITY
	$wsdl = "http://www.esearch.net.au/soap/queryNameAvailability.wsdl";

    

	//DEFAULT VALUES
	//$company_search = 'SALT AND VINEGAR SOX';
	$company_search = $_GET['company'];
	

	//XML Params----
		$section_header = array("messageType"=>'QueryNameAvailability', "messageVersion"=>1.06, "clientReference"=>'CLIENT1', "messageTraceNumber"=>1,"messageCreationDate"=>'29/08/2013', "messageCreationTime"=>'22:50:53');
		$section_request_data = array("proposedName"=> $company_search, "companyNameAvailabilityCheck"=>true);
		$request_str =  array(  "Header" => $section_header,  "RequestData" => $section_request_data);
		$parameters= array( "Request" => $request_str );

    //----

	//Authentication Header----

		$params = array(

			'trace' => 1, 

			'exceptions'=>0,

			'login' => "paratus",

			'password' => '$uper123'

		);

	//----

	

	//Initialize SoapClient----

		$client = new SoapClient($wsdl, $params);

	

	//Function to call----

		$soapFunction = "SendQueryNameAvailability" ;

	

	//Call the function

		$client->__soapCall($soapFunction, $parameters) ;

		

	//Get last request

	$request = $client->__getLastRequest();

	

	//Get the result----

	$result = $client->__getLastResponse();

	

	//Display results----

	?>

		<style>

			body, div { background-color: #eFefef; color: #464646; }

			h1, h2 { background-color: #aaa; margin: 0px; margin-bottom: 32px; padding: 16px 12px; }

			h3, h4, h5, h6 { background-color: #CFCFCF;; margin: 24px 0px 12px 0px; padding: 8px 8px; }

		</style>

		<div style="width: 50%; min-width: 320px; float: left; border-right: 1px solid #ddd; padding: 8px; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;">

			<h2>queryNameAvailability</h2>

			<h3>DEFAULT VALUES</h3>

			<p><strong>Company Name:</strong> <?php echo $company_search; ?></p>

			<h3>REQUEST</h3>

			<div style="width: 100%; overflow: auto; border: 1px solid #eaeaea; padding: 8px; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;">

				<pre><?php

				

					echo htmlspecialchars($request, ENT_QUOTES);

					

				?></pre>

			</div>

			<h3>RESULT</h3>

			<div style="width: 100%; overflow: auto; border: 1px solid #eaeaea; padding: 8px; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;">	

				<pre><?php

				

					echo htmlspecialchars($result, ENT_QUOTES); 
					
					

				?></pre>

			</div>

			<h3>print_r (XML Output)</h3>

			<div style="width: 100%; overflow: auto; border: 1px solid #eaeaea; padding: 8px; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;">	

				<pre><?php

				

					echo print_r($result); 

					

				?></pre>

			</div>				

<?php

	

	//STORE RESULTS ON VARIABLE ARRAY

	

	$soap  = simplexml_load_string($result);

	$response = $soap->children('http://schemas.xmlsoap.org/soap/envelope/')->Body->children()->Reply;

	

	$checkAvailability_Header_Array = array();

	$checkAvailability_ReplyData_Array = array();

	

	echo '<h3>VALUES (Header)</h3>';

	
	echo 'The Response for the Query: '.$response->ReplyData->NameResult->code;
	echo '<p>';

	foreach( $response->Header as $a )

	{

		foreach( $a as $b => $c )

		{

			echo '<strong>'.$b.':</strong> '.$c.'<br /><br />';	

			$checkAvailability_Header_Array[] = array( $b => $c );

		}

	}

	echo '</p>';

	

	echo '<h4>var_dump</h4>';

	

	var_dump($checkAvailability_Header_Array);

	

	echo '<h3>VALUES (ReplyData)</h3>';

	

	echo '<p>';

	foreach( $response->ReplyData->NameResult as $a )

	{

		foreach( $a as $b => $c )

		{

			echo '<strong>'.$b.':</strong> '.$c.'<br /><br />';	

			$checkAvailability_ReplyData_Array[] = array( $b => $c );

		}

	}	

	echo '</p>';

	

	echo '<h4>var_dump</h4>';

	

	var_dump($checkAvailability_ReplyData_Array);

	echo '<h4>Print_r</h4>';
	echo $checkAvailability_ReplyData_Array[1]['code'][0];
?>

		</div>

<?php

	

	// QUERY CHECK COMPANY

	

	$wsdl = "http://www.esearch.net.au/soap/checkCompany.wsdl";

  

 	//DEFAULT VALUES

	//$company_acn = 123123124;
	$company_acn = $_GET['acn'];
	$company_name = $_GET['name'];

	//XML Params----

		$section_header = array("messageType"=>'CheckCompany', "messageVersion"=>1.06, "clientReference"=>'CLIENT1', "messageTraceNumber"=>1,"messageCreationDate"=>'29/08/2013', "messageCreationTime"=>'22:50:53');

		if(strlen($company_acn) > 0){
			$section_request_data = array("acn"=> $company_acn );
		}
		elseif (strlen($company_name) > 0){
			$section_request_data = array("companyName"=> $company_name );
		}
		else {
			$section_request_data = '';
		}
		

		

		$request_str =  array(  "Header" => $section_header,  "RequestData" => $section_request_data);

		

		$parameters= array( "Request" => $request_str );

    //----

	

	//Authentication Header----

		$params = array(

			'trace' => 1, 

			'exceptions'=>0,

			'login' => "paratus",

			'password' => '$uper123'

		);

	//----

	

	//Initialize SoapClient----

		$client = new SoapClient($wsdl, $params);

	

	//Function to call----

		$soapFunction = "SendCheckCompany" ;

	

	//Call the function

		$client->__soapCall($soapFunction, $parameters) ;



	//Get last request

	$request = $client->__getLastRequest();

	

	//Get the result----

	$result = $client->__getLastResponse();

	

	//Display results----

	?>

		<div style="width: 50%; min-width: 320px; float: left; border-left: 1px solid #ddd; padding: 8px; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;">

			<h2>checkCompany</h2>

			<h3>DEFAULT VALUES</h3>

			<p><strong>ACN:</strong> <?php echo $company_acn; ?></p>

			<h3>REQUEST</h3>

			<div style="width: 100%; overflow: auto; border: 1px solid #eaeaea; padding: 8px; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;">

				<pre><?php

				

					echo htmlspecialchars($request, ENT_QUOTES);

					

				?></pre>

			</div>

			<h3>RESULT</h3>

			<div style="width: 100%; overflow: auto; border: 1px solid #eaeaea; padding: 8px; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;">	

				<pre><?php

				

					echo htmlspecialchars($result, ENT_QUOTES); 
					
					

				?></pre>

			</div>

			<h3>print_r (XML Output)</h3>

			<div style="width: 100%; overflow: auto; border: 1px solid #eaeaea; padding: 8px; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;">	

				<pre><?php

				

					echo print_r($result); 

					

				?></pre>

			</div>

		

<?php

	

	//STORE RESULTS ON VARIABLE ARRAY

	

	$soap  = simplexml_load_string($result);

	$response = $soap->children('http://schemas.xmlsoap.org/soap/envelope/')->Body->children()->Reply;

	

	$checkCompany_Header_Array = array();

	$checkCompany_ReplyData_Array = array();

	

	echo '<h3>VALUES (Header)</h3>';

	

	echo '<p>';
	foreach( $response->Header as $a )

	{

		foreach( $a as $b => $c )

		{

			echo '<strong>'.$b.':</strong> '.$c.'<br /><br />';	

			$checkCompany_Header_Array[] = array( $b => $c );

		}

	}

	echo '</p>';

	

	echo '<h4>var_dump</h4>';

	var_dump($checkCompany_Header_Array);

	

	echo '<h3>VALUES (ReplyData)</h3>';

	

	echo '<p>';
	echo$response->ReplyData->Company->Organisation;
	foreach( $response->ReplyData->Company->Organisation as $a )

	{

		foreach( $a as $b => $c )

		{

			echo '<strong>'.$b.':</strong> '.$c.'<br /><br />';	

			$checkCompany_ReplyData_Array[] = array( $b => $c );

		}

	}	

	echo '</p>';

	

	echo '<h4>var_dump</h4>';

	var_dump($checkCompany_ReplyData_Array);

	

?>

	</div>

	