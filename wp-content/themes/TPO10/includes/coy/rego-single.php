<html>
<head>
  <title>rego</title>
  <style type="text/css">
    td {width:330px;}
    th {text-align:left;width:250px;}
    td.error { color:red;} 
  </style>	
</head>
<?php

print("<pre>");
print_r($_POST);
print("</pre>");
$errors = array();

if (isset($_POST['companyDetails_orgNameNoLegal']))
{
	$request = new stdClass();
	$request->userName = "info@thesmsfacademy.com.au";
	$request->password = "Superannuation0";

	$form201 = new stdClass();
	$request-> form201 = $form201;
	$officers = array();
	$shareHoldings = array();

	//we'll make a few assumptions
	//1. This is a standard pty ltd company
	//2. It has no special purpose
	//3. Not previously reserved
	//4. No identical business names
	//5. It will be using a preferred company name

	//Stupid php substitutes periods for underscores 
	$companyDetails 											= new stdClass();
	$companyDetails->orgNameNoLegal 							= $_POST['companyDetails_orgNameNoLegal'];
	$companyDetails->legalElements 								= $_POST['companyDetails_legalElements'];
	$companyDetails->jurisdiction 								= $_POST['companyDetails_jurisdiction'];
	$companyDetails->useAcn 									= false;
	$companyDetails->companyType 								= "APTY";
	$companyDetails->companyClass 								= "LMSH";
	$companyDetails->companySubClass 							= "PROP";
	$companyDetails->bn 										= false;
	$companyDetails->reserved 									= false;
	$companyDetails->areOHAddressesResidential 					= true;
	
	//Add company details to Form 201 Object	
	$form201->companyDetails 									= $companyDetails;

	$registeredOffice = new stdClass();
	$registeredOffice->occupyAddress 							= true;

	//6. the company occupies the registered office	
	$registeredOfficeAddress 									= new stdClass();
	$registeredOfficeAddress->careOf 							= $_POST['registeredOffice_registeredOffice_careOf'];
	$registeredOfficeAddress->addrLine2 						= $_POST['registeredOffice_registeredOffice_addrLine2'];
	$registeredOfficeAddress->addrStreet 						= $_POST['registeredOffice_registeredOffice_addrStreet'];
	$registeredOfficeAddress->city 								= $_POST['registeredOffice_registeredOffice_city'];
	$registeredOfficeAddress->state 							= $_POST['registeredOffice_registeredOffice_state'];
	$registeredOfficeAddress->postcode 							= $_POST['registeredOffice_registeredOffice_postcode'];
	$registeredOffice->registeredOffice 						= $registeredOfficeAddress;
	
	//Add registered office to Form 201 Object
	$form201->registeredOffice 									= $registeredOffice;

	//7. the principal place of business is the same as the registered office.
	$placeOfBusiness 											= new stdClass();
	$principalAddress 											= new StdClass();
	$placeOfBusiness->principalAddress 							= $principalAddress;
	$principalAddress->careOf 									= $_POST['registeredOffice_registeredOffice_careOf'];
	$principalAddress->addrLine2 								= $_POST['registeredOffice_registeredOffice_addrLine2'];
	$principalAddress->addrStreet 								= $_POST['registeredOffice_registeredOffice_addrStreet'];
	$principalAddress->city 									= $_POST['registeredOffice_registeredOffice_city'];
	$principalAddress->state 									= $_POST['registeredOffice_registeredOffice_state'];
	$principalAddress->postcode 								= $_POST['registeredOffice_registeredOffice_postcode'];
	
	//Add PPOB to Form 201 Object
	$form201->placeOfBusiness 									= $placeOfBusiness;

	//Officeholder 1 - Start
	$officer 													= new stdClass();
	$officer->director 											= $_POST['officers_director'];
	$officer->secretary 										= $_POST['officers_secretary'];

	$officerDetails 											= new stdClass();
	$officerName 												= new stdClass();
	$officerName->givenName 									= $_POST['officers_companyOfficer_officer_givenName'];
	$officerName->givenName2 									= $_POST['officers_companyOfficer_officer_givenName2'];
	$officerName->familyName 									= $_POST['officers_companyOfficer_officer_familyName'];
	$officerDetails->officer 									= $officerName;

	$officerAddress 											= new stdClass();
	$officerAddress->addrLine2 									= $_POST['officers_companyOfficer_officerAddress_addrLine2'];
	$officerAddress->addrStreet 								= $_POST['officers_companyOfficer_officerAddress_addrStreet'];
	$officerAddress->city 										= $_POST['officers_companyOfficer_officerAddress_city'];
	$officerAddress->state 										= $_POST['officers_companyOfficer_officerAddress_state'];
	$officerAddress->postcode 									= $_POST['officers_companyOfficer_officerAddress_postcode'];
	$officerAddress->countryDisplay 							= $_POST['officers_companyOfficer_officerAddress_countryDisplay'];
	$officerDetails->officerAddress 							= $officerAddress;

	$birthDetails 												= new stdClass();
	try 
	{
		$date 													= date_create_from_format( 'd/m/Y', $_POST['officers_companyOfficer_birthDetails_date']);

		$birthDetails->date 									= empty($date) ? "" : $date->getTimeStamp();
	} 
	catch (Exception $e) 
	{
		//ignored
	}

	$birthDetails->town 										= $_POST['officers_companyOfficer_birthDetails_town'];
	$birthDetails->state 										= $_POST['officers_companyOfficer_birthDetails_state'];
	$birthDetails->country 										= $_POST['officers_companyOfficer_birthDetails_country'];
	$officerDetails->birthDetails 								= $birthDetails;

	$officer->companyOfficer 									= $officerDetails;
	
	//Add Officer 1 to Officers array
	$officers[] = $officer;
	
	//Shares
	$shareHolder 												= new stdClass();
	//we have to clone otherwise php uses a href in the request
	$shareHolder->person 										= clone $officerName;
	$shareHolder->isPerson 										= true;
	$shareHolder->address 										= clone $officerAddress;

	$shareDetails 												= new stdClass();
	$shareDetails->shareClassCode 								= $_POST['shareMembers1_holding_shareClassCode'];
	$shareDetails->agreedNumber 								= $_POST['shareMembers1_holding_agreedNumber'];
	$shareDetails->amountPaid 									= $_POST['shareMembers1_holding_amountPaid'];
	$shareDetails->totalAmountPaid 								= $_POST['shareMembers1_holding_totalAmountPaid'];
	$shareDetails->beneficialOwner 								= $_POST['shareMembers1_holding_beneficialOwner'];

	//over here we work out a few things
	$totalAmountUnpaid 											= $shareDetails->totalAmountPaid - ($shareDetails->agreedNumber * $shareDetails->amountPaid);
	$shareDetails->fullyPaid 									= ($totalAmountUnpaid == 0);
	$shareDetails->amountUnpaid 								= $totalAmountUnpaid / $shareDetails->agreedNumber;
	$shareDetails->totalAmountUnpaid 							= $totalAmountUnpaid;

	$shareHolding 												= new stdClass();
	$shareHolding->holding 										= $shareDetails;
	$shareHolding->members 										= array($shareHolder);

	//Add shareholding 1 to shareholdings array
	$shareHoldings[] = $shareHolding;
	
	//Applicant - Start
	$applicant 													= new stdClass();
	$applicant->applicant 										= clone $officerName;
	$applicant->address 										= clone $officerAddress;
	$form201->applicant 										= $applicant;
	//Applicant - End
	
	

	
	//Add Officers to Form 201 Object
	$form201->officers 											= $officers;
	
	//Add Shareholdings to Form 201 Object
	$form201->shareMembers 										= $shareHoldings;
	
	
	
	
	
	$client = new SoapClient( "https://www.ecompanies.com.au/RegistrationService?wsdl", array('trace' => 1));

	try
	{
		//$result = $client->getConsents($request);
		$result = $client->registerCompany($request);
		print("<h1>Your order id is $result->return </h1>");

		//$pdf_decoded = base64_decode ($result->return);
		//Write data back to pdf file
		//$pdf = fopen ('test.pdf','w');
		//fwrite ($pdf,$pdf_decoded);
		//close output file
		//fclose ($pdf);
		//echo 'Done';
	} 
	catch (SoapFault $soapFault) 
	{
		//echo $soapFault;
		print("<h1>The following errors were found with your application</h1>");
		
		if (is_array($soapFault->detail->ValidationException->errors))
		{
			foreach ($soapFault->detail->ValidationException->errors as $r)
			{
				print("$r->property <b>$r->message</b><br/>");
				//change periods to underscores to be consistent...
				$property = str_replace(".", "_", $r->property);
				$errors["$property"] = $r->message;
			}
		}
		else
		{
			var_dump($soapFault->detail->ValidationException->errors);
		}
	}
}
?>
<body>
<h2>Register a company now!</h2>
<form action="rego-single.php" method="POST">
<h3>Company Details</h3>
<table cellspacing="10px">
<tr>
  <th>Proposed Name</th>
  <td><input type="text" name="companyDetails_orgNameNoLegal" value="<?php echo $_POST['companyDetails_orgNameNoLegal'] ?>"/></td>
  <td class="error"><?php echo $errors["companyDetails_orgNameNoLegal"] ?></td>
</tr>
<tr>
  <th>Legal Elements</th>
  <td>
     <select name="companyDetails_legalElements"> 
       <option value="PTY. LTD.">PTY. LTD.</option><option value="PTY. LTD">PTY. LTD</option><option value="PTY. LIMITED">PTY. LIMITED</option><option value="PTY LTD">PTY LTD</option><option value="PTY LTD.">PTY LTD.</option><option value="PTY LIMITED">PTY LIMITED</option><option value="PROPRIETARY LTD.">PROPRIETARY LTD.</option><option value="PROPRIETARY LTD">PROPRIETARY LTD</option><option value="PROPRIETARY LIMITED">PROPRIETARY LIMITED</option> 
     </select> 
  </td>
  <td class="error"><?php echo $errors["companyDetails_legalElements"] ?></td>
</tr>
<tr>
  <th>Jurisdiction</th>
  <td>
    <select name="companyDetails_jurisdiction"> 
       <option value="">Please select</option> 
       <option value="ACT">Australian Capital Territory</option><option value="NSW">New South Wales</option><option value="NT">Northern Territory</option><option value="QLD">Queensland</option><option value="SA">South Australia</option><option value="TAS">Tasmania</option><option value="VIC">Victoria</option><option value="WA">Western Australia</option> 
     </select> 
  </td>
  <td class="error"><?php echo $errors["companyDetails_jurisdiction"] ?></td>
</tr>
</table>
<h3>Address Details</h3>
<h4>Registered Office</h4>
<table cellspacing="10px">
<tr>
  <th>Care Of</th>
  <td><input type="text" name="registeredOffice_registeredOffice_careOf" value="<?php echo $_POST['registeredOffice_registeredOffice_careOf'] ?>"/></td>
  <td class="error"><?php echo $errors["registeredOffice_registeredOffice_careOf"] ?></td>
</tr>
<tr>
  <th>Unit/Level/Suite</th>
  <td><input type="text" name="registeredOffice_registeredOffice_addrLine2" value="<?php echo $_POST['registeredOffice_registeredOffice_addrLine2'] ?>"/></td>
  <td class="error"><?php echo $errors["registeredOffice_registeredOffice_addrLine2"] ?></td>
</tr>
<tr>
  <th>Street number and street name</th>
  <td><input type="text" name="registeredOffice_registeredOffice_addrStreet" value="<?php echo $_POST['registeredOffice_registeredOffice_addrStreet'] ?>"/></td>
  <td class="error"><?php echo $errors["registeredOffice_registeredOffice_addrStreet"] ?></td>
</tr>
<tr>
  <th>Suburb, town or city</th>
  <td><input type="text" name="registeredOffice_registeredOffice_city" value="<?php echo $_POST['registeredOffice_registeredOffice_city'] ?>"/></td>
  <td class="error"><?php echo $errors["registeredOffice_registeredOffice_city"] ?></td>
</tr>
<tr>
  <th>State</th>
  <td>
    <select name="registeredOffice_registeredOffice_state"> 
      <option value="">Please select</option> 
      <option value="ACT">Australian Capital Territory</option><option value="NSW">New South Wales</option><option value="NT">Northern Territory</option><option value="QLD">Queensland</option><option value="SA">South Australia</option><option value="TAS">Tasmania</option><option value="VIC">Victoria</option><option value="WA">Western Australia</option> 
    </select>  
  </td>
  <td class="error"><?php echo $errors["registeredOffice_registeredOffice_state"] ?></td>
</tr>
<tr>
  <th>Postcode</th>
  <td><input type="text" name="registeredOffice_registeredOffice_postcode" value="<?php echo $_POST['registeredOffice_registeredOffice_postcode'] ?>"/></td>
  <td class="error"><?php echo $errors["registeredOffice_registeredOffice_postcode"] ?></td>
</tr>
</table>

<h3>Office Holder 1</h3>
<table cellspacing="10px">
<tr>
  <th>First Name</th>
  <td><input name="officers_companyOfficer_officer_givenName" type="text"  value="<?php echo $_POST['officers_companyOfficer_officer_givenName'] ?>"/></td>
  <td class="error"><?php echo $errors["officers[0]_companyOfficer_officer_givenName"] ?></td>
</tr>
<tr>
  <th>Middle Name</th>
  <td><input name="officers_companyOfficer_officer_givenName2" type="text"  value="<?php echo $_POST['officers_companyOfficer_officer_givenName2'] ?>"/></td>
  <td class="error"><?php echo $errors["officers[0]_companyOfficer_officer_givenName2"] ?></td>
</tr>
<tr>
  <th>Surname</th>
  <td><input name="officers_companyOfficer_officer_familyName" type="text"  value="<?php echo $_POST['officers_companyOfficer_officer_familyName'] ?>"/></td>
  <td class="error"><?php echo $errors["officers[0]_companyOfficer_officer_familyName"] ?></td>
</tr>
<tr>
  <th>Offices Held</th>
  <td>
    <input name="officers_director" value="true" type="checkbox" />Director<br/> 
    <input name="officers_secretary" value="true" type="checkbox" />Secretary
  </td>
  <td class="error"><?php echo $errors["officers[0]_officesHeld"] ?></td>
</tr>
<tr>
  <th colspan="2">Residential Address</th>
</tr>
<tr>
  <th>Unit/Level/Suite</th>
  <td><input name="officers_companyOfficer_officerAddress_addrLine2" type="text"  value="<?php echo $_POST['officers_companyOfficer_officerAddress_addrLine2'] ?>"/></td>
  <td class="error"><?php echo $errors["officers[0]_companyOfficer_officerAddress_addrLine2"] ?></td>
</tr>
<tr>
  <th>Street number and street name</th>
  <td><input name="officers_companyOfficer_officerAddress_addrStreet" type="text"  value="<?php echo $_POST['officers_companyOfficer_officerAddress_addrStreet'] ?>"/></td>
  <td class="error"><?php echo $errors["officers[0]_companyOfficer_officerAddress_addrStreet"] ?></td>
</tr>
<tr>
  <th>Suburb, town or city</th>
  <td><input name="officers_companyOfficer_officerAddress_city" type="text"  value="<?php echo $_POST['officers_companyOfficer_officerAddress_city'] ?>"/></td>
  <td class="error"><?php echo $errors["officers[0]_companyOfficer_officerAddress_city"] ?></td>
</tr>
<tr>
  <th>State</th>
  <td>
     <select name="officers_companyOfficer_officerAddress_state"> 
        <option value="">Non-Australian</option> 
        <option value="ACT">Australian Capital Territory</option><option value="NSW">New South Wales</option><option value="NT">Northern Territory</option><option value="QLD">Queensland</option><option value="SA">South Australia</option><option value="TAS">Tasmania</option><option value="VIC">Victoria</option><option value="WA">Western Australia</option> 
     </select> 
  </td>
  <td class="error"><?php echo $errors["officers[0]_companyOfficer_officerAddress_state"] ?></td>
</tr>
<tr>
  <th>Postcode</th>
  <td><input name="officers_companyOfficer_officerAddress_postcode" type="text"  value="<?php echo $_POST['officers_companyOfficer_officerAddress_postcode'] ?>"/></td>
  <td class="error"><?php echo $errors["officers[0]_companyOfficer_officerAddress_postcode"] ?></td>
