<?php
function myCodes($in, $type){
$out = "";
$long = array('Afghanistan' , 'Åland Islands' , 'Albania' , 'Algeria' , 'American Samoa' , 'Andorra' , 'Angola' , 'Anguilla' , 'Antarctica' , 'Antigua and Barbuda' , 'Argentina' , 'Armenia' , 'Aruba' , 'Australia' , 'Austria' , 'Azerbaijan' , 'Bahamas' , 'Bahrain' , 'Bangladesh' , 'Barbados' , 'Belarus' , 'Belgium' , 'Belize' , 'Benin' , 'Bermuda' , 'Bhutan' , 'Bolivia - Plurinational State of' , 'Bonaire - Sint Eustatius and Saba' , 'Bosnia and Herzegovina' , 'Botswana' , 'Bouvet Island' , 'Brazil' , 'British Indian Ocean Territory' , 'Brunei Darussalam' , 'Bulgaria' , 'Burkina Faso' , 'Burundi' , 'Cambodia' , 'Cameroon' , 'Canada' , 'Cape Verde' , 'Cayman Islands' , 'Central African Republic' , 'Chad' , 'Chile' , 'China' , 'Christmas Island' , 'Cocos (Keeling) Islands' , 'Colombia' , 'Comoros' , 'Congo' , 'Congo - the Democratic Republic of the' , 'Cook Islands' , 'Costa Rica' , 'Côte d\'Ivoire' , 'Croatia' , 'Cuba' , 'Curaçao' , 'Cyprus' , 'Czech Republic' , 'Denmark' , 'Djibouti' , 'Dominica' , 'Dominican Republic' , 'Ecuador' , 'Egypt' , 'El Salvador' , 'Equatorial Guinea' , 'Eritrea' , 'Estonia' , 'Ethiopia' , 'Falkland Islands (Malvinas)' , 'Faroe Islands' , 'Fiji' , 'Finland' , 'France' , 'French Guiana' , 'French Polynesia' , 'French Southern Territories' , 'Gabon' , 'Gambia' , 'Georgia' , 'Germany' , 'Ghana' , 'Gibraltar' , 'Greece' , 'Greenland' , 'Grenada' , 'Guadeloupe' , 'Guam' , 'Guatemala' , 'Guernsey' , 'Guinea' , 'Guinea-Bissau' , 'Guyana' , 'Haiti' , 'Heard Island and McDonald Islands' , 'Holy See (Vatican City State)' , 'Honduras' , 'Hong Kong' , 'Hungary' , 'Iceland' , 'India' , 'Indonesia' , 'Iran - Islamic Republic of' , 'Iraq' , 'Ireland' , 'Isle of Man' , 'Israel' , 'Italy' , 'Jamaica' , 'Japan' , 'Jersey' , 'Jordan' , 'Kazakhstan' , 'Kenya' , 'Kiribati' , 'Korea - Democratic People\'s Republic of' , 'Korea - Republic of' , 'Kuwait' , 'Kyrgyzstan' , 'Lao People\'s Democratic Republic' , 'Latvia' , 'Lebanon' , 'Lesotho' , 'Liberia' , 'Libya' , 'Liechtenstein' , 'Lithuania' , 'Luxembourg' , 'Macao' , 'Macedonia - the former Yugoslav Republic of' , 'Madagascar' , 'Malawi' , 'Malaysia' , 'Maldives' , 'Mali' , 'Malta' , 'Marshall Islands' , 'Martinique' , 'Mauritania' , 'Mauritius' , 'Mayotte' , 'Mexico' , 'Micronesia - Federated States of' , 'Moldova - Republic of' , 'Monaco' , 'Mongolia' , 'Montenegro' , 'Montserrat' , 'Morocco' , 'Mozambique' , 'Myanmar' , 'Namibia' , 'Nauru' , 'Nepal' , 'Netherlands' , 'New Caledonia' , 'New Zealand' , 'Nicaragua' , 'Niger' , 'Nigeria' , 'Niue' , 'Norfolk Island' , 'Northern Mariana Islands' , 'Norway' , 'Oman' , 'Pakistan' , 'Palau' , 'Palestinian Territory - Occupied' , 'Panama' , 'Papua New Guinea' , 'Paraguay' , 'Peru' , 'Philippines' , 'Pitcairn' , 'Poland' , 'Portugal' , 'Puerto Rico' , 'Qatar' , 'Réunion' , 'Romania' , 'Russian Federation' , 'Rwanda' , 'Saint Barthélemy' , 'Saint Helena - Ascension and Tristan da Cunha' , 'Saint Kitts and Nevis' , 'Saint Lucia' , 'Saint Martin (French part)' , 'Saint Pierre and Miquelon' , 'Saint Vincent and the Grenadines' , 'Samoa' , 'San Marino' , 'Sao Tome and Principe' , 'Saudi Arabia' , 'Senegal' , 'Serbia' , 'Seychelles' , 'Sierra Leone' , 'Singapore' , 'Sint Maarten (Dutch part)' , 'Slovakia' , 'Slovenia' , 'Solomon Islands' , 'Somalia' , 'South Africa' , 'South Georgia and the South Sandwich Islands' , 'South Sudan' , 'Spain' , 'Sri Lanka' , 'Sudan' , 'Suriname' , 'Svalbard and Jan Mayen' , 'Swaziland' , 'Sweden' , 'Switzerland' , 'Syrian Arab Republic' , 'Taiwan - Province of China' , 'Tajikistan' , 'Tanzania - United Republic of' , 'Thailand' , 'Timor-Leste' , 'Togo' , 'Tokelau' , 'Tonga' , 'Trinidad and Tobago' , 'Tunisia' , 'Turkey' , 'Turkmenistan' , 'Turks and Caicos Islands' , 'Tuvalu' , 'Uganda' , 'Ukraine' , 'United Arab Emirates' , 'United Kingdom' , 'United States' , 'United States Minor Outlying Islands' , 'Uruguay' , 'Uzbekistan' , 'Vanuatu' , 'Venezuela - Bolivarian Republic of' , 'Viet Nam' , 'Virgin Islands - British' , 'Virgin Islands - U.S.' , 'Wallis and Futuna' , 'Western Sahara' , 'Yemen' , 'Zambia' , 'Zimbabwe');
$short = array('AF','AX','AL','DZ','AS','AD','AO','AI','AQ','AG','AR','AM','AW','AU','AT','AZ','BS','BH','BD','BB','BY','BE','BZ','BJ','BM','BT','BO','BQ','BA','BW','BV','BR','IO','BN','BG','BF','BI','KH','CM','CA','CV','KY','CF','TD','CL','CN','CX','CC','CO','KM','CG','CD','CK','CR','CI','HR','CU','CW','CY','CZ','DK','DJ','DM','DO','EC','EG','SV','GQ','ER','EE','ET','FK','FO','FJ','FI','FR','GF','PF','TF','GA','GM','GE','DE','GH','GI','GR','GL','GD','GP','GU','GT','GG','GN','GW','GY','HT','HM','VA','HN','HK','HU','IS','IN','ID','IR','IQ','IE','IM','IL','IT','JM','JP','JE','JO','KZ','KE','KI','KP','KR','KW','KG','LA','LV','LB','LS','LR','LY','LI','LT','LU','MO','MK','MG','MW','MY','MV','ML','MT','MH','MQ','MR','MU','YT','MX','FM','MD','MC','MN','ME','MS','MA','MZ','MM','NA','NR','NP','NL','NC','NZ','NI','NE','NG','NU','NF','MP','NO','OM','PK','PW','PS','PA','PG','PY','PE','PH','PN','PL','PT','PR','QA','RE','RO','RU','RW','BL','SH','KN','LC','MF','PM','VC','WS','SM','ST','SA','SN','RS','SC','SL','SG','SX','SK','SI','SB','SO','ZA','GS','SS','ES','LK','SD','SR','SJ','SZ','SE','CH','SY','TW','TJ','TZ','TH','TL','TG','TK','TO','TT','TN','TR','TM','TC','TV','UG','UA','AE','GB','US','UM','UY','UZ','VU','VE','VN','VG','VI','WF','EH','YE','ZM','ZW');
//$in = strtolower(trim($in));
switch($type){
	case 'long':$out = str_replace($short, $long, $in);break;
	case 'short':$out = str_replace($long, $short, $in);break;
}
return $out;
}

