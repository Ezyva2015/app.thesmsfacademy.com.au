<?php

//////////////////////////////////////////////////////////
//														//
//														//
//														//
//			  NSF & Company Registration. 				//
//														//
//														//
//														//
//////////////////////////////////////////////////////////
function corp_post_Data($item, $order_id, $deedVersion, $constitutionVersion, $billingArray, $billingName, $billingCompany, $billing_phone, $product_id, $adviserEmail, $userID, $orderDate) {
	
		$yourRef 		= $item['item_meta']['yourRef'][0];
		
		// $fundAddress = array (
			// 'careOf' => $item['item_meta']['fundAddressCareOf'][0],
			// 'levelName' => $item['item_meta']['fundAddressLevel'][0],
			// 'streetName' => $item['item_meta']['fundAddressStreet'][0],
			// 'suburbName' => $item['item_meta']['fundAddressSuburb'][0],
			// 'stateName' => $item['item_meta']['fundAddressState'][0],
			// 'postcode' => $item['item_meta']['fundAddressPostcode'][0]
			// );
		
		//Postall address will come from Jigo-shop once the form submission is hooked up to run from that instead.
		$fundPostalAddress = array(
			'careOf' => NULL,
			'levelName' => NULL,
			'streetName' => NULL,
			'suburbName' => NULL,
			'stateName' => NULL,
			'postcode' => NULL
		);
		
		$trusteeMeetingAddress = array(
			'careOf' => NULL,
			'levelName' => NULL,
			'streetName' => NULL,
			'suburbName' => NULL,
			'stateName' => NULL,
			'postcode' => NULL
		);
		
		
		$billingAddresArray = array (
		
			'careOf' => NULL,
			'levelName' => $billingArray[0],
			'streetName' => $billingArray[1],
			'suburbName' => $billingArray[2],
			'stateName' => $billingArray[3],
			'postcode' => $billingArray[4]
		
		);
		
		
		
		$companyPrincipalPlaceBusiness = array();
		
		$companyId = NULL;
		
		
		
		$chairmanSwitch = $item['item_meta']['chairman'][0];
		
		$t = $item['item_meta']['numOfficeholders'][0];
		
		if ($t == 1) {
		$chairmanSwitch = "Director 1";
		}
				// $to = 'tim@justsuper.com.au';
				 // $subject = 'Chairman';
				 // $message = 'Chairman Switch: '.print_r($chairmanSwitch, true).' Number of members: '.$t;
				 // wp_mail( $to, $subject, $message);
		
		
		switch ($chairmanSwitch) {
		case "Director 1":
			$isDirectorOneChairman = 1;
			$isDirectorTwoChairman = 0;
			$isDirectorThreeChairman = 0;
			$isDirectorFourChairman = 0;
			break;
			
		case "Director 2":
			$isDirectorOneChairman = 0;
			$isDirectorTwoChairman = 1;
			$isDirectorThreeChairman = 0;
			$isDirectorFourChairman = 0;
			break;
		
		case "Director 3":
			$isDirectorOneChairman = 0;
			$isDirectorTwoChairman = 0;
			$isDirectorThreeChairman = 1;
			$isDirectorFourChairman = 0;
			break;
			
		case "Director 4":
			$isDirectorOneChairman = 0;
			$isDirectorTwoChairman = 0;
			$isDirectorThreeChairman = 0;
			$isDirectorFourChairman = 1;
			break;
			
		default:
			//$chairmanName = NULL;
			$isDirectorOneChairman = 0;
			$isDirectorTwoChairman = 0;
			$isDirectorThreeChairman = 0;
			$isDirectorFourChairman = 0;
		}
		
		
		//publicOfficer
		$publicOfficerSwitch = $item['item_meta']['publicOfficer'][0];
		if ($t == 1) {
			$publicOfficerSwitch = "Director 1";
		}
				// $to = 'tim@justsuper.com.au';
				 // $subject = 'Chairman';
				 // $message = 'Chairman Switch: '.print_r($chairmanSwitch, true).' Number of members: '.$t;
				 // wp_mail( $to, $subject, $message);
		
		
		switch ($publicOfficerSwitch) {
		case "Director 1":
				$isDirectorOnePublicOfficer = 1;
				$isDirectorTwoPublicOfficer = 0;
				$isDirectorThreePublicOfficer = 0;
				$isDirectorFourPublicOfficer = 0;
				break;
			
		case "Director 2":
				$isDirectorOnePublicOfficer = 0;
				$isDirectorTwoPublicOfficer = 1;
				$isDirectorThreePublicOfficer = 0;
				$isDirectorFourPublicOfficer = 0;
				break;
		
		case "Director 3":
				$isDirectorOnePublicOfficer = 0;
				$isDirectorTwoPublicOfficer = 0;
				$isDirectorThreePublicOfficer = 1;
				$isDirectorFourPublicOfficer = 0;
				break;
			
		case "Director 4":
				$isDirectorOnePublicOfficer = 0;
				$isDirectorTwoPublicOfficer = 0;
				$isDirectorThreePublicOfficer = 0;
				$isDirectorFourPublicOfficer = 1;
			break;
			
		default:
				$isDirectorOnePublicOfficer = 0;
				$isDirectorTwoPublicOfficer = 0;
				$isDirectorThreePublicOfficer = 0;
				$isDirectorFourPublicOfficer = 0;
		}
		
		
		//Corporate Registered Office
		$companyRegisteredOffice = array(			
				'careOf' => $item['item_meta']['registeredOfficeCareOf'][0],
				'levelName' => $item['item_meta']['registeredOfficeLevel'][0],
				'streetName' => $item['item_meta']['registeredOfficeStreetName'][0], 
				'suburbName' => $item['item_meta']['registeredOfficeSuburbName'][0],
				'stateName' => $item['item_meta']['registeredOfficeStateName'][0],
				'postcode' => $item['item_meta']['registeredOfficePostcode'][0]
			
			);
		
		//Corporate Principal Place of Business
		$ppobsw = $item['item_meta']['principalPlaceBusinessSameAsRO'][0];
		switch ($ppobsw) {
		case "Same as Registered Office Address":
			$ppobAddress = $companyRegisteredOffice;
			break;

		case "Other Address":
			$ppobAddress = array(
			'careOf' => $item['item_meta']['principalPlaceBusinessCareOf'][0],
			'levelName' => $item['item_meta']['principalPlaceBusinessLevel'][0],
			'streetName' => $item['item_meta']['principalPlaceBusinessStreetName'][0],
			'suburbName' => $item['item_meta']['principalPlaceBusinessSuburbName'][0],
			'stateName' => $item['item_meta']['principalPlaceBusinessStateName'][0],
			'postcode' => $item['item_meta']['principalPlaceBusinessPostcode'][0]
			);
			break;
		default:
			$ppobAddress = NULL;
		}
		
		
		//D1 Address
		$d1sw = $item['item_meta']['d1AddressSameAsRO'][0];
		switch ($d1sw) {
		case "Same as Registered Office Address":
			$d1Address = $companyRegisteredOffice;
			break;
		
		case "Same as Principal Place Of Business Address":
			$d1Address = $ppobAddress;
			break;

		case "Other Address":
			$d1Address = array(
			'careOf' => $item['item_meta']['d1AddressCareOf'][0],
			'levelName' => $item['item_meta']['d1AddressLevel'][0],
			'streetName' => $item['item_meta']['d1AddressStreetName'][0],
			'suburbName' => $item['item_meta']['d1SuburbName'][0],
			'stateName' => $item['item_meta']['d1AddressStateName'][0],
			'postcode' => $item['item_meta']['d1AddressPostcode'][0]
			);
			break;
		default:
			$d1Address = NULL;
		}
		
		//D2 Address
		$d2sw = $item['item_meta']['d2AddressSameAsRO'][0];
		switch ($d2sw) {
		case "Same as Registered Office Address":
			$d2Address = $companyRegisteredOffice;
			break;

		case "Same as Principal Place Of Business Address":
			$d2Address = $ppobAddress;
			break;
			
		case "Other Address":
			$d2Address = array(
			'careOf' => $item['item_meta']['d2AddressCareOf'][0],
			'levelName' => $item['item_meta']['d2AddressLevel'][0],
			'streetName' => $item['item_meta']['d2AddressStreetName'][0],
			'suburbName' => $item['item_meta']['d2SuburbName'][0],
			'stateName' => $item['item_meta']['d2AddressStateName'][0],
			'postcode' => $item['item_meta']['d2AddressPostcode'][0]
			);
			break;
		default:
			$d2Address = NULL;
		}
		
		//D3 Address
		$d3sw = $item['item_meta']['d3AddressSameAsRO'][0];
		switch ($d3sw) {
		case "Same as Registered Office Address":
			$d3Address = $companyRegisteredOffice;
			break;
		
		case "Same as Principal Place Of Business Address":
			$d3Address = $ppobAddress;
			break;

		case "Other Address":
			$d3Address = array(
			'careOf' => $item['item_meta']['d3AddressCareOf'][0],
			'levelName' => $item['item_meta']['d3AddressLevel'][0],
			'streetName' => $item['item_meta']['d3AddressStreetName'][0],
			'suburbName' => $item['item_meta']['d3SuburbName'][0],
			'stateName' => $item['item_meta']['d3AddressStateName'][0],
			'postcode' => $item['item_meta']['d3AddressPostcode'][0]
			);
			break;
		default:
			$d3Address = NULL;
		}

		//D4 Address
		$d4sw = $item['item_meta']['d4AddressSameAsRO'][0];
		switch ($d4sw) {
		case "Same as Registered Office Address":
			$d4Address = $companyRegisteredOffice;
			break;
		
		case "Same as Principal Place Of Business Address":
			$d4Address = $ppobAddress;
			break;
		
		case "Other Address":
			$d4Address = array(
			'careOf' => $item['item_meta']['d4AddressCareOf'][0],
			'levelName' => $item['item_meta']['d4AddressLevel'][0],
			'streetName' => $item['item_meta']['d4AddressStreetName'][0],
			'suburbName' => $item['item_meta']['d4SuburbName'][0],
			'stateName' => $item['item_meta']['d4AddressStateName'][0],
			'postcode' => $item['item_meta']['d4AddressPostcode'][0]
			);
			break;
		default:
			$d4Address = NULL;
		}
		
		//SH1 Address
		$sh1sw = $item['item_meta']['sh1AddressSameAsRO'][0];
		switch ($sh1sw) {
		case "Same as Registered Office Address":
			$sh1Address = $companyRegisteredOffice;
			break;
			
		case "Same as Principal Place Of Business Address":
			$sh1Address = $ppobAddress;
			break;
		
		case "Other Address":
			$sh1Address = array(
			'careOf' => $item['item_meta']['sh1AddressCareOf'][0],
			'levelName' => $item['item_meta']['sh1AddressLevel'][0],
			'streetName' => $item['item_meta']['sh1AddressStreetName'][0],
			'suburbName' => $item['item_meta']['sh1SuburbName'][0],
			'stateName' => $item['item_meta']['sh1AddressStateName'][0],
			'postcode' => $item['item_meta']['sh1AddressPostcode'][0]
			);
			break;
		default:
			$sh1Address = NULL;
		}
		
		//SH2 Address
		$sh2sw = $item['item_meta']['sh2AddressSameAsRO'][0];
		switch ($sh2sw) {
		case "Same as Registered Office Address":
			$sh2Address = $companyRegisteredOffice;
			break;
		
		case "Same as Principal Place Of Business Address":
			$sh2Address = $ppobAddress;
			break;
			
		case "Other Address":
			$sh2Address = array(
			'careOf' => $item['item_meta']['sh2AddressCareOf'][0],
			'levelName' => $item['item_meta']['sh2AddressLevel'][0],
			'streetName' => $item['item_meta']['sh2AddressStreetName'][0],
			'suburbName' => $item['item_meta']['sh2SuburbName'][0],
			'stateName' => $item['item_meta']['sh2AddressStateName'][0],
			'postcode' => $item['item_meta']['sh2AddressPostcode'][0]
			);
			break;
		default:
			$sh2Address = NULL;
		}
		
		//SH3 Address
		$sh3sw = $item['item_meta']['sh3AddressSameAsRO'][0];
		switch ($sh3sw) {
		case "Same as Registered Office Address":
			$sh3Address = $companyRegisteredOffice;
			break;

		case "Same as Principal Place Of Business Address":
			$sh3Address = $ppobAddress;
			break;
		
		case "Other Address":
			$sh3Address = array(
			'careOf' => $item['item_meta']['sh3AddressCareOf'][0],
			'levelName' => $item['item_meta']['sh3AddressLevel'][0],
			'streetName' => $item['item_meta']['sh3AddressStreetName'][0],
			'suburbName' => $item['item_meta']['sh3SuburbName'][0],
			'stateName' => $item['item_meta']['sh3AddressStateName'][0],
			'postcode' => $item['item_meta']['sh3AddressPostcode'][0]
			);
			break;
		default:
			$sh3Address = NULL;
		}
		
		//SH4 Address
		$sh4sw = $item['item_meta']['sh4AddressSameAsRO'][0];
		switch ($sh4sw) {
		case "Same as Registered Office Address":
			$sh4Address = $companyRegisteredOffice;
			break;
		
		case "Same as Principal Place Of Business Address":
			$sh4Address = $ppobAddress;
			break;
		
		case "Other Address":
			$sh4Address = array(
			'careOf' => $item['item_meta']['sh4AddressCareOf'][0],
			'levelName' => $item['item_meta']['sh4AddressLevel'][0],
			'streetName' => $item['item_meta']['sh4AddressStreetName'][0],
			'suburbName' => $item['item_meta']['sh4SuburbName'][0],
			'stateName' => $item['item_meta']['sh4AddressStateName'][0],
			'postcode' => $item['item_meta']['sh4AddressPostcode'][0]
			);
			break;
		default:
			$sh4Address = NULL;
		}
		
		//Applicant Address
		$appsw = $item['item_meta']['applicantAddressSameAsRO'][0];
		switch ($appsw) {
		case "Same as Registered Office":
			$applicantAddress = $companyRegisteredOffice;
			break;
		
		case "Same as Principal Place Of Business Address":
			$applicantAddress = $ppobAddress;
			break;
				
		case "Other Address":
			$applicantAddress = array(
			'careOf' => $item['item_meta']['applicantAddressCareOf'][0],
			'levelName' => $item['item_meta']['applicantAddressLevel'][0],
			'streetName' => $item['item_meta']['applicantAddressStreetName'][0],
			'suburbName' => $item['item_meta']['applicantSuburbName'][0],
			'stateName' => $item['item_meta']['applicantAddressStateName'][0],
			'postcode' => $item['item_meta']['applicantAddressPostcode'][0]
			);
			break;
		default:
			$applicantAddress = NULL;
		}
		
		
		
		//Dates of birth
		if(!is_Null($item['item_meta']['d1Dob'][0])) {
			$d1dob = $item['item_meta']['d1Dob'][0];
		}
		else {
			$d1dob = NULL;
		}
		
		if(!is_Null($item['item_meta']['d2Dob'][0])) {
			$d2dob = $item['item_meta']['d2Dob'][0];
		}
		else {
			$d2dob = NULL;
		}
		
		if(!is_Null($item['item_meta']['d3Dob'][0])) {
			$d3dob = $item['item_meta']['d3Dob'][0];
		}
		else {
			$d3dob = NULL;
		}
		
		if(!is_Null($item['item_meta']['d4Dob'][0])) {
			$d4dob = $item['item_meta']['d4Dob'][0];
		}
		else {
			$d4dob = NULL;
		}
		
		//D1 Roles
		$d1RolesSw = $item['item_meta']['d1Roles'][0];
		switch ($d1RolesSw) {
		case "Director":
			$d1isSecretary = 0;
			$d1isDirector = 1;
			break;

		case "Secretary":
			$d1isSecretary = 1;
			$d1isDirector = 0;
			break;

		case "Director/Secretary":
			$d1isSecretary = 1;
			$d1isDirector = 1;
			break;			
		
		default:
			$d1isSecretary = 0;
			$d1isDirector = 0;
		}
		
		//D2 Roles
		$d2RolesSw = $item['item_meta']['d2Roles'][0];
		switch ($d2RolesSw) {
		case "Director":
			$d2isSecretary = 0;
			$d2isDirector = 1;
			break;

		case "Secretary":
			$d2isSecretary = 1;
			$d2isDirector = 0;
			break;

		case "Director/Secretary":
			$d2isSecretary = 1;
			$d2isDirector = 1;
			break;			
		
		default:
			$d2isSecretary = 0;
			$d2isDirector = 0;
		}
		
		//D3 Roles
		$d3RolesSw = $item['item_meta']['d3Roles'][0];
		switch ($d3RolesSw) {
		case "Director":
			$d3isSecretary = 0;
			$d3isDirector = 1;
			break;

		case "Secretary":
			$d3isSecretary = 1;
			$d3isDirector = 0;
			break;

		case "Director/Secretary":
			$d3isSecretary = 1;
			$d3isDirector = 1;
			break;			
		
		default:
			$d3isSecretary = 0;
			$d3isDirector = 0;
		}
		
		//D4 Roles
		$d4RolesSw = $item['item_meta']['d4Roles'][0];
		switch ($d4RolesSw) {
		case "Director":
			$d4isSecretary = 0;
			$d4isDirector = 1;
			break;

		case "Secretary":
			$d4isSecretary = 1;
			$d4isDirector = 0;
			break;

		case "Director/Secretary":
			$d4isSecretary = 1;
			$d4isDirector = 1;
			break;			
		
		default:
			$d4isSecretary = 0;
			$d4isDirector = 0;
		}
		
		//D1 Shareholder?
		if($item['item_meta']['d1IsShareholder'][0] == "Yes"){
			$d1isShareholder = 1;
		}
		else {
			$d1isShareholder = 0;
		}
		
		//D2 Shareholder?
		if($item['item_meta']['d2IsShareholder'][0] == "Yes"){
			$d2isShareholder = 1;
		}
		else {
			$d2isShareholder = 0;
		}
		
		//D3 Shareholder?
		if($item['item_meta']['d3IsShareholder'][0] == "Yes"){
			$d3isShareholder = 1;
		}
		else {
			$d3isShareholder = 0;
		}
		
		//D4 Shareholder?
		if($item['item_meta']['d4IsShareholder'][0] == "Yes"){
			$d4isShareholder = 1;
		}
		else {
			$d4isShareholder = 0;
		}
		
		
		
		//Director 1 Details
		$d1TownOfBirth = $item['item_meta']['d1TownOfBirth'][0];
		$d1StateOfBirth = $item['item_meta']['d1StateOfBirth'][0];
		$d1CountryOfBirth = $item['item_meta']['d1CountryOfBirth'][0];
		
		
		If ($d1StateOfBirth == "Other - International") {
			$d1StateOfBirth = NULL;
		}
		else {
			$d1CountryOfBirth = "Australia";
		}
		
		$d1ChangedName = $item['item_meta']['d1ChangedName'][0];
		
		if ($d1ChangedName == "Yes"){
			$d1FormerGivenNames = $item['item_meta']['d1FormerGivenNames'][0];
			$d1FormerFamilyName = $item['item_meta']['d1FormerFamilyName'][0];
			$d1HasChangedName = 1;
		}
		else {
			$d1FormerGivenNames = Null;
			$d1FormerFamilyName = Null;
			$d1HasChangedName = 0;
		
		}
		
		$d1HeldOnTrust = $item['item_meta']['d1SharesHeldOnTrust'][0];
		
		if ($d1HeldOnTrust == "Yes"){
			$d1BeneficiallyOwned = 0;
			$d1HeldFor = $item['item_meta']['d1SharesOnTrustFor'][0];
		}
		else {
			$d1BeneficiallyOwned = 1;
			$d1HeldFor = NULL;
		
		}
		
		
		$d1details = array(	
			'memberNamePrefix' => $item['item_meta']['d1NamePrefix'][0],
			'memberGivenNames' => $item['item_meta']['d1GivenNames'][0],
			'memberFamilyName' => $item['item_meta']['d1FamilyName'][0],
			'memberFormerGivenNames' => $d1FormerGivenNames,
			'memberFormerFamilyName' => $d1FormerFamilyName,
			'memberChangedName' => $d1HasChangedName,
			'memberTFN' => Null,
			'memberDOB' => $d1dob,
			'memberGender' => $item['item_meta']['d1Gender'][0],
			'memberTownOfBirth' => $d1TownOfBirth,
			'memberStateOfBirth' => $d1StateOfBirth,
			'memberCountryOfBirth' => $d1CountryOfBirth,
			'memberOccupation' => NULL,
			'isCompany' => NULL,
			'companyname' => NULL,
			'hasacn' => NULL,
			'acn' => NULL,
			'companyrep1' => NULL,
			'companyrep2' => NULL,
			'companyrep3' => NULL,
			'companyrep4' => NULL,
			'isDirector' => $d1isDirector,
			'isTrustee' => 0,
			'isChairman' => $isDirectorOneChairman,
			'isMember' => 0,
			'isSecretary' => $d1isSecretary,
			'isPublicOfficer' => $isDirectorOnePublicOfficer,
			'isShareHolder' => $d1isShareholder,
			'classOfShares' => $item['item_meta']['d1ClassOfShares'][0],
			'numShares' => $item['item_meta']['d1NumShares'][0],
			'benOwned' => $d1BeneficiallyOwned,
			'benName' => $d1HeldFor,
			'memberDateJoined' => NULL,
			'memberDateLeft' => NULL,
			'memberAccountDesc' => NULL,
			'memberResidential' => $d1Address,
			'addPtyType'		=> NULL
		);
		
		
		//Director 2 Details
		$d2TownOfBirth = $item['item_meta']['d2TownOfBirth'][0];
		$d2StateOfBirth = $item['item_meta']['d2StateOfBirth'][0];
		$d2CountryOfBirth = $item['item_meta']['d2CountryOfBirth'][0];
		
		
		If ($d2StateOfBirth == "Other - International") {
			$d2StateOfBirth = NULL;
		}
		else {
			$d2CountryOfBirth = "Australia";
		}
		
		$d2ChangedName = $item['item_meta']['d2ChangedName'][0];
		
		if ($d2ChangedName == "Yes"){
			$d2FormerGivenNames = $item['item_meta']['d2FormerGivenNames'][0];
			$d2FormerFamilyName = $item['item_meta']['d2FormerFamilyName'][0];
			$d2HasChangedName = 1;
		}
		else {
			$d2FormerGivenNames = Null;
			$d2FormerFamilyName = Null;
			$d2HasChangedName = 0;
		
		}
		
		$d2HeldOnTrust = $item['item_meta']['d2SharesHeldOnTrust'][0];
		
		if ($d2HeldOnTrust == "Yes"){
			$d2BeneficiallyOwned = 0;
			$d2HeldFor = $item['item_meta']['d2SharesOnTrustFor'][0];
		}
		else {
			$d2BeneficiallyOwned = 1;
			$d2HeldFor = NULL;
		
		}
		
		$d2details = array(	
			'memberNamePrefix' => $item['item_meta']['d2NamePrefix'][0],
			'memberGivenNames' => $item['item_meta']['d2GivenNames'][0],
			'memberFamilyName' => $item['item_meta']['d2FamilyName'][0],
			'memberFormerGivenNames' => $d2FormerGivenNames,
			'memberFormerFamilyName' => $d2FormerFamilyName,
			'memberChangedName' => $d2HasChangedName,
			'memberTFN' => NULL,
			'memberDOB' => $d2dob,
			'memberGender' => $item['item_meta']['d2Gender'][0],
			'memberTownOfBirth' => $d2TownOfBirth,
			'memberStateOfBirth' => $d2StateOfBirth,
			'memberCountryOfBirth' => $d2CountryOfBirth,
			'memberOccupation' => NULL,
			'isCompany' => NULL,
			'companyname' => NULL,
			'hasacn' => NULL,
			'acn' => NULL,
			'companyrep1' => NULL,
			'companyrep2' => NULL,
			'companyrep3' => NULL,
			'companyrep4' => NULL,
			'isDirector' => $d2isDirector,
			'isTrustee' => 0,
			'isChairman' => $isDirectorTwoChairman,
			'isMember' => 0,
			'isSecretary' => $d2isSecretary,
			'isPublicOfficer' => $isDirectorTwoPublicOfficer,
			'isShareHolder' => $d2isShareholder,
			'classOfShares' => $item['item_meta']['d2ClassOfShares'][0],
			'numShares' => $item['item_meta']['d2NumShares'][0],
			'benOwned' => $d2BeneficiallyOwned,
			'benName' => $d2HeldFor,
			'memberDateJoined' => NULL,
			'memberDateLeft' => NULL,
			'memberAccountDesc' => NULL,
			'memberResidential' => $d2Address,
			'addPtyType'		=> NULL
		);
		
		
		//Director 3 Details
		$d3TownOfBirth = $item['item_meta']['d3TownOfBirth'][0];
		$d3StateOfBirth = $item['item_meta']['d3StateOfBirth'][0];
		$d3CountryOfBirth = $item['item_meta']['d3CountryOfBirth'][0];
		
		
		If ($d3StateOfBirth == "Other - International") {
			$d3StateOfBirth = NULL;
		}
		else {
			$d3CountryOfBirth = "Australia";
		}
		
		$d3ChangedName = $item['item_meta']['d3ChangedName'][0];
		
		if ($d3ChangedName == "Yes"){
			$d3FormerGivenNames = $item['item_meta']['d3FormerGivenNames'][0];
			$d3FormerFamilyName = $item['item_meta']['d3FormerFamilyName'][0];
			$d3HasChangedName = 1;
		}
		else {
			$d3FormerGivenNames = Null;
			$d3FormerFamilyName = Null;
			$d3HasChangedName = 0;
		
		}
		
		$d3HeldOnTrust = $item['item_meta']['d3SharesHeldOnTrust'][0];
		
		if ($d3HeldOnTrust == "Yes"){
			$d3BeneficiallyOwned = 0;
			$d3HeldFor = $item['item_meta']['d3SharesOnTrustFor'][0];
		}
		else {
			$d3BeneficiallyOwned = 1;
			$d3HeldFor = NULL;
		
		}
		
		$d3details = array(	
			'memberNamePrefix' => $item['item_meta']['d3NamePrefix'][0],
			'memberGivenNames' => $item['item_meta']['d3GivenNames'][0],
			'memberFamilyName' => $item['item_meta']['d3FamilyName'][0],
			'memberFormerGivenNames' => $d3FormerGivenNames,
			'memberFormerFamilyName' => $d3FormerFamilyName,
			'memberChangedName' => $d3HasChangedName,
			'memberTFN' => NULL,
			'memberDOB' => $d3dob,
			'memberGender' => $item['item_meta']['d3Gender'][0],
			'memberTownOfBirth' => $d3TownOfBirth,
			'memberStateOfBirth' => $d3StateOfBirth,
			'memberCountryOfBirth' => $d3CountryOfBirth,
			'memberOccupation' => NULL,
			'isCompany' => NULL,
			'companyname' => NULL,
			'hasacn' => NULL,
			'acn' => NULL,
			'companyrep1' => NULL,
			'companyrep2' => NULL,
			'companyrep3' => NULL,
			'companyrep4' => NULL,
			'isDirector' => $d3isDirector,
			'isTrustee' => 0,
			'isChairman' => $isDirectorThreeChairman,
			'isMember' => 0,
			'isSecretary' => $d3isSecretary,
			'isPublicOfficer' => $isDirectorThreePublicOfficer,
			'isShareHolder' => $d3isShareholder,
			'classOfShares' => $item['item_meta']['d3ClassOfShares'][0],
			'numShares' => $item['item_meta']['d3NumShares'][0],
			'benOwned' => $d3BeneficiallyOwned,
			'benName' => $d3HeldFor,
			'memberDateJoined' => NULL,
			'memberDateLeft' => NULL,
			'memberAccountDesc' => NULL,
			'memberResidential' => $d3Address,
			'addPtyType'		=> NULL
		);
		
		
		
		
		//Director 4 Details
		$d4TownOfBirth = $item['item_meta']['d4TownOfBirth'][0];
		$d4StateOfBirth = $item['item_meta']['d4StateOfBirth'][0];
		$d4CountryOfBirth = $item['item_meta']['d4CountryOfBirth'][0];
		
		
		If ($d4StateOfBirth == "Other - International") {
			$d4StateOfBirth = NULL;
		}
		else {
			$d4CountryOfBirth = "Australia";
		}
		
		$d4ChangedName = $item['item_meta']['d4ChangedName'][0];
		
		if ($d4ChangedName == "Yes"){
			$d4FormerGivenNames = $item['item_meta']['d4FormerGivenNames'][0];
			$d4FormerFamilyName = $item['item_meta']['d4FormerFamilyName'][0];
			$d4HasChangedName = 1;
		}
		else {
			$d4FormerGivenNames = Null;
			$d4FormerFamilyName = Null;
			$d4HasChangedName = 0;
		
		}
		
		$d4HeldOnTrust = $item['item_meta']['d4SharesHeldOnTrust'][0];
		
		if ($d4HeldOnTrust == "Yes"){
			$d4BeneficiallyOwned = 0;
			$d4HeldFor = $item['item_meta']['d4SharesOnTrustFor'][0];
		}
		else {
			$d4BeneficiallyOwned = 1;
			$d4HeldFor = NULL;
		
		}
		
		$d4details = array(	
			'memberNamePrefix' => $item['item_meta']['d4NamePrefix'][0],
			'memberGivenNames' => $item['item_meta']['d4GivenNames'][0],
			'memberFamilyName' => $item['item_meta']['d4FamilyName'][0],
			'memberFormerGivenNames' => $d4FormerGivenNames,
			'memberFormerFamilyName' => $d4FormerFamilyName,
			'memberChangedName' => $d4HasChangedName,
			'memberTFN' => NULL,
			'memberDOB' => $d4dob,
			'memberGender' => $item['item_meta']['d4Gender'][0],
			'memberTownOfBirth' => $d4TownOfBirth,
			'memberStateOfBirth' => $d4StateOfBirth,
			'memberCountryOfBirth' => $d4CountryOfBirth,
			'memberOccupation' => NULL,
			'isCompany' => NULL,
			'companyname' => NULL,
			'hasacn' => NULL,
			'acn' => NULL,
			'companyrep1' => NULL,
			'companyrep2' => NULL,
			'companyrep3' => NULL,
			'companyrep4' => NULL,
			'isDirector' => $d4isDirector,
			'isTrustee' => 0,
			'isChairman' => $isDirectorFourChairman,
			'isMember' => 0,
			'isSecretary' => $d4isSecretary,
			'isPublicOfficer' => $isDirectorFourPublicOfficer,
			'isShareHolder' => $d4isShareholder,
			'classOfShares' => $item['item_meta']['d4ClassOfShares'][0],
			'numShares' => $item['item_meta']['d4NumShares'][0],
			'benOwned' => $d4BeneficiallyOwned,
			'benName' => $d4HeldFor,
			'memberDateJoined' => NULL,
			'memberDateLeft' => NULL,
			'memberAccountDesc' => NULL,
			'memberResidential' => $d4Address,
			'addPtyType'		=> NULL
		);
		
		//Shareholder 1 Details
		$sh1HeldOnTrust = $item['item_meta']['sh1HeldOnTrust'][0];
		
		if ($sh1HeldOnTrust == "Yes"){
			$sh1BeneficiallyOwned = 0;
			$sh1HeldFor = $item['item_meta']['sh1HeldOnTrustFor'][0];
		}
		else {
			$sh1BeneficiallyOwned = 1;
			$sh1HeldFor = NULL;
		
		}
		
		$sh1Type = $item['item_meta']['sh1Type'][0];
		
		if ($sh1Type == "Individual"){
			$sh1NamePrefix = $item['item_meta']['sh1NamePrefix'][0];
			$sh1GivenNames = $item['item_meta']['sh1GivenNames'][0];
			$sh1FamilyName = $item['item_meta']['sh1FamilyName'][0];
			$sh1Gender = $item['item_meta']['sh1Gender'][0];
			$sh1IsCompany = 0;
			$sh1CompanyName = NULL;
			$sh1HasAcnOrArbn = NULL;
			$sh1Acn = NULL;
			$sh1Rep1 = NULL;
			$sh1Rep2 = NULL;
		}
		else {
			$sh1NamePrefix = NULL;
			$sh1GivenNames = NULL;
			$sh1FamilyName = NULL;
			$sh1Gender = NULL;
			$sh1IsCompany = 1;
			$sh1CompanyName = $item['item_meta']['sh1CompanyName'][0];
			$sh1HasAcnOrArbnStr = $item['item_meta']['sh1HasAcnOrArbn'][0];
			if ($sh1HasAcnOrArbnStr == "Yes") {
				$sh1Acn = $item['item_meta']['sh1Acn'][0];
				$sh1HasAcnOrArbn = 1;
			}
			else {
				$sh1Acn = NULL;
				$sh1HasAcnOrArbn = 0;
			}
			$sh1Rep1 = $item['item_meta']['sh1Rep1'][0];
			$sh1Rep2 = $item['item_meta']['sh1Rep2'][0];
		
		}
		
		$sh1details = array(	
			'memberNamePrefix' => $sh1NamePrefix,
			'memberGivenNames' => $sh1GivenNames,
			'memberFamilyName' => $sh1FamilyName,
			'memberFormerGivenNames' => NULL,
			'memberFormerFamilyName' => NULL,
			'memberChangedName' => NULL,
			'memberTFN' => NULL,
			'memberDOB' => NULL,
			'memberGender' => $sh1Gender,
			'memberTownOfBirth' => NULL,
			'memberStateOfBirth' => NULL,
			'memberCountryOfBirth' => NULL,
			'memberOccupation' => NULL,
			'isCompany' => $sh1IsCompany,
			'companyname' => $sh1CompanyName,
			'hasacn' => $sh1HasAcnOrArbn,
			'acn' => $sh1Acn,
			'companyrep1' => $sh1Rep1,
			'companyrep2' => $sh1Rep2,
			'companyrep3' => NULL,
			'companyrep4' => NULL,
			'isDirector' => 0,
			'isTrustee' => 0,
			'isChairman' => 0,
			'isMember' => 0,
			'isSecretary' => 0,
			'isPublicOfficer' => 0,
			'isShareHolder' => 1,
			'classOfShares' => $item['item_meta']['sh1ShareClass'][0],
			'numShares' => $item['item_meta']['sh1NumShares'][0],
			'benOwned' => $sh1BeneficiallyOwned,
			'benName' => $sh1HeldFor,
			'memberDateJoined' => NULL,
			'memberDateLeft' => NULL,
			'memberAccountDesc' => NULL,
			'memberResidential' => $sh1Address,
			'addPtyType'		=> NULL
		);
		
		
		
		
		
		//Shareholder 2 Details
		$sh2HeldOnTrust = $item['item_meta']['sh2HeldOnTrust'][0];
		
		if ($sh2HeldOnTrust == "Yes"){
			$sh2BeneficiallyOwned = 0;
			$sh2HeldFor = $item['item_meta']['sh2HeldOnTrustFor'][0];
		}
		else {
			$sh2BeneficiallyOwned = 1;
			$sh2HeldFor = NULL;
		
		}
		
		$sh2Type = $item['item_meta']['sh2Type'][0];
		
		if ($sh2Type == "Individual"){
			$sh2NamePrefix = $item['item_meta']['sh2NamePrefix'][0];
			$sh2GivenNames = $item['item_meta']['sh2GivenNames'][0];
			$sh2FamilyName = $item['item_meta']['sh2FamilyName'][0];
			$sh2Gender = $item['item_meta']['sh2Gender'][0];
			$sh2IsCompany = 0;
			$sh2CompanyName = NULL;
			$sh2HasAcnOrArbn = NULL;
			$sh2Acn = NULL;
			$sh2Rep1 = NULL;
			$sh2Rep2 = NULL;
		}
		else {
			$sh2NamePrefix = NULL;
			$sh2GivenNames = NULL;
			$sh2FamilyName = NULL;
			$sh2Gender = NULL;
			$sh2IsCompany = 1;
			$sh2CompanyName = $item['item_meta']['sh2CompanyName'][0];
			$$sh2HasAcnOrArbnStr = $item['item_meta']['sh2HasAcnOrArbn'][0];
			if ($$sh2HasAcnOrArbnStr == "Yes") {
				$sh2Acn = $item['item_meta']['sh2Acn'][0];
				$sh2HasAcnOrArbn = 1;
			}
			else {
				$sh2Acn = NULL;
				$sh2HasAcnOrArbn = 0;
			}
			$sh2Rep1 = $item['item_meta']['sh2Rep1'][0];
			$sh2Rep2 = $item['item_meta']['sh2Rep2'][0];
		
		}
		
		$sh2details = array(	
			'memberNamePrefix' => $sh2NamePrefix,
			'memberGivenNames' => $sh2GivenNames,
			'memberFamilyName' => $sh2FamilyName,
			'memberFormerGivenNames' => NULL,
			'memberFormerFamilyName' => NULL,
			'memberChangedName' => NULL,
			'memberTFN' => NULL,
			'memberDOB' => NULL,
			'memberGender' => $sh2Gender,
			'memberTownOfBirth' => NULL,
			'memberStateOfBirth' => NULL,
			'memberCountryOfBirth' => NULL,
			'memberOccupation' => NULL,
			'isCompany' => $sh2IsCompany,
			'companyname' => $sh2CompanyName,
			'hasacn' => $sh2HasAcnOrArbn,
			'acn' => $sh2Acn,
			'companyrep1' => $sh2Rep1,
			'companyrep2' => $sh2Rep2,
			'companyrep3' => NULL,
			'companyrep4' => NULL,
			'isDirector' => 0,
			'isTrustee' => 0,
			'isChairman' => 0,
			'isMember' => 0,
			'isSecretary' => 0,
			'isPublicOfficer' => 0,
			'isShareHolder' => 1,
			'classOfShares' => $item['item_meta']['sh2ShareClass'][0],
			'numShares' => $item['item_meta']['sh2NumShares'][0],
			'benOwned' => $sh2BeneficiallyOwned,
			'benName' => $sh2HeldFor,
			'memberDateJoined' => NULL,
			'memberDateLeft' => NULL,
			'memberAccountDesc' => NULL,
			'memberResidential' => $sh2Address,
			'addPtyType'		=> NULL
		);
		
		//Shareholder 3 Details
		$sh3HeldOnTrust = $item['item_meta']['sh3HeldOnTrust'][0];
		
		if ($sh3HeldOnTrust == "Yes"){
			$sh3BeneficiallyOwned = 0;
			$sh3HeldFor = $item['item_meta']['sh3HeldOnTrustFor'][0];
		}
		else {
			$sh3BeneficiallyOwned = 1;
			$sh3HeldFor = NULL;
		
		}
		
		$sh3Type = $item['item_meta']['sh3Type'][0];
		
		if ($sh3Type == "Individual"){
			$sh3NamePrefix = $item['item_meta']['sh3NamePrefix'][0];
			$sh3GivenNames = $item['item_meta']['sh3GivenNames'][0];
			$sh3FamilyName = $item['item_meta']['sh3FamilyName'][0];
			$sh3Gender = $item['item_meta']['sh3Gender'][0];
			$sh3IsCompany = 0;
			$sh3CompanyName = NULL;
			$sh3HasAcnOrArbn = NULL;
			$sh3Acn = NULL;
			$sh3Rep1 = NULL;
			$sh3Rep2 = NULL;
		}
		else {
			$sh3NamePrefix = NULL;
			$sh3GivenNames = NULL;
			$sh3FamilyName = NULL;
			$sh3Gender = NULL;
			$sh3IsCompany = 1;
			$sh3CompanyName = $item['item_meta']['sh3CompanyName'][0];
			$$sh3HasAcnOrArbnStr = $item['item_meta']['sh3HasAcnOrArbn'][0];
			if ($$sh3HasAcnOrArbnStr == "Yes") {
				$sh3Acn = $item['item_meta']['sh2Acn'][0];
				$sh3HasAcnOrArbn = 1;
			}
			else {
				$sh3Acn = NULL;
				$sh3HasAcnOrArbn = 0;
			}
			$sh3Rep1 = $item['item_meta']['sh3Rep1'][0];
			$sh3Rep2 = $item['item_meta']['sh3Rep2'][0];
		
		}
		
		$sh3details = array(	
			'memberNamePrefix' => $sh3NamePrefix,
			'memberGivenNames' => $sh3GivenNames,
			'memberFamilyName' => $sh3FamilyName,
			'memberFormerGivenNames' => NULL,
			'memberFormerFamilyName' => NULL,
			'memberChangedName' => NULL,
			'memberTFN' => NULL,
			'memberDOB' => NULL,
			'memberGender' => $sh3Gender,
			'memberTownOfBirth' => NULL,
			'memberStateOfBirth' => NULL,
			'memberCountryOfBirth' => NULL,
			'memberOccupation' => NULL,
			'isCompany' => $sh3IsCompany,
			'companyname' => $sh3CompanyName,
			'hasacn' => $sh3HasAcnOrArbn,
			'acn' => $sh3Acn,
			'companyrep1' => $sh3Rep1,
			'companyrep2' => $sh3Rep2,
			'companyrep3' => NULL,
			'companyrep4' => NULL,
			'isDirector' => 0,
			'isTrustee' => 0,
			'isChairman' => 0,
			'isMember' => 0,
			'isSecretary' => 0,
			'isPublicOfficer' => 0,
			'isShareHolder' => 1,
			'classOfShares' => $item['item_meta']['sh3ShareClass'][0],
			'numShares' => $item['item_meta']['sh3NumShares'][0],
			'benOwned' => $sh3BeneficiallyOwned,
			'benName' => $sh3HeldFor,
			'memberDateJoined' => NULL,
			'memberDateLeft' => NULL,
			'memberAccountDesc' => NULL,
			'memberResidential' => $sh3Address,
			'addPtyType'		=> NULL
		);
		
		
		//Shareholder 4 Details
		$sh4HeldOnTrust = $item['item_meta']['sh4HeldOnTrust'][0];
		
		if ($sh4HeldOnTrust == "Yes"){
			$sh4BeneficiallyOwned = 0;
			$sh4HeldFor = $item['item_meta']['sh4HeldOnTrustFor'][0];
		}
		else {
			$sh4BeneficiallyOwned = 1;
			$sh4HeldFor = NULL;
		
		}
		
		$sh4Type = $item['item_meta']['sh4Type'][0];
		
		if ($sh4Type == "Individual"){
			$sh4NamePrefix = $item['item_meta']['sh4NamePrefix'][0];
			$sh4GivenNames = $item['item_meta']['sh4GivenNames'][0];
			$sh4FamilyName = $item['item_meta']['sh4FamilyName'][0];
			$sh4Gender = $item['item_meta']['sh4Gender'][0];
			$sh4IsCompany = 0;
			$sh4CompanyName = NULL;
			$sh4HasAcnOrArbn = NULL;
			$sh4Acn = NULL;
			$sh4Rep1 = NULL;
			$sh4Rep2 = NULL;
		}
		else {
			$sh4NamePrefix = NULL;
			$sh4GivenNames = NULL;
			$sh4FamilyName = NULL;
			$sh4Gender = NULL;
			$sh4IsCompany = 1;
			$sh4CompanyName = $item['item_meta']['sh4CompanyName'][0];
			$$sh4HasAcnOrArbnStr = $item['item_meta']['sh4HasAcnOrArbn'][0];
			if ($$sh4HasAcnOrArbnStr == "Yes") {
				$sh4Acn = $item['item_meta']['sh4Acn'][0];
				$sh4HasAcnOrArbn = 1;
			}
			else {
				$sh4Acn = NULL;
				$sh4HasAcnOrArbn = 0;
			}
			$sh4Rep1 = $item['item_meta']['sh4Rep1'][0];
			$sh4Rep2 = $item['item_meta']['sh4Rep2'][0];
		
		}
		
		$sh4details = array(	
			'memberNamePrefix' => $sh4NamePrefix,
			'memberGivenNames' => $sh4GivenNames,
			'memberFamilyName' => $sh4FamilyName,
			'memberFormerGivenNames' => NULL,
			'memberFormerFamilyName' => NULL,
			'memberChangedName' => NULL,
			'memberTFN' => NULL,
			'memberDOB' => NULL,
			'memberGender' => $sh4Gender,
			'memberTownOfBirth' => NULL,
			'memberStateOfBirth' => NULL,
			'memberCountryOfBirth' => NULL,
			'memberOccupation' => NULL,
			'isCompany' => $sh4IsCompany,
			'companyname' => $sh4CompanyName,
			'hasacn' => $sh4HasAcnOrArbn,
			'acn' => $sh4Acn,
			'companyrep1' => $sh4Rep1,
			'companyrep2' => $sh4Rep2,
			'companyrep3' => NULL,
			'companyrep4' => NULL,
			'isDirector' => 0,
			'isTrustee' => 0,
			'isChairman' => 0,
			'isMember' => 0,
			'isSecretary' => 0,
			'isPublicOfficer' => 0,
			'isShareHolder' => 1,
			'classOfShares' => $item['item_meta']['sh4ShareClass'][0],
			'numShares' => $item['item_meta']['sh4NumShares'][0],
			'benOwned' => $sh4BeneficiallyOwned,
			'benName' => $sh4HeldFor,
			'memberDateJoined' => NULL,
			'memberDateLeft' => NULL,
			'memberAccountDesc' => NULL,
			'memberResidential' => $sh4Address,
			'addPtyType'		=> NULL
		);
		
		
		$p1details = NULL;
		
		$p2details = NULL;
		
		$p3details = NULL;
		
		$p4details = NULL;
		
		$applicantDetails = array(
			'memberNamePrefix' => NULL,
			'memberGivenNames' => $item['item_meta']['applicantGivenName'][0],
			'memberFamilyName' => $item['item_meta']['applicantFamilyName'][0],
			'memberFormerGivenNames' => NULL,
			'memberFormerFamilyName' => NULL,
			'memberChangedName' => NULL,
			'memberTFN' => NULL,
			'memberDOB' => NULL,
			'memberGender' => NULL,
			'memberTownOfBirth' => NULL,
			'memberStateOfBirth' => NULL,
			'memberCountryOfBirth' => NULL,
			'memberOccupation' => NULL,
			'isCompany' => NULL,
			'companyname' => NULL,
			'hasacn' => NULL,
			'acn' => NULL,
			'companyrep1' => NULL,
			'companyrep2' => NULL,
			'companyrep3' => NULL,
			'companyrep4' => NULL,
			'isDirector' => 0,
			'isTrustee' => 0,
			'isChairman' => 0,
			'isMember' => 0,
			'isSecretary' => 0,
			'isPublicOfficer' => 0,
			'isShareHolder' => 0,
			'classOfShares' => NULL,
			'numShares' => NULL,
			'benOwned' => 0,
			'benName' => '',
			'memberDateJoined' => NULL,
			'memberDateLeft' => NULL,
			'memberAccountDesc' => NULL,
			'memberResidential' => $applicantAddress,
			'addPtyType'		=> NULL
		);
		
		if($item['item_meta']['hasAdditionalShareholders'][0] == "Yes"){
			$numShareholders = $item['item_meta']['numExtraSH'][0];
		}
		else {
			$numShareholders = '0';
		}
		
		
				 
		switch ($numShareholders) {
		
			case '0':
				$sh1details = NULL;
				$sh2details = NULL;
				$sh3details = NULL;
				$sh4details = NULL;
				// $to = 'tim@justsuper.com.au';
				 // $subject = 'Switch Case 0';
				 // $message = 'Switch Case 0';
				 // wp_mail( $to, $subject, $message);
				break;
				
			case '1':
				//only one extra shareholder
				
				$sh2details = NULL;
				$sh3details = NULL;
				$sh4details = NULL;
				// $to = 'tim@justsuper.com.au';
				 // $subject = 'Switch Case 1';
				 // $message = 'Switch Case 1';
				 // wp_mail( $to, $subject, $message);
				break;
			case '2':
				$sh3details = NULL;
				$sh4details = NULL;
				// $to = 'tim@justsuper.com.au';
				 // $subject = 'Switch Case 2';
				 // $message = 'Switch Case 2';
				 // wp_mail( $to, $subject, $message);
				break;
			case '3':
				$sh4details = NULL;
				// $to = 'tim@justsuper.com.au';
				 // $subject = 'Switch Case 3';
				 // $message = 'Switch Case 3';
				 // wp_mail( $to, $subject, $message);
				break;
			case '4':
				// $to = 'tim@justsuper.com.au';
				 // $subject = 'Switch Case 4';
				 // $message = 'Switch Case 4';
				 // wp_mail( $to, $subject, $message);
				break;
		}
		
		
		
				 
		$t = $item['item_meta']['numOfficeholders'][0];
		
		
		switch ($t) {
		
			case '0':
				$d1details = NULL;
				$d2details = NULL;
				$d3details = NULL;
				$d4details = NULL;
				break;
				
			case '1':			
				$d2details = NULL;
				$d3details = NULL;
				$d4details = NULL;
				break;
				
			case '2':
				$d3details = NULL;
				$d4details = NULL;
				break;
				
			case '3':
				$d4details = NULL;
						
				break;
			case '4':
				
				break;
		}
		
			 
		
		
		$isSolePurposeTxt = $item['item_meta']['isSolePurpose'][0];
		if ($isSolePurposeTxt == "Yes"){
			$isSolePurposeBit = 1;
		}
		else {
			$isSolePurposeBit = 0;
		}
		
		$hasSolePurposeDecTxt = $item['item_meta']['solePurposeDec'][0];
		if ($hasSolePurposeDecTxt == "Yes"){
			$hasSolePurposeDecBit = 1;
		}
		else {
			$hasSolePurposeDecBit = 0;
		}
		
		if ( $item['item_meta']['manualReview'][0] == "Yes"){
			$manualReview = 1;
		}
		else {
			$manualReview = 0;
		}
		
		
		$isOccupyingRegOfficeTxt = $item['item_meta']['isOccupyingRegOffice'][0];
		if ($isOccupyingRegOfficeTxt == "Yes"){
			$isOccupyingRegOfficeBit = 1;
		}
		else {
			$isOccupyingRegOfficeBit = 0;
		}
		
		$hasOccupiersConsentTxt = $item['item_meta']['hasOccupiersConsent'][0];
		if ($hasOccupiersConsentTxt == "Yes"){
			$hasOccupiersConsentBit = 1;
		}
		else {
			$hasOccupiersConsentBit = 0;
		}
				 
		$nameOfOccupier = $item['item_meta']['occupiersName'][0];
				 
		$isIdenticalBusinessName = $item['item_meta']['isIdenticalBusinessName'][0];
	
		if ($isIdenticalBusinessName == "Yes"){
			$identicalBusinessNameBit = 1;
		}
		else {
			$identicalBusinessNameBit = 0;
		}
		
		// $to = 'tim@justsuper.com.au';
				 // $subject = 'Shareholder 1 Details JUST BEFORE';
				 // $message = 'Shareholder 1 Details: '.print_r($sh1details, true);
				 // wp_mail( $to, $subject, $message);	
			
			
		if ($item['item_meta']['numExtraSH'][0] == "None") {
			$numExtraSH = 0;
		}
		else {
			$numExtraSH = $item['item_meta']['numExtraSH'][0];
		}
		$newCompanyArray = array (
				'companyName' => $item['item_meta']['companyName'][0],
				'companySuffix' => $item['item_meta']['companySuffix'][0],
				'registeredState' => $item['item_meta']['companyRegState'][0],
				'isNameReserved' => 0,
				'isIdenticalBusinessName' => $identicalBusinessNameBit,
				'identicalBusinessNumber' => $item['item_meta']['identicalBusinessNumber'][0],
				'identicalBusinessStates' => $item['item_meta']['identicalBusinessStates'][0],
				'isSolePurpose' => $isSolePurposeBit,
				'solePurposeDec' => $hasSolePurposeDecBit,
				'registeredOffice' => $companyRegisteredOffice,
				'isOccupyingRegOffice' => $isOccupyingRegOfficeBit,
				'occupiersName' => $nameOfOccupier,
				'occupiersConsent' => $hasOccupiersConsentBit,
				'principalPlaceBusiness' => $ppobAddress,
				'share_Price' => $item['item_meta']['share_Price'][0],
				'numOfficeholders' => $item['item_meta']['numOfficeholders'][0],
				'D1Details' => $d1details,
				'D2Details' => $d2details,
				'D3Details' => $d3details,
				'D4Details' => $d4details,
				'numShareholders' => $numShareholders,
				'SH1Details' => $sh1details,
				'SH2Details' => $sh2details,
				'SH3Details' => $sh3details,
				'SH4Details' => $sh4details,
				'applicant'  => $applicantDetails,
				'manualReview' => $manualReview,
		);
		
		$to = 'tim@justsuper.com.au';
				 // $subject = 'Shareholder 1 Details JUST AFTER';
				 // $message = 'Shareholder 1 Details: '.print_r($sh1details, true);
				 // wp_mail( $to, $subject, $message);	
		
		$to = 'tim@justsuper.com.au';
				 // $subject = 'Number Extra Shareholders';
				 // $message = 'Number Extra Shareholders: '.$t.' Type: '.gettype($t). ' New Company Array: '.print_r($newCompanyArray,true);
				 // wp_mail( $to, $subject, $message);
				 
		//This will be populated once moved to jigo-shop.
		$adviserAddress = array(
			'levelName' => NULL,
			'streetName' => '',
			'suburbName' => '',
			'stateName' => '',
			'postcode' => ''
		);
		
		$body= array( 
			'fundName' => '*COMPANY INCORP ONLY*',
			'fundPreviousName' => NULL,
			'fundState' => NULL,
			'fundAddress' => NULL,
			'isPostalDifferent' => NULL,
			'fundPostalAddress' => NULL,
			'isTrusteeMeetingElsewhere' => NULL,
			'trusteeMeetingAddress' => NULL,
			'trusteeType' => 'C',
			'trusteeIndiv' => NULL,
			'trusteeCompany' => NULL,
			'corporateTrustee' => $newCompanyArray,
			'hasCompany' => 1,
			'companyCode' => NULL,
			'establishmentDate' => NULL,
			'fundABN' => NULL,
			'corporateTrusteeAcn' => NULL,
			'numDirectors' => NULL,
			'numMembers' => 0,
			'M1Details' => NULL,
			'M2Details' => NULL,
			'M3Details' => NULL,
			'M4Details' => NULL,
			'person1Detail' => NULL,
			'person2Detail' => NULL,
			'person3Detail' => NULL,
			'person4Detail' => NULL,
			'fundCurrentDeedDate' => NULL,
			'fundCurrentDeedNumber' => NULL,
			'fundCurrentDeedVarClause' => NULL,
			'fundPrev1DeedDate' => NULL,
			'fundPrev1DeedVarClause' => NULL,
			'fundPrev2DeedDate' => NULL,
			'fundPrev2DeedVarClause' => NULL,
			'fundPrev3DeedDate' => NULL,
			'fundPrev3DeedVarClause' => NULL,
			'fundPrev4DeedDate' => NULL,
			'fundPrev4DeedVarClause' => NULL,
			'adviserName' => $billingName,
			'adviserCompany' => $billingCompany,
			'adviserAddress' => $billingAddresArray,
			'adviserAreaCode' => NULL,
			'adviserPhone' => $billing_phone,
			'isProcessed' => NULL,
			'financialYearApplicable' => NULL,
			'investmentObj' => NULL,
			'returnLow' => NULL,
			'returnHigh' => NULL,
			'returnRate' => NULL,
			'returnOverCPI' => NULL,
			'fixedInterestAustAllocationFrom' => NULL,
			'fixedInterestAustAllocationTo' => NULL,
			'equityAustAllocationFrom' => NULL,
			'equityAustAllocationTo' => NULL,
			'internationalEquityAllocationFrom' => NULL,
			'internationalEquityAllocationTo' => NULL,
			'cashAllocationFrom' => NULL,
			'cashAllocationTo' => NULL,
			'propertyAllocationFrom' => NULL,
			'propertyAllocationTo' => NULL,
			'additionalAssetType1Name' => NULL,
			'additionalAssetType1From' => NULL,
			'additionalAssetType1To' => NULL,
			'additionalAssetType2Name' => NULL,
			'additionalAssetType2From' => NULL,
			'additionalAssetType2To' => NULL,
			'isAcquiringPropertyUsingLoan' => NULL,
			'isHoldingContractOfInsurance' => NULL,
			'submissionDate' => NULL,
			'processedDate' => NULL,
			'deedVersion' => NULL,
			'constitutionVersion' => $constitutionVersion,
			'orderNumber' => $order_id,
			'hasInvStrat' => 0,
			'hasBDBN'	  => 0,
			'hasNBDBN'	  => 0,
			'userID'	  => $userID,
			'productID'	  => $product_id,
			'chairman'	  => $chairmanSwitch,
			'adviserEmail' => $adviserEmail,
			'orderDate'	  => $orderDate,
			'apIndivOne' => NULL,
			'apIndivTwo' => NULL,
			'apCompany' => NULL,
			'numVariations' => NULL,
			'yourRef'			=> $yourRef,
			'publicOfficer'	=> $publicOfficer,
			'orderServiceType' 	=> $item['item_meta']['Service Type'][0]

		);

			
        
		//$request = new WP_Http();
		//$response = $request->post($post_url, array('body' => $body));
		return $body;
}

?>