</tr>
<tr>
  <th>Country</th>
  <td>
    <select name="officers_companyOfficer_officerAddress_countryDisplay"> 
    <option value="AU">AUSTRALIA</option><option value="AF">AFGHANISTAN</option><option value="AX">ALAND ISLANDS</option><option value="AL">ALBANIA</option><option value="DZ">ALGERIA</option><option value="AS">AMERICAN SAMOA</option><option value="AD">ANDORRA</option><option value="AO">ANGOLA</option><option value="AI">ANGUILLA</option><option value="AQ">ANTARCTICA</option><option value="AG">ANTIGUA AND BARBUDA</option><option value="AR">ARGENTINA</option><option value="AM">ARMENIA</option><option value="AW">ARUBA</option><option value="AT">AUSTRIA</option><option value="AZ">AZERBAIJAN</option><option value="BS">BAHAMAS</option><option value="BH">BAHRAIN</option><option value="BD">BANGLADESH</option><option value="BB">BARBADOS</option><option value="BY">BELARUS</option><option value="BE">BELGIUM</option><option value="BZ">BELIZE</option><option value="BJ">BENIN</option><option value="BM">BERMUDA</option><option value="BT">BHUTAN</option><option value="BO">BOLIVIA</option><option value="BA">BOSNIA AND HERZEGOVINA</option><option value="BW">BOTSWANA</option><option value="BV">BOUVET ISLAND</option><option value="BR">BRAZIL</option><option value="IO">BRITISH INDIAN OCEAN TERRITORY</option><option value="BN">BRUNEI DARUSSALAM</option><option value="BG">BULGARIA</option><option value="BF">BURKINA FASO</option><option value="BI">BURUNDI</option><option value="KH">CAMBODIA</option><option value="CM">CAMEROON</option><option value="CA">CANADA</option><option value="CV">CAPE VERDE</option><option value="KY">CAYMAN ISLANDS</option><option value="CF">CENTRAL AFRICAN REPUBLIC</option><option value="TD">CHAD</option><option value="CL">CHILE</option><option value="CN">CHINA</option><option value="CX">CHRISTMAS ISLAND</option><option value="CC">COCOS (KEELING) ISLANDS</option><option value="CO">COLOMBIA</option><option value="KM">COMOROS</option><option value="CG">CONGO</option><option value="CD">CONGO, THE DEMOCRATIC REPUBLIC OF THE</option><option value="CK">COOK ISLANDS</option><option value="CR">COSTA RICA</option><option value="CI">CÔøΩTE D'IVOIRE</option><option value="HR">CROATIA</option><option value="CU">CUBA</option><option value="CY">CYPRUS</option><option value="CZ">CZECH REPUBLIC</option><option value="DK">DENMARK</option><option value="DJ">DJIBOUTI</option><option value="DM">DOMINICA</option><option value="DO">DOMINICAN REPUBLIC</option><option value="EC">ECUADOR</option><option value="EG">EGYPT</option><option value="SV">EL SALVADOR</option><option value="GQ">EQUATORIAL GUINEA</option><option value="ER">ERITREA</option><option value="EE">ESTONIA</option><option value="ET">ETHIOPIA</option><option value="FK">FALKLAND ISLANDS (MALVINAS)</option><option value="FO">FAROE ISLANDS</option><option value="FJ">FIJI</option><option value="FI">FINLAND</option><option value="FR">FRANCE</option><option value="GF">FRENCH GUIANA</option><option value="PF">FRENCH POLYNESIA</option><option value="TF">FRENCH SOUTHERN TERRITORIES</option><option value="GA">GABON</option><option value="GM">GAMBIA</option><option value="GE">GEORGIA</option><option value="DE">GERMANY</option><option value="GH">GHANA</option><option value="GI">GIBRALTAR</option><option value="GR">GREECE</option><option value="GL">GREENLAND</option><option value="GD">GRENADA</option><option value="GP">GUADELOUPE</option><option value="GU">GUAM</option><option value="GT">GUATEMALA</option><option value="GG">GUERNSEY</option><option value="GN">GUINEA</option><option value="GW">GUINEA-BISSAU</option><option value="GY">GUYANA</option><option value="HT">HAITI</option><option value="HM">HEARD ISLAND AND MCDONALD ISLANDS</option><option value="VA">HOLY SEE (VATICAN CITY STATE)</option><option value="HN">HONDURAS</option><option value="HK">HONG KONG</option><option value="HU">HUNGARY</option><option value="IS">ICELAND</option><option value="IN">INDIA</option><option value="ID">INDONESIA</option><option value="IR">IRAN, ISLAMIC REPUBLIC OF</option><option value="IQ">IRAQ</option><option value="IE">IRELAND</option><option value="IM">ISLE OF MAN</option><option value="IL">ISRAEL</option><option value="IT">ITALY</option><option value="JM">JAMAICA</option><option value="JP">JAPAN</option><option value="JE">JERSEY</option><option value="JO">JORDAN</option><option value="KZ">KAZAKHSTAN</option><option value="KE">KENYA</option><option value="KI">KIRIBATI</option><option value="KP">KOREA, DEMOCRATIC PEOPLE'S REPUBLIC OF</option><option value="KR">KOREA, REPUBLIC OF</option><option value="KW">KUWAIT</option><option value="KG">KYRGYZSTAN</option><option value="LA">LAO PEOPLE'S DEMOCRATIC REPUBLIC</option><option value="LV">LATVIA</option><option value="LB">LEBANON</option><option value="LS">LESOTHO</option><option value="LR">LIBERIA</option><option value="LY">LIBYAN ARAB JAMAHIRIYA</option><option value="LI">LIECHTENSTEIN</option><option value="LT">LITHUANIA</option><option value="LU">LUXEMBOURG</option><option value="MO">MACAO</option><option value="MK">MACEDONIA, THE FORMER YUGOSLAV REPUBLIC OF</option><option value="MG">MADAGASCAR</option><option value="MW">MALAWI</option><option value="MY">MALAYSIA</option><option value="MV">MALDIVES</option><option value="ML">MALI</option><option value="MT">MALTA</option><option value="MH">MARSHALL ISLANDS</option><option value="MQ">MARTINIQUE</option><option value="MR">MAURITANIA</option><option value="MU">MAURITIUS</option><option value="YT">MAYOTTE</option><option value="MX">MEXICO</option><option value="FM">MICRONESIA, FEDERATED STATES OF</option><option value="MD">MOLDOVA</option><option value="MC">MONACO</option><option value="MN">MONGOLIA</option><option value="ME">MONTENEGRO</option><option value="MS">MONTSERRAT</option><option value="MA">MOROCCO</option><option value="MZ">MOZAMBIQUE</option><option value="MM">MYANMAR</option><option value="NA">NAMIBIA</option><option value="NR">NAURU</option><option value="NP">NEPAL</option><option value="NL">NETHERLANDS</option><option value="AN">NETHERLANDS ANTILLES</option><option value="NC">NEW CALEDONIA</option><option value="NZ">NEW ZEALAND</option><option value="NI">NICARAGUA</option><option value="NE">NIGER</option><option value="NG">NIGERIA</option><option value="NU">NIUE</option><option value="NF">NORFOLK ISLAND</option><option value="MP">NORTHERN MARIANA ISLANDS</option><option value="NO">NORWAY</option><option value="OM">OMAN</option><option value="PK">PAKISTAN</option><option value="PW">PALAU</option><option value="PS">PALESTINIAN TERRITORY, OCCUPIED</option><option value="PA">PANAMA</option><option value="PG">PAPUA NEW GUINEA</option><option value="PY">PARAGUAY</option><option value="PE">PERU</option><option value="PH">PHILIPPINES</option><option value="PN">PITCAIRN</option><option value="PL">POLAND</option><option value="PT">PORTUGAL</option><option value="PR">PUERTO RICO</option><option value="QA">QATAR</option><option value="RO">ROMANIA</option><option value="RU">RUSSIAN FEDERATION</option><option value="RW">RWANDA</option><option value="SH">SAINT HELENA</option><option value="KN">SAINT KITTS AND NEVIS</option><option value="LC">SAINT LUCIA</option><option value="MF">SAINT MARTIN</option><option value="PM">SAINT PIERRE AND MIQUELON</option><option value="VC">SAINT VINCENT AND THE GRENADINES</option><option value="WS">SAMOA</option><option value="SM">SAN MARINO</option><option value="ST">SAO TOME AND PRINCIPE</option><option value="SA">SAUDI ARABIA</option><option value="SN">SENEGAL</option><option value="RS">SERBIA</option><option value="SC">SEYCHELLES</option><option value="SL">SIERRA LEONE</option><option value="SG">SINGAPORE</option><option value="SK">SLOVAKIA</option><option value="SI">SLOVENIA</option><option value="SB">SOLOMON ISLANDS</option><option value="SO">SOMALIA</option><option value="ZA">SOUTH AFRICA</option><option value="GS">SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS</option><option value="ES">SPAIN</option><option value="LK">SRI LANKA</option><option value="SD">SUDAN</option><option value="SR">SURINAME</option><option value="SJ">SVALBARD AND JAN MAYEN</option><option value="SZ">SWAZILAND</option><option value="SE">SWEDEN</option><option value="CH">SWITZERLAND</option><option value="SY">SYRIAN ARAB REPUBLIC</option><option value="TW">TAIWAN, PROVINCE OF CHINA</option><option value="TJ">TAJIKISTAN</option><option value="TZ">TANZANIA, UNITED REPUBLIC OF</option><option value="TH">THAILAND</option><option value="TL">TIMOR-LESTE</option><option value="TG">TOGO</option><option value="TK">TOKELAU</option><option value="TO">TONGA</option><option value="TT">TRINIDAD AND TOBAGO</option><option value="TN">TUNISIA</option><option value="TR">TURKEY</option><option value="TM">TURKMENISTAN</option><option value="TC">TURKS AND CAICOS ISLANDS</option><option value="TV">TUVALU</option><option value="UG">UGANDA</option><option value="UA">UKRAINE</option><option value="AE">UNITED ARAB EMIRATES</option><option value="GB">UNITED KINGDOM</option><option value="US">UNITED STATES</option><option value="UM">UNITED STATES MINOR OUTLYING ISLANDS</option><option value="UY">URUGUAY</option><option value="UZ">UZBEKISTAN</option><option value="VU">VANUATU</option><option value="VE">VENEZUELA</option><option value="VN">VIET NAM</option><option value="VG">VIRGIN ISLANDS, BRITISH</option><option value="VI">VIRGIN ISLANDS, U_S_</option><option value="WF">WALLIS AND FUTUNA</option><option value="EH">WESTERN SAHARA</option><option value="YE">YEMEN</option><option value="ZM">ZAMBIA</option><option value="ZW">ZIMBABWE </option> 
    </select> 
  </td>
  <td class="error"><?php echo $errors["officers[0]_companyOfficer_officerAddress_countryDisplay"] ?></td>
</tr>
<tr>
  <th colspan="2">Birth information</th>
</tr>
<tr>
  <th>Date Of Birth (dd/mm/yyyy)</th>
  <td><input id="dob" name="officers_companyOfficer_birthDetails_date" type="text"  value="<?php echo $_POST['officers_companyOfficer_birthDetails_date'] ?>"/></td>
  <td class="error"><?php echo $errors["officers[0]_companyOfficer_birthDetails_date"] ?></td>
</tr>
<tr>
  <th>Place Of Birth</th>
  <td><input id="birthsuburb" name="officers_companyOfficer_birthDetails_town" type="text"  value="<?php echo $_POST['officers_companyOfficer_birthDetails_town'] ?>"/></td>
  <td class="error"><?php echo $errors["officers[0]_companyOfficer_birthDetails_town"] ?></td>
</tr>
<tr>
  <th>Place of birth state</th>
  <td>
     <select name="officers_companyOfficer_birthDetails_state"> 
        <option value="">Non-Australian</option> 
        <option value="ACT">Australian Capital Territory</option><option value="NSW">New South Wales</option><option value="NT">Northern Territory</option><option value="QLD">Queensland</option><option value="SA">South Australia</option><option value="TAS">Tasmania</option><option value="VIC">Victoria</option><option value="WA">Western Australia</option> 
     </select> 
  </td>
  <td class="error"><?php echo $errors["officers[0]_companyOfficer_birthDetails_localityQualifier"] ?></td>