function corp_post_Data($entry, $form){
	$pending_meta_value = gform_get_meta($entry["id"], "is_pending");
	if($pending_meta_value != "1"){
	
	$request = new stdClass();
	$request->userName = "info@thesmsfacademy.com.au";
	$request->password = "Superannuation0";
	//echo "Object: ".print_r($request, true);

	$form201 = new stdClass();
	$request-> form201 = $form201;
	$officers = array();
	$shareHoldings = array();
	$formerNames = array();

	//we'll make a few assumptions
	//1. This is a standard pty ltd company
	//2. It has no special purpose
	//3. Not previously reserved
	//4. No identical business names
	//5. It will be using a preferred company name

	//Stupid php substitutes periods for underscores 
	$companyDetails 											= new stdClass();
	$companyDetails->orgNameNoLegal 							= $entry['1'];
	$companyDetails->legalElements 								= strtoupper($entry['2']);
	$companyDetails->jurisdiction 								= $entry['6'];
	$companyDetails->useAcn 									= false;
	$companyDetails->companyType 								= "APTY";
	$companyDetails->companyClass 								= "LMSH";
	$companyDetails->companySubClass 							= "PROP";
	
	if($entry['80'] == "Yes"){
		$companyDetails->bn 									= true;
		$businessName											= new stdClass();
		
	}
	else {
		$companyDetails->bn 									= false;
	}
	
	$companyDetails->reserved 									= false;
	$companyDetails->areOHAddressesResidential 					= true;
	
	//Add company details to Form 201 Object	
	$form201->companyDetails 									= $companyDetails;

	$registeredOffice = new stdClass();
	if($entry['82'] == "Yes"){
		$registeredOffice->occupyAddress 						= true;
	}
	else {
		$registeredOffice->occupyAddress 						= false;
		
		if($entry['377'] == "Yes"){
			$registeredOffice->consent							= true;
			$registeredOffice->occupierName						= $entry['14'];
		}
		else{
			$registeredOffice->consent							= false;
		}
		
	}


	/**
	 *  Title: Company Registered Address
	 *  1. Care of (C/-) = [140]
	 *  2. Search for Registered Address* [347]
	 *  3. Manual address override [389]
	 *  HIDDEN FIELDS
	 *  1. registeredOfficeLevel [391]
	 *  2. registeredOfficeStreetName [392]
	 *  3. registeredOfficeSuburbName [393]
	 *  4. registeredOfficeStateName[394]
	 *  5. registeredOfficePostcode[395]
	 *  VISIBLE FIELDS
	 *  1. Level, Floor, Unit, Office, Suite [141]
	 *  2. Street Number and Name [142]
	 *  3. Suburb [143]
	 *  4. State [144]
	 *  5. Postcode [145]

	 DONE
	  This seems that the form is echange with company incorporations special purpose
	  set up is not correct
	  with special purpose
	 */

	/**
	 *  Title: Principal Business Address of the Company
	 * HIDDEN
	 * 1. principalPlaceBusinessLevel [398]
	 * 2. principalPlaceBusinessStreetName [399]
	 * 3. principalPlaceBusinessSuburbName [400]
	 * 4. principalPlaceBusinessStateName [401]
	 * 5. principalPlaceBusinessPostcode [402]
	 * VISIBLE
	 * 1. Level, Floor, Unit, Office, Suite [146]
	 * 2. Street Number and Name* [152]
	 * 3. Suburb* [148]
	 * 4. State* [154]
	 * 5. Postcode* [155]

	 DONE
	 */


	/**
	 * Title: Officeholder Address Details
	 * HIDDEN
	 * 1. d1AddressLevel = 403
	 * 2. d1AddressStreetName = 404
	 * 3. d1AddressSuburbName = 405
	 * 4. d1AddressStateName = 406
	 * 5. d1AddressPostcode = 407
	 * VISIBLE
	 * 1. Level, Floor, Unit, Office, Suite = 151
	 * 2. Street Number and Name* = 147
	 * 3. Suburb* = 153
	 * 4. State* = 149
	 * 5. Postcode* = 150

	 DONE
	 */


	/*
		Officeholder Address Details
		// HIDDEN
		d2AddressLevel = 415
		d2AddressStreetName = 416
		d2AddressSuburbName = 423
		d2AddressStateName = 421
		d2AddressPostcode = 422
		// visible  
		Level, Floor, Unit, Office, Suite  = 163
		Street Number and Name*  = 164
		Suburb = 179
		State   = 166
		Postcode = 167


		DONE
	*/




	/* 

		Officeholder Address Details 

		HIDDEN
		d3AddressLevel = 431
		d3AddressStreetName = 432
		d3AddressSuburbName = 433
		d3AddressStateName = 434
		d3AddressPostcode = 435

		VISIBLE
		Level, Floor, Unit, Office, Suite  = 68
		Street Number and Name*  = 178
		Suburb*  = 165
		State*  = 180
		Postcode*  = 181
		DONE
	*/
 
	/*
		HIDDEN 
		d4AddressLevel = 444
		d4AddressStreetName = 445
		d4AddressSuburbName = 446
		d4AddressStateName = 447
		d4AddressPostcode = 448 

		VISIBLE  

		Level, Floor, Unit, Office, Suite = 194
		Street Number and Name* =   195
		Suburb* =  196
		State* =  192
		Postcode* = 191

		DONE
	*/

		/*
	HIDDEN 
	sh1AddressLevel = 460
	sh1AddressStreetName=  461
	sh1AddressSuburbName= 462
	sh1AddressStateName= 463
	sh1AddressPostcode= 464

	VISIBLE
	Level, Floor, Unit, Office, Suite = 217
	Street Number and Name* = 221
	Suburb* = 213
	State* = 235
	Postcode* = 339
		
		DONE - DOBULE CHECKED 
		with same id in special purpose document
	

	*/

	 // @TODO continue adding the document id to each partner









	/*
		HIDDEN
		sh2AddressLevel = 465
		sh2AddressStreetName = 467
		sh2AddressSuburbName = 466
		sh2AddressStateName = 468
		sh2AddressPostcode = 469
		VISIBLE
		Level, Floor, Unit, Office, Suite = 226  
		Street Number and Name* = 229 
		Suburb* = 234 
		State* = 236 
		Postcode* = 340

		Done with special purpose as well
	*/
 
	/*
		Shareholder's Address
		
		HIDDEM
		sh3AddressLevel = 477
		sh3AddressStreetName = 476
		sh3AddressSuburbName = 475
		sh3AddressStateName = 474
		sh3AddressPostcode = 473
	 
		VISIBLE 
		
		Level, Floor, Unit, Office, Suite =  227
		Street Number and Name*  = 230
		Suburb*  = 233
		State*  = 237
		Postcode* = 341

		done with special purpose
	*/
 

	/* 
		HIDDEN
		sh4AddressLevel = 488  
		sh4AddressStreetName   = 487
		sh4AddressSuburbName  = 486
		sh4AddressStateName   = 485
		sh4AddressPostcode  = 484
		
		VISIBLE
		Level, Floor, Unit, Office, Suite   = 228
		Street Number and Name*  = 231
		Suburb*  = 232
		State*  =  238
		Postcode*  = 346

		done with special purpose
	*/
 

	/*

		VISIBLE
		Level, Floor, Unit, Office, Suite = 369
		Street Number and Name* = 370
		Suburb* = 371
		State* = 372
		Postcode* = 373
		 	
		HIDDEN
		applicantAddressLevel = 515 
		applicantAddressStreetName = 514 
		applicantAddressSuburbName = 513
		applicantAddressStateName = 512
		applicantAddressPostcode = 511 


		done with special purpose
	*/












	$registeredOfficeAddress 									= new stdClass();
	$registeredOfficeAddress->careOf 							= $entry['140'];

	$registeredOfficeAddress->addrLine2 						= (!empty($entry['391'])) ? $entry['391'] : $entry['141'];  //$entry['398'];
	$registeredOfficeAddress->addrStreet 						= (!empty($entry['392'])) ? $entry['392'] : $entry['142'];  //$entry['399'];
	$registeredOfficeAddress->city 								= (!empty($entry['393'])) ? $entry['393'] : $entry['143'];  //$entry['400'];
	$registeredOfficeAddress->state 							= (!empty($entry['394'])) ? $entry['394'] : $entry['144'];  //$entry['401'];
	$registeredOfficeAddress->postcode 							= (!empty($entry['395'])) ? $entry['395'] : $entry['145'];  //$entry['402'];
	$registeredOffice->registeredOffice 						= $registeredOfficeAddress;
















	//Add registered office to Form 201 Object
	$form201->registeredOffice 									= $registeredOffice;

	//The principal place of business
	$placeOfBusiness 											= new stdClass();
	$principalAddress 											= new StdClass();
	$placeOfBusiness->principalAddress 							= $principalAddress;
	$principalAddress->careOf 									= $entry['322'];
	$principalAddress->addrLine2 								= ( !empty($entry['398'])) ? $entry['398'] : $entry['146'];
	$principalAddress->addrStreet 								= ( !empty($entry['399'])) ? $entry['399'] : $entry['152'];
	$principalAddress->city 									= ( !empty($entry['400'])) ? $entry['400'] : $entry['148'];
	$principalAddress->state 									= ( !empty($entry['401'])) ? $entry['401'] : $entry['154'];
	$principalAddress->postcode 								= ( !empty($entry['402'])) ? $entry['402'] : $entry['155'];

	//Add PPOB to Form 201 Object
	$form201->placeOfBusiness 									= $placeOfBusiness;

	//Officeholder 1 - Start
	$officer 													= new stdClass();
	if($entry['550.1'] == "Director"){
		$officer->director 										= true;
	}
	
	if($entry['550.2'] == "Secretary"){
		$officer->secretary 									= true;
	}

	$officerDetails 											= new stdClass();
	$officerName 												= new stdClass();
	$officerName->givenName 									= $entry['272'];
//	$officerName->givenName2 									= $entry[''];
	$officerName->familyName 									= $entry['275'];
	$officerDetails->officer 									= $officerName;

	if($entry['93'] == "Yes"){
		$officerDetails->hasFormerNames							= true;
		$formerName												= new stdClass();
		$formerName->givenName									= $entry['278'];
		$formerName->familyName									= $entry['279'];								
		$formerNames[] 											= $formerName;		
		$officerDetails->formerNames							= $formerNames;
		$formerNames = null;
	}
	else{
		$officerDetails->hasFormerNames							= false;
	}





	$officerAddress 											= new stdClass();


	$officerAddress->addrLine2 									= ( !empty($entry['403'])) ? $entry['403'] : $entry['151'];
	$officerAddress->addrStreet 								= ( !empty($entry['404'])) ? $entry['404'] : $entry['147'];
	$officerAddress->city 										= ( !empty($entry['405'])) ? $entry['405'] : $entry['153'];
	$officerAddress->state 										= ( !empty($entry['406'])) ? $entry['406'] : $entry['149'];
	$officerAddress->postcode 									= ( !empty($entry['407'])) ? $entry['407'] : $entry['150'];
	//$officerAddress->countryDisplay 							= $entry[''];
	$officerDetails->officerAddress 							= $officerAddress;

	$birthDetails 												= new stdClass();
	
	try 
	{
		$date = date( 'Y-m-d', strtotime( $entry['26'] ) );
			$birthDetails->date = $date;



			//$headers[] = "Content-type: text/html";
	 		//wp_mail('tim@automationlab.com.au', 'Date Email 1', 'Date: '.$birthDetails->date.' Entry: '.$entry['26'], $headers);
		
	} 
	catch (Exception $e) 
	{
		//ignored
		//$headers[] = "Content-type: text/html";
	 	//wp_mail('tim@automationlab.com.au', 'Date Error', print_r($e,true), $headers);
	}
	

	$birthDetails->town 										= strtoupper($entry['21']);
	$birthDetails->state 										= strtoupper($entry['559']);
	if($entry['494'] != "Yes"){
			$code =		myCodes($entry['139'], 'short');
			$birthDetails->country 								= $code;	
	}
	else{
			//$birthDetails->country 								= "Australia";
	}

	$officerDetails->birthDetails 								= $birthDetails;

	$officer->companyOfficer 									= $officerDetails;
	
	//Add Officer 1 to Officers array
	$officers[] = $officer;
	
	
	//Add Officer 1 as a Shareholder if applicable
	if($entry['92'] == "Yes"){
		//Shares
		$shareHolder 												= new stdClass();
		//we have to clone otherwise php uses a href in the request
		$shareHolder->person 										= clone $officerName;
		$shareHolder->isPerson 										= true;
		$shareHolder->address 										= clone $officerAddress;

		$shareDetails 												= new stdClass();
		$shareDetails->shareClassCode 								= $entry['302'];
		$shareDetails->agreedNumber 								= $entry['24'];
		$shareDetails->amountPaid 									= $entry['313'];
		$shareDetails->totalAmountPaid 								= $shareDetails->agreedNumber * $entry['313'];
	
		if($entry['84'] == "No"){
			$shareDetails->beneficialOwner 							= true;
			$shareDetails->beneficialOwnerName						= $entry['27'];
		}
		else {
			$shareDetails->beneficialOwner 							= false;
		}


		//over here we work out a few things
		$totalAmountUnpaid 											= $shareDetails->totalAmountPaid - ($shareDetails->agreedNumber * $entry['313']);
		$shareDetails->fullyPaid 									= ($totalAmountUnpaid == 0);
		$shareDetails->amountUnpaid 								= $totalAmountUnpaid / $shareDetails->agreedNumber;
		$shareDetails->totalAmountUnpaid 							= $totalAmountUnpaid;
		

		$shareHolding 												= new stdClass();
		$shareHolding->holding 										= $shareDetails;
		$shareHolding->members 										= array($shareHolder);
		
		

		//Add shareholding 1 to shareholdings array
		$shareHoldings[] = $shareHolding;
		$shareholding = null;
		$shareholder  = null;
	}
	
	$officerName = null;
	$officerAddress = null;
	$officer = null;
	
	
	
	if($entry['83'] > 1){
		//Officeholder 2 - Start
		$officer 													= new stdClass();
		if($entry['551.1'] == "Director"){
		$officer->director 										= true;
		}
	
		if($entry['551.2'] == "Secretary"){
			$officer->secretary 									= true;
		}
		$officerDetails 											= new stdClass();
		$officerName 												= new stdClass();
		$officerName->givenName 									= $entry['273'];
	//	$officerName->givenName2 									= $entry[''];
		$officerName->familyName 									= $entry['276'];
		$officerDetails->officer 									= $officerName;

		if($entry['96'] == "Yes"){
			$officerDetails->hasFormerNames							= true;
			$formerName												= new stdClass();
			$formerName->givenName									= $entry['277'];
			$formerName->familyName									= $entry['280'];								
			$formerNames[] 											= $formerName;		
			$officerDetails->formerNames							= $formerNames;
			$formerNames = null;
		}
		else{
			$officerDetails->hasFormerNames							= false;
		}
	
		$officerAddress 											= new stdClass();
		$officerAddress->addrLine2 									= (!empty($entry['415'])) ? $entry['415'] : $entry['163'];
		$officerAddress->addrStreet 								= (!empty($entry['416'])) ? $entry['416'] : $entry['164'];
		$officerAddress->city 										= (!empty($entry['423'])) ? $entry['423'] : $entry['179'];
		$officerAddress->state 										= (!empty($entry['421'])) ? $entry['421'] : $entry['166'];
		$officerAddress->postcode 									= (!empty($entry['422'])) ? $entry['422'] : $entry['167'];
		//$officerAddress->countryDisplay 							= $entry[''];
		$officerDetails->officerAddress 							= $officerAddress;

		$birthDetails 												= new stdClass();
		
		
	 		
		try 
		{
			$date = date( 'Y-m-d', strtotime( $entry['38'] ) );
			$birthDetails->date = $date;
			//$headers[] = "Content-type: text/html";
	 		//wp_mail('tim@automationlab.com.au', 'Date Email 2', 'Date: '.$birthDetails->date.' Entry: '.$entry['38'], $headers);
		
		} 
		catch (Exception $e) 
		{
			//ignored
			//$headers[] = "Content-type: text/html";
			//wp_mail('tim@automationlab.com.au', 'Date Error', print_r($e,true), $headers);
		}

		$birthDetails->town 										= strtoupper($entry['185']);
		$birthDetails->state 										= strtoupper($entry['560']);
		if(strlen($entry['170']) > 0){
				$code =		myCodes($entry['170'], 'short');
				$birthDetails->country 								= $code;
		}
		else{
				$birthDetails->country 								= "";
		}

		$officerDetails->birthDetails 								= $birthDetails;

		$officer->companyOfficer 									= $officerDetails;
	
		//Add Officer 2 to Officers array
		$officers[] = $officer;
		
	
		//Add Officer 2 as a Shareholder if applicable
		if($entry['303'] == "Yes"){
			//Shares
			$shareHolder 												= new stdClass();
			//we have to clone otherwise php uses a href in the request
			$shareHolder->person 										= clone $officerName;
			$shareHolder->isPerson 										= true;
			$shareHolder->address 										= clone $officerAddress;

			$shareDetails 												= new stdClass();
			$shareDetails->shareClassCode 								= $entry['98'];
			$shareDetails->agreedNumber 								= $entry['39'];
			$shareDetails->amountPaid 									= $entry['313'];
			$shareDetails->totalAmountPaid 								= $shareDetails->agreedNumber * $entry['313'];
	
			if($entry['100'] == "No"){
				$shareDetails->beneficialOwner 							= true;
				$shareDetails->beneficialOwnerName						= $entry['101'];
			}
			else {
				$shareDetails->beneficialOwner 							= false;
			}


			//over here we work out a few things
			$totalAmountUnpaid 											= $shareDetails->totalAmountPaid - ($shareDetails->agreedNumber * $entry['313']);
			$shareDetails->fullyPaid 									= ($totalAmountUnpaid == 0);
			$shareDetails->amountUnpaid 								= $totalAmountUnpaid / $shareDetails->agreedNumber;
			$shareDetails->totalAmountUnpaid 							= $totalAmountUnpaid;

			$shareHolding 												= new stdClass();
			$shareHolding->holding 										= $shareDetails;
			$shareHolding->members 										= array($shareHolder);

			//Add shareholding 2 to shareholdings array
			$shareHoldings[] = $shareHolding;
			$shareholding = null;
			$shareholder  = null;
		}
	
		$officerName = null;
		$officerAddress = null;
		$officer = null;
	}
	
	//Officeholder 3 - Start
	if($entry['83'] > 2){
		$officer 													= new stdClass();
		if($entry['552.1'] == "Director"){
		$officer->director 										= true;
		}
	
		if($entry['552.2'] == "Secretary"){
			$officer->secretary 									= true;
		}

		$officerDetails 											= new stdClass();
		$officerName 												= new stdClass();
		$officerName->givenName 									= $entry['46'];
	//	$officerName->givenName2 									= $entry[''];
		$officerName->familyName 									= $entry['171'];
		$officerDetails->officer 									= $officerName;

		if($entry['106'] == "Yes"){
			$officerDetails->hasFormerNames							= true;
			$formerName												= new stdClass();
			$formerName->givenName									= $entry['189'];
			$formerName->familyName									= $entry['173'];								
			$formerNames[] 											= $formerName;		
			$officerDetails->formerNames							= $formerNames;
			$formerNames = null;
		}
		else{
			$officerDetails->hasFormerNames							= false;
		}
		
		$officerAddress 											= new stdClass();
		$officerAddress->addrLine2 									= ( !empty($entry['431'])) ? $entry['431'] : $entry['68'];
		$officerAddress->addrStreet 								= ( !empty($entry['432'])) ? $entry['432'] : $entry['178'];
		$officerAddress->city 										= ( !empty($entry['433'])) ? $entry['433'] : $entry['165'];
		$officerAddress->state 										= ( !empty($entry['434'])) ? $entry['434'] : $entry['180'];
		$officerAddress->postcode 									= ( !empty($entry['435'])) ? $entry['435'] : $entry['181'];
		//$officerAddress->countryDisplay 							= $entry[''];
		$officerDetails->officerAddress 							= $officerAddress;

		$birthDetails 												= new stdClass();
		try 
		{
		
			//$date = date_create_from_format( 'Y-m-d', $entry['48']);
			$date = date( 'Y-m-d', strtotime( $entry['48'] ) );
			$birthDetails->date = $date;
			//if(empty($date)){
			//	$birthDetails->date = "";
			//}
			//else {
			//	$birthDetails->date = $date->getTimeStamp();
			//}


				//$headers[] = "Content-type: text/html";
				//wp_mail('tim@automationlab.com.au', 'Date Email', 'Date: '.$birthDetails->date.' Entry: '.$entry['48'], $headers);
		
		} 
		catch (Exception $e) 
		{
			//ignored
			//$headers[] = "Content-type: text/html";
			//wp_mail('tim@automationlab.com.au', 'Date Error', print_r($e,true), $headers);
		}

		$birthDetails->town 										= strtoupper($entry['441']);
		$birthDetails->state 										= strtoupper($entry['561']);
		if(strlen($entry['184']) > 0){
				$code =		myCodes($entry['184'], 'short');
				$birthDetails->country 								= $code;	
		}
		else{
				$birthDetails->country 								= "";
		}

		$officerDetails->birthDetails 								= $birthDetails;

		$officer->companyOfficer 									= $officerDetails;
	
		//Add Officer 3 to Officers array
		$officers[] = $officer;
		
		//Add Officer 3 as a Shareholder if applicable
		if($entry['304'] == "Yes"){
			//Shares
			$shareHolder 												= new stdClass();
			//we have to clone otherwise php uses a href in the request
			$shareHolder->person 										= clone $officerName;
			$shareHolder->isPerson 										= true;
			$shareHolder->address 										= clone $officerAddress;

			$shareDetails 												= new stdClass();
			$shareDetails->shareClassCode 								= $entry['108'];
			$shareDetails->agreedNumber 								= $entry['49'];
			$shareDetails->amountPaid 									= $entry['313'];
			$shareDetails->totalAmountPaid 								= $shareDetails->agreedNumber * $entry['313'];
	
			if($entry['110'] == "No"){
				$shareDetails->beneficialOwner 							= true;
				$shareDetails->beneficialOwnerName						= $entry['111'];
			}
			else {
				$shareDetails->beneficialOwner 							= false;
			}


			//over here we work out a few things
			$totalAmountUnpaid 											= $shareDetails->totalAmountPaid - ($shareDetails->agreedNumber * $entry['313']);
			$shareDetails->fullyPaid 									= ($totalAmountUnpaid == 0);
			$shareDetails->amountUnpaid 								= $totalAmountUnpaid / $shareDetails->agreedNumber;
			$shareDetails->totalAmountUnpaid 							= $totalAmountUnpaid;

			$shareHolding 												= new stdClass();
			$shareHolding->holding 										= $shareDetails;
			$shareHolding->members 										= array($shareHolder);

			//Add shareholding 3 to shareholdings array
			$shareHoldings[] = $shareHolding;
			$shareholding = null;
			$shareholder  = null;
		}
	
		$officerName = null;
		$officerAddress = null;
		$officer = null;
		
	}
	//Officeholder 4 - Start
	if($entry['83'] > 3){
		$officer 													= new stdClass();
		if($entry['553.1'] == "Director"){
		$officer->director 										= true;
		}
	
		if($entry['553.2'] == "Secretary"){
			$officer->secretary 									= true;
		}

		$officerDetails 											= new stdClass();
		$officerName 												= new stdClass();
		$officerName->givenName 									= $entry['186'];
	//	$officerName->givenName2 									= $entry[''];
		$officerName->familyName 									= $entry['187'];
		$officerDetails->officer 									= $officerName;

		if($entry['115'] == "Yes"){
			$officerDetails->hasFormerNames							= true;
			$formerName												= new stdClass();
			$formerName->givenName									= $entry['172'];
			$formerName->familyName									= $entry['190'];								
			$formerNames[] 											= $formerName;		
			$officerDetails->formerNames							= $formerNames;
			$formerNames = null;
		}
		else{
			$officerDetails->hasFormerNames							= false;
		}
		
		$officerAddress 											= new stdClass();
		$officerAddress->addrLine2 									= (!empty($entry['444'])) ? $entry['444'] : $entry['194'];
		$officerAddress->addrStreet 								= (!empty($entry['445'])) ? $entry['445'] : $entry['195'];
		$officerAddress->city 										= (!empty($entry['446'])) ? $entry['446'] : $entry['196'];
		$officerAddress->state 										= (!empty($entry['447'])) ? $entry['447'] : $entry['192'];
		$officerAddress->postcode 									= (!empty($entry['448'])) ? $entry['448'] : $entry['191'];
		//$officerAddress->countryDisplay 							= $entry[''];
		$officerDetails->officerAddress 							= $officerAddress;

		$birthDetails 												= new stdClass();
		try 
		{
			$date = date( 'Y-m-d', strtotime( $entry['59'] ) );
			$birthDetails->date = $date;


				//$headers[] = "Content-type: text/html";
				//wp_mail('tim@automationlab.com.au', 'Date Email', 'Date: '.$birthDetails->date.' Entry: '.$entry['59'], $headers);
		
		} 
		catch (Exception $e) 
		{
			//ignored
			//$headers[] = "Content-type: text/html";
			//wp_mail('tim@automationlab.com.au', 'Date Error', print_r($e,true), $headers);
		}

		$birthDetails->town 										= strtoupper($entry['453']);
		$birthDetails->state 										= strtoupper($entry['562']);
		if(strlen($entry['199']) > 0){
				$code =		myCodes($entry['199'], 'short');
				$birthDetails->country 								= $code;
		}
		else{
				$birthDetails->country 								= "";
		}

		$officerDetails->birthDetails 								= $birthDetails;

		$officer->companyOfficer 									= $officerDetails;
	
		//Add Officer 4 to Officers array
		$officers[] = $officer;
		
		//Add Officer 4 as a Shareholder if applicable
		if($entry['305'] == "Yes"){
			//Shares
			$shareHolder 												= new stdClass();
			//we have to clone otherwise php uses a href in the request
			$shareHolder->person 										= clone $officerName;
			$shareHolder->isPerson 										= true;
			$shareHolder->address 										= clone $officerAddress;

			$shareDetails 												= new stdClass();
			$shareDetails->shareClassCode 								= $entry['118'];
			$shareDetails->agreedNumber 								= $entry['120'];
			$shareDetails->amountPaid 									= $entry['313'];
			$shareDetails->totalAmountPaid 								= $shareDetails->agreedNumber * $entry['313'];
	
			if($entry['121'] == "No"){
				$shareDetails->beneficialOwner 							= true;
				$shareDetails->beneficialOwnerName						= $entry['122'];
			}
			else {
				$shareDetails->beneficialOwner 							= false;
			}


			//over here we work out a few things
			$totalAmountUnpaid 											= $shareDetails->totalAmountPaid - ($shareDetails->agreedNumber * $entry['313']);
			$shareDetails->fullyPaid 									= ($totalAmountUnpaid == 0);
			$shareDetails->amountUnpaid 								= $totalAmountUnpaid / $shareDetails->agreedNumber;
			$shareDetails->totalAmountUnpaid 							= $totalAmountUnpaid;

			$shareHolding 												= new stdClass();
			$shareHolding->holding 										= $shareDetails;
			$shareHolding->members 										= array($shareHolder);

			//Add shareholding 4 to shareholdings array
			$shareHoldings[] = $shareHolding;
			$shareholding = null;
			$shareholder  = null;
		}
	
		$officerName = null;
		$officerAddress = null;
		$officer = null;
	}
	
	
	//Non-officeholder Shareholders
	if($entry['387'] == "Yes"){
		//Non-officeholder Shareholder 1		
		$shareHolder 													= new stdClass();	
		if($entry['207'] == "Company"){
			$shareHolder->isPerson 										= false;
			$shareHolder->organisation									= $entry['260'];
			if($entry['271'] == "Yes"){
				$shareHolder->hasBusinessNumber							= true;
				$shareHolder->businessNumber							= str_replace("-","",$entry['284']);
			}
			else {
				$shareHolder->hasBusinessNumber							= false;
			}
		}
		else {
			$shareHolder->isPerson 										= true;
			$shareHolderName 											= new stdClass();
			$shareHolderName->givenName 								= $entry['214'];
			//$shareHolderName->givenName2 								= $entry[''];
			$shareHolderName->familyName 								= $entry['212'];
			$shareHolder->person 										= $shareHolderName;
		}
		
		$shareHolderAddress 											= new stdClass();
		$shareHolderAddress->addrLine2 									= (!empty($entry['460'])) ? $entry['460'] : $entry['217'];
		$shareHolderAddress->addrStreet 								= (!empty($entry['461'])) ? $entry['461'] : $entry['221'];
		$shareHolderAddress->city 										= (!empty($entry['462'])) ? $entry['462'] : $entry['213'];
		$shareHolderAddress->state 										= (!empty($entry['463'])) ? $entry['463'] : $entry['235'];
		$shareHolderAddress->postcode 									= (!empty($entry['464'])) ? $entry['464'] : $entry['339'];
		//$shareHolderAddress->countryDisplay 							= $entry[''];
		$shareHolder->address 											= $shareHolderAddress;
		
		$shareDetails 													= new stdClass();
		$shareDetails->shareClassCode 									= $entry['252'];
		$shareDetails->agreedNumber 									= $entry['259'];
		$shareDetails->amountPaid 										= $entry['313'];
		$shareDetails->totalAmountPaid 									= $shareDetails->agreedNumber * $entry['313'];
		
		if($entry['293'] == "No"){
				$shareDetails->beneficialOwner 							= true;
				$shareDetails->beneficialOwnerName						= $entry['297'];
		}
		else {
				$shareDetails->beneficialOwner 							= false;
		}
		
		$totalAmountUnpaid 												= $shareDetails->totalAmountPaid - ($shareDetails->agreedNumber * $entry['313']);
		$shareDetails->fullyPaid 										= ($totalAmountUnpaid == 0);
		$shareDetails->amountUnpaid 									= $totalAmountUnpaid / $shareDetails->agreedNumber;
		$shareDetails->totalAmountUnpaid 								= $totalAmountUnpaid;

		$shareHolding 													= new stdClass();
		$shareHolding->holding 											= $shareDetails;
		$shareHolding->members 											= array($shareHolder);

		//Add shareholding 1 to shareholdings array
		$shareHoldings[] = $shareHolding;
		$shareholding 													= null;
		$shareholder  													= null;
		$shareDetails 													= null;
		$shareHolderAddress 											= null;
		$shareHolderName 												= null;
		
		
		
		
		
		
		//SHAREHOLDER 2
		if($entry['388'] > 1){
			//Non-officeholder Shareholder 2		
			$shareHolder 													= new stdClass();	
			if($entry['210'] == "Company"){
				$shareHolder->isPerson 										= false;
				$shareHolder->organisation									= $entry['265'];
				if($entry['269'] == "Yes"){
					$shareHolder->hasBusinessNumber							= true;
					$shareHolder->businessNumber							= str_replace("-","",$entry['283']);
				}
				else {
					$shareHolder->hasBusinessNumber							= false;
				}
			}
			else {
				$shareHolder->isPerson 										= true;
				$shareHolderName 											= new stdClass();
				$shareHolderName->givenName 								= $entry['216'];
				//$shareHolderName->givenName2 								= $entry[''];
				$shareHolderName->familyName 								= $entry['220'];
				$shareHolder->person 										= $shareHolderName;
			}
		
			$shareHolderAddress 											= new stdClass();
			$shareHolderAddress->addrLine2 									= (!empty($entry['465'])) ? $entry['465'] : $entry['226'];
			$shareHolderAddress->addrStreet 								= (!empty($entry['467'])) ? $entry['467'] : $entry['229'];
			$shareHolderAddress->city 										= (!empty($entry['466'])) ? $entry['466'] : $entry['234'];
			$shareHolderAddress->state 										= (!empty($entry['468'])) ? $entry['468'] : $entry['236'];
			$shareHolderAddress->postcode 									= (!empty($entry['469'])) ? $entry['469'] : $entry['340'];
			//$shareHolderAddress->countryDisplay 							= $entry[''];
			$shareHolder->address 											= $shareHolderAddress;
		
			$shareDetails 													= new stdClass();
			$shareDetails->shareClassCode 									= $entry['253'];
			$shareDetails->agreedNumber 									= $entry['257'];
			$shareDetails->amountPaid 										= $entry['313'];
			$shareDetails->totalAmountPaid 									= $shareDetails->agreedNumber * $entry['313'];
		
			if($entry['296'] == "No"){
					$shareDetails->beneficialOwner 							= true;
					$shareDetails->beneficialOwnerName						= $entry['300'];
			}
			else {
					$shareDetails->beneficialOwner 							= false;
			}
		
			$totalAmountUnpaid 												= $shareDetails->totalAmountPaid - ($shareDetails->agreedNumber * $entry['313']);
			$shareDetails->fullyPaid 										= ($totalAmountUnpaid == 0);
			$shareDetails->amountUnpaid 									= $totalAmountUnpaid / $shareDetails->agreedNumber;
			$shareDetails->totalAmountUnpaid 								= $totalAmountUnpaid;

			$shareHolding 													= new stdClass();
			$shareHolding->holding 											= $shareDetails;
			$shareHolding->members 											= array($shareHolder);

			//Add shareholding 1 to shareholdings array
			$shareHoldings[] = $shareHolding;
			$shareholding 													= null;
			$shareholder  													= null;
			$shareDetails 													= null;
			$shareHolderAddress 											= null;
			$shareHolderName 												= null;
		}
		
		
		
		//SHAREHOLDER 3
		if($entry['388'] > 2){
			//Non-officeholder Shareholder 3		
			$shareHolder 													= new stdClass();	
			if($entry['208'] == "Company"){
				$shareHolder->isPerson 										= false;
				$shareHolder->organisation									= $entry['266'];
				if($entry['270'] == "Yes"){
					$shareHolder->hasBusinessNumber							= true;
					$shareHolder->businessNumber							= str_replace("-","",$entry['282']);
				}
				else {
					$shareHolder->hasBusinessNumber							= false;
				}
			}
			else {
				$shareHolder->isPerson 										= true;
				$shareHolderName 											= new stdClass();
				$shareHolderName->givenName 								= $entry['211'];
				//$shareHolderName->givenName2 								= $entry[''];
				$shareHolderName->familyName 								= $entry['219'];
				$shareHolder->person 										= $shareHolderName;
			}
		
			$shareHolderAddress 											= new stdClass();
			$shareHolderAddress->addrLine2 									= (!empty($entry['477'])) ? $entry['477'] : $entry['227'];
			$shareHolderAddress->addrStreet 								= (!empty($entry['476'])) ? $entry['476'] : $entry['230'];
			$shareHolderAddress->city 										= (!empty($entry['475'])) ? $entry['475'] : $entry['233'];
			$shareHolderAddress->state 										= (!empty($entry['474'])) ? $entry['474'] : $entry['237'];
			$shareHolderAddress->postcode 									= (!empty($entry['473'])) ? $entry['473'] : $entry['341'];
			//$shareHolderAddress->countryDisplay 							= $entry[''];
			$shareHolder->address 											= $shareHolderAddress;
		
			$shareDetails 													= new stdClass();
			$shareDetails->shareClassCode 									= $entry['254'];
			$shareDetails->agreedNumber 									= $entry['258'];
			$shareDetails->amountPaid 										= $entry['313'];
			$shareDetails->totalAmountPaid 									= $shareDetails->agreedNumber * $entry['313'];
		
			if($entry['295'] == "No"){
					$shareDetails->beneficialOwner 							= true;
					$shareDetails->beneficialOwnerName						= $entry['299'];
			}
			else {
					$shareDetails->beneficialOwner 							= false;
			}
		
			$totalAmountUnpaid 												= $shareDetails->totalAmountPaid - ($shareDetails->agreedNumber * $entry['313']);
			$shareDetails->fullyPaid 										= ($totalAmountUnpaid == 0);
			$shareDetails->amountUnpaid 									= $totalAmountUnpaid / $shareDetails->agreedNumber;
			$shareDetails->totalAmountUnpaid 								= $totalAmountUnpaid;

			$shareHolding 													= new stdClass();
			$shareHolding->holding 											= $shareDetails;
			$shareHolding->members 											= array($shareHolder);

			//Add shareholding 1 to shareholdings array
			$shareHoldings[] = $shareHolding;
			$shareholding 													= null;
			$shareholder  													= null;
			$shareDetails 													= null;
			$shareHolderAddress 											= null;
			$shareHolderName 												= null;
		}
		
		
		//SHAREHOLDER 4
		if($entry['388'] > 3){
			//Non-officeholder Shareholder 4		
			$shareHolder 													= new stdClass();	
			if($entry['209'] == "Company"){
				$shareHolder->isPerson 										= false;
				$shareHolder->organisation									= $entry['267'];
				if($entry['268'] == "Yes"){
					$shareHolder->hasBusinessNumber							= true;
					$shareHolder->businessNumber							= str_replace("-","",$entry['281']);
				}
				else {
					$shareHolder->hasBusinessNumber							= false;
				}
			}
			else {
				$shareHolder->isPerson 										= true;
				$shareHolderName 											= new stdClass();
				$shareHolderName->givenName 								= $entry['215'];
				//$shareHolderName->givenName2 								= $entry[''];
				$shareHolderName->familyName 								= $entry['218'];
				$shareHolder->person 										= $shareHolderName;
			}
		
			$shareHolderAddress 											= new stdClass();
			$shareHolderAddress->addrLine2 									= ( !empty($entry['488'])) ? $entry['488'] : $entry['228'];
			$shareHolderAddress->addrStreet 								= ( !empty($entry['487'])) ? $entry['487'] : $entry['231'];
			$shareHolderAddress->city 										= ( !empty($entry['486'])) ? $entry['486'] : $entry['232'];
			$shareHolderAddress->state 										= ( !empty($entry['485'])) ? $entry['485'] : $entry['238'];
			$shareHolderAddress->postcode 									= ( !empty($entry['484'])) ? $entry['484'] : $entry['346'];
			//$shareHolderAddress->countryDisplay 							= $entry[''];
			$shareHolder->address 											= $shareHolderAddress;
		
			$shareDetails 													= new stdClass();
			$shareDetails->shareClassCode 									= $entry['255'];
			$shareDetails->agreedNumber 									= $entry['256'];
			$shareDetails->amountPaid 										= $entry['313'];
			$shareDetails->totalAmountPaid 									= $shareDetails->agreedNumber * $entry['313'];
		
			if($entry['294'] == "No"){
					$shareDetails->beneficialOwner 							= true;
					$shareDetails->beneficialOwnerName						= $entry['298'];
			}
			else {
					$shareDetails->beneficialOwner 							= false;
			}
		
			$totalAmountUnpaid 												= $shareDetails->totalAmountPaid - ($shareDetails->agreedNumber * $entry['313']);
			$shareDetails->fullyPaid 										= ($totalAmountUnpaid == 0);
			$shareDetails->amountUnpaid 									= $totalAmountUnpaid / $shareDetails->agreedNumber;
			$shareDetails->totalAmountUnpaid 								= $totalAmountUnpaid;

			$shareHolding 													= new stdClass();
			$shareHolding->holding 											= $shareDetails;
			$shareHolding->members 											= array($shareHolder);

			//Add shareholding 1 to shareholdings array
			$shareHoldings[] = $shareHolding;
			$shareholding 													= null;
			$shareholder  													= null;
			$shareDetails 													= null;
			$shareHolderAddress 											= null;
			$shareHolderName 												= null;
		}
	}	
	
	//
	
	
	
	//Applicant - Start
	$applicant 													= new stdClass();
	
	$applicantName	 											= new stdClass();
	$applicantName->givenName 									= $entry['364'];
	//$applicantName->givenName2 								= $entry[''];
	$applicantName->familyName 									= $entry['365'];
	$applicant->applicant 										= $applicantName;
	
	$applicantAddress 											= new stdClass();
	$applicantAddress->addrLine2 								= ( !empty($entry['515'])) ? $entry['515'] : $entry['369'];
	$applicantAddress->addrStreet 								= ( !empty($entry['514'])) ? $entry['514'] : $entry['370'];
	$applicantAddress->city 									= ( !empty($entry['513'])) ? $entry['513'] : $entry['371'];
	$applicantAddress->state 									= ( !empty($entry['512'])) ? $entry['512'] : $entry['372'];
	$applicantAddress->postcode 								= ( !empty($entry['511'])) ? $entry['511'] : $entry['373'];
	//$applicantAddress->countryDisplay 						= $entry[''];
			
	$applicant->address 										= $applicantAddress;
	$form201->applicant 										= $applicant;
	//Applicant - End
	
	

	
	//Add Officers to Form 201 Object
	$form201->officers 											= $officers;
	 
	//Add Shareholdings to Form 201 Object
	$form201->shareMembers 										= $shareHoldings;
	
	
	
	
	
	$client = new SoapClient( "https://www.ecompanies.com.au/RegistrationService?wsdl", array('trace' => 1));
	
	$eCompanies_Response = array();
	try
	{
		//$result = $client->getConsents($request);
		$result = $client->registerCompany($request);
		$order_id = $result->return;
		
		$client = new SoapClient( "https://www.ecompanies.com.au/RegistrationService?wsdl" );
		$addRequest = new stdClass();
		$addRequest->userName = "info@thesmsfacademy.com.au";
		$addRequest->password = "Superannuation0";
		$addRequest->orderId = $order_id;
		
		if(strlen($addRequest->orderId) > 0){
			try
			{
				$result = $client->checkOrderStatus($addRequest);
				$return = $result->return;
				$status = $return->status;
				print("Status: ".$status);
 
			} 
			catch (SoapFault $soapFault) 
			{
				echo "Fault $soapFault";
			}
		}
		else{
		echo "Invalid Request";
		}
		
		//$pdf_decoded = base64_decode ($result->return);
		//Write data back to pdf file
		//$pdf = fopen ('test.pdf','w');
		//fwrite ($pdf,$pdf_decoded);
		//close output file
		//fclose ($pdf);
		//echo 'Done';
		$eCompanies_Response['result'] = $result;
		
		//grab entry id and form id
		
		global $wpdb;
		//look up row in lead table, update asic status and update with eCompanies order number.
		$wpdb->query( $wpdb->prepare("UPDATE wp_rg_lead  SET eco_ref=".$order_id.", asic_status='Submitted to ASIC' WHERE id=".$entry['id']." AND form_id=".$entry['form_id']) );
		
		
	} 
	catch (SoapFault $soapFault) 
	{
		//echo $soapFault;
		print("<h1>The following errors were found with your application</h1>");
		print($soapFault);
		
		if (is_array($soapFault->detail->ValidationException->errors))
		{
			print("<h1>IF</h1>");
			foreach ($soapFault->detail->ValidationException->errors as $r)
			{
				print("$r->property <b>$r->message</b><br/>");
				//change periods to underscores to be consistent...
				$property = str_replace(".", "_", $r->property);
				$errors["$property"] = $r->message;
				$eCompanies_Response['errors'][] = "$r->property <b>$r->message</b><br/>";
			}
		}
		else
		{
			print("<h1>ELSE</h1>");
			print_r($soapFault,true);
			$eCompanies_Response['result'][] = var_dump($soapFault->detail->ValidationException->errors);
		}
	}
	$headers[] = "Content-type: text/html";
	$message = print_r($form201, true);
	 wp_mail('tim@automationlab.com.au', 'Company Submission', "Date: ".$entry['48']." ".print_r($entry['550'], true).'<br/>'.$message.'<br/>'.print_r($eCompanies_Response, true), $headers);
	
	return $eCompanies_Response;
	}
}