</tr>
<tr>
  <th>Country of birth</th>
  <td>
     <select id="birthcountry" name="officers_companyOfficer_birthDetails_country"> 
       <option value="AU">AUSTRALIA</option><option value="AF">AFGHANISTAN</option><option value="AX">ALAND ISLANDS</option><option value="AL">ALBANIA</option><option value="DZ">ALGERIA</option><option value="AS">AMERICAN SAMOA</option><option value="AD">ANDORRA</option><option value="AO">ANGOLA</option><option value="AI">ANGUILLA</option><option value="AQ">ANTARCTICA</option><option value="AG">ANTIGUA AND BARBUDA</option><option value="AR">ARGENTINA</option><option value="AM">ARMENIA</option><option value="AW">ARUBA</option><option value="AT">AUSTRIA</option><option value="AZ">AZERBAIJAN</option><option value="BS">BAHAMAS</option><option value="BH">BAHRAIN</option><option value="BD">BANGLADESH</option><option value="BB">BARBADOS</option><option value="BY">BELARUS</option><option value="BE">BELGIUM</option><option value="BZ">BELIZE</option><option value="BJ">BENIN</option><option value="BM">BERMUDA</option><option value="BT">BHUTAN</option><option value="BO">BOLIVIA</option><option value="BA">BOSNIA AND HERZEGOVINA</option><option value="BW">BOTSWANA</option><option value="BV">BOUVET ISLAND</option><option value="BR">BRAZIL</option><option value="IO">BRITISH INDIAN OCEAN TERRITORY</option><option value="BN">BRUNEI DARUSSALAM</option><option value="BG">BULGARIA</option><option value="BF">BURKINA FASO</option><option value="BI">BURUNDI</option><option value="KH">CAMBODIA</option><option value="CM">CAMEROON</option><option value="CA">CANADA</option><option value="CV">CAPE VERDE</option><option value="KY">CAYMAN ISLANDS</option><option value="CF">CENTRAL AFRICAN REPUBLIC</option><option value="TD">CHAD</option><option value="CL">CHILE</option><option value="CN">CHINA</option><option value="CX">CHRISTMAS ISLAND</option><option value="CC">COCOS (KEELING) ISLANDS</option><option value="CO">COLOMBIA</option><option value="KM">COMOROS</option><option value="CG">CONGO</option><option value="CD">CONGO, THE DEMOCRATIC REPUBLIC OF THE</option><option value="CK">COOK ISLANDS</option><option value="CR">COSTA RICA</option><option value="CI">CÔøΩTE D'IVOIRE</option><option value="HR">CROATIA</option><option value="CU">CUBA</option><option value="CY">CYPRUS</option><option value="CZ">CZECH REPUBLIC</option><option value="DK">DENMARK</option><option value="DJ">DJIBOUTI</option><option value="DM">DOMINICA</option><option value="DO">DOMINICAN REPUBLIC</option><option value="EC">ECUADOR</option><option value="EG">EGYPT</option><option value="SV">EL SALVADOR</option><option value="GQ">EQUATORIAL GUINEA</option><option value="ER">ERITREA</option><option value="EE">ESTONIA</option><option value="ET">ETHIOPIA</option><option value="FK">FALKLAND ISLANDS (MALVINAS)</option><option value="FO">FAROE ISLANDS</option><option value="FJ">FIJI</option><option value="FI">FINLAND</option><option value="FR">FRANCE</option><option value="GF">FRENCH GUIANA</option><option value="PF">FRENCH POLYNESIA</option><option value="TF">FRENCH SOUTHERN TERRITORIES</option><option value="GA">GABON</option><option value="GM">GAMBIA</option><option value="GE">GEORGIA</option><option value="DE">GERMANY</option><option value="GH">GHANA</option><option value="GI">GIBRALTAR</option><option value="GR">GREECE</option><option value="GL">GREENLAND</option><option value="GD">GRENADA</option><option value="GP">GUADELOUPE</option><option value="GU">GUAM</option><option value="GT">GUATEMALA</option><option value="GG">GUERNSEY</option><option value="GN">GUINEA</option><option value="GW">GUINEA-BISSAU</option><option value="GY">GUYANA</option><option value="HT">HAITI</option><option value="HM">HEARD ISLAND AND MCDONALD ISLANDS</option><option value="VA">HOLY SEE (VATICAN CITY STATE)</option><option value="HN">HONDURAS</option><option value="HK">HONG KONG</option><option value="HU">HUNGARY</option><option value="IS">ICELAND</option><option value="IN">INDIA</option><option value="ID">INDONESIA</option><option value="IR">IRAN, ISLAMIC REPUBLIC OF</option><option value="IQ">IRAQ</option><option value="IE">IRELAND</option><option value="IM">ISLE OF MAN</option><option value="IL">ISRAEL</option><option value="IT">ITALY</option><option value="JM">JAMAICA</option><option value="JP">JAPAN</option><option value="JE">JERSEY</option><option value="JO">JORDAN</option><option value="KZ">KAZAKHSTAN</option><option value="KE">KENYA</option><option value="KI">KIRIBATI</option><option value="KP">KOREA, DEMOCRATIC PEOPLE'S REPUBLIC OF</option><option value="KR">KOREA, REPUBLIC OF</option><option value="KW">KUWAIT</option><option value="KG">KYRGYZSTAN</option><option value="LA">LAO PEOPLE'S DEMOCRATIC REPUBLIC</option><option value="LV">LATVIA</option><option value="LB">LEBANON</option><option value="LS">LESOTHO</option><option value="LR">LIBERIA</option><option value="LY">LIBYAN ARAB JAMAHIRIYA</option><option value="LI">LIECHTENSTEIN</option><option value="LT">LITHUANIA</option><option value="LU">LUXEMBOURG</option><option value="MO">MACAO</option><option value="MK">MACEDONIA, THE FORMER YUGOSLAV REPUBLIC OF</option><option value="MG">MADAGASCAR</option><option value="MW">MALAWI</option><option value="MY">MALAYSIA</option><option value="MV">MALDIVES</option><option value="ML">MALI</option><option value="MT">MALTA</option><option value="MH">MARSHALL ISLANDS</option><option value="MQ">MARTINIQUE</option><option value="MR">MAURITANIA</option><option value="MU">MAURITIUS</option><option value="YT">MAYOTTE</option><option value="MX">MEXICO</option><option value="FM">MICRONESIA, FEDERATED STATES OF</option><option value="MD">MOLDOVA</option><option value="MC">MONACO</option><option value="MN">MONGOLIA</option><option value="ME">MONTENEGRO</option><option value="MS">MONTSERRAT</option><option value="MA">MOROCCO</option><option value="MZ">MOZAMBIQUE</option><option value="MM">MYANMAR</option><option value="NA">NAMIBIA</option><option value="NR">NAURU</option><option value="NP">NEPAL</option><option value="NL">NETHERLANDS</option><option value="AN">NETHERLANDS ANTILLES</option><option value="NC">NEW CALEDONIA</option><option value="NZ">NEW ZEALAND</option><option value="NI">NICARAGUA</option><option value="NE">NIGER</option><option value="NG">NIGERIA</option><option value="NU">NIUE</option><option value="NF">NORFOLK ISLAND</option><option value="MP">NORTHERN MARIANA ISLANDS</option><option value="NO">NORWAY</option><option value="OM">OMAN</option><option value="PK">PAKISTAN</option><option value="PW">PALAU</option><option value="PS">PALESTINIAN TERRITORY, OCCUPIED</option><option value="PA">PANAMA</option><option value="PG">PAPUA NEW GUINEA</option><option value="PY">PARAGUAY</option><option value="PE">PERU</option><option value="PH">PHILIPPINES</option><option value="PN">PITCAIRN</option><option value="PL">POLAND</option><option value="PT">PORTUGAL</option><option value="PR">PUERTO RICO</option><option value="QA">QATAR</option><option value="RO">ROMANIA</option><option value="RU">RUSSIAN FEDERATION</option><option value="RW">RWANDA</option><option value="SH">SAINT HELENA</option><option value="KN">SAINT KITTS AND NEVIS</option><option value="LC">SAINT LUCIA</option><option value="MF">SAINT MARTIN</option><option value="PM">SAINT PIERRE AND MIQUELON</option><option value="VC">SAINT VINCENT AND THE GRENADINES</option><option value="WS">SAMOA</option><option value="SM">SAN MARINO</option><option value="ST">SAO TOME AND PRINCIPE</option><option value="SA">SAUDI ARABIA</option><option value="SN">SENEGAL</option><option value="RS">SERBIA</option><option value="SC">SEYCHELLES</option><option value="SL">SIERRA LEONE</option><option value="SG">SINGAPORE</option><option value="SK">SLOVAKIA</option><option value="SI">SLOVENIA</option><option value="SB">SOLOMON ISLANDS</option><option value="SO">SOMALIA</option><option value="ZA">SOUTH AFRICA</option><option value="GS">SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS</option><option value="ES">SPAIN</option><option value="LK">SRI LANKA</option><option value="SD">SUDAN</option><option value="SR">SURINAME</option><option value="SJ">SVALBARD AND JAN MAYEN</option><option value="SZ">SWAZILAND</option><option value="SE">SWEDEN</option><option value="CH">SWITZERLAND</option><option value="SY">SYRIAN ARAB REPUBLIC</option><option value="TW">TAIWAN, PROVINCE OF CHINA</option><option value="TJ">TAJIKISTAN</option><option value="TZ">TANZANIA, UNITED REPUBLIC OF</option><option value="TH">THAILAND</option><option value="TL">TIMOR-LESTE</option><option value="TG">TOGO</option><option value="TK">TOKELAU</option><option value="TO">TONGA</option><option value="TT">TRINIDAD AND TOBAGO</option><option value="TN">TUNISIA</option><option value="TR">TURKEY</option><option value="TM">TURKMENISTAN</option><option value="TC">TURKS AND CAICOS ISLANDS</option><option value="TV">TUVALU</option><option value="UG">UGANDA</option><option value="UA">UKRAINE</option><option value="AE">UNITED ARAB EMIRATES</option><option value="GB">UNITED KINGDOM</option><option value="US">UNITED STATES</option><option value="UM">UNITED STATES MINOR OUTLYING ISLANDS</option><option value="UY">URUGUAY</option><option value="UZ">UZBEKISTAN</option><option value="VU">VANUATU</option><option value="VE">VENEZUELA</option><option value="VN">VIET NAM</option><option value="VG">VIRGIN ISLANDS, BRITISH</option><option value="VI">VIRGIN ISLANDS, U_S_</option><option value="WF">WALLIS AND FUTUNA</option><option value="EH">WESTERN SAHARA</option><option value="YE">YEMEN</option><option value="ZM">ZAMBIA</option><option value="ZW">ZIMBABWE </option> 
  </td>
  <td class="error"><?php echo $errors["officers[0]_companyOfficer_birthDetails_country"] ?></td>
</table>

<h3>Shares (office holder 1)</h3>
<table cellspacing="10px">
<tr>
  <th>Share Class</th>
  <td>            
    <select name="shareMembers1_holding_shareClassCode"> 
      <option selected="selected" value="ORD">(ORD) Ordinary</option><option value="A">(A) A</option><option value="B">(B) B</option><option value="MAN">(MAN) Management</option><option value="LG">(LG) Life Governors</option><option value="EMP">(EMP) Employees</option><option value="FOU">(FOU) Founders</option><option value="PRF">(PRF) Preference</option><option value="CUMP">(CUMP) Cumulative Preference</option><option value="NCP">(NCP) Non Cumulative Preference</option><option value="REDP">(REDP) Redeemable Preference</option><option value="NRP">(NRP) Non Redeemable Preference</option><option value="NCRP">(NCRP) Non Cum_ Redeemable Preference</option><option value="PARP">(PARP) Participative Preference</option><option value="RED">(RED) Redeemable</option><option value="INI">(INI) Initial</option><option value="SPE">(SPE) Special</option> 
    </select>
  </td>
  <td class="error"><?php echo $errors["shareMembers[0]_holding_shareClassCode"] ?></td>
</tr>
<tr>
  <th>Number of shares</th>
  <td><input id="number" name="shareMembers1_holding_agreedNumber" type="text"  value="<?php echo $_POST['shareMembers1_holding_agreedNumber'] ?>"/>
  <td class="error"><?php echo $errors["shareMembers[0]_holding_agreedNumber"] ?></td>
</tr>
<tr>
  <th>Cost per share</th>
  <td>$<input id="amount" name="shareMembers1_holding_amountPaid" type="text"  value="<?php echo $_POST['shareMembers1_holding_amountPaid'] ?>"/> 
  <td class="error"><?php echo $errors["shareMembers[0]_holding_amountPaid"] ?></td>
</tr>
<tr>
  <th>
   Total amount paid to the company upon registration for these shares
  </th>
  <td>$<input id="amount" name="shareMembers1_holding_totalAmountPaid" type="text"  value="<?php echo $_POST['shareMembers1_holding_totalAmountPaid'] ?>"/> 
  <td class="error"><?php echo $errors["shareMembers[0]_holding_totalAmountPaid"] ?></td>
</tr>
<tr>
  <th>Are these shares held on behalf of another individual or organisation?</th>
  <td>
     <input name="shareMembers1_holding_beneficialOwner" value="false" type="radio" />Yes<br/> 
     <input name="shareMembers1_holding_beneficialOwner" value="true" type="radio" checked="checked" />No
  </td>
</table>


<h3>Office Holder 2</h3>
<table cellspacing="10px">
<tr>
  <th>First Name</th>
  <td><input name="officers2_companyOfficer_officer_givenName" type="text"  value="<?php echo $_POST['officers2_companyOfficer_officer_givenName'] ?>"/></td>
  <td class="error"><?php echo $errors["officers[1]_companyOfficer_officer_givenName"] ?></td>
</tr>
<tr>
  <th>Middle Name</th>
  <td><input name="officers2_companyOfficer_officer_givenName2" type="text"  value="<?php echo $_POST['officers2_companyOfficer_officer_givenName2'] ?>"/></td>
  <td class="error"><?php echo $errors["officers[1]_companyOfficer_officer_givenName2"] ?></td>
</tr>
<tr>
  <th>Surname</th>
  <td><input name="officers2_companyOfficer_officer_familyName" type="text"  value="<?php echo $_POST['officers2_companyOfficer_officer_familyName'] ?>"/></td>
  <td class="error"><?php echo $errors["officers[1]_companyOfficer_officer_familyName"] ?></td>
</tr>
<tr>
  <th>Offices Held</th>
  <td>
    <input name="officers2_director" value="true" type="checkbox" />Director<br/> 
    <input name="officers2_secretary" value="true" type="checkbox" />Secretary
  </td>
  <td class="error"><?php echo $errors["officers[1]_officesHeld"] ?></td>
</tr>
<tr>
  <th colspan="2">Residential Address</th>
</tr>
<tr>
  <th>Unit/Level/Suite</th>
  <td><input name="officers2_companyOfficer_officerAddress_addrLine2" type="text"  value="<?php echo $_POST['officers2_companyOfficer_officerAddress_addrLine2'] ?>"/></td>
  <td class="error"><?php echo $errors["officers[1]_companyOfficer_officerAddress_addrLine2"] ?></td>
</tr>
<tr>
  <th>Street number and street name</th>
  <td><input name="officers2_companyOfficer_officerAddress_addrStreet" type="text"  value="<?php echo $_POST['officers2_companyOfficer_officerAddress_addrStreet'] ?>"/></td>
  <td class="error"><?php echo $errors["officers[1]_companyOfficer_officerAddress_addrStreet"] ?></td>
</tr>
<tr>
  <th>Suburb, town or city</th>
  <td><input name="officers2_companyOfficer_officerAddress_city" type="text"  value="<?php echo $_POST['officers2_companyOfficer_officerAddress_city'] ?>"/></td>
  <td class="error"><?php echo $errors["officers[1]_companyOfficer_officerAddress_city"] ?></td>
</tr>
<tr>
  <th>State</th>
  <td>
     <select name="officers2_companyOfficer_officerAddress_state"> 
        <option value="">Non-Australian</option> 
        <option value="ACT">Australian Capital Territory</option><option value="NSW">New South Wales</option><option value="NT">Northern Territory</option><option value="QLD">Queensland</option><option value="SA">South Australia</option><option value="TAS">Tasmania</option><option value="VIC">Victoria</option><option value="WA">Western Australia</option> 
     </select> 
  </td>
  <td class="error"><?php echo $errors["officers[1]_companyOfficer_officerAddress_state"] ?></td>
</tr>
<tr>
  <th>Postcode</th>
  <td><input name="officers2_companyOfficer_officerAddress_postcode" type="text"  value="<?php echo $_POST['officers2_companyOfficer_officerAddress_postcode'] ?>"/></td>
  <td class="error"><?php echo $errors["officers[1]_companyOfficer_officerAddress_postcode"] ?></td>
</tr>
<tr>
  <th>Country</th>
  <td>
    <select name="officers2_companyOfficer_officerAddress_countryDisplay"> 
    <option value="AU">AUSTRALIA</option><option value="AF">AFGHANISTAN</option><option value="AX">ALAND ISLANDS</option><option value="AL">ALBANIA</option><option value="DZ">ALGERIA</option><option value="AS">AMERICAN SAMOA</option><option value="AD">ANDORRA</option><option value="AO">ANGOLA</option><option value="AI">ANGUILLA</option><option value="AQ">ANTARCTICA</option><option value="AG">ANTIGUA AND BARBUDA</option><option value="AR">ARGENTINA</option><option value="AM">ARMENIA</option><option value="AW">ARUBA</option><option value="AT">AUSTRIA</option><option value="AZ">AZERBAIJAN</option><option value="BS">BAHAMAS</option><option value="BH">BAHRAIN</option><option value="BD">BANGLADESH</option><option value="BB">BARBADOS</option><option value="BY">BELARUS</option><option value="BE">BELGIUM</option><option value="BZ">BELIZE</option><option value="BJ">BENIN</option><option value="BM">BERMUDA</option><option value="BT">BHUTAN</option><option value="BO">BOLIVIA</option><option value="BA">BOSNIA AND HERZEGOVINA</option><option value="BW">BOTSWANA</option><option value="BV">BOUVET ISLAND</option><option value="BR">BRAZIL</option><option value="IO">BRITISH INDIAN OCEAN TERRITORY</option><option value="BN">BRUNEI DARUSSALAM</option><option value="BG">BULGARIA</option><option value="BF">BURKINA FASO</option><option value="BI">BURUNDI</option><option value="KH">CAMBODIA</option><option value="CM">CAMEROON</option><option value="CA">CANADA</option><option value="CV">CAPE VERDE</option><option value="KY">CAYMAN ISLANDS</option><option value="CF">CENTRAL AFRICAN REPUBLIC</option><option value="TD">CHAD</option><option value="CL">CHILE</option><option value="CN">CHINA</option><option value="CX">CHRISTMAS ISLAND</option><option value="CC">COCOS (KEELING) ISLANDS</option><option value="CO">COLOMBIA</option><option value="KM">COMOROS</option><option value="CG">CONGO</option><option value="CD">CONGO, THE DEMOCRATIC REPUBLIC OF THE</option><option value="CK">COOK ISLANDS</option><option value="CR">COSTA RICA</option><option value="CI">CÔøΩTE D'IVOIRE</option><option value="HR">CROATIA</option><option value="CU">CUBA</option><option value="CY">CYPRUS</option><option value="CZ">CZECH REPUBLIC</option><option value="DK">DENMARK</option><option value="DJ">DJIBOUTI</option><option value="DM">DOMINICA</option><option value="DO">DOMINICAN REPUBLIC</option><option value="EC">ECUADOR</option><option value="EG">EGYPT</option><option value="SV">EL SALVADOR</option><option value="GQ">EQUATORIAL GUINEA</option><option value="ER">ERITREA</option><option value="EE">ESTONIA</option><option value="ET">ETHIOPIA</option><option value="FK">FALKLAND ISLANDS (MALVINAS)</option><option value="FO">FAROE ISLANDS</option><option value="FJ">FIJI</option><option value="FI">FINLAND</option><option value="FR">FRANCE</option><option value="GF">FRENCH GUIANA</option><option value="PF">FRENCH POLYNESIA</option><option value="TF">FRENCH SOUTHERN TERRITORIES</option><option value="GA">GABON</option><option value="GM">GAMBIA</option><option value="GE">GEORGIA</option><option value="DE">GERMANY</option><option value="GH">GHANA</option><option value="GI">GIBRALTAR</option><option value="GR">GREECE</option><option value="GL">GREENLAND</option><option value="GD">GRENADA</option><option value="GP">GUADELOUPE</option><option value="GU">GUAM</option><option value="GT">GUATEMALA</option><option value="GG">GUERNSEY</option><option value="GN">GUINEA</option><option value="GW">GUINEA-BISSAU</option><option value="GY">GUYANA</option><option value="HT">HAITI</option><option value="HM">HEARD ISLAND AND MCDONALD ISLANDS</option><option value="VA">HOLY SEE (VATICAN CITY STATE)</option><option value="HN">HONDURAS</option><option value="HK">HONG KONG</option><option value="HU">HUNGARY</option><option value="IS">ICELAND</option><option value="IN">INDIA</option><option value="ID">INDONESIA</option><option value="IR">IRAN, ISLAMIC REPUBLIC OF</option><option value="IQ">IRAQ</option><option value="IE">IRELAND</option><option value="IM">ISLE OF MAN</option><option value="IL">ISRAEL</option><option value="IT">ITALY</option><option value="JM">JAMAICA</option><option value="JP">JAPAN</option><option value="JE">JERSEY</option><option value="JO">JORDAN</option><option value="KZ">KAZAKHSTAN</option><option value="KE">KENYA</option><option value="KI">KIRIBATI</option><option value="KP">KOREA, DEMOCRATIC PEOPLE'S REPUBLIC OF</option><option value="KR">KOREA, REPUBLIC OF</option><option value="KW">KUWAIT</option><option value="KG">KYRGYZSTAN</option><option value="LA">LAO PEOPLE'S DEMOCRATIC REPUBLIC</option><option value="LV">LATVIA</option><option value="LB">LEBANON</option><option value="LS">LESOTHO</option><option value="LR">LIBERIA</option><option value="LY">LIBYAN ARAB JAMAHIRIYA</option><option value="LI">LIECHTENSTEIN</option><option value="LT">LITHUANIA</option><option value="LU">LUXEMBOURG</option><option value="MO">MACAO</option><option value="MK">MACEDONIA, THE FORMER YUGOSLAV REPUBLIC OF</option><option value="MG">MADAGASCAR</option><option value="MW">MALAWI</option><option value="MY">MALAYSIA</option><option value="MV">MALDIVES</option><option value="ML">MALI</option><option value="MT">MALTA</option><option value="MH">MARSHALL ISLANDS</option><option value="MQ">MARTINIQUE</option><option value="MR">MAURITANIA</option><option value="MU">MAURITIUS</option><option value="YT">MAYOTTE</option><option value="MX">MEXICO</option><option value="FM">MICRONESIA, FEDERATED STATES OF</option><option value="MD">MOLDOVA</option><option value="MC">MONACO</option><option value="MN">MONGOLIA</option><option value="ME">MONTENEGRO</option><option value="MS">MONTSERRAT</option><option value="MA">MOROCCO</option><option value="MZ">MOZAMBIQUE</option><option value="MM">MYANMAR</option><option value="NA">NAMIBIA</option><option value="NR">NAURU</option><option value="NP">NEPAL</option><option value="NL">NETHERLANDS</option><option value="AN">NETHERLANDS ANTILLES</option><option value="NC">NEW CALEDONIA</option><option value="NZ">NEW ZEALAND</option><option value="NI">NICARAGUA</option><option value="NE">NIGER</option><option value="NG">NIGERIA</option><option value="NU">NIUE</option><option value="NF">NORFOLK ISLAND</option><option value="MP">NORTHERN MARIANA ISLANDS</option><option value="NO">NORWAY</option><option value="OM">OMAN</option><option value="PK">PAKISTAN</option><option value="PW">PALAU</option><option value="PS">PALESTINIAN TERRITORY, OCCUPIED</option><option value="PA">PANAMA</option><option value="PG">PAPUA NEW GUINEA</option><option value="PY">PARAGUAY</option><option value="PE">PERU</option><option value="PH">PHILIPPINES</option><option value="PN">PITCAIRN</option><option value="PL">POLAND</option><option value="PT">PORTUGAL</option><option value="PR">PUERTO RICO</option><option value="QA">QATAR</option><option value="RO">ROMANIA</option><option value="RU">RUSSIAN FEDERATION</option><option value="RW">RWANDA</option><option value="SH">SAINT HELENA</option><option value="KN">SAINT KITTS AND NEVIS</option><option value="LC">SAINT LUCIA</option><option value="MF">SAINT MARTIN</option><option value="PM">SAINT PIERRE AND MIQUELON</option><option value="VC">SAINT VINCENT AND THE GRENADINES</option><option value="WS">SAMOA</option><option value="SM">SAN MARINO</option><option value="ST">SAO TOME AND PRINCIPE</option><option value="SA">SAUDI ARABIA</option><option value="SN">SENEGAL</option><option value="RS">SERBIA</option><option value="SC">SEYCHELLES</option><option value="SL">SIERRA LEONE</option><option value="SG">SINGAPORE</option><option value="SK">SLOVAKIA</option><option value="SI">SLOVENIA</option><option value="SB">SOLOMON ISLANDS</option><option value="SO">SOMALIA</option><option value="ZA">SOUTH AFRICA</option><option value="GS">SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS</option><option value="ES">SPAIN</option><option value="LK">SRI LANKA</option><option value="SD">SUDAN</option><option value="SR">SURINAME</option><option value="SJ">SVALBARD AND JAN MAYEN</option><option value="SZ">SWAZILAND</option><option value="SE">SWEDEN</option><option value="CH">SWITZERLAND</option><option value="SY">SYRIAN ARAB REPUBLIC</option><option value="TW">TAIWAN, PROVINCE OF CHINA</option><option value="TJ">TAJIKISTAN</option><option value="TZ">TANZANIA, UNITED REPUBLIC OF</option><option value="TH">THAILAND</option><option value="TL">TIMOR-LESTE</option><option value="TG">TOGO</option><option value="TK">TOKELAU</option><option value="TO">TONGA</option><option value="TT">TRINIDAD AND TOBAGO</option><option value="TN">TUNISIA</option><option value="TR">TURKEY</option><option value="TM">TURKMENISTAN</option><option value="TC">TURKS AND CAICOS ISLANDS</option><option value="TV">TUVALU</option><option value="UG">UGANDA</option><option value="UA">UKRAINE</option><option value="AE">UNITED ARAB EMIRATES</option><option value="GB">UNITED KINGDOM</option><option value="US">UNITED STATES</option><option value="UM">UNITED STATES MINOR OUTLYING ISLANDS</option><option value="UY">URUGUAY</option><option value="UZ">UZBEKISTAN</option><option value="VU">VANUATU</option><option value="VE">VENEZUELA</option><option value="VN">VIET NAM</option><option value="VG">VIRGIN ISLANDS, BRITISH</option><option value="VI">VIRGIN ISLANDS, U_S_</option><option value="WF">WALLIS AND FUTUNA</option><option value="EH">WESTERN SAHARA</option><option value="YE">YEMEN</option><option value="ZM">ZAMBIA</option><option value="ZW">ZIMBABWE </option> 
    </select> 
  </td>
  <td class="error"><?php echo $errors["officers[1]_companyOfficer_officerAddress_countryDisplay"] ?></td>
</tr>
<tr>
  <th colspan="2">Birth information</th>
</tr>
<tr>
  <th>Date Of Birth (dd/mm/yyyy)</th>
  <td><input id="dob" name="officers2_companyOfficer_birthDetails_date" type="text"  value="<?php echo $_POST['officers2_companyOfficer_birthDetails_date'] ?>"/></td>
  <td class="error"><?php echo $errors["officers[1]_companyOfficer_birthDetails_date"] ?></td>
</tr>
<tr>
  <th>Place Of Birth</th>
  <td><input id="birthsuburb" name="officers2_companyOfficer_birthDetails_town" type="text"  value="<?php echo $_POST['officers2_companyOfficer_birthDetails_town'] ?>"/></td>
  <td class="error"><?php echo $errors["officers[1]_companyOfficer_birthDetails_town"] ?></td>
</tr>
<tr>
  <th>Place of birth state</th>
  <td>
     <select name="officers2_companyOfficer_birthDetails_state"> 
        <option value="">Non-Australian</option> 
        <option value="ACT">Australian Capital Territory</option><option value="NSW">New South Wales</option><option value="NT">Northern Territory</option><option value="QLD">Queensland</option><option value="SA">South Australia</option><option value="TAS">Tasmania</option><option value="VIC">Victoria</option><option value="WA">Western Australia</option> 
     </select> 
  </td>
  <td class="error"><?php echo $errors["officers[1]_companyOfficer_birthDetails_localityQualifier"] ?></td>
</tr>
<tr>
  <th>Country of birth</th>
  <td>
     <select id="birthcountry" name="officers2_companyOfficer_birthDetails_country"> 
       <option value="AU">AUSTRALIA</option><option value="AF">AFGHANISTAN</option><option value="AX">ALAND ISLANDS</option><option value="AL">ALBANIA</option><option value="DZ">ALGERIA</option><option value="AS">AMERICAN SAMOA</option><option value="AD">ANDORRA</option><option value="AO">ANGOLA</option><option value="AI">ANGUILLA</option><option value="AQ">ANTARCTICA</option><option value="AG">ANTIGUA AND BARBUDA</option><option value="AR">ARGENTINA</option><option value="AM">ARMENIA</option><option value="AW">ARUBA</option><option value="AT">AUSTRIA</option><option value="AZ">AZERBAIJAN</option><option value="BS">BAHAMAS</option><option value="BH">BAHRAIN</option><option value="BD">BANGLADESH</option><option value="BB">BARBADOS</option><option value="BY">BELARUS</option><option value="BE">BELGIUM</option><option value="BZ">BELIZE</option><option value="BJ">BENIN</option><option value="BM">BERMUDA</option><option value="BT">BHUTAN</option><option value="BO">BOLIVIA</option><option value="BA">BOSNIA AND HERZEGOVINA</option><option value="BW">BOTSWANA</option><option value="BV">BOUVET ISLAND</option><option value="BR">BRAZIL</option><option value="IO">BRITISH INDIAN OCEAN TERRITORY</option><option value="BN">BRUNEI DARUSSALAM</option><option value="BG">BULGARIA</option><option value="BF">BURKINA FASO</option><option value="BI">BURUNDI</option><option value="KH">CAMBODIA</option><option value="CM">CAMEROON</option><option value="CA">CANADA</option><option value="CV">CAPE VERDE</option><option value="KY">CAYMAN ISLANDS</option><option value="CF">CENTRAL AFRICAN REPUBLIC</option><option value="TD">CHAD</option><option value="CL">CHILE</option><option value="CN">CHINA</option><option value="CX">CHRISTMAS ISLAND</option><option value="CC">COCOS (KEELING) ISLANDS</option><option value="CO">COLOMBIA</option><option value="KM">COMOROS</option><option value="CG">CONGO</option><option value="CD">CONGO, THE DEMOCRATIC REPUBLIC OF THE</option><option value="CK">COOK ISLANDS</option><option value="CR">COSTA RICA</option><option value="CI">CÔøΩTE D'IVOIRE</option><option value="HR">CROATIA</option><option value="CU">CUBA</option><option value="CY">CYPRUS</option><option value="CZ">CZECH REPUBLIC</option><option value="DK">DENMARK</option><option value="DJ">DJIBOUTI</option><option value="DM">DOMINICA</option><option value="DO">DOMINICAN REPUBLIC</option><option value="EC">ECUADOR</option><option value="EG">EGYPT</option><option value="SV">EL SALVADOR</option><option value="GQ">EQUATORIAL GUINEA</option><option value="ER">ERITREA</option><option value="EE">ESTONIA</option><option value="ET">ETHIOPIA</option><option value="FK">FALKLAND ISLANDS (MALVINAS)</option><option value="FO">FAROE ISLANDS</option><option value="FJ">FIJI</option><option value="FI">FINLAND</option><option value="FR">FRANCE</option><option value="GF">FRENCH GUIANA</option><option value="PF">FRENCH POLYNESIA</option><option value="TF">FRENCH SOUTHERN TERRITORIES</option><option value="GA">GABON</option><option value="GM">GAMBIA</option><option value="GE">GEORGIA</option><option value="DE">GERMANY</option><option value="GH">GHANA</option><option value="GI">GIBRALTAR</option><option value="GR">GREECE</option><option value="GL">GREENLAND</option><option value="GD">GRENADA</option><option value="GP">GUADELOUPE</option><option value="GU">GUAM</option><option value="GT">GUATEMALA</option><option value="GG">GUERNSEY</option><option value="GN">GUINEA</option><option value="GW">GUINEA-BISSAU</option><option value="GY">GUYANA</option><option value="HT">HAITI</option><option value="HM">HEARD ISLAND AND MCDONALD ISLANDS</option><option value="VA">HOLY SEE (VATICAN CITY STATE)</option><option value="HN">HONDURAS</option><option value="HK">HONG KONG</option><option value="HU">HUNGARY</option><option value="IS">ICELAND</option><option value="IN">INDIA</option><option value="ID">INDONESIA</option><option value="IR">IRAN, ISLAMIC REPUBLIC OF</option><option value="IQ">IRAQ</option><option value="IE">IRELAND</option><option value="IM">ISLE OF MAN</option><option value="IL">ISRAEL</option><option value="IT">ITALY</option><option value="JM">JAMAICA</option><option value="JP">JAPAN</option><option value="JE">JERSEY</option><option value="JO">JORDAN</option><option value="KZ">KAZAKHSTAN</option><option value="KE">KENYA</option><option value="KI">KIRIBATI</option><option value="KP">KOREA, DEMOCRATIC PEOPLE'S REPUBLIC OF</option><option value="KR">KOREA, REPUBLIC OF</option><option value="KW">KUWAIT</option><option value="KG">KYRGYZSTAN</option><option value="LA">LAO PEOPLE'S DEMOCRATIC REPUBLIC</option><option value="LV">LATVIA</option><option value="LB">LEBANON</option><option value="LS">LESOTHO</option><option value="LR">LIBERIA</option><option value="LY">LIBYAN ARAB JAMAHIRIYA</option><option value="LI">LIECHTENSTEIN</option><option value="LT">LITHUANIA</option><option value="LU">LUXEMBOURG</option><option value="MO">MACAO</option><option value="MK">MACEDONIA, THE FORMER YUGOSLAV REPUBLIC OF</option><option value="MG">MADAGASCAR</option><option value="MW">MALAWI</option><option value="MY">MALAYSIA</option><option value="MV">MALDIVES</option><option value="ML">MALI</option><option value="MT">MALTA</option><option value="MH">MARSHALL ISLANDS</option><option value="MQ">MARTINIQUE</option><option value="MR">MAURITANIA</option><option value="MU">MAURITIUS</option><option value="YT">MAYOTTE</option><option value="MX">MEXICO</option><option value="FM">MICRONESIA, FEDERATED STATES OF</option><option value="MD">MOLDOVA</option><option value="MC">MONACO</option><option value="MN">MONGOLIA</option><option value="ME">MONTENEGRO</option><option value="MS">MONTSERRAT</option><option value="MA">MOROCCO</option><option value="MZ">MOZAMBIQUE</option><option value="MM">MYANMAR</option><option value="NA">NAMIBIA</option><option value="NR">NAURU</option><option value="NP">NEPAL</option><option value="NL">NETHERLANDS</option><option value="AN">NETHERLANDS ANTILLES</option><option value="NC">NEW CALEDONIA</option><option value="NZ">NEW ZEALAND</option><option value="NI">NICARAGUA</option><option value="NE">NIGER</option><option value="NG">NIGERIA</option><option value="NU">NIUE</option><option value="NF">NORFOLK ISLAND</option><option value="MP">NORTHERN MARIANA ISLANDS</option><option value="NO">NORWAY</option><option value="OM">OMAN</option><option value="PK">PAKISTAN</option><option value="PW">PALAU</option><option value="PS">PALESTINIAN TERRITORY, OCCUPIED</option><option value="PA">PANAMA</option><option value="PG">PAPUA NEW GUINEA</option><option value="PY">PARAGUAY</option><option value="PE">PERU</option><option value="PH">PHILIPPINES</option><option value="PN">PITCAIRN</option><option value="PL">POLAND</option><option value="PT">PORTUGAL</option><option value="PR">PUERTO RICO</option><option value="QA">QATAR</option><option value="RO">ROMANIA</option><option value="RU">RUSSIAN FEDERATION</option><option value="RW">RWANDA</option><option value="SH">SAINT HELENA</option><option value="KN">SAINT KITTS AND NEVIS</option><option value="LC">SAINT LUCIA</option><option value="MF">SAINT MARTIN</option><option value="PM">SAINT PIERRE AND MIQUELON</option><option value="VC">SAINT VINCENT AND THE GRENADINES</option><option value="WS">SAMOA</option><option value="SM">SAN MARINO</option><option value="ST">SAO TOME AND PRINCIPE</option><option value="SA">SAUDI ARABIA</option><option value="SN">SENEGAL</option><option value="RS">SERBIA</option><option value="SC">SEYCHELLES</option><option value="SL">SIERRA LEONE</option><option value="SG">SINGAPORE</option><option value="SK">SLOVAKIA</option><option value="SI">SLOVENIA</option><option value="SB">SOLOMON ISLANDS</option><option value="SO">SOMALIA</option><option value="ZA">SOUTH AFRICA</option><option value="GS">SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS</option><option value="ES">SPAIN</option><option value="LK">SRI LANKA</option><option value="SD">SUDAN</option><option value="SR">SURINAME</option><option value="SJ">SVALBARD AND JAN MAYEN</option><option value="SZ">SWAZILAND</option><option value="SE">SWEDEN</option><option value="CH">SWITZERLAND</option><option value="SY">SYRIAN ARAB REPUBLIC</option><option value="TW">TAIWAN, PROVINCE OF CHINA</option><option value="TJ">TAJIKISTAN</option><option value="TZ">TANZANIA, UNITED REPUBLIC OF</option><option value="TH">THAILAND</option><option value="TL">TIMOR-LESTE</option><option value="TG">TOGO</option><option value="TK">TOKELAU</option><option value="TO">TONGA</option><option value="TT">TRINIDAD AND TOBAGO</option><option value="TN">TUNISIA</option><option value="TR">TURKEY</option><option value="TM">TURKMENISTAN</option><option value="TC">TURKS AND CAICOS ISLANDS</option><option value="TV">TUVALU</option><option value="UG">UGANDA</option><option value="UA">UKRAINE</option><option value="AE">UNITED ARAB EMIRATES</option><option value="GB">UNITED KINGDOM</option><option value="US">UNITED STATES</option><option value="UM">UNITED STATES MINOR OUTLYING ISLANDS</option><option value="UY">URUGUAY</option><option value="UZ">UZBEKISTAN</option><option value="VU">VANUATU</option><option value="VE">VENEZUELA</option><option value="VN">VIET NAM</option><option value="VG">VIRGIN ISLANDS, BRITISH</option><option value="VI">VIRGIN ISLANDS, U_S_</option><option value="WF">WALLIS AND FUTUNA</option><option value="EH">WESTERN SAHARA</option><option value="YE">YEMEN</option><option value="ZM">ZAMBIA</option><option value="ZW">ZIMBABWE </option> 
  </td>
  <td class="error"><?php echo $errors["officers[1]_companyOfficer_birthDetails_country"] ?></td>