function sp_corp_post_Data($entry, $form){
	$pending_meta_value = gform_get_meta($entry["id"], "is_pending");
	if($pending_meta_value != "1"){
	
	$request = new stdClass();
	$request->userName = "info@thesmsfacademy.com.au";
	$request->password = "Superannuation0";
	//echo "Object: ".print_r($request, true);

	$form201 = new stdClass();
	$request-> form201 = $form201;
	$officers = array();
	$shareHoldings = array();
	$formerNames = array();

	//we'll make a few assumptions
	//1. This is a standard pty ltd company
	//2. It has no special purpose
	//3. Not previously reserved
	//4. No identical business names
	//5. It will be using a preferred company name

	//Stupid php substitutes periods for underscores 
	$companyDetails 											= new stdClass();
	$companyDetails->orgNameNoLegal 							= $entry['1'];
	$companyDetails->legalElements 								= strtoupper($entry['2']);
	$companyDetails->jurisdiction 								= $entry['6'];
	$companyDetails->useAcn 									= false;
	$companyDetails->companyType 								= "APTY";
	$companyDetails->companyClass 								= "LMSH";
	$companyDetails->companySubClass 							= "PSTC";
	
	if($entry['80'] == "Yes"){
		$companyDetails->bn 									= true;
		$businessName											= new stdClass();
		
	}
	else {
		$companyDetails->bn 									= false;
	}
	
	$companyDetails->reserved 									= false;
	$companyDetails->areOHAddressesResidential 					= true;
	
	//Add company details to Form 201 Object	
	$form201->companyDetails 									= $companyDetails;

	$registeredOffice = new stdClass();
	if($entry['82'] == "Yes"){
		$registeredOffice->occupyAddress 						= true;
	}
	else {
		$registeredOffice->occupyAddress 						= false;
		
		if($entry['377'] == "Yes"){
			$registeredOffice->consent							= true;
			$registeredOffice->occupierName						= $entry['14'];
		}
		else{
			$registeredOffice->consent							= false;
		}
		
	}











/*
		

VISIBLE
registeredOfficeLevel = 391
registeredOfficeStreetName = 392
registeredOfficeSuburbName = 393
registeredOfficeStateName = 394
registeredOfficePostcode = 395

HIDDEN 
Level, Floor, Unit, Office, Suite  = 141
Street Number and Name*  = 142
Suburb*  = 143
State*  = 144
Postcode* = 145

done






VISIBLE
principalPlaceBusinessLevel = 398 
principalPlaceBusinessStreetName = 399
principalPlaceBusinessSuburbName = 400
principalPlaceBusinessStateName = 401
principalPlaceBusinessPostcode = 402
HIDDEN 
Level, Floor, Unit, Office, Suite  = 146
Street Number and Name*  = 152
Suburb*  = 148
State*  = 	154
Postcode* = 155

DONE





VISIBLE
d1AddressLevel = 403
d1AddressStreetName = 404
d1AddressSuburbName = 405
d1AddressStateName = 406
d1AddressPostcode = 407
HIDDEN 
Level, Floor, Unit, Office, Suite  = 151
Street Number and Name*  = 147
Suburb*  = 153
State*  = 149
Postcode* = 150

DONE 



 VISIBLE
d2AddressLevel = 415 
d2AddressStreetName = 416 
d2AddressSuburbName = 423
d2AddressStateName = 421
d2AddressPostcode = 422
HIDDEN 
Level, Floor, Unit, Office, Suite  = 163
Street Number and Name*  = 164
Suburb*  = 179
State*  = 166
Postcode* = 167

DONE 





VISIBLE
d3AddressLevel = 431 
d3AddressStreetName =  432
d3AddressSuburbName = 433 
d3AddressStateName = 434
d3AddressPostcode =  435
HIDDEN 
Level, Floor, Unit, Office, Suite =  68
Street Number and Name* =    178
Suburb*  = 165
State*  =  180
Postcode* = 181
DONE 


VISIBLE
d4AddressLevel = 444
d4AddressStreetName = 445
d4AddressSuburbName = 446
d4AddressStateName = 447
d4AddressPostcode = 448
HIDDEN 
Level, Floor, Unit, Office, Suite  = 194
Street Number and Name*   = 195
Suburb*  = 196
State*  = 192
Postcode* = 191
 DONE 


VISIBLE
sh1AddressLevel = 460
sh1AddressStreetName = 461 
sh1AddressSuburbName = 462 
sh1AddressStateName  = 463
sh1AddressPostcode = 464
HIDDEN 
Level, Floor, Unit, Office, Suite  = 217 
Street Number and Name*  = 221 
Suburb*  = 213
State*  = 235
Postcode*  = 339  
 DONE



VISIBLE
sh2AddressLevel = 465
sh2AddressStreetName = 467
sh2AddressSuburbName = 466
sh2AddressStateName = 468
sh2AddressPostcode = 469
HIDDEN 
Level, Floor, Unit, Office, Suite  = 226
Street Number and Name*  = 229 
Suburb* = 234
State*  = 236
Postcode*  = 340 
 DONE





VISIBLE
sh3AddressLevel = 477
sh3AddressStreetName = 476
sh3AddressSuburbName = 475
sh3AddressStateName = 474
sh3AddressPostcode = 473
 HIDDEN 
Level, Floor, Unit, Office, Suite  = 227
Street Number and Name*  = 230
Suburb*  = 233
State*  = 237
Postcode* = 341 
DONE

VISIBLE
sh4AddressLevel = 488
sh4AddressStreetName = 487
sh4AddressSuburbName = 486
sh4AddressStateName = 485
sh4AddressPostcode = 484
HIDDEN 
Level, Floor, Unit, Office, Suite  = 228
Street Number and Name*  = 231
Suburb*  = 232
State*  = 238
Postcode* = 346
DONE



HIDDEN  
Level, Floor, Unit, Office, Suite  = 369
Street Number and Name*  = 370
Suburb*  = 371 
State*  = 372
Postcode* = 373
VISIBLE
applicantAddressLevel = 515
applicantAddressStreetName = 514
applicantAddressSuburbName = 513
applicantAddressStateName = 512 
applicantAddressPostcode = 511














*/
















	
	$registeredOfficeAddress 									= new stdClass();
	$registeredOfficeAddress->careOf 							= $entry['140']; 
	$registeredOfficeAddress->addrLine2 						= (!empty($entry['391'])) ? $entry['391'] : $entry['141'];
	$registeredOfficeAddress->addrStreet 						= (!empty($entry['392'])) ? $entry['392'] : $entry['142'];
	$registeredOfficeAddress->city 								= (!empty($entry['393'])) ? $entry['393'] : $entry['143'];
	$registeredOfficeAddress->state 							= (!empty($entry['394'])) ? $entry['394'] : $entry['144'];
	$registeredOfficeAddress->postcode 							= (!empty($entry['395'])) ? $entry['395'] : $entry['145'];
	$registeredOffice->registeredOffice 						= $registeredOfficeAddress;
	
	//Add registered office to Form 201 Object
	$form201->registeredOffice 									= $registeredOffice;

	//The principal place of business
	$placeOfBusiness 											= new stdClass();
	$principalAddress 											= new StdClass();
	$placeOfBusiness->principalAddress 							= $principalAddress;
	$principalAddress->careOf 									= $entry['322'];

	$principalAddress->addrLine2 								= ( !empty($entry['398'])) ? $entry['398'] : $entry['146'];
	$principalAddress->addrStreet 								= ( !empty($entry['399'])) ? $entry['399'] : $entry['152'];
	$principalAddress->city 									= ( !empty($entry['400'])) ? $entry['400'] : $entry['148'];
	$principalAddress->state 									= ( !empty($entry['401'])) ? $entry['401'] : $entry['154'];
	$principalAddress->postcode 								= ( !empty($entry['402'])) ? $entry['402'] : $entry['155'];

	//Add PPOB to Form 201 Object
	$form201->placeOfBusiness 									= $placeOfBusiness;

	//Officeholder 1 - Start
	$officer 													= new stdClass();
	if($entry['550.1'] == "Director"){
		$officer->director 										= true;
	}
	
	if($entry['550.2'] == "Secretary"){
		$officer->secretary 									= true;
	}

	$officerDetails 											= new stdClass();
	$officerName 												= new stdClass();
	$officerName->givenName 									= $entry['272'];
//	$officerName->givenName2 									= $entry[''];
	$officerName->familyName 									= $entry['275'];
	$officerDetails->officer 									= $officerName;

	if($entry['93'] == "Yes"){
		$officerDetails->hasFormerNames							= true;
		$formerName												= new stdClass();
		$formerName->givenName									= $entry['278'];
		$formerName->familyName									= $entry['279'];								
		$formerNames[] 											= $formerName;		
		$officerDetails->formerNames							= $formerNames;
		$formerNames = null;
	}
	else{
		$officerDetails->hasFormerNames							= false;
	}
	
	$officerAddress 											= new stdClass();
	$officerAddress->addrLine2 									= ( !empty($entry['403'])) ? $entry['403'] : $entry['151'];
	$officerAddress->addrStreet 								= ( !empty($entry['404'])) ? $entry['404'] : $entry['147'];
	$officerAddress->city 										= ( !empty($entry['405'])) ? $entry['405'] : $entry['153'];
	$officerAddress->state 										= ( !empty($entry['406'])) ? $entry['406'] : $entry['149'];
	$officerAddress->postcode 									= ( !empty($entry['407'])) ? $entry['407'] : $entry['150'];
	//$officerAddress->countryDisplay 							= $entry[''];
	$officerDetails->officerAddress 							= $officerAddress;

	$birthDetails 												= new stdClass();
	
	try 
	{
		$date = date( 'Y-m-d', strtotime( $entry['26'] ) );
		$birthDetails->date = $date;
			//$headers[] = "Content-type: text/html";
	 		//wp_mail('tim@automationlab.com.au', 'Date Email 1', 'Date: '.$birthDetails->date.' Entry: '.$entry['26'], $headers);
		
	} 
	catch (Exception $e) 
	{
		//ignored
		//$headers[] = "Content-type: text/html";
	 	//wp_mail('tim@automationlab.com.au', 'Date Error', print_r($e,true), $headers);
	}
	

	$birthDetails->town 										= strtoupper($entry['21']);
	$birthDetails->state 										= strtoupper($entry['559']);
	if($entry['494'] != "Yes"){
			$code =		myCodes($entry['139'], 'short');
			$birthDetails->country 								= $code;	
	}
	else{
			//$birthDetails->country 								= "Australia";
	}

	$officerDetails->birthDetails 								= $birthDetails;

	$officer->companyOfficer 									= $officerDetails;
	
	//Add Officer 1 to Officers array
	$officers[] = $officer;
	
	
	//Add Officer 1 as a Shareholder if applicable
	if($entry['92'] == "Yes"){
		//Shares
		$shareHolder 												= new stdClass();
		//we have to clone otherwise php uses a href in the request
		$shareHolder->person 										= clone $officerName;
		$shareHolder->isPerson 										= true;
		$shareHolder->address 										= clone $officerAddress;

		$shareDetails 												= new stdClass();
		$shareDetails->shareClassCode 								= $entry['302'];
		$shareDetails->agreedNumber 								= $entry['24'];
		$shareDetails->amountPaid 									= $entry['313'];
		$shareDetails->totalAmountPaid 								= $shareDetails->agreedNumber * $entry['313'];
	
		if($entry['84'] == "No"){
			$shareDetails->beneficialOwner 							= true;
			$shareDetails->beneficialOwnerName						= $entry['27'];
		}
		else {
			$shareDetails->beneficialOwner 							= false;
		}


		//over here we work out a few things
		$totalAmountUnpaid 											= $shareDetails->totalAmountPaid - ($shareDetails->agreedNumber * $entry['313']);
		$shareDetails->fullyPaid 									= ($totalAmountUnpaid == 0);
		$shareDetails->amountUnpaid 								= $totalAmountUnpaid / $shareDetails->agreedNumber;
		$shareDetails->totalAmountUnpaid 							= $totalAmountUnpaid;
		

		$shareHolding 												= new stdClass();
		$shareHolding->holding 										= $shareDetails;
		$shareHolding->members 										= array($shareHolder);
		
		

		//Add shareholding 1 to shareholdings array
		$shareHoldings[] = $shareHolding;
		$shareholding = null;
		$shareholder  = null;
	}
	
	$officerName = null;
	$officerAddress = null;
	$officer = null;
	
	
	
	if($entry['83'] > 1){
		//Officeholder 2 - Start
		$officer 													= new stdClass();
		if($entry['551.1'] == "Director"){
		$officer->director 										= true;
		}
	
		if($entry['551.2'] == "Secretary"){
			$officer->secretary 									= true;
		}
		$officerDetails 											= new stdClass();
		$officerName 												= new stdClass();
		$officerName->givenName 									= $entry['273'];
	//	$officerName->givenName2 									= $entry[''];
		$officerName->familyName 									= $entry['276'];
		$officerDetails->officer 									= $officerName;

		if($entry['96'] == "Yes"){
			$officerDetails->hasFormerNames							= true;
			$formerName												= new stdClass();
			$formerName->givenName									= $entry['277'];
			$formerName->familyName									= $entry['280'];								
			$formerNames[] 											= $formerName;		
			$officerDetails->formerNames							= $formerNames;
			$formerNames = null;
		}
		else{
			$officerDetails->hasFormerNames							= false;
		}
	
		$officerAddress 											= new stdClass();
		$officerAddress->addrLine2 									= ( !empty($entry['415'])) ? $entry['415'] : $entry['163'];
		$officerAddress->addrStreet 								= ( !empty($entry['416'])) ? $entry['416'] : $entry['164'];
		$officerAddress->city 										= ( !empty($entry['423'])) ? $entry['423'] : $entry['179'];
		$officerAddress->state 										= ( !empty($entry['421'])) ? $entry['421'] : $entry['166'];
		$officerAddress->postcode 									= ( !empty($entry['422'])) ? $entry['422'] : $entry['167'];
		//$officerAddress->countryDisplay 							= $entry[''];
		$officerDetails->officerAddress 							= $officerAddress;

		$birthDetails 												= new stdClass();
		
		
	 		
		try 
		{
			$date = date( 'Y-m-d', strtotime( $entry['38'] ) );
			$birthDetails->date = $date;
			
		} 
		catch (Exception $e) 
		{
			//ignored
			//$headers[] = "Content-type: text/html";
			//wp_mail('tim@automationlab.com.au', 'Date Error', print_r($e,true), $headers);
		}

		$birthDetails->town 										= strtoupper($entry['185']);
		$birthDetails->state 										= strtoupper($entry['560']);
		if(strlen($entry['170']) > 0){
				$code =		myCodes($entry['170'], 'short');
				$birthDetails->country 								= $code;
		}
		else{
				$birthDetails->country 								= "";
		}

		$officerDetails->birthDetails 								= $birthDetails;

		$officer->companyOfficer 									= $officerDetails;
	
		//Add Officer 2 to Officers array
		$officers[] = $officer;
		
	
		//Add Officer 2 as a Shareholder if applicable
		if($entry['303'] == "Yes"){
			//Shares
			$shareHolder 												= new stdClass();
			//we have to clone otherwise php uses a href in the request
			$shareHolder->person 										= clone $officerName;
			$shareHolder->isPerson 										= true;
			$shareHolder->address 										= clone $officerAddress;

			$shareDetails 												= new stdClass();
			$shareDetails->shareClassCode 								= $entry['98'];
			$shareDetails->agreedNumber 								= $entry['39'];
			$shareDetails->amountPaid 									= $entry['313'];
			$shareDetails->totalAmountPaid 								= $shareDetails->agreedNumber * $entry['313'];
	
			if($entry['100'] == "No"){
				$shareDetails->beneficialOwner 							= true;
				$shareDetails->beneficialOwnerName						= $entry['101'];
			}
			else {
				$shareDetails->beneficialOwner 							= false;
			}


			//over here we work out a few things
			$totalAmountUnpaid 											= $shareDetails->totalAmountPaid - ($shareDetails->agreedNumber * $entry['313']);
			$shareDetails->fullyPaid 									= ($totalAmountUnpaid == 0);
			$shareDetails->amountUnpaid 								= $totalAmountUnpaid / $shareDetails->agreedNumber;
			$shareDetails->totalAmountUnpaid 							= $totalAmountUnpaid;

			$shareHolding 												= new stdClass();
			$shareHolding->holding 										= $shareDetails;
			$shareHolding->members 										= array($shareHolder);

			//Add shareholding 2 to shareholdings array
			$shareHoldings[] = $shareHolding;
			$shareholding = null;
			$shareholder  = null;
		}
	
		$officerName = null;
		$officerAddress = null;
		$officer = null;
	}
	
	//Officeholder 3 - Start
	if($entry['83'] > 2){
		$officer 													= new stdClass();
		if($entry['552.1'] == "Director"){
		$officer->director 										= true;
		}
	
		if($entry['552.2'] == "Secretary"){
			$officer->secretary 									= true;
		}

		$officerDetails 											= new stdClass();
		$officerName 												= new stdClass();
		$officerName->givenName 									= $entry['46'];
	//	$officerName->givenName2 									= $entry[''];
		$officerName->familyName 									= $entry['171'];
		$officerDetails->officer 									= $officerName;

		if($entry['106'] == "Yes"){
			$officerDetails->hasFormerNames							= true;
			$formerName												= new stdClass();
			$formerName->givenName									= $entry['189'];
			$formerName->familyName									= $entry['173'];								
			$formerNames[] 											= $formerName;		
			$officerDetails->formerNames							= $formerNames;
			$formerNames = null;
		}
		else{
			$officerDetails->hasFormerNames							= false;
		}
		
		$officerAddress 											= new stdClass();
		$officerAddress->addrLine2 									= ( !empty($entry['431'])) ? $entry['431'] : $entry['68'];
		$officerAddress->addrStreet 								= ( !empty($entry['432'])) ? $entry['432'] : $entry['178'];
		$officerAddress->city 										= ( !empty($entry['433'])) ? $entry['433'] : $entry['165'];
		$officerAddress->state 										= ( !empty($entry['434'])) ? $entry['434'] : $entry['180'];
		$officerAddress->postcode 									= ( !empty($entry['435'])) ? $entry['435'] : $entry['181'];
		//$officerAddress->countryDisplay 							= $entry[''];
		$officerDetails->officerAddress 							= $officerAddress;

		$birthDetails 												= new stdClass();
		try 
		{
		
			//$date = date_create_from_format( 'Y-m-d', $entry['48']);
			$date = date( 'Y-m-d', strtotime( $entry['48'] ) );
			$birthDetails->date = $date;
			//if(empty($date)){
			//	$birthDetails->date = "";
			//}
			//else {
			//	$birthDetails->date = $date->getTimeStamp();
			//}


				//$headers[] = "Content-type: text/html";
				//wp_mail('tim@automationlab.com.au', 'Date Email', 'Date: '.$birthDetails->date.' Entry: '.$entry['48'], $headers);
		
		} 
		catch (Exception $e) 
		{
			//ignored
			//$headers[] = "Content-type: text/html";
			//wp_mail('tim@automationlab.com.au', 'Date Error', print_r($e,true), $headers);
		}

		$birthDetails->town 										= strtoupper($entry['441']);
		$birthDetails->state 										= strtoupper($entry['561']);
		if(strlen($entry['184']) > 0){
				$code =		myCodes($entry['184'], 'short');
				$birthDetails->country 								= $code;	
		}
		else{
				$birthDetails->country 								= "";
		}

		$officerDetails->birthDetails 								= $birthDetails;

		$officer->companyOfficer 									= $officerDetails;
	
		//Add Officer 3 to Officers array
		$officers[] = $officer;
		
		//Add Officer 3 as a Shareholder if applicable
		if($entry['304'] == "Yes"){
			//Shares
			$shareHolder 												= new stdClass();
			//we have to clone otherwise php uses a href in the request
			$shareHolder->person 										= clone $officerName;
			$shareHolder->isPerson 										= true;
			$shareHolder->address 										= clone $officerAddress;

			$shareDetails 												= new stdClass();
			$shareDetails->shareClassCode 								= $entry['108'];
			$shareDetails->agreedNumber 								= $entry['49'];
			$shareDetails->amountPaid 									= $entry['313'];
			$shareDetails->totalAmountPaid 								= $shareDetails->agreedNumber * $entry['313'];
	
			if($entry['110'] == "No"){
				$shareDetails->beneficialOwner 							= true;
				$shareDetails->beneficialOwnerName						= $entry['111'];
			}
			else {
				$shareDetails->beneficialOwner 							= false;
			}


			//over here we work out a few things
			$totalAmountUnpaid 											= $shareDetails->totalAmountPaid - ($shareDetails->agreedNumber * $entry['313']);
			$shareDetails->fullyPaid 									= ($totalAmountUnpaid == 0);
			$shareDetails->amountUnpaid 								= $totalAmountUnpaid / $shareDetails->agreedNumber;
			$shareDetails->totalAmountUnpaid 							= $totalAmountUnpaid;

			$shareHolding 												= new stdClass();
			$shareHolding->holding 										= $shareDetails;
			$shareHolding->members 										= array($shareHolder);

			//Add shareholding 3 to shareholdings array
			$shareHoldings[] = $shareHolding;
			$shareholding = null;
			$shareholder  = null;
		}
	
		$officerName = null;
		$officerAddress = null;
		$officer = null;
		
	}
	//Officeholder 4 - Start
	if($entry['83'] > 3){
		$officer 													= new stdClass();
		if($entry['553.1'] == "Director"){
		$officer->director 										= true;
		}
	
		if($entry['553.2'] == "Secretary"){
			$officer->secretary 									= true;
		}

		$officerDetails 											= new stdClass();
		$officerName 												= new stdClass();
		$officerName->givenName 									= $entry['186'];
	//	$officerName->givenName2 									= $entry[''];
		$officerName->familyName 									= $entry['187'];
		$officerDetails->officer 									= $officerName;

		if($entry['115'] == "Yes"){
			$officerDetails->hasFormerNames							= true;
			$formerName												= new stdClass();
			$formerName->givenName									= $entry['172'];
			$formerName->familyName									= $entry['190'];								
			$formerNames[] 											= $formerName;		
			$officerDetails->formerNames							= $formerNames;
			$formerNames = null;
		}
		else{
			$officerDetails->hasFormerNames							= false;
		}
		
		$officerAddress 											= new stdClass();
		$officerAddress->addrLine2 									= (!empty($entry['444'])) ? $entry['444'] : $entry['194'];
		$officerAddress->addrStreet 								= (!empty($entry['445'])) ? $entry['445'] : $entry['195'];
		$officerAddress->city 										= (!empty($entry['446'])) ? $entry['446'] : $entry['196'];
		$officerAddress->state 										= (!empty($entry['447'])) ? $entry['447'] : $entry['192'];
		$officerAddress->postcode 									= (!empty($entry['448'])) ? $entry['448'] : $entry['191'];
		//$officerAddress->countryDisplay 							= $entry[''];
		$officerDetails->officerAddress 							= $officerAddress;

		$birthDetails 												= new stdClass();
		try 
		{
			$date = date( 'Y-m-d', strtotime( $entry['59'] ) );
			$birthDetails->date = $date;
			
				//$headers[] = "Content-type: text/html";
				//wp_mail('tim@automationlab.com.au', 'Date Email', 'Date: '.$birthDetails->date.' Entry: '.$entry['59'], $headers);
		
		} 
		catch (Exception $e) 
		{
			//ignored
			//$headers[] = "Content-type: text/html";
			//wp_mail('tim@automationlab.com.au', 'Date Error', print_r($e,true), $headers);
		}

		$birthDetails->town 										= strtoupper($entry['453']);
		$birthDetails->state 										= strtoupper($entry['562']);
		if(strlen($entry['199']) > 0){
				$code =		myCodes($entry['199'], 'short');
				$birthDetails->country 								= $code;
		}
		else{
				$birthDetails->country 								= "";
		}

		$officerDetails->birthDetails 								= $birthDetails;

		$officer->companyOfficer 									= $officerDetails;
	
		//Add Officer 4 to Officers array
		$officers[] = $officer;
		
		//Add Officer 4 as a Shareholder if applicable
		if($entry['305'] == "Yes"){
			//Shares
			$shareHolder 												= new stdClass();
			//we have to clone otherwise php uses a href in the request
			$shareHolder->person 										= clone $officerName;
			$shareHolder->isPerson 										= true;
			$shareHolder->address 										= clone $officerAddress;

			$shareDetails 												= new stdClass();
			$shareDetails->shareClassCode 								= $entry['118'];
			$shareDetails->agreedNumber 								= $entry['120'];
			$shareDetails->amountPaid 									= $entry['313'];
			$shareDetails->totalAmountPaid 								= $shareDetails->agreedNumber * $entry['313'];
	
			if($entry['121'] == "No"){
				$shareDetails->beneficialOwner 							= true;
				$shareDetails->beneficialOwnerName						= $entry['122'];
			}
			else {
				$shareDetails->beneficialOwner 							= false;
			}


			//over here we work out a few things
			$totalAmountUnpaid 											= $shareDetails->totalAmountPaid - ($shareDetails->agreedNumber * $entry['313']);
			$shareDetails->fullyPaid 									= ($totalAmountUnpaid == 0);
			$shareDetails->amountUnpaid 								= $totalAmountUnpaid / $shareDetails->agreedNumber;
			$shareDetails->totalAmountUnpaid 							= $totalAmountUnpaid;

			$shareHolding 												= new stdClass();
			$shareHolding->holding 										= $shareDetails;
			$shareHolding->members 										= array($shareHolder);

			//Add shareholding 4 to shareholdings array
			$shareHoldings[] = $shareHolding;
			$shareholding = null;
			$shareholder  = null;
		}
	
		$officerName = null;
		$officerAddress = null;
		$officer = null;
	}
	
	
	//Non-officeholder Shareholders
	if($entry['387'] == "Yes"){
		//Non-officeholder Shareholder 1		
		$shareHolder 													= new stdClass();	
		if($entry['207'] == "Company"){
			$shareHolder->isPerson 										= false;
			$shareHolder->organisation									= $entry['260'];
			if($entry['271'] == "Yes"){
				$shareHolder->hasBusinessNumber							= true;
				$shareHolder->businessNumber							= str_replace("-","",$entry['284']);
			}
			else {
				$shareHolder->hasBusinessNumber							= false;
			}
		}
		else {
			$shareHolder->isPerson 										= true;
			$shareHolderName 											= new stdClass();
			$shareHolderName->givenName 								= $entry['214'];
			//$shareHolderName->givenName2 								= $entry[''];
			$shareHolderName->familyName 								= $entry['212'];
			$shareHolder->person 										= $shareHolderName;
		}
		
		$shareHolderAddress 											= new stdClass();
		$shareHolderAddress->addrLine2 									= ( !empty($entry['460'])) ? $entry['460'] : $entry['217'];
		$shareHolderAddress->addrStreet 								= ( !empty($entry['461'])) ? $entry['461'] : $entry['221'];
		$shareHolderAddress->city 										= ( !empty($entry['462'])) ? $entry['462'] : $entry['213'];
		$shareHolderAddress->state 										= ( !empty($entry['463'])) ? $entry['463'] : $entry['235'];
		$shareHolderAddress->postcode 									= ( !empty($entry['464'])) ? $entry['464'] : $entry['339'];
		//$shareHolderAddress->countryDisplay 							= $entry[''];
		$shareHolder->address 											= $shareHolderAddress;
		
		$shareDetails 													= new stdClass();
		$shareDetails->shareClassCode 									= $entry['252'];
		$shareDetails->agreedNumber 									= $entry['259'];
		$shareDetails->amountPaid 										= $entry['313'];
		$shareDetails->totalAmountPaid 									= $shareDetails->agreedNumber * $entry['313'];
		
		if($entry['293'] == "No"){
				$shareDetails->beneficialOwner 							= true;
				$shareDetails->beneficialOwnerName						= $entry['297'];
		}
		else {
				$shareDetails->beneficialOwner 							= false;
		}
		
		$totalAmountUnpaid 												= $shareDetails->totalAmountPaid - ($shareDetails->agreedNumber * $entry['313']);
		$shareDetails->fullyPaid 										= ($totalAmountUnpaid == 0);
		$shareDetails->amountUnpaid 									= $totalAmountUnpaid / $shareDetails->agreedNumber;
		$shareDetails->totalAmountUnpaid 								= $totalAmountUnpaid;

		$shareHolding 													= new stdClass();
		$shareHolding->holding 											= $shareDetails;
		$shareHolding->members 											= array($shareHolder);

		//Add shareholding 1 to shareholdings array
		$shareHoldings[] = $shareHolding;
		$shareholding 													= null;
		$shareholder  													= null;
		$shareDetails 													= null;
		$shareHolderAddress 											= null;
		$shareHolderName 												= null;
		
		
		
		
		
		
		//SHAREHOLDER 2
		if($entry['388'] > 1){
			//Non-officeholder Shareholder 2		
			$shareHolder 													= new stdClass();	
			if($entry['210'] == "Company"){
				$shareHolder->isPerson 										= false;
				$shareHolder->organisation									= $entry['265'];
				if($entry['269'] == "Yes"){
					$shareHolder->hasBusinessNumber							= true;
					$shareHolder->businessNumber							= str_replace("-","",$entry['283']);
				}
				else {
					$shareHolder->hasBusinessNumber							= false;
				}
			}
			else {
				$shareHolder->isPerson 										= true;
				$shareHolderName 											= new stdClass();
				$shareHolderName->givenName 								= $entry['216'];
				//$shareHolderName->givenName2 								= $entry[''];
				$shareHolderName->familyName 								= $entry['220'];
				$shareHolder->person 										= $shareHolderName;
			}
		
			$shareHolderAddress 											= new stdClass();
			$shareHolderAddress->addrLine2 									= ( !empty($entry['465'])) ? $entry['465'] : $entry['226'];
			$shareHolderAddress->addrStreet 								= ( !empty($entry['467'])) ? $entry['467'] : $entry['229'];
			$shareHolderAddress->city 										= ( !empty($entry['466'])) ? $entry['466'] : $entry['234'];
			$shareHolderAddress->state 										= ( !empty($entry['468'])) ? $entry['468'] : $entry['236'];
			$shareHolderAddress->postcode 									= ( !empty($entry['469'])) ? $entry['469'] : $entry['340'];
			//$shareHolderAddress->countryDisplay 							= $entry[''];
			$shareHolder->address 											= $shareHolderAddress;
		
			$shareDetails 													= new stdClass();
			$shareDetails->shareClassCode 									= $entry['253'];
			$shareDetails->agreedNumber 									= $entry['257'];
			$shareDetails->amountPaid 										= $entry['313'];
			$shareDetails->totalAmountPaid 									= $shareDetails->agreedNumber * $entry['313'];
		
			if($entry['296'] == "No"){
					$shareDetails->beneficialOwner 							= true;
					$shareDetails->beneficialOwnerName						= $entry['300'];
			}
			else {
					$shareDetails->beneficialOwner 							= false;
			}
		
			$totalAmountUnpaid 												= $shareDetails->totalAmountPaid - ($shareDetails->agreedNumber * $entry['313']);
			$shareDetails->fullyPaid 										= ($totalAmountUnpaid == 0);
			$shareDetails->amountUnpaid 									= $totalAmountUnpaid / $shareDetails->agreedNumber;
			$shareDetails->totalAmountUnpaid 								= $totalAmountUnpaid;

			$shareHolding 													= new stdClass();
			$shareHolding->holding 											= $shareDetails;
			$shareHolding->members 											= array($shareHolder);

			//Add shareholding 1 to shareholdings array
			$shareHoldings[] = $shareHolding;
			$shareholding 													= null;
			$shareholder  													= null;
			$shareDetails 													= null;
			$shareHolderAddress 											= null;
			$shareHolderName 												= null;
		}
		
		
		
		//SHAREHOLDER 3
		if($entry['388'] > 2){
			//Non-officeholder Shareholder 3		
			$shareHolder 													= new stdClass();	
			if($entry['208'] == "Company"){
				$shareHolder->isPerson 										= false;
				$shareHolder->organisation									= $entry['266'];
				if($entry['270'] == "Yes"){
					$shareHolder->hasBusinessNumber							= true;
					$shareHolder->businessNumber							= str_replace("-","",$entry['282']);
				}
				else {
					$shareHolder->hasBusinessNumber							= false;
				}
			}
			else {
				$shareHolder->isPerson 										= true;
				$shareHolderName 											= new stdClass();
				$shareHolderName->givenName 								= $entry['211'];
				//$shareHolderName->givenName2 								= $entry[''];
				$shareHolderName->familyName 								= $entry['219'];
				$shareHolder->person 										= $shareHolderName;
			}
		
			$shareHolderAddress 											= new stdClass();
			$shareHolderAddress->addrLine2 									= ( !empty($entry['477'])) ? $entry['477'] : $entry['227'];
			$shareHolderAddress->addrStreet 								= ( !empty($entry['476'])) ? $entry['476'] : $entry['230'];
			$shareHolderAddress->city 										= ( !empty($entry['475'])) ? $entry['475'] : $entry['233'];
			$shareHolderAddress->state 										= ( !empty($entry['474'])) ? $entry['474'] : $entry['237'];
			$shareHolderAddress->postcode 									= ( !empty($entry['473'])) ? $entry['473'] : $entry['341'];
			//$shareHolderAddress->countryDisplay 							= $entry[''];
			$shareHolder->address 											= $shareHolderAddress;
		
			$shareDetails 													= new stdClass();
			$shareDetails->shareClassCode 									= $entry['254'];
			$shareDetails->agreedNumber 									= $entry['258'];
			$shareDetails->amountPaid 										= $entry['313'];
			$shareDetails->totalAmountPaid 									= $shareDetails->agreedNumber * $entry['313'];
		
			if($entry['295'] == "No"){
					$shareDetails->beneficialOwner 							= true;
					$shareDetails->beneficialOwnerName						= $entry['299'];
			}
			else {
					$shareDetails->beneficialOwner 							= false;
			}
		
			$totalAmountUnpaid 												= $shareDetails->totalAmountPaid - ($shareDetails->agreedNumber * $entry['313']);
			$shareDetails->fullyPaid 										= ($totalAmountUnpaid == 0);
			$shareDetails->amountUnpaid 									= $totalAmountUnpaid / $shareDetails->agreedNumber;
			$shareDetails->totalAmountUnpaid 								= $totalAmountUnpaid;

			$shareHolding 													= new stdClass();
			$shareHolding->holding 											= $shareDetails;
			$shareHolding->members 											= array($shareHolder);

			//Add shareholding 1 to shareholdings array
			$shareHoldings[] = $shareHolding;
			$shareholding 													= null;
			$shareholder  													= null;
			$shareDetails 													= null;
			$shareHolderAddress 											= null;
			$shareHolderName 												= null;
		}
		
		
		//SHAREHOLDER 4
		if($entry['388'] > 3){
			//Non-officeholder Shareholder 4		
			$shareHolder 													= new stdClass();	
			if($entry['209'] == "Company"){
				$shareHolder->isPerson 										= false;
				$shareHolder->organisation									= $entry['267'];
				if($entry['268'] == "Yes"){
					$shareHolder->hasBusinessNumber							= true;
					$shareHolder->businessNumber							= str_replace("-","",$entry['281']);
				}
				else {
					$shareHolder->hasBusinessNumber							= false;
				}
			}
			else {
				$shareHolder->isPerson 										= true;
				$shareHolderName 											= new stdClass();
				$shareHolderName->givenName 								= $entry['215'];
				//$shareHolderName->givenName2 								= $entry[''];
				$shareHolderName->familyName 								= $entry['218'];
				$shareHolder->person 										= $shareHolderName;
			}
		
			$shareHolderAddress 											= new stdClass();
			$shareHolderAddress->addrLine2 									= ( !empty($entry['488'])) ? $entry['488'] : $entry['228'];
			$shareHolderAddress->addrStreet 								= ( !empty($entry['487'])) ? $entry['487'] : $entry['231'];
			$shareHolderAddress->city 										= ( !empty($entry['486'])) ? $entry['486'] : $entry['232'];
			$shareHolderAddress->state 										= ( !empty($entry['485'])) ? $entry['485'] : $entry['238'];
			$shareHolderAddress->postcode 									= ( !empty($entry['484'])) ? $entry['484'] : $entry['346'];
			//$shareHolderAddress->countryDisplay 							= $entry[''];
			$shareHolder->address 											= $shareHolderAddress;
		
			$shareDetails 													= new stdClass();
			$shareDetails->shareClassCode 									= $entry['255'];
			$shareDetails->agreedNumber 									= $entry['256'];
			$shareDetails->amountPaid 										= $entry['313'];
			$shareDetails->totalAmountPaid 									= $shareDetails->agreedNumber * $entry['313'];
		
			if($entry['294'] == "No"){
					$shareDetails->beneficialOwner 							= true;
					$shareDetails->beneficialOwnerName						= $entry['298'];
			}
			else {
					$shareDetails->beneficialOwner 							= false;
			}
		
			$totalAmountUnpaid 												= $shareDetails->totalAmountPaid - ($shareDetails->agreedNumber * $entry['313']);
			$shareDetails->fullyPaid 										= ($totalAmountUnpaid == 0);
			$shareDetails->amountUnpaid 									= $totalAmountUnpaid / $shareDetails->agreedNumber;
			$shareDetails->totalAmountUnpaid 								= $totalAmountUnpaid;

			$shareHolding 													= new stdClass();
			$shareHolding->holding 											= $shareDetails;
			$shareHolding->members 											= array($shareHolder);

			//Add shareholding 1 to shareholdings array
			$shareHoldings[] = $shareHolding;
			$shareholding 													= null;
			$shareholder  													= null;
			$shareDetails 													= null;
			$shareHolderAddress 											= null;
			$shareHolderName 												= null;
		}
	}	
	
	//
	
	
	
	//Applicant - Start
	$applicant 													= new stdClass();
	
	$applicantName	 											= new stdClass();
	$applicantName->givenName 									= $entry['364'];
	//$applicantName->givenName2 								= $entry[''];
	$applicantName->familyName 									= $entry['365'];
	$applicant->applicant 										= $applicantName;
	
	$applicantAddress 											= new stdClass();
	$applicantAddress->addrLine2 								= ( !empty($entry['515'])) ? $entry['515'] : $entry['369'];
	$applicantAddress->addrStreet 								= ( !empty($entry['514'])) ? $entry['514'] : $entry['370'];
	$applicantAddress->city 									= ( !empty($entry['513'])) ? $entry['513'] : $entry['371'];
	$applicantAddress->state 									= ( !empty($entry['512'])) ? $entry['512'] : $entry['372'];
	$applicantAddress->postcode 								= ( !empty($entry['511'])) ? $entry['511'] : $entry['373'];
	//$applicantAddress->countryDisplay 						= $entry[''];
			
	$applicant->address 										= $applicantAddress;
	$form201->applicant 										= $applicant;
	//Applicant - End
	
	

	
	//Add Officers to Form 201 Object
	$form201->officers 											= $officers;
	 
	//Add Shareholdings to Form 201 Object
	$form201->shareMembers 										= $shareHoldings;
	
	
	
	
	
	$client = new SoapClient( "https://www.ecompanies.com.au/RegistrationService?wsdl", array('trace' => 1));
	
	$eCompanies_Response = array();
	try
	{
		//$result = $client->getConsents($request);
		$result = $client->registerCompany($request);
		$order_id = $result->return;
		
		$client = new SoapClient( "https://www.ecompanies.com.au/RegistrationService?wsdl" );
		$addRequest = new stdClass();
		$addRequest->userName = "info@thesmsfacademy.com.au";
		$addRequest->password = "Superannuation0";
		$addRequest->orderId = $order_id;
		
		if(strlen($addRequest->orderId) > 0){
			try
			{
				$result = $client->checkOrderStatus($addRequest);
				$return = $result->return;
				$status = $return->status;
				print("Status: ".$status);
 
			} 
			catch (SoapFault $soapFault) 
			{
				echo "Fault $soapFault";
			}
		}
		else{
		echo "Invalid Request";
		}
		
		//$pdf_decoded = base64_decode ($result->return);
		//Write data back to pdf file
		//$pdf = fopen ('test.pdf','w');
		//fwrite ($pdf,$pdf_decoded);
		//close output file
		//fclose ($pdf);
		//echo 'Done';
		$eCompanies_Response['result'] = $result;
		
		//grab entry id and form id
		
		global $wpdb;
		//look up row in lead table, update asic status and update with eCompanies order number.
		$wpdb->query( $wpdb->prepare("UPDATE wp_rg_lead  SET eco_ref=".$order_id.", asic_status='Submitted to ASIC' WHERE id=".$entry['id']." AND form_id=".$entry['form_id']) );
		
		
	} 
	catch (SoapFault $soapFault) 
	{
		//echo $soapFault;
		print("<h1>The following errors were found with your application</h1>");
		print($soapFault);
		
		if (is_array($soapFault->detail->ValidationException->errors))
		{
			print("<h1>IF</h1>");
			foreach ($soapFault->detail->ValidationException->errors as $r)
			{
				print("$r->property <b>$r->message</b><br/>");
				//change periods to underscores to be consistent...
				$property = str_replace(".", "_", $r->property);
				$errors["$property"] = $r->message;
				$eCompanies_Response['errors'][] = "$r->property <b>$r->message</b><br/>";
			}
		}
		else
		{
			print("<h1>ELSE</h1>");
			print_r($soapFault,true);
			$eCompanies_Response['result'][] = var_dump($soapFault->detail->ValidationException->errors);
		}
	}
	$headers[] = "Content-type: text/html";
	$message = print_r($form201, true);
	 wp_mail('tim@automationlab.com.au', 'Company Submission', "Date: ".$entry['48']." ".print_r($entry['550'], true).'<br/>'.$message.'<br/>'.print_r($eCompanies_Response, true), $headers);
	
	return $eCompanies_Response;
	}
}
?>