</table>

<h3>Shares (office holder 2)</h3>
<table cellspacing="10px">
<tr>
  <th>Share Class</th>
  <td>
    <select name="shareMembers2_holding_shareClassCode"> 
      <option selected="selected" value="ORD">(ORD) Ordinary</option><option value="A">(A) A</option><option value="B">(B) B</option><option value="MAN">(MAN) Management</option><option value="LG">(LG) Life Governors</option><option value="EMP">(EMP) Employees</option><option value="FOU">(FOU) Founders</option><option value="PRF">(PRF) Preference</option><option value="CUMP">(CUMP) Cumulative Preference</option><option value="NCP">(NCP) Non Cumulative Preference</option><option value="REDP">(REDP) Redeemable Preference</option><option value="NRP">(NRP) Non Redeemable Preference</option><option value="NCRP">(NCRP) Non Cum_ Redeemable Preference</option><option value="PARP">(PARP) Participative Preference</option><option value="RED">(RED) Redeemable</option><option value="INI">(INI) Initial</option><option value="SPE">(SPE) Special</option> 
    </select>
  </td>
  <td class="error"><?php echo $errors["shareMembers[1]_holding_shareClassCode"] ?></td>
</tr>
<tr>
  <th>Number of shares</th>
  <td><input id="number" name="shareMembers2_holding_agreedNumber" type="text"  value="<?php echo $_POST['shareMembers2_holding_agreedNumber'] ?>"/>
  <td class="error"><?php echo $errors["shareMembers[1]_holding_agreedNumber"] ?></td>
</tr>
<tr>
  <th>Cost per share</th>
  <td>$<input id="amount" name="shareMembers2_holding_amountPaid" type="text"  value="<?php echo $_POST['shareMembers2_holding_amountPaid'] ?>"/> 
  <td class="error"><?php echo $errors["shareMembers[1]_holding_amountPaid"] ?></td>
</tr>
<tr>
  <th>
   Total amount paid to the company upon registration for these shares
  </th>
  <td>$<input id="amount" name="shareMembers2_holding_totalAmountPaid" type="text"  value="<?php echo $_POST['shareMembers2_holding_totalAmountPaid'] ?>"/> 
  <td class="error"><?php echo $errors["shareMembers[1]_holding_totalAmountPaid"] ?></td>
</tr>
<tr>
  <th>Are these shares held on behalf of another individual or organisation?</th>
  <td>
     <input name="shareMembers2_holding_beneficialOwner" value="false" type="radio" />Yes<br/> 
     <input name="shareMembers2_holding_beneficialOwner" value="true" type="radio" checked="checked" />No
  </td>
</table>






<h3>Office Holder 3</h3>
<table cellspacing="10px">
<tr>
  <th>First Name</th>
  <td><input name="officers3_companyOfficer_officer_givenName" type="text"  value="<?php echo $_POST['officers3_companyOfficer_officer_givenName'] ?>"/></td>
  <td class="error"><?php echo $errors["officers[2]_companyOfficer_officer_givenName"] ?></td>
</tr>
<tr>
  <th>Middle Name</th>
  <td><input name="officers3_companyOfficer_officer_givenName2" type="text"  value="<?php echo $_POST['officers3_companyOfficer_officer_givenName2'] ?>"/></td>
  <td class="error"><?php echo $errors["officers[2]_companyOfficer_officer_givenName2"] ?></td>
</tr>
<tr>
  <th>Surname</th>
  <td><input name="officers3_companyOfficer_officer_familyName" type="text"  value="<?php echo $_POST['officers3_companyOfficer_officer_familyName'] ?>"/></td>
  <td class="error"><?php echo $errors["officers[2]_companyOfficer_officer_familyName"] ?></td>
</tr>
<tr>
  <th>Offices Held</th>
  <td>
    <input name="officers3_director" value="true" type="checkbox" />Director<br/> 
    <input name="officers3_secretary" value="true" type="checkbox" />Secretary
  </td>
  <td class="error"><?php echo $errors["officers[2]_officesHeld"] ?></td>
</tr>
<tr>
  <th colspan="2">Residential Address</th>
</tr>
<tr>
  <th>Unit/Level/Suite</th>
  <td><input name="officers3_companyOfficer_officerAddress_addrLine2" type="text"  value="<?php echo $_POST['officers3_companyOfficer_officerAddress_addrLine2'] ?>"/></td>
  <td class="error"><?php echo $errors["officers[2]_companyOfficer_officerAddress_addrLine2"] ?></td>
</tr>
<tr>
  <th>Street number and street name</th>
  <td><input name="officers3_companyOfficer_officerAddress_addrStreet" type="text"  value="<?php echo $_POST['officers3_companyOfficer_officerAddress_addrStreet'] ?>"/></td>
  <td class="error"><?php echo $errors["officers[2]_companyOfficer_officerAddress_addrStreet"] ?></td>
</tr>
<tr>
  <th>Suburb, town or city</th>
  <td><input name="officers3_companyOfficer_officerAddress_city" type="text"  value="<?php echo $_POST['officers3_companyOfficer_officerAddress_city'] ?>"/></td>
  <td class="error"><?php echo $errors["officers[2]_companyOfficer_officerAddress_city"] ?></td>
</tr>
<tr>
  <th>State</th>
  <td>
     <select name="officers3_companyOfficer_officerAddress_state"> 
        <option value="">Non-Australian</option> 
        <option value="ACT">Australian Capital Territory</option><option value="NSW">New South Wales</option><option value="NT">Northern Territory</option><option value="QLD">Queensland</option><option value="SA">South Australia</option><option value="TAS">Tasmania</option><option value="VIC">Victoria</option><option value="WA">Western Australia</option> 
     </select> 
  </td>
  <td class="error"><?php echo $errors["officers[2]_companyOfficer_officerAddress_state"] ?></td>
</tr>
<tr>
  <th>Postcode</th>
  <td><input name="officers3_companyOfficer_officerAddress_postcode" type="text"  value="<?php echo $_POST['officers3_companyOfficer_officerAddress_postcode'] ?>"/></td>
  <td class="error"><?php echo $errors["officers[2]_companyOfficer_officerAddress_postcode"] ?></td>
</tr>
<tr>
  <th>Country</th>
  <td>
    <select name="officers3_companyOfficer_officerAddress_countryDisplay"> 
    <option value="AU">AUSTRALIA</option><option value="AF">AFGHANISTAN</option><option value="AX">ALAND ISLANDS</option><option value="AL">ALBANIA</option><option value="DZ">ALGERIA</option><option value="AS">AMERICAN SAMOA</option><option value="AD">ANDORRA</option><option value="AO">ANGOLA</option><option value="AI">ANGUILLA</option><option value="AQ">ANTARCTICA</option><option value="AG">ANTIGUA AND BARBUDA</option><option value="AR">ARGENTINA</option><option value="AM">ARMENIA</option><option value="AW">ARUBA</option><option value="AT">AUSTRIA</option><option value="AZ">AZERBAIJAN</option><option value="BS">BAHAMAS</option><option value="BH">BAHRAIN</option><option value="BD">BANGLADESH</option><option value="BB">BARBADOS</option><option value="BY">BELARUS</option><option value="BE">BELGIUM</option><option value="BZ">BELIZE</option><option value="BJ">BENIN</option><option value="BM">BERMUDA</option><option value="BT">BHUTAN</option><option value="BO">BOLIVIA</option><option value="BA">BOSNIA AND HERZEGOVINA</option><option value="BW">BOTSWANA</option><option value="BV">BOUVET ISLAND</option><option value="BR">BRAZIL</option><option value="IO">BRITISH INDIAN OCEAN TERRITORY</option><option value="BN">BRUNEI DARUSSALAM</option><option value="BG">BULGARIA</option><option value="BF">BURKINA FASO</option><option value="BI">BURUNDI</option><option value="KH">CAMBODIA</option><option value="CM">CAMEROON</option><option value="CA">CANADA</option><option value="CV">CAPE VERDE</option><option value="KY">CAYMAN ISLANDS</option><option value="CF">CENTRAL AFRICAN REPUBLIC</option><option value="TD">CHAD</option><option value="CL">CHILE</option><option value="CN">CHINA</option><option value="CX">CHRISTMAS ISLAND</option><option value="CC">COCOS (KEELING) ISLANDS</option><option value="CO">COLOMBIA</option><option value="KM">COMOROS</option><option value="CG">CONGO</option><option value="CD">CONGO, THE DEMOCRATIC REPUBLIC OF THE</option><option value="CK">COOK ISLANDS</option><option value="CR">COSTA RICA</option><option value="CI">CÔøΩTE D'IVOIRE</option><option value="HR">CROATIA</option><option value="CU">CUBA</option><option value="CY">CYPRUS</option><option value="CZ">CZECH REPUBLIC</option><option value="DK">DENMARK</option><option value="DJ">DJIBOUTI</option><option value="DM">DOMINICA</option><option value="DO">DOMINICAN REPUBLIC</option><option value="EC">ECUADOR</option><option value="EG">EGYPT</option><option value="SV">EL SALVADOR</option><option value="GQ">EQUATORIAL GUINEA</option><option value="ER">ERITREA</option><option value="EE">ESTONIA</option><option value="ET">ETHIOPIA</option><option value="FK">FALKLAND ISLANDS (MALVINAS)</option><option value="FO">FAROE ISLANDS</option><option value="FJ">FIJI</option><option value="FI">FINLAND</option><option value="FR">FRANCE</option><option value="GF">FRENCH GUIANA</option><option value="PF">FRENCH POLYNESIA</option><option value="TF">FRENCH SOUTHERN TERRITORIES</option><option value="GA">GABON</option><option value="GM">GAMBIA</option><option value="GE">GEORGIA</option><option value="DE">GERMANY</option><option value="GH">GHANA</option><option value="GI">GIBRALTAR</option><option value="GR">GREECE</option><option value="GL">GREENLAND</option><option value="GD">GRENADA</option><option value="GP">GUADELOUPE</option><option value="GU">GUAM</option><option value="GT">GUATEMALA</option><option value="GG">GUERNSEY</option><option value="GN">GUINEA</option><option value="GW">GUINEA-BISSAU</option><option value="GY">GUYANA</option><option value="HT">HAITI</option><option value="HM">HEARD ISLAND AND MCDONALD ISLANDS</option><option value="VA">HOLY SEE (VATICAN CITY STATE)</option><option value="HN">HONDURAS</option><option value="HK">HONG KONG</option><option value="HU">HUNGARY</option><option value="IS">ICELAND</option><option value="IN">INDIA</option><option value="ID">INDONESIA</option><option value="IR">IRAN, ISLAMIC REPUBLIC OF</option><option value="IQ">IRAQ</option><option value="IE">IRELAND</option><option value="IM">ISLE OF MAN</option><option value="IL">ISRAEL</option><option value="IT">ITALY</option><option value="JM">JAMAICA</option><option value="JP">JAPAN</option><option value="JE">JERSEY</option><option value="JO">JORDAN</option><option value="KZ">KAZAKHSTAN</option><option value="KE">KENYA</option><option value="KI">KIRIBATI</option><option value="KP">KOREA, DEMOCRATIC PEOPLE'S REPUBLIC OF</option><option value="KR">KOREA, REPUBLIC OF</option><option value="KW">KUWAIT</option><option value="KG">KYRGYZSTAN</option><option value="LA">LAO PEOPLE'S DEMOCRATIC REPUBLIC</option><option value="LV">LATVIA</option><option value="LB">LEBANON</option><option value="LS">LESOTHO</option><option value="LR">LIBERIA</option><option value="LY">LIBYAN ARAB JAMAHIRIYA</option><option value="LI">LIECHTENSTEIN</option><option value="LT">LITHUANIA</option><option value="LU">LUXEMBOURG</option><option value="MO">MACAO</option><option value="MK">MACEDONIA, THE FORMER YUGOSLAV REPUBLIC OF</option><option value="MG">MADAGASCAR</option><option value="MW">MALAWI</option><option value="MY">MALAYSIA</option><option value="MV">MALDIVES</option><option value="ML">MALI</option><option value="MT">MALTA</option><option value="MH">MARSHALL ISLANDS</option><option value="MQ">MARTINIQUE</option><option value="MR">MAURITANIA</option><option value="MU">MAURITIUS</option><option value="YT">MAYOTTE</option><option value="MX">MEXICO</option><option value="FM">MICRONESIA, FEDERATED STATES OF</option><option value="MD">MOLDOVA</option><option value="MC">MONACO</option><option value="MN">MONGOLIA</option><option value="ME">MONTENEGRO</option><option value="MS">MONTSERRAT</option><option value="MA">MOROCCO</option><option value="MZ">MOZAMBIQUE</option><option value="MM">MYANMAR</option><option value="NA">NAMIBIA</option><option value="NR">NAURU</option><option value="NP">NEPAL</option><option value="NL">NETHERLANDS</option><option value="AN">NETHERLANDS ANTILLES</option><option value="NC">NEW CALEDONIA</option><option value="NZ">NEW ZEALAND</option><option value="NI">NICARAGUA</option><option value="NE">NIGER</option><option value="NG">NIGERIA</option><option value="NU">NIUE</option><option value="NF">NORFOLK ISLAND</option><option value="MP">NORTHERN MARIANA ISLANDS</option><option value="NO">NORWAY</option><option value="OM">OMAN</option><option value="PK">PAKISTAN</option><option value="PW">PALAU</option><option value="PS">PALESTINIAN TERRITORY, OCCUPIED</option><option value="PA">PANAMA</option><option value="PG">PAPUA NEW GUINEA</option><option value="PY">PARAGUAY</option><option value="PE">PERU</option><option value="PH">PHILIPPINES</option><option value="PN">PITCAIRN</option><option value="PL">POLAND</option><option value="PT">PORTUGAL</option><option value="PR">PUERTO RICO</option><option value="QA">QATAR</option><option value="RO">ROMANIA</option><option value="RU">RUSSIAN FEDERATION</option><option value="RW">RWANDA</option><option value="SH">SAINT HELENA</option><option value="KN">SAINT KITTS AND NEVIS</option><option value="LC">SAINT LUCIA</option><option value="MF">SAINT MARTIN</option><option value="PM">SAINT PIERRE AND MIQUELON</option><option value="VC">SAINT VINCENT AND THE GRENADINES</option><option value="WS">SAMOA</option><option value="SM">SAN MARINO</option><option value="ST">SAO TOME AND PRINCIPE</option><option value="SA">SAUDI ARABIA</option><option value="SN">SENEGAL</option><option value="RS">SERBIA</option><option value="SC">SEYCHELLES</option><option value="SL">SIERRA LEONE</option><option value="SG">SINGAPORE</option><option value="SK">SLOVAKIA</option><option value="SI">SLOVENIA</option><option value="SB">SOLOMON ISLANDS</option><option value="SO">SOMALIA</option><option value="ZA">SOUTH AFRICA</option><option value="GS">SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS</option><option value="ES">SPAIN</option><option value="LK">SRI LANKA</option><option value="SD">SUDAN</option><option value="SR">SURINAME</option><option value="SJ">SVALBARD AND JAN MAYEN</option><option value="SZ">SWAZILAND</option><option value="SE">SWEDEN</option><option value="CH">SWITZERLAND</option><option value="SY">SYRIAN ARAB REPUBLIC</option><option value="TW">TAIWAN, PROVINCE OF CHINA</option><option value="TJ">TAJIKISTAN</option><option value="TZ">TANZANIA, UNITED REPUBLIC OF</option><option value="TH">THAILAND</option><option value="TL">TIMOR-LESTE</option><option value="TG">TOGO</option><option value="TK">TOKELAU</option><option value="TO">TONGA</option><option value="TT">TRINIDAD AND TOBAGO</option><option value="TN">TUNISIA</option><option value="TR">TURKEY</option><option value="TM">TURKMENISTAN</option><option value="TC">TURKS AND CAICOS ISLANDS</option><option value="TV">TUVALU</option><option value="UG">UGANDA</option><option value="UA">UKRAINE</option><option value="AE">UNITED ARAB EMIRATES</option><option value="GB">UNITED KINGDOM</option><option value="US">UNITED STATES</option><option value="UM">UNITED STATES MINOR OUTLYING ISLANDS</option><option value="UY">URUGUAY</option><option value="UZ">UZBEKISTAN</option><option value="VU">VANUATU</option><option value="VE">VENEZUELA</option><option value="VN">VIET NAM</option><option value="VG">VIRGIN ISLANDS, BRITISH</option><option value="VI">VIRGIN ISLANDS, U_S_</option><option value="WF">WALLIS AND FUTUNA</option><option value="EH">WESTERN SAHARA</option><option value="YE">YEMEN</option><option value="ZM">ZAMBIA</option><option value="ZW">ZIMBABWE </option> 
    </select> 
  </td>
  <td class="error"><?php echo $errors["officers[2]_companyOfficer_officerAddress_countryDisplay"] ?></td>
</tr>
<tr>
  <th colspan="2">Birth information</th>
</tr>
<tr>
  <th>Date Of Birth (dd/mm/yyyy)</th>
  <td><input id="dob" name="officers3_companyOfficer_birthDetails_date" type="text"  value="<?php echo $_POST['officers3_companyOfficer_birthDetails_date'] ?>"/></td>
  <td class="error"><?php echo $errors["officers[2]_companyOfficer_birthDetails_date"] ?></td>
</tr>
<tr>
  <th>Place Of Birth</th>
  <td><input id="birthsuburb" name="officers3_companyOfficer_birthDetails_town" type="text"  value="<?php echo $_POST['officers3_companyOfficer_birthDetails_town'] ?>"/></td>
  <td class="error"><?php echo $errors["officers[2]_companyOfficer_birthDetails_town"] ?></td>
</tr>
<tr>
  <th>Place of birth state</th>
  <td>
     <select name="officers3_companyOfficer_birthDetails_state"> 
        <option value="">Non-Australian</option> 
        <option value="ACT">Australian Capital Territory</option><option value="NSW">New South Wales</option><option value="NT">Northern Territory</option><option value="QLD">Queensland</option><option value="SA">South Australia</option><option value="TAS">Tasmania</option><option value="VIC">Victoria</option><option value="WA">Western Australia</option> 
     </select> 
  </td>
  <td class="error"><?php echo $errors["officers[2]_companyOfficer_birthDetails_localityQualifier"] ?></td>
</tr>
<tr>
  <th>Country of birth</th>
  <td>
     <select id="birthcountry" name="officers3_companyOfficer_birthDetails_country"> 
       <option value="AU">AUSTRALIA</option><option value="AF">AFGHANISTAN</option><option value="AX">ALAND ISLANDS</option><option value="AL">ALBANIA</option><option value="DZ">ALGERIA</option><option value="AS">AMERICAN SAMOA</option><option value="AD">ANDORRA</option><option value="AO">ANGOLA</option><option value="AI">ANGUILLA</option><option value="AQ">ANTARCTICA</option><option value="AG">ANTIGUA AND BARBUDA</option><option value="AR">ARGENTINA</option><option value="AM">ARMENIA</option><option value="AW">ARUBA</option><option value="AT">AUSTRIA</option><option value="AZ">AZERBAIJAN</option><option value="BS">BAHAMAS</option><option value="BH">BAHRAIN</option><option value="BD">BANGLADESH</option><option value="BB">BARBADOS</option><option value="BY">BELARUS</option><option value="BE">BELGIUM</option><option value="BZ">BELIZE</option><option value="BJ">BENIN</option><option value="BM">BERMUDA</option><option value="BT">BHUTAN</option><option value="BO">BOLIVIA</option><option value="BA">BOSNIA AND HERZEGOVINA</option><option value="BW">BOTSWANA</option><option value="BV">BOUVET ISLAND</option><option value="BR">BRAZIL</option><option value="IO">BRITISH INDIAN OCEAN TERRITORY</option><option value="BN">BRUNEI DARUSSALAM</option><option value="BG">BULGARIA</option><option value="BF">BURKINA FASO</option><option value="BI">BURUNDI</option><option value="KH">CAMBODIA</option><option value="CM">CAMEROON</option><option value="CA">CANADA</option><option value="CV">CAPE VERDE</option><option value="KY">CAYMAN ISLANDS</option><option value="CF">CENTRAL AFRICAN REPUBLIC</option><option value="TD">CHAD</option><option value="CL">CHILE</option><option value="CN">CHINA</option><option value="CX">CHRISTMAS ISLAND</option><option value="CC">COCOS (KEELING) ISLANDS</option><option value="CO">COLOMBIA</option><option value="KM">COMOROS</option><option value="CG">CONGO</option><option value="CD">CONGO, THE DEMOCRATIC REPUBLIC OF THE</option><option value="CK">COOK ISLANDS</option><option value="CR">COSTA RICA</option><option value="CI">CÔøΩTE D'IVOIRE</option><option value="HR">CROATIA</option><option value="CU">CUBA</option><option value="CY">CYPRUS</option><option value="CZ">CZECH REPUBLIC</option><option value="DK">DENMARK</option><option value="DJ">DJIBOUTI</option><option value="DM">DOMINICA</option><option value="DO">DOMINICAN REPUBLIC</option><option value="EC">ECUADOR</option><option value="EG">EGYPT</option><option value="SV">EL SALVADOR</option><option value="GQ">EQUATORIAL GUINEA</option><option value="ER">ERITREA</option><option value="EE">ESTONIA</option><option value="ET">ETHIOPIA</option><option value="FK">FALKLAND ISLANDS (MALVINAS)</option><option value="FO">FAROE ISLANDS</option><option value="FJ">FIJI</option><option value="FI">FINLAND</option><option value="FR">FRANCE</option><option value="GF">FRENCH GUIANA</option><option value="PF">FRENCH POLYNESIA</option><option value="TF">FRENCH SOUTHERN TERRITORIES</option><option value="GA">GABON</option><option value="GM">GAMBIA</option><option value="GE">GEORGIA</option><option value="DE">GERMANY</option><option value="GH">GHANA</option><option value="GI">GIBRALTAR</option><option value="GR">GREECE</option><option value="GL">GREENLAND</option><option value="GD">GRENADA</option><option value="GP">GUADELOUPE</option><option value="GU">GUAM</option><option value="GT">GUATEMALA</option><option value="GG">GUERNSEY</option><option value="GN">GUINEA</option><option value="GW">GUINEA-BISSAU</option><option value="GY">GUYANA</option><option value="HT">HAITI</option><option value="HM">HEARD ISLAND AND MCDONALD ISLANDS</option><option value="VA">HOLY SEE (VATICAN CITY STATE)</option><option value="HN">HONDURAS</option><option value="HK">HONG KONG</option><option value="HU">HUNGARY</option><option value="IS">ICELAND</option><option value="IN">INDIA</option><option value="ID">INDONESIA</option><option value="IR">IRAN, ISLAMIC REPUBLIC OF</option><option value="IQ">IRAQ</option><option value="IE">IRELAND</option><option value="IM">ISLE OF MAN</option><option value="IL">ISRAEL</option><option value="IT">ITALY</option><option value="JM">JAMAICA</option><option value="JP">JAPAN</option><option value="JE">JERSEY</option><option value="JO">JORDAN</option><option value="KZ">KAZAKHSTAN</option><option value="KE">KENYA</option><option value="KI">KIRIBATI</option><option value="KP">KOREA, DEMOCRATIC PEOPLE'S REPUBLIC OF</option><option value="KR">KOREA, REPUBLIC OF</option><option value="KW">KUWAIT</option><option value="KG">KYRGYZSTAN</option><option value="LA">LAO PEOPLE'S DEMOCRATIC REPUBLIC</option><option value="LV">LATVIA</option><option value="LB">LEBANON</option><option value="LS">LESOTHO</option><option value="LR">LIBERIA</option><option value="LY">LIBYAN ARAB JAMAHIRIYA</option><option value="LI">LIECHTENSTEIN</option><option value="LT">LITHUANIA</option><option value="LU">LUXEMBOURG</option><option value="MO">MACAO</option><option value="MK">MACEDONIA, THE FORMER YUGOSLAV REPUBLIC OF</option><option value="MG">MADAGASCAR</option><option value="MW">MALAWI</option><option value="MY">MALAYSIA</option><option value="MV">MALDIVES</option><option value="ML">MALI</option><option value="MT">MALTA</option><option value="MH">MARSHALL ISLANDS</option><option value="MQ">MARTINIQUE</option><option value="MR">MAURITANIA</option><option value="MU">MAURITIUS</option><option value="YT">MAYOTTE</option><option value="MX">MEXICO</option><option value="FM">MICRONESIA, FEDERATED STATES OF</option><option value="MD">MOLDOVA</option><option value="MC">MONACO</option><option value="MN">MONGOLIA</option><option value="ME">MONTENEGRO</option><option value="MS">MONTSERRAT</option><option value="MA">MOROCCO</option><option value="MZ">MOZAMBIQUE</option><option value="MM">MYANMAR</option><option value="NA">NAMIBIA</option><option value="NR">NAURU</option><option value="NP">NEPAL</option><option value="NL">NETHERLANDS</option><option value="AN">NETHERLANDS ANTILLES</option><option value="NC">NEW CALEDONIA</option><option value="NZ">NEW ZEALAND</option><option value="NI">NICARAGUA</option><option value="NE">NIGER</option><option value="NG">NIGERIA</option><option value="NU">NIUE</option><option value="NF">NORFOLK ISLAND</option><option value="MP">NORTHERN MARIANA ISLANDS</option><option value="NO">NORWAY</option><option value="OM">OMAN</option><option value="PK">PAKISTAN</option><option value="PW">PALAU</option><option value="PS">PALESTINIAN TERRITORY, OCCUPIED</option><option value="PA">PANAMA</option><option value="PG">PAPUA NEW GUINEA</option><option value="PY">PARAGUAY</option><option value="PE">PERU</option><option value="PH">PHILIPPINES</option><option value="PN">PITCAIRN</option><option value="PL">POLAND</option><option value="PT">PORTUGAL</option><option value="PR">PUERTO RICO</option><option value="QA">QATAR</option><option value="RO">ROMANIA</option><option value="RU">RUSSIAN FEDERATION</option><option value="RW">RWANDA</option><option value="SH">SAINT HELENA</option><option value="KN">SAINT KITTS AND NEVIS</option><option value="LC">SAINT LUCIA</option><option value="MF">SAINT MARTIN</option><option value="PM">SAINT PIERRE AND MIQUELON</option><option value="VC">SAINT VINCENT AND THE GRENADINES</option><option value="WS">SAMOA</option><option value="SM">SAN MARINO</option><option value="ST">SAO TOME AND PRINCIPE</option><option value="SA">SAUDI ARABIA</option><option value="SN">SENEGAL</option><option value="RS">SERBIA</option><option value="SC">SEYCHELLES</option><option value="SL">SIERRA LEONE</option><option value="SG">SINGAPORE</option><option value="SK">SLOVAKIA</option><option value="SI">SLOVENIA</option><option value="SB">SOLOMON ISLANDS</option><option value="SO">SOMALIA</option><option value="ZA">SOUTH AFRICA</option><option value="GS">SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS</option><option value="ES">SPAIN</option><option value="LK">SRI LANKA</option><option value="SD">SUDAN</option><option value="SR">SURINAME</option><option value="SJ">SVALBARD AND JAN MAYEN</option><option value="SZ">SWAZILAND</option><option value="SE">SWEDEN</option><option value="CH">SWITZERLAND</option><option value="SY">SYRIAN ARAB REPUBLIC</option><option value="TW">TAIWAN, PROVINCE OF CHINA</option><option value="TJ">TAJIKISTAN</option><option value="TZ">TANZANIA, UNITED REPUBLIC OF</option><option value="TH">THAILAND</option><option value="TL">TIMOR-LESTE</option><option value="TG">TOGO</option><option value="TK">TOKELAU</option><option value="TO">TONGA</option><option value="TT">TRINIDAD AND TOBAGO</option><option value="TN">TUNISIA</option><option value="TR">TURKEY</option><option value="TM">TURKMENISTAN</option><option value="TC">TURKS AND CAICOS ISLANDS</option><option value="TV">TUVALU</option><option value="UG">UGANDA</option><option value="UA">UKRAINE</option><option value="AE">UNITED ARAB EMIRATES</option><option value="GB">UNITED KINGDOM</option><option value="US">UNITED STATES</option><option value="UM">UNITED STATES MINOR OUTLYING ISLANDS</option><option value="UY">URUGUAY</option><option value="UZ">UZBEKISTAN</option><option value="VU">VANUATU</option><option value="VE">VENEZUELA</option><option value="VN">VIET NAM</option><option value="VG">VIRGIN ISLANDS, BRITISH</option><option value="VI">VIRGIN ISLANDS, U_S_</option><option value="WF">WALLIS AND FUTUNA</option><option value="EH">WESTERN SAHARA</option><option value="YE">YEMEN</option><option value="ZM">ZAMBIA</option><option value="ZW">ZIMBABWE </option> 
  </td>
  <td class="error"><?php echo $errors["officers[2]_companyOfficer_birthDetails_country"] ?></td>
</table>

<h3>Shares (office holder 3)</h3>
<table cellspacing="10px">
<tr>
  <th>Share Class</th>
  <td>
    <select name="shareMembers3_holding_shareClassCode"> 
      <option selected="selected" value="ORD">(ORD) Ordinary</option><option value="A">(A) A</option><option value="B">(B) B</option><option value="MAN">(MAN) Management</option><option value="LG">(LG) Life Governors</option><option value="EMP">(EMP) Employees</option><option value="FOU">(FOU) Founders</option><option value="PRF">(PRF) Preference</option><option value="CUMP">(CUMP) Cumulative Preference</option><option value="NCP">(NCP) Non Cumulative Preference</option><option value="REDP">(REDP) Redeemable Preference</option><option value="NRP">(NRP) Non Redeemable Preference</option><option value="NCRP">(NCRP) Non Cum_ Redeemable Preference</option><option value="PARP">(PARP) Participative Preference</option><option value="RED">(RED) Redeemable</option><option value="INI">(INI) Initial</option><option value="SPE">(SPE) Special</option> 
    </select>
  </td>
  <td class="error"><?php echo $errors["shareMembers[2]_holding_shareClassCode"] ?></td>
</tr>
<tr>
  <th>Number of shares</th>
  <td><input id="number" name="shareMembers3_holding_agreedNumber" type="text"  value="<?php echo $_POST['shareMembers3_holding_agreedNumber'] ?>"/>
  <td class="error"><?php echo $errors["shareMembers[2]_holding_agreedNumber"] ?></td>
</tr>
<tr>
  <th>Cost per share</th>
  <td>$<input id="amount" name="shareMembers3_holding_amountPaid" type="text"  value="<?php echo $_POST['shareMembers3_holding_amountPaid'] ?>"/> 
  <td class="error"><?php echo $errors["shareMembers[2]_holding_amountPaid"] ?></td>
</tr>
<tr>
  <th>
   Total amount paid to the company upon registration for these shares
  </th>
  <td>$<input id="amount" name="shareMembers3_holding_totalAmountPaid" type="text"  value="<?php echo $_POST['shareMembers3_holding_totalAmountPaid'] ?>"/> 
  <td class="error"><?php echo $errors["shareMembers[2]_holding_totalAmountPaid"] ?></td>
</tr>
<tr>
  <th>Are these shares held on behalf of another individual or organisation?</th>
  <td>
     <input name="shareMembers3_holding_beneficialOwner" value="false" type="radio" />Yes<br/> 
     <input name="shareMembers3_holding_beneficialOwner" value="true" type="radio" checked="checked" />No
  </td>
</table>







<h3>Office Holder 4</h3>
<table cellspacing="10px">
<tr>
  <th>First Name</th>
  <td><input name="officers4_companyOfficer_officer_givenName" type="text"  value="<?php echo $_POST['officers4_companyOfficer_officer_givenName'] ?>"/></td>
  <td class="error"><?php echo $errors["officers[3]_companyOfficer_officer_givenName"] ?></td>
</tr>
<tr>
  <th>Middle Name</th>
  <td><input name="officers4_companyOfficer_officer_givenName2" type="text"  value="<?php echo $_POST['officers4_companyOfficer_officer_givenName2'] ?>"/></td>
  <td class="error"><?php echo $errors["officers[3]_companyOfficer_officer_givenName2"] ?></td>
</tr>
<tr>
  <th>Surname</th>
  <td><input name="officers4_companyOfficer_officer_familyName" type="text"  value="<?php echo $_POST['officers4_companyOfficer_officer_familyName'] ?>"/></td>
  <td class="error"><?php echo $errors["officers[3]_companyOfficer_officer_familyName"] ?></td>
</tr>
<tr>
  <th>Offices Held</th>
  <td>
    <input name="officers4_director" value="true" type="checkbox" />Director<br/> 
    <input name="officers4_secretary" value="true" type="checkbox" />Secretary
  </td>
  <td class="error"><?php echo $errors["officers[3]_officesHeld"] ?></td>
</tr>
<tr>
  <th colspan="2">Residential Address</th>
</tr>
<tr>
  <th>Unit/Level/Suite</th>
  <td><input name="officers4_companyOfficer_officerAddress_addrLine2" type="text"  value="<?php echo $_POST['officers4_companyOfficer_officerAddress_addrLine2'] ?>"/></td>
  <td class="error"><?php echo $errors["officers[3]_companyOfficer_officerAddress_addrLine2"] ?></td>
</tr>
<tr>
  <th>Street number and street name</th>
  <td><input name="officers4_companyOfficer_officerAddress_addrStreet" type="text"  value="<?php echo $_POST['officers4_companyOfficer_officerAddress_addrStreet'] ?>"/></td>
  <td class="error"><?php echo $errors["officers[3]_companyOfficer_officerAddress_addrStreet"] ?></td>
</tr>
<tr>
  <th>Suburb, town or city</th>
  <td><input name="officers4_companyOfficer_officerAddress_city" type="text"  value="<?php echo $_POST['officers4_companyOfficer_officerAddress_city'] ?>"/></td>
  <td class="error"><?php echo $errors["officers[3]_companyOfficer_officerAddress_city"] ?></td>
</tr>
<tr>
  <th>State</th>
  <td>
     <select name="officers4_companyOfficer_officerAddress_state"> 
        <option value="">Non-Australian</option> 
        <option value="ACT">Australian Capital Territory</option><option value="NSW">New South Wales</option><option value="NT">Northern Territory</option><option value="QLD">Queensland</option><option value="SA">South Australia</option><option value="TAS">Tasmania</option><option value="VIC">Victoria</option><option value="WA">Western Australia</option> 
     </select> 
  </td>
  <td class="error"><?php echo $errors["officers[3]_companyOfficer_officerAddress_state"] ?></td>
</tr>
<tr>
  <th>Postcode</th>
  <td><input name="officers4_companyOfficer_officerAddress_postcode" type="text"  value="<?php echo $_POST['officers4_companyOfficer_officerAddress_postcode'] ?>"/></td>
  <td class="error"><?php echo $errors["officers[3]_companyOfficer_officerAddress_postcode"] ?></td>
</tr>
<tr>
  <th>Country</th>
  <td>
    <select name="officers4_companyOfficer_officerAddress_countryDisplay"> 
    <option value="AU">AUSTRALIA</option><option value="AF">AFGHANISTAN</option><option value="AX">ALAND ISLANDS</option><option value="AL">ALBANIA</option><option value="DZ">ALGERIA</option><option value="AS">AMERICAN SAMOA</option><option value="AD">ANDORRA</option><option value="AO">ANGOLA</option><option value="AI">ANGUILLA</option><option value="AQ">ANTARCTICA</option><option value="AG">ANTIGUA AND BARBUDA</option><option value="AR">ARGENTINA</option><option value="AM">ARMENIA</option><option value="AW">ARUBA</option><option value="AT">AUSTRIA</option><option value="AZ">AZERBAIJAN</option><option value="BS">BAHAMAS</option><option value="BH">BAHRAIN</option><option value="BD">BANGLADESH</option><option value="BB">BARBADOS</option><option value="BY">BELARUS</option><option value="BE">BELGIUM</option><option value="BZ">BELIZE</option><option value="BJ">BENIN</option><option value="BM">BERMUDA</option><option value="BT">BHUTAN</option><option value="BO">BOLIVIA</option><option value="BA">BOSNIA AND HERZEGOVINA</option><option value="BW">BOTSWANA</option><option value="BV">BOUVET ISLAND</option><option value="BR">BRAZIL</option><option value="IO">BRITISH INDIAN OCEAN TERRITORY</option><option value="BN">BRUNEI DARUSSALAM</option><option value="BG">BULGARIA</option><option value="BF">BURKINA FASO</option><option value="BI">BURUNDI</option><option value="KH">CAMBODIA</option><option value="CM">CAMEROON</option><option value="CA">CANADA</option><option value="CV">CAPE VERDE</option><option value="KY">CAYMAN ISLANDS</option><option value="CF">CENTRAL AFRICAN REPUBLIC</option><option value="TD">CHAD</option><option value="CL">CHILE</option><option value="CN">CHINA</option><option value="CX">CHRISTMAS ISLAND</option><option value="CC">COCOS (KEELING) ISLANDS</option><option value="CO">COLOMBIA</option><option value="KM">COMOROS</option><option value="CG">CONGO</option><option value="CD">CONGO, THE DEMOCRATIC REPUBLIC OF THE</option><option value="CK">COOK ISLANDS</option><option value="CR">COSTA RICA</option><option value="CI">CÔøΩTE D'IVOIRE</option><option value="HR">CROATIA</option><option value="CU">CUBA</option><option value="CY">CYPRUS</option><option value="CZ">CZECH REPUBLIC</option><option value="DK">DENMARK</option><option value="DJ">DJIBOUTI</option><option value="DM">DOMINICA</option><option value="DO">DOMINICAN REPUBLIC</option><option value="EC">ECUADOR</option><option value="EG">EGYPT</option><option value="SV">EL SALVADOR</option><option value="GQ">EQUATORIAL GUINEA</option><option value="ER">ERITREA</option><option value="EE">ESTONIA</option><option value="ET">ETHIOPIA</option><option value="FK">FALKLAND ISLANDS (MALVINAS)</option><option value="FO">FAROE ISLANDS</option><option value="FJ">FIJI</option><option value="FI">FINLAND</option><option value="FR">FRANCE</option><option value="GF">FRENCH GUIANA</option><option value="PF">FRENCH POLYNESIA</option><option value="TF">FRENCH SOUTHERN TERRITORIES</option><option value="GA">GABON</option><option value="GM">GAMBIA</option><option value="GE">GEORGIA</option><option value="DE">GERMANY</option><option value="GH">GHANA</option><option value="GI">GIBRALTAR</option><option value="GR">GREECE</option><option value="GL">GREENLAND</option><option value="GD">GRENADA</option><option value="GP">GUADELOUPE</option><option value="GU">GUAM</option><option value="GT">GUATEMALA</option><option value="GG">GUERNSEY</option><option value="GN">GUINEA</option><option value="GW">GUINEA-BISSAU</option><option value="GY">GUYANA</option><option value="HT">HAITI</option><option value="HM">HEARD ISLAND AND MCDONALD ISLANDS</option><option value="VA">HOLY SEE (VATICAN CITY STATE)</option><option value="HN">HONDURAS</option><option value="HK">HONG KONG</option><option value="HU">HUNGARY</option><option value="IS">ICELAND</option><option value="IN">INDIA</option><option value="ID">INDONESIA</option><option value="IR">IRAN, ISLAMIC REPUBLIC OF</option><option value="IQ">IRAQ</option><option value="IE">IRELAND</option><option value="IM">ISLE OF MAN</option><option value="IL">ISRAEL</option><option value="IT">ITALY</option><option value="JM">JAMAICA</option><option value="JP">JAPAN</option><option value="JE">JERSEY</option><option value="JO">JORDAN</option><option value="KZ">KAZAKHSTAN</option><option value="KE">KENYA</option><option value="KI">KIRIBATI</option><option value="KP">KOREA, DEMOCRATIC PEOPLE'S REPUBLIC OF</option><option value="KR">KOREA, REPUBLIC OF</option><option value="KW">KUWAIT</option><option value="KG">KYRGYZSTAN</option><option value="LA">LAO PEOPLE'S DEMOCRATIC REPUBLIC</option><option value="LV">LATVIA</option><option value="LB">LEBANON</option><option value="LS">LESOTHO</option><option value="LR">LIBERIA</option><option value="LY">LIBYAN ARAB JAMAHIRIYA</option><option value="LI">LIECHTENSTEIN</option><option value="LT">LITHUANIA</option><option value="LU">LUXEMBOURG</option><option value="MO">MACAO</option><option value="MK">MACEDONIA, THE FORMER YUGOSLAV REPUBLIC OF</option><option value="MG">MADAGASCAR</option><option value="MW">MALAWI</option><option value="MY">MALAYSIA</option><option value="MV">MALDIVES</option><option value="ML">MALI</option><option value="MT">MALTA</option><option value="MH">MARSHALL ISLANDS</option><option value="MQ">MARTINIQUE</option><option value="MR">MAURITANIA</option><option value="MU">MAURITIUS</option><option value="YT">MAYOTTE</option><option value="MX">MEXICO</option><option value="FM">MICRONESIA, FEDERATED STATES OF</option><option value="MD">MOLDOVA</option><option value="MC">MONACO</option><option value="MN">MONGOLIA</option><option value="ME">MONTENEGRO</option><option value="MS">MONTSERRAT</option><option value="MA">MOROCCO</option><option value="MZ">MOZAMBIQUE</option><option value="MM">MYANMAR</option><option value="NA">NAMIBIA</option><option value="NR">NAURU</option><option value="NP">NEPAL</option><option value="NL">NETHERLANDS</option><option value="AN">NETHERLANDS ANTILLES</option><option value="NC">NEW CALEDONIA</option><option value="NZ">NEW ZEALAND</option><option value="NI">NICARAGUA</option><option value="NE">NIGER</option><option value="NG">NIGERIA</option><option value="NU">NIUE</option><option value="NF">NORFOLK ISLAND</option><option value="MP">NORTHERN MARIANA ISLANDS</option><option value="NO">NORWAY</option><option value="OM">OMAN</option><option value="PK">PAKISTAN</option><option value="PW">PALAU</option><option value="PS">PALESTINIAN TERRITORY, OCCUPIED</option><option value="PA">PANAMA</option><option value="PG">PAPUA NEW GUINEA</option><option value="PY">PARAGUAY</option><option value="PE">PERU</option><option value="PH">PHILIPPINES</option><option value="PN">PITCAIRN</option><option value="PL">POLAND</option><option value="PT">PORTUGAL</option><option value="PR">PUERTO RICO</option><option value="QA">QATAR</option><option value="RO">ROMANIA</option><option value="RU">RUSSIAN FEDERATION</option><option value="RW">RWANDA</option><option value="SH">SAINT HELENA</option><option value="KN">SAINT KITTS AND NEVIS</option><option value="LC">SAINT LUCIA</option><option value="MF">SAINT MARTIN</option><option value="PM">SAINT PIERRE AND MIQUELON</option><option value="VC">SAINT VINCENT AND THE GRENADINES</option><option value="WS">SAMOA</option><option value="SM">SAN MARINO</option><option value="ST">SAO TOME AND PRINCIPE</option><option value="SA">SAUDI ARABIA</option><option value="SN">SENEGAL</option><option value="RS">SERBIA</option><option value="SC">SEYCHELLES</option><option value="SL">SIERRA LEONE</option><option value="SG">SINGAPORE</option><option value="SK">SLOVAKIA</option><option value="SI">SLOVENIA</option><option value="SB">SOLOMON ISLANDS</option><option value="SO">SOMALIA</option><option value="ZA">SOUTH AFRICA</option><option value="GS">SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS</option><option value="ES">SPAIN</option><option value="LK">SRI LANKA</option><option value="SD">SUDAN</option><option value="SR">SURINAME</option><option value="SJ">SVALBARD AND JAN MAYEN</option><option value="SZ">SWAZILAND</option><option value="SE">SWEDEN</option><option value="CH">SWITZERLAND</option><option value="SY">SYRIAN ARAB REPUBLIC</option><option value="TW">TAIWAN, PROVINCE OF CHINA</option><option value="TJ">TAJIKISTAN</option><option value="TZ">TANZANIA, UNITED REPUBLIC OF</option><option value="TH">THAILAND</option><option value="TL">TIMOR-LESTE</option><option value="TG">TOGO</option><option value="TK">TOKELAU</option><option value="TO">TONGA</option><option value="TT">TRINIDAD AND TOBAGO</option><option value="TN">TUNISIA</option><option value="TR">TURKEY</option><option value="TM">TURKMENISTAN</option><option value="TC">TURKS AND CAICOS ISLANDS</option><option value="TV">TUVALU</option><option value="UG">UGANDA</option><option value="UA">UKRAINE</option><option value="AE">UNITED ARAB EMIRATES</option><option value="GB">UNITED KINGDOM</option><option value="US">UNITED STATES</option><option value="UM">UNITED STATES MINOR OUTLYING ISLANDS</option><option value="UY">URUGUAY</option><option value="UZ">UZBEKISTAN</option><option value="VU">VANUATU</option><option value="VE">VENEZUELA</option><option value="VN">VIET NAM</option><option value="VG">VIRGIN ISLANDS, BRITISH</option><option value="VI">VIRGIN ISLANDS, U_S_</option><option value="WF">WALLIS AND FUTUNA</option><option value="EH">WESTERN SAHARA</option><option value="YE">YEMEN</option><option value="ZM">ZAMBIA</option><option value="ZW">ZIMBABWE </option> 
    </select> 
  </td>
  <td class="error"><?php echo $errors["officers[3]_companyOfficer_officerAddress_countryDisplay"] ?></td>
</tr>
<tr>
  <th colspan="2">Birth information</th>
</tr>
<tr>
  <th>Date Of Birth (dd/mm/yyyy)</th>
  <td><input id="dob" name="officers4_companyOfficer_birthDetails_date" type="text"  value="<?php echo $_POST['officers4_companyOfficer_birthDetails_date'] ?>"/></td>
  <td class="error"><?php echo $errors["officers[3]_companyOfficer_birthDetails_date"] ?></td>
</tr>
<tr>
  <th>Place Of Birth</th>
  <td><input id="birthsuburb" name="officers4_companyOfficer_birthDetails_town" type="text"  value="<?php echo $_POST['officers4_companyOfficer_birthDetails_town'] ?>"/></td>
  <td class="error"><?php echo $errors["officers[3]_companyOfficer_birthDetails_town"] ?></td>
</tr>
<tr>
  <th>Place of birth state</th>
  <td>
     <select name="officers4_companyOfficer_birthDetails_state"> 
        <option value="">Non-Australian</option> 
        <option value="ACT">Australian Capital Territory</option><option value="NSW">New South Wales</option><option value="NT">Northern Territory</option><option value="QLD">Queensland</option><option value="SA">South Australia</option><option value="TAS">Tasmania</option><option value="VIC">Victoria</option><option value="WA">Western Australia</option> 
     </select> 
  </td>
  <td class="error"><?php echo $errors["officers[3]_companyOfficer_birthDetails_localityQualifier"] ?></td>
</tr>
<tr>
  <th>Country of birth</th>
  <td>
     <select id="birthcountry" name="officers4_companyOfficer_birthDetails_country"> 
       <option value="AU">AUSTRALIA</option><option value="AF">AFGHANISTAN</option><option value="AX">ALAND ISLANDS</option><option value="AL">ALBANIA</option><option value="DZ">ALGERIA</option><option value="AS">AMERICAN SAMOA</option><option value="AD">ANDORRA</option><option value="AO">ANGOLA</option><option value="AI">ANGUILLA</option><option value="AQ">ANTARCTICA</option><option value="AG">ANTIGUA AND BARBUDA</option><option value="AR">ARGENTINA</option><option value="AM">ARMENIA</option><option value="AW">ARUBA</option><option value="AT">AUSTRIA</option><option value="AZ">AZERBAIJAN</option><option value="BS">BAHAMAS</option><option value="BH">BAHRAIN</option><option value="BD">BANGLADESH</option><option value="BB">BARBADOS</option><option value="BY">BELARUS</option><option value="BE">BELGIUM</option><option value="BZ">BELIZE</option><option value="BJ">BENIN</option><option value="BM">BERMUDA</option><option value="BT">BHUTAN</option><option value="BO">BOLIVIA</option><option value="BA">BOSNIA AND HERZEGOVINA</option><option value="BW">BOTSWANA</option><option value="BV">BOUVET ISLAND</option><option value="BR">BRAZIL</option><option value="IO">BRITISH INDIAN OCEAN TERRITORY</option><option value="BN">BRUNEI DARUSSALAM</option><option value="BG">BULGARIA</option><option value="BF">BURKINA FASO</option><option value="BI">BURUNDI</option><option value="KH">CAMBODIA</option><option value="CM">CAMEROON</option><option value="CA">CANADA</option><option value="CV">CAPE VERDE</option><option value="KY">CAYMAN ISLANDS</option><option value="CF">CENTRAL AFRICAN REPUBLIC</option><option value="TD">CHAD</option><option value="CL">CHILE</option><option value="CN">CHINA</option><option value="CX">CHRISTMAS ISLAND</option><option value="CC">COCOS (KEELING) ISLANDS</option><option value="CO">COLOMBIA</option><option value="KM">COMOROS</option><option value="CG">CONGO</option><option value="CD">CONGO, THE DEMOCRATIC REPUBLIC OF THE</option><option value="CK">COOK ISLANDS</option><option value="CR">COSTA RICA</option><option value="CI">CÔøΩTE D'IVOIRE</option><option value="HR">CROATIA</option><option value="CU">CUBA</option><option value="CY">CYPRUS</option><option value="CZ">CZECH REPUBLIC</option><option value="DK">DENMARK</option><option value="DJ">DJIBOUTI</option><option value="DM">DOMINICA</option><option value="DO">DOMINICAN REPUBLIC</option><option value="EC">ECUADOR</option><option value="EG">EGYPT</option><option value="SV">EL SALVADOR</option><option value="GQ">EQUATORIAL GUINEA</option><option value="ER">ERITREA</option><option value="EE">ESTONIA</option><option value="ET">ETHIOPIA</option><option value="FK">FALKLAND ISLANDS (MALVINAS)</option><option value="FO">FAROE ISLANDS</option><option value="FJ">FIJI</option><option value="FI">FINLAND</option><option value="FR">FRANCE</option><option value="GF">FRENCH GUIANA</option><option value="PF">FRENCH POLYNESIA</option><option value="TF">FRENCH SOUTHERN TERRITORIES</option><option value="GA">GABON</option><option value="GM">GAMBIA</option><option value="GE">GEORGIA</option><option value="DE">GERMANY</option><option value="GH">GHANA</option><option value="GI">GIBRALTAR</option><option value="GR">GREECE</option><option value="GL">GREENLAND</option><option value="GD">GRENADA</option><option value="GP">GUADELOUPE</option><option value="GU">GUAM</option><option value="GT">GUATEMALA</option><option value="GG">GUERNSEY</option><option value="GN">GUINEA</option><option value="GW">GUINEA-BISSAU</option><option value="GY">GUYANA</option><option value="HT">HAITI</option><option value="HM">HEARD ISLAND AND MCDONALD ISLANDS</option><option value="VA">HOLY SEE (VATICAN CITY STATE)</option><option value="HN">HONDURAS</option><option value="HK">HONG KONG</option><option value="HU">HUNGARY</option><option value="IS">ICELAND</option><option value="IN">INDIA</option><option value="ID">INDONESIA</option><option value="IR">IRAN, ISLAMIC REPUBLIC OF</option><option value="IQ">IRAQ</option><option value="IE">IRELAND</option><option value="IM">ISLE OF MAN</option><option value="IL">ISRAEL</option><option value="IT">ITALY</option><option value="JM">JAMAICA</option><option value="JP">JAPAN</option><option value="JE">JERSEY</option><option value="JO">JORDAN</option><option value="KZ">KAZAKHSTAN</option><option value="KE">KENYA</option><option value="KI">KIRIBATI</option><option value="KP">KOREA, DEMOCRATIC PEOPLE'S REPUBLIC OF</option><option value="KR">KOREA, REPUBLIC OF</option><option value="KW">KUWAIT</option><option value="KG">KYRGYZSTAN</option><option value="LA">LAO PEOPLE'S DEMOCRATIC REPUBLIC</option><option value="LV">LATVIA</option><option value="LB">LEBANON</option><option value="LS">LESOTHO</option><option value="LR">LIBERIA</option><option value="LY">LIBYAN ARAB JAMAHIRIYA</option><option value="LI">LIECHTENSTEIN</option><option value="LT">LITHUANIA</option><option value="LU">LUXEMBOURG</option><option value="MO">MACAO</option><option value="MK">MACEDONIA, THE FORMER YUGOSLAV REPUBLIC OF</option><option value="MG">MADAGASCAR</option><option value="MW">MALAWI</option><option value="MY">MALAYSIA</option><option value="MV">MALDIVES</option><option value="ML">MALI</option><option value="MT">MALTA</option><option value="MH">MARSHALL ISLANDS</option><option value="MQ">MARTINIQUE</option><option value="MR">MAURITANIA</option><option value="MU">MAURITIUS</option><option value="YT">MAYOTTE</option><option value="MX">MEXICO</option><option value="FM">MICRONESIA, FEDERATED STATES OF</option><option value="MD">MOLDOVA</option><option value="MC">MONACO</option><option value="MN">MONGOLIA</option><option value="ME">MONTENEGRO</option><option value="MS">MONTSERRAT</option><option value="MA">MOROCCO</option><option value="MZ">MOZAMBIQUE</option><option value="MM">MYANMAR</option><option value="NA">NAMIBIA</option><option value="NR">NAURU</option><option value="NP">NEPAL</option><option value="NL">NETHERLANDS</option><option value="AN">NETHERLANDS ANTILLES</option><option value="NC">NEW CALEDONIA</option><option value="NZ">NEW ZEALAND</option><option value="NI">NICARAGUA</option><option value="NE">NIGER</option><option value="NG">NIGERIA</option><option value="NU">NIUE</option><option value="NF">NORFOLK ISLAND</option><option value="MP">NORTHERN MARIANA ISLANDS</option><option value="NO">NORWAY</option><option value="OM">OMAN</option><option value="PK">PAKISTAN</option><option value="PW">PALAU</option><option value="PS">PALESTINIAN TERRITORY, OCCUPIED</option><option value="PA">PANAMA</option><option value="PG">PAPUA NEW GUINEA</option><option value="PY">PARAGUAY</option><option value="PE">PERU</option><option value="PH">PHILIPPINES</option><option value="PN">PITCAIRN</option><option value="PL">POLAND</option><option value="PT">PORTUGAL</option><option value="PR">PUERTO RICO</option><option value="QA">QATAR</option><option value="RO">ROMANIA</option><option value="RU">RUSSIAN FEDERATION</option><option value="RW">RWANDA</option><option value="SH">SAINT HELENA</option><option value="KN">SAINT KITTS AND NEVIS</option><option value="LC">SAINT LUCIA</option><option value="MF">SAINT MARTIN</option><option value="PM">SAINT PIERRE AND MIQUELON</option><option value="VC">SAINT VINCENT AND THE GRENADINES</option><option value="WS">SAMOA</option><option value="SM">SAN MARINO</option><option value="ST">SAO TOME AND PRINCIPE</option><option value="SA">SAUDI ARABIA</option><option value="SN">SENEGAL</option><option value="RS">SERBIA</option><option value="SC">SEYCHELLES</option><option value="SL">SIERRA LEONE</option><option value="SG">SINGAPORE</option><option value="SK">SLOVAKIA</option><option value="SI">SLOVENIA</option><option value="SB">SOLOMON ISLANDS</option><option value="SO">SOMALIA</option><option value="ZA">SOUTH AFRICA</option><option value="GS">SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS</option><option value="ES">SPAIN</option><option value="LK">SRI LANKA</option><option value="SD">SUDAN</option><option value="SR">SURINAME</option><option value="SJ">SVALBARD AND JAN MAYEN</option><option value="SZ">SWAZILAND</option><option value="SE">SWEDEN</option><option value="CH">SWITZERLAND</option><option value="SY">SYRIAN ARAB REPUBLIC</option><option value="TW">TAIWAN, PROVINCE OF CHINA</option><option value="TJ">TAJIKISTAN</option><option value="TZ">TANZANIA, UNITED REPUBLIC OF</option><option value="TH">THAILAND</option><option value="TL">TIMOR-LESTE</option><option value="TG">TOGO</option><option value="TK">TOKELAU</option><option value="TO">TONGA</option><option value="TT">TRINIDAD AND TOBAGO</option><option value="TN">TUNISIA</option><option value="TR">TURKEY</option><option value="TM">TURKMENISTAN</option><option value="TC">TURKS AND CAICOS ISLANDS</option><option value="TV">TUVALU</option><option value="UG">UGANDA</option><option value="UA">UKRAINE</option><option value="AE">UNITED ARAB EMIRATES</option><option value="GB">UNITED KINGDOM</option><option value="US">UNITED STATES</option><option value="UM">UNITED STATES MINOR OUTLYING ISLANDS</option><option value="UY">URUGUAY</option><option value="UZ">UZBEKISTAN</option><option value="VU">VANUATU</option><option value="VE">VENEZUELA</option><option value="VN">VIET NAM</option><option value="VG">VIRGIN ISLANDS, BRITISH</option><option value="VI">VIRGIN ISLANDS, U_S_</option><option value="WF">WALLIS AND FUTUNA</option><option value="EH">WESTERN SAHARA</option><option value="YE">YEMEN</option><option value="ZM">ZAMBIA</option><option value="ZW">ZIMBABWE </option> 
  </td>
  <td class="error"><?php echo $errors["officers[3]_companyOfficer_birthDetails_country"] ?></td>
</table>

<h3>Shares (office holder 4)</h3>
<table cellspacing="10px">
<tr>
  <th>Share Class</th>
  <td>
    <select name="shareMembers4_holding_shareClassCode"> 
      <option selected="selected" value="ORD">(ORD) Ordinary</option><option value="A">(A) A</option><option value="B">(B) B</option><option value="MAN">(MAN) Management</option><option value="LG">(LG) Life Governors</option><option value="EMP">(EMP) Employees</option><option value="FOU">(FOU) Founders</option><option value="PRF">(PRF) Preference</option><option value="CUMP">(CUMP) Cumulative Preference</option><option value="NCP">(NCP) Non Cumulative Preference</option><option value="REDP">(REDP) Redeemable Preference</option><option value="NRP">(NRP) Non Redeemable Preference</option><option value="NCRP">(NCRP) Non Cum_ Redeemable Preference</option><option value="PARP">(PARP) Participative Preference</option><option value="RED">(RED) Redeemable</option><option value="INI">(INI) Initial</option><option value="SPE">(SPE) Special</option> 
    </select>
  </td>
  <td class="error"><?php echo $errors["shareMembers[3]_holding_shareClassCode"] ?></td>
</tr>
<tr>
  <th>Number of shares</th>
  <td><input id="number" name="shareMembers4_holding_agreedNumber" type="text"  value="<?php echo $_POST['shareMembers4_holding_agreedNumber'] ?>"/>
  <td class="error"><?php echo $errors["shareMembers[3]_holding_agreedNumber"] ?></td>
</tr>
<tr>
  <th>Cost per share</th>
  <td>$<input id="amount" name="shareMembers4_holding_amountPaid" type="text"  value="<?php echo $_POST['shareMembers4_holding_amountPaid'] ?>"/> 
  <td class="error"><?php echo $errors["shareMembers[3]_holding_amountPaid"] ?></td>
</tr>
<tr>
  <th>
   Total amount paid to the company upon registration for these shares
  </th>
  <td>$<input id="amount" name="shareMembers4_holding_totalAmountPaid" type="text"  value="<?php echo $_POST['shareMembers4_holding_totalAmountPaid'] ?>"/> 
  <td class="error"><?php echo $errors["shareMembers[3]_holding_totalAmountPaid"] ?></td>
</tr>
<tr>
  <th>Are these shares held on behalf of another individual or organisation?</th>
  <td>
     <input name="shareMembers4_holding_beneficialOwner" value="false" type="radio" />Yes<br/> 
     <input name="shareMembers4_holding_beneficialOwner" value="true" type="radio" checked="checked" />No
  </td>
</table>



<input type="submit" name="submit"/>
</form>
</body>
</html>
