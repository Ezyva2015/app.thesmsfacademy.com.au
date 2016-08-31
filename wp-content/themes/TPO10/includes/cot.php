<?php
//////////////////////////////////////////////////////////
//														//
//														//
//														//
//					  Change of Trustees.			 				//
//														//
//														//
//														//
//////////////////////////////////////////////////////////
function cot_post_Data($item, $order_id, $deedVersion, $constitutionVersion, $billingArray, $billingName, $billingCompany, $billing_phone, $product_id, $adviserEmail, $userID, $orderDate) {
	
		$yourRef 		= $item['item_meta']['yourRef'][0];
		
		if(!is_null($item['item_meta']['changeType'][0])){
			$changeType = $item['item_meta']['changeType'][0];
		}	
		else {
			$changeType = NULL;
		}
		
		
		switch($changeType) {
			case 'Individuals to Corporate':
				$retTeeType = "I";
				$newTeeType = "C";
				
			break;
			
			case 'Company to Individuals':
				$retTeeType = "C";
				$newTeeType = "I";
			break;
				
			case 'Add/Remove Individuals':
				$retTeeType = "I";
				$newTeeType = "I";
				break;
				
			case 'Company to Company':
				$retTeeType = "C";
				$newTeeType = "C";
				break;
			
			default:
				$retTeeType = "";
				$newTeeType = "";
		}
		
		if ($item['item_meta']['t1D1IsMember'][0] == "Yes") {
			$retT1D1IsMember = 1;
		}
		else {
			$retT1D1IsMember = 0;
		}
		
		if ($item['item_meta']['t2D2IsMember'][0] == "Yes") {
			$retT2D2IsMember = 1;
		}
		else {
			$retT2D2IsMember = 0;
		}
		
		if ($item['item_meta']['t3D3IsMember'][0] == "Yes") {
			$retT3D3IsMember = 1;
		}
		else {
			$retT3D3IsMember = 0;
		}
		
		if ($item['item_meta']['t4D4IsMember'][0] == "Yes") {
			$retT4D4IsMember = 1;
		}
		else {
			$retT4D4IsMember = 0;
		}
		
		
		//Fund Address
		$fundAddress = array (
			'careOf' => $item['item_meta']['fundAddressCareOf'][0],
			'levelName' => $item['item_meta']['fundAddressLevel'][0],
			'streetName' => $item['item_meta']['fundAddressStreet'][0],
			'suburbName' => $item['item_meta']['fundAddressSuburb'][0],
			'stateName' => $item['item_meta']['fundAddressState'][0],
			'postcode' => $item['item_meta']['fundAddressPostcode'][0]
			);
			
		//Retiring T1D1 Address
			$retT1D1Address = array(
			'careOf' => $item['item_meta']['t1D1AddressCareOf'][0],
			'levelName' => $item['item_meta']['t1D1AddressLevel'][0],
			'streetName' => $item['item_meta']['t1D1AddressStreet'][0],
			'suburbName' => $item['item_meta']['t1D1AddressSuburb'][0],
			'stateName' => $item['item_meta']['t1D1AddressState'][0],
			'postcode' => $item['item_meta']['t1D1AddressPostcode'][0]
			);
			
		//Retiring T2D2 Address
			$retT2D2Address = array(
			'careOf' => $item['item_meta']['t2D2AddressCareOf'][0],
			'levelName' => $item['item_meta']['t2D2AddressLevel'][0],
			'streetName' => $item['item_meta']['t2D2AddressStreet'][0],
			'suburbName' => $item['item_meta']['t2D2AddressSuburb'][0],
			'stateName' => $item['item_meta']['t2D2AddressState'][0],
			'postcode' => $item['item_meta']['t2D2AddressPostcode'][0]
			);
			
		//Retiring T3D3 Address
			$retT3D3Address = array(
			'careOf' => $item['item_meta']['t3D3AddressCareOf'][0],
			'levelName' => $item['item_meta']['t3D3AddressLevel'][0],
			'streetName' => $item['item_meta']['t3D3AddressStreet'][0],
			'suburbName' => $item['item_meta']['t3D3AddressSuburb'][0],
			'stateName' => $item['item_meta']['t3D3AddressState'][0],
			'postcode' => $item['item_meta']['t3D3AddressPostcode'][0]
			);
			
		//Retiring T4D4 Address
			$retT4D4Address = array(
			'careOf' => $item['item_meta']['t4D4AddressCareOf'][0],
			'levelName' => $item['item_meta']['t4D4AddressLevel'][0],
			'streetName' => $item['item_meta']['t4D4AddressStreet'][0],
			'suburbName' => $item['item_meta']['t4D4AddressSuburb'][0],
			'stateName' => $item['item_meta']['t4D4AddressState'][0],
			'postcode' => $item['item_meta']['t4D4AddressPostcode'][0]
			);
		
		
		$retT1D1Details = array(	
						'memberNamePrefix' => $item['item_meta']['t1D1Title'][0],
						'memberGivenNames' => $item['item_meta']['t1D1GivenNames'][0],
						'memberFamilyName' => $item['item_meta']['t1D1FamilyName'][0],
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
						'isSecretary' => NULL,
						'isPublicOfficer' => NULL,
						'isShareHolder' => NULL,
						'classOfShares' => NULL,
						'numShares' => NULL,
						'benOwned' => NULL,
						'benName' => NULL,
						'memberDateJoined' => NULL,
						'memberDateLeft' => NULL,
						'memberAccountDesc' => NULL,
						'memberResidential' => $retT1D1Address,
						'addPtyType'		=> NULL
					);
					
		$retT2D2Details = array(	
						'memberNamePrefix' => $item['item_meta']['t2D2Title'][0],
						'memberGivenNames' => $item['item_meta']['t2D2GivenNames'][0],
						'memberFamilyName' => $item['item_meta']['t2D2FamilyName'][0],
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
						'isSecretary' => NULL,
						'isPublicOfficer' => NULL,
						'isShareHolder' => NULL,
						'classOfShares' => NULL,
						'numShares' => NULL,
						'benOwned' => NULL,
						'benName' => NULL,
						'memberDateJoined' => NULL,
						'memberDateLeft' => NULL,
						'memberAccountDesc' => NULL,
						'memberResidential' => $retT2D2Address,
						'addPtyType'		=> NULL
					);
		
		
		$retT3D3Details = array(	
						'memberNamePrefix' => $item['item_meta']['t3D3Title'][0],
						'memberGivenNames' => $item['item_meta']['t3D3GivenNames'][0],
						'memberFamilyName' => $item['item_meta']['t3D3FamilyName'][0],
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
						'isSecretary' => NULL,
						'isPublicOfficer' => NULL,
						'isShareHolder' => NULL,
						'classOfShares' => NULL,
						'numShares' => NULL,
						'benOwned' => NULL,
						'benName' => NULL,
						'memberDateJoined' => NULL,
						'memberDateLeft' => NULL,
						'memberAccountDesc' => NULL,
						'memberResidential' => $retT3D3Address,
						'addPtyType'		=> NULL
					);
		
		
		$retT4D4Details = array(	
						'memberNamePrefix' => $item['item_meta']['t4D4Title'][0],
						'memberGivenNames' => $item['item_meta']['t4D4GivenNames'][0],
						'memberFamilyName' => $item['item_meta']['t4D4FamilyName'][0],
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
						'isSecretary' => NULL,
						'isPublicOfficer' => NULL,
						'isShareHolder' => NULL,
						'classOfShares' => NULL,
						'numShares' => NULL,
						'benOwned' => NULL,
						'benName' => NULL,
						'memberDateJoined' => NULL,
						'memberDateLeft' => NULL,
						'memberAccountDesc' => NULL,
						'memberResidential' => $retT4D4Address,
						'addPtyType'		=> NULL
					);
		
		
		$fundRegisteredOffice = array(
						'careOf' => NULL,
						'levelName' => $item['item_meta']['fundAddressLevel'][0],
						'streetName' => $item['item_meta']['fundAddressStreet'][0],
						'suburbName' => $item['item_meta']['fundAddressSuburb'][0],
						'stateName' => $item['item_meta']['fundAddressState'][0],
						'postcode' => $item['item_meta']['fundAddressPostcode'][0],
					);
					
		$teeMtgAddress = array (
						'careOf' => NULL,
						'levelName' => $item['item_meta']['teeMtgAddressLevel'][0],
						'streetName' => $item['item_meta']['teeMtgAddressStreet'][0],
						'suburbName' => $item['item_meta']['teeMtgAddressSuburb'][0],
						'stateName' => $item['item_meta']['teeMtgAddressState'][0],
						'postcode' => $item['item_meta']['teeMtgAddressPostcode'][0]
					);
					
		
		if ($retTeeType == "C"){
					$numRetDirectors = $item['item_meta']['retCorpTeeNumDirectors'][0];
					switch ($numRetDirectors) {
		
						case '1':
							//$retT1D1Details = NULL;
							$retT2D2Details = NULL;
							$retT3D3Details = NULL;
							$retT4D4Details = NULL;
						break;
						
						case '2':
							//$retT1D1Details = NULL;
							//$retT2D2Details = NULL;
							$retT3D3Details = NULL;
							$retT4D4Details = NULL;
						break;
						
						case '3':
							//$retT1D1Details = NULL;
							//$retT2D2Details = NULL;
							//$retT3D3Details = NULL;
							$retT4D4Details = NULL;
						break;
						
						case '4':
							//$retT1D1Details = NULL;
							//$retT2D2Details = NULL;
							//$retT3D3Details = NULL;
							//$retT4D4Details = NULL;
						break;
					}
		
					$retTrusteeCompanyRegisteredOffice = array(
						'careOf' => NULL,
						'levelName' => $item['item_meta']['retCorpTeeAddressLevel'][0],
						'streetName' => $item['item_meta']['retCorpTeeAddressStreet'][0],
						'suburbName' => $item['item_meta']['retCorpTeeAddressSuburb'][0],
						'stateName' => $item['item_meta']['retCorpTeeAddressState'][0],
						'postcode' => $item['item_meta']['retCorpTeeAddressPostcode'][0],
					);
		
					$retTrusteeCorpArray = array (		
						'companyName' => $item['item_meta']['retTeeCorpName'][0],
						'companySuffix' => '',
						'companyACN' => $item['item_meta']['retTeeCorpACN'][0],
						'registeredOffice' => $retTrusteeCompanyRegisteredOffice,
						'D1Details' => $retT1D1Details,
						'D2Details' => $retT2D2Details,
						'D3Details' => $retT3D3Details,
						'D4Details' => $retT4D4Details
					
					);
		
		}
		
		elseif ($retTeeType == "I"){
					$numRetIndiv = $item['item_meta']['retIndivTeeNumTees'][0];
					switch ($numRetIndiv) {
		
						case '1':
							//$retT1D1Details = NULL;
							$retT2D2Details = NULL;
							$retT3D3Details = NULL;
							$retT4D4Details = NULL;
						break;
						
						case '2':
							//$retT1D1Details = NULL;
							//$retT2D2Details = NULL;
							$retT3D3Details = NULL;
							$retT4D4Details = NULL;
						break;
						
						case '3':
							//$retT1D1Details = NULL;
							//$retT2D2Details = NULL;
							//$retT3D3Details = NULL;
							$retT4D4Details = NULL;
						break;
						
						case '4':
							//$retT1D1Details = NULL;
							//$retT2D2Details = NULL;
							//$retT3D3Details = NULL;
							//$retT4D4Details = NULL;
						break;
					}
		
					
					
					$retTrusteeIndiv = array(
						'T1Details' => $retT1D1Details,
						'isT1M1' => 0,
						'T2Details' => $retT2D2Details,
						'isT2M2' => 0,
						'isT2P1' => 0,
						'T3Details' => $retT3D3Details,
						'isT3M3' => 0,
						'T4Details' => $retT4D4Details,
						'isT4M4' => 0
					);		
		
		
		}
		
		$retTrusteeMeetingAddress = array(
						'careOf' => NULL,
						'levelName' => $item['item_meta']['teeMtgAddressLevel'][0],
						'streetName' => $item['item_meta']['teeMtgAddressStreet'][0],
						'suburbName' => $item['item_meta']['teeMtgAddressSuburb'][0],
						'stateName' => $item['item_meta']['teeMtgAddressState'][0],
						'postcode' => $item['item_meta']['teeMtgAddressPostcode'][0],
					);
		
		
		
		//NEW TRUSTEE DETAILS
		if ($item['item_meta']['newT1D1IsMember'][0] == "Yes") {
			$newT1D1IsMember = 1;
		}
		elseif (($item['item_meta']['newT1D1IsMember'][0] == "No") and ($item['item_meta']['newT1D1AddAsMember'][0] == "Yes")) {
			$retT1D1IsMember = 1;
		}
		else {
			$retT1D1IsMember = 0;
		}
		
		if ($item['item_meta']['newT2D2IsMember'][0] == "Yes") {
			$newT2D2IsMember = 1;
		}
		elseif (($item['item_meta']['newT2D2IsMember'][0] == "No") and ($item['item_meta']['newT2D2AddAsMember'][0] == "Yes")) {
			$retT2D2IsMember = 1;
		}
		else {
			$retT2D2IsMember = 0;
		}
		
		if ($item['item_meta']['newT3D3IsMember'][0] == "Yes") {
			$newT3D3IsMember = 1;
		}
		elseif (($item['item_meta']['newT3D3IsMember'][0] == "No") and ($item['item_meta']['newT3D3AddAsMember'][0] == "Yes")) {
			$retT3D3IsMember = 1;
		}
		else {
			$retT3D3IsMember = 0;
		}
		
		if ($item['item_meta']['newT4D4IsMember'][0] == "Yes") {
			$newT4D4IsMember = 1;
		}
		elseif (($item['item_meta']['newT4D4IsMember'][0] == "No") and ($item['item_meta']['newT4D4AddAsMember'][0] == "Yes")) {
			$retT4D4IsMember = 1;
		}
		else {
			$retT4D4IsMember = 0;
		}
		
		//New T1D1 Address
			$newT1D1Address = array(
			'careOf' => $item['item_meta']['newT1D1AddressCareOf'][0],
			'levelName' => $item['item_meta']['newT1D1AddressLevel'][0],
			'streetName' => $item['item_meta']['newT1D1AddressStreet'][0],
			'suburbName' => $item['item_meta']['newT1D1AddressSuburb'][0],
			'stateName' => $item['item_meta']['newT1D1AddressState'][0],
			'postcode' => $item['item_meta']['newT1D1AddressPostcode'][0]
			);
			
		//New T2D2 Address
			$newT2D2Address = array(
			'careOf' => $item['item_meta']['newT2D2AddressCareOf'][0],
			'levelName' => $item['item_meta']['newT2D2AddressLevel'][0],
			'streetName' => $item['item_meta']['newT2D2AddressStreet'][0],
			'suburbName' => $item['item_meta']['newT2D2AddressSuburb'][0],
			'stateName' => $item['item_meta']['newT2D2AddressState'][0],
			'postcode' => $item['item_meta']['newT2D2AddressPostcode'][0]
			);
			
		//New T3D3 Address
			$newT3D3Address = array(
			'careOf' => $item['item_meta']['newT3D3AddressCareOf'][0],
			'levelName' => $item['item_meta']['newT3D3AddressLevel'][0],
			'streetName' => $item['item_meta']['newT3D3AddressStreet'][0],
			'suburbName' => $item['item_meta']['newT3D3AddressSuburb'][0],
			'stateName' => $item['item_meta']['newT3D3AddressState'][0],
			'postcode' => $item['item_meta']['newT3D3AddressPostcode'][0]
			);
			
		//New T4D4 Address
			$newT4D4Address = array(
			'careOf' => $item['item_meta']['newT4D4AddressCareOf'][0],
			'levelName' => $item['item_meta']['newT4D4AddressLevel'][0],
			'streetName' => $item['item_meta']['newT4D4AddressStreet'][0],
			'suburbName' => $item['item_meta']['newT4D4AddressSuburb'][0],
			'stateName' => $item['item_meta']['newT4D4AddressState'][0],
			'postcode' => $item['item_meta']['newT4D4AddressPostcode'][0]
			);
		
		
		$newT1D1Details = array(	
						'memberNamePrefix' => $item['item_meta']['newT1D1Title'][0],
						'memberGivenNames' => $item['item_meta']['newT1D1GivenNames'][0],
						'memberFamilyName' => $item['item_meta']['newT1D1FamilyName'][0],
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
						'isSecretary' => NULL,
						'isPublicOfficer' => NULL,
						'isShareHolder' => NULL,
						'classOfShares' => NULL,
						'numShares' => NULL,
						'benOwned' => NULL,
						'benName' => NULL,
						'memberDateJoined' => NULL,
						'memberDateLeft' => NULL,
						'memberAccountDesc' => NULL,
						'memberResidential' => $newT1D1Address,
						'addPtyType'		=> NULL
					);
		
		
		$newT2D2Details = array(	
						'memberNamePrefix' => $item['item_meta']['newT2D2Title'][0],
						'memberGivenNames' => $item['item_meta']['newT2D2GivenNames'][0],
						'memberFamilyName' => $item['item_meta']['newT2D2FamilyName'][0],
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
						'isSecretary' => NULL,
						'isPublicOfficer' => NULL,
						'isShareHolder' => NULL,
						'classOfShares' => NULL,
						'numShares' => NULL,
						'benOwned' => NULL,
						'benName' => NULL,
						'memberDateJoined' => NULL,
						'memberDateLeft' => NULL,
						'memberAccountDesc' => NULL,
						'memberResidential' => $newT2D2Address,
						'addPtyType'		=> NULL
					);
			
			$newT3D3Details = array(	
						'memberNamePrefix' => $item['item_meta']['newT3D3Title'][0],
						'memberGivenNames' => $item['item_meta']['newT3D3GivenNames'][0],
						'memberFamilyName' => $item['item_meta']['newT3D3FamilyName'][0],
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
						'isSecretary' => NULL,
						'isPublicOfficer' => NULL,
						'isShareHolder' => NULL,
						'classOfShares' => NULL,
						'numShares' => NULL,
						'benOwned' => NULL,
						'benName' => NULL,
						'memberDateJoined' => NULL,
						'memberDateLeft' => NULL,
						'memberAccountDesc' => NULL,
						'memberResidential' => $newT3D3Address,
						'addPtyType'		=> NULL
					);
		
			$newT4D4Details = array(	
						'memberNamePrefix' => $item['item_meta']['newT4D4Title'][0],
						'memberGivenNames' => $item['item_meta']['newT4D4GivenNames'][0],
						'memberFamilyName' => $item['item_meta']['newT4D4FamilyName'][0],
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
						'isSecretary' => NULL,
						'isPublicOfficer' => NULL,
						'isShareHolder' => NULL,
						'classOfShares' => NULL,
						'numShares' => NULL,
						'benOwned' => NULL,
						'benName' => NULL,
						'memberDateJoined' => NULL,
						'memberDateLeft' => NULL,
						'memberAccountDesc' => NULL,
						'memberResidential' => $newT4D4Address,
						'addPtyType'		=> NULL
					);
		
		if ($newTeeType == "C"){
					$numNewDirectors = $item['item_meta']['newCorpTeeNumDirectors'][0];
					switch ($numNewDirectors) {
		
						case '1':
							//$newT1D1Details = NULL;
							$newT2D2Details = NULL;
							$newT3D3Details = NULL;
							$newT4D4Details = NULL;
						break;
						
						case '2':
							//$newT1D1Details = NULL;
							//$newT2D2Details = NULL;
							$newT3D3Details = NULL;
							$newT4D4Details = NULL;
						break;
						
						case '3':
							//$newT1D1Details = NULL;
							//$newT2D2Details = NULL;
							//$newT3D3Details = NULL;
							$newT4D4Details = NULL;
						break;
						
						case '4':
							//$newT1D1Details = NULL;
							//$newT2D2Details = NULL;
							//$newT3D3Details = NULL;
							//$newT4D4Details = NULL;
						break;
					}
		
					$newTrusteeCompanyRegisteredOffice = array(
						'careOf' => NULL,
						'levelName' => $item['item_meta']['newCorpTeeAddressLevel'][0],
						'streetName' => $item['item_meta']['newCorpTeeAddressStreet'][0],
						'suburbName' => $item['item_meta']['newCorpTeeAddressSuburb'][0],
						'stateName' => $item['item_meta']['newCorpTeeAddressState'][0],
						'postcode' => $item['item_meta']['newCorpTeeAddressPostcode'][0],
					);
		
					$newTrusteeCorpArray = array (		
						'companyName' => $item['item_meta']['newCorpTeeName'][0],
						'companySuffix' => '',
						'companyACN' => $item['item_meta']['newCorpTrusteeACN'][0],
						'registeredOffice' => $newTrusteeCompanyRegisteredOffice,
						'D1Details' => $newT1D1Details,
						'D2Details' => $newT2D2Details,
						'D3Details' => $newT3D3Details,
						'D4Details' => $newT4D4Details
					
					);
		
		}
		elseif ($newTeeType == "I"){
					$numNewIndiv = $item['item_meta']['newIndivTeeNumTees'][0];
					switch ($numNewIndiv) {
		
						case '1':
							//$newT1D1Details = NULL;
							$newT2D2Details = NULL;
							$newT3D3Details = NULL;
							$newT4D4Details = NULL;
						break;
						
						case '2':
							//$newT1D1Details = NULL;
							//$newT2D2Details = NULL;
							$newT3D3Details = NULL;
							$newT4D4Details = NULL;
						break;
						
						case '3':
							//$newT1D1Details = NULL;
							//$newT2D2Details = NULL;
							//$newT3D3Details = NULL;
							$newT4D4Details = NULL;
						break;
						
						case '4':
							//$newT1D1Details = NULL;
							//$newT2D2Details = NULL;
							//$newT3D3Details = NULL;
							//$newT4D4Details = NULL;
						break;
					}
		
					
					
					
					$newTrusteeIndiv = array(
						'T1Details' => $newT1D1Details,
						'isT1M1' => 0,
						'T2Details' => $newT2D2Details,
						'isT2M2' => 0,
						'isT2P1' => 0,
						'T3Details' => $newT3D3Details,
						'isT3M3' => 0,
						'T4Details' => $newT4D4Details,
						'isT4M4' => 0
					);		
		
		
		}
		
		$newTrusteeMeetingAddress = array(
						'careOf' => NULL,
						'levelName' => $item['item_meta']['newTeeMtgAddressLevel'][0],
						'streetName' => $item['item_meta']['newTeeMtgAddressStreet'][0],
						'suburbName' => $item['item_meta']['newTeeMtgAddressSuburb'][0],
						'stateName' => $item['item_meta']['newTeeMtgAddressState'][0],
						'postcode' => $item['item_meta']['newTeeMtgAddressPostcode'][0],
					);
					

		//Details of Deed Variations
		$hasBeenVaried = $item['item_meta']['hasBeenVaried'][0];
		if ($hasBeenVaried == 'Yes') {
				$numVariations = $item['item_meta']['numVariations'][0];
		
		}
		else {
				$numVariations = 0;
		
		}
		
		switch ($numVariations) {
		
			case '0':
				$currentDeedDate = NULL;
				$secondRecentDeedDate = NULL;
				$thirdRecentDeedDate = NULL;
				$fourthRecentDeedDate = NULL;
				$fifthRecentDeedDate = NULL;
			break;
			
			case '1':
				$currentDeedDate = $item['item_meta']['currentDeedDate'][0];
				$secondRecentDeedDate = NULL;
				$thirdRecentDeedDate = NULL;
				$fourthRecentDeedDate = NULL;
				$fifthRecentDeedDate = NULL;
			break;
			
			case '2':
				$currentDeedDate = $item['item_meta']['currentDeedDate'][0];
				$secondRecentDeedDate = $item['item_meta']['secondRecentDeedDate'][0];
				$thirdRecentDeedDate = NULL;
				$fourthRecentDeedDate = NULL;
				$fifthRecentDeedDate = NULL;
			break;
			
			case '3':
				$currentDeedDate = $item['item_meta']['currentDeedDate'][0];
				$secondRecentDeedDate = $item['item_meta']['secondRecentDeedDate'][0];
				$thirdRecentDeedDate = $item['item_meta']['thirdRecentDeedDate'][0];
				$fourthRecentDeedDate = NULL;
				$fifthRecentDeedDate = NULL;
			break;
			
			case '4':
				$currentDeedDate = $item['item_meta']['currentDeedDate'][0];
				$secondRecentDeedDate = $item['item_meta']['secondRecentDeedDate'][0];
				$thirdRecentDeedDate = $item['item_meta']['thirdRecentDeedDate'][0];
				$fourthRecentDeedDate = $item['item_meta']['fourthRecentDeedDate'][0];
				$fifthRecentDeedDate = $item['item_meta']['fifthRecentDeedDate'][0];;
			break;
			
		
		}
		
		
		
	
		
		
		$billingAddresArray = array (
		
			'careOf' => NULL,
			'levelName' => NULL,
			'streetName' => $billingArray[0].' '.$billingArray[1],
			'suburbName' => $billingArray[2],
			'stateName' => $billingArray[3],
			'postcode' => $billingArray[4]
		
		);
		
		
	//Chairperson
		$chairperson = $item['item_meta']['chairman'][0];
		
		
			
		
		$adviserAddress = array(
			'levelName' => NULL,
			'streetName' => '',
			'suburbName' => '',
			'stateName' => '',
			'postcode' => ''
		);
		
		
		if ($item['item_meta']['hasAdditionalPty'][0] == "Yes") {
			$addPtyType = $item['item_meta']['addPtyType'][0];
			$addPtyCompanyOrIndiv = $item['item_meta']['addPtyCompanyOrIndiv'][0];
		}
		else {
			$addPtyType = NULL;
			$addPtyCompanyOrIndiv = NULL;
		}
		
		if ((!is_null($addPtyCompanyOrIndiv)) and ($addPtyCompanyOrIndiv == "C")) {
			$addPtyCompanyName = $item['item_meta']['addPtyCompanyName'][0];
			$addPtyCompanyACN = $item['item_meta']['addPtyCompanyACN'][0];
			$addPtyNumDirs = $item['item_meta']['addPtyNumDirs'][0];
			
			switch($addPtyNumDirs) {
				case '1':
					$companyrep1 = $item['item_meta']['addPtyD1GivenNames'][0].' '.$item['item_meta']['addPtyD1FamilyName'][0];
					$companyrep2 = NULL;
					$companyrep3 = NULL;
					$companyrep4 = NULL;
				break;
				
				case '2':
					$companyrep1 = $item['item_meta']['addPtyD1GivenNames'][0].' '.$item['item_meta']['addPtyD1FamilyName'][0];
					$companyrep2 = $item['item_meta']['addPtyD2GivenNames'][0].' '.$item['item_meta']['addPtyD2FamilyName'][0];
					$companyrep3 = NULL;
					$companyrep4 = NULL;
				break;
				
				case '3':
					$companyrep1 = $item['item_meta']['addPtyD1GivenNames'][0].' '.$item['item_meta']['addPtyD1FamilyName'][0];
					$companyrep2 = $item['item_meta']['addPtyD2GivenNames'][0].' '.$item['item_meta']['addPtyD2FamilyName'][0];
					$companyrep3 = $item['item_meta']['addPtyD3GivenNames'][0].' '.$item['item_meta']['addPtyD3FamilyName'][0];
					$companyrep4 = NULL;
				break;
				
				case '4':
					$companyrep1 = $item['item_meta']['addPtyD1GivenNames'][0].' '.$item['item_meta']['addPtyD1FamilyName'][0];
					$companyrep2 = $item['item_meta']['addPtyD2GivenNames'][0].' '.$item['item_meta']['addPtyD2FamilyName'][0];
					$companyrep3 = $item['item_meta']['addPtyD3GivenNames'][0].' '.$item['item_meta']['addPtyD3FamilyName'][0];
					$companyrep4 = $item['item_meta']['addPtyD4GivenNames'][0].' '.$item['item_meta']['addPtyD4FamilyName'][0];
				break;
			}
			
			//Additional Party Address
			$addPartyAddress = array(
						'careOf' => NULL,
						'levelName' => $item['item_meta']['addPtyAddressLevel'][0],
						'streetName' => $item['item_meta']['addPtyAddressStreet'][0],
						'suburbName' => $item['item_meta']['addPtyAddressSuburb'][0],
						'stateName' => $item['item_meta']['addPtyAddressState'][0],
						'postcode' => $item['item_meta']['addPtyAddressPostcode'][0],
					);
			
			
			$apCompany = array(	
						'memberNamePrefix' => NULL,
						'memberGivenNames' => NULL,
						'memberFamilyName' => NULL,
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
						'isCompany' => 1,
						'companyname' => $addPtyCompanyName,
						'hasacn' => 1,
						'acn' => $addPtyCompanyName,
						'companyrep1' => $companyrep1,
						'companyrep2' => $companyrep2,
						'companyrep3' => $companyrep3,
						'companyrep4' => $companyrep4,
						'isDirector' => 0,
						'isTrustee' => 0,
						'isChairman' => 0,
						'isMember' => 0,
						'isSecretary' => NULL,
						'isPublicOfficer' => NULL,
						'isShareHolder' => NULL,
						'classOfShares' => NULL,
						'numShares' => NULL,
						'benOwned' => NULL,
						'benName' => NULL,
						'memberDateJoined' => NULL,
						'memberDateLeft' => NULL,
						'memberAccountDesc' => NULL,
						'memberResidential' => $addPartyAddress,
						'addPtyType'		=> 'Company'
					);
		
			
		}
		elseif ((!is_null($addPtyCompanyOrIndiv)) and ($addPtyCompanyOrIndiv == "I")) {
			$addPtyCompanyName = NULL;
			$addPtyCompanyACN = NULL;
			$addPtyNumDirs = NULL;
			$addPtyIndivTitle = $item['item_meta']['addPtyIndivTitle'][0];
			$addPtyIndivGivenNames = $item['item_meta']['addPtyIndivGivenNames'][0];
			$addPtyIndivFamilyName = $item['item_meta']['addPtyIndivFamilyName'][0];
			
			//Additional Party Address
			$addPartyAddress = array(
						'careOf' => NULL,
						'levelName' => $item['item_meta']['addPtyAddressLevel'][0],
						'streetName' => $item['item_meta']['addPtyAddressStreet'][0],
						'suburbName' => $item['item_meta']['addPtyAddressSuburb'][0],
						'stateName' => $item['item_meta']['addPtyAddressState'][0],
						'postcode' => $item['item_meta']['addPtyAddressPostcode'][0],
					);
			
			$apIndivOne = array(	
						'memberNamePrefix' => $item['item_meta']['addPtyIndivTitle'][0],
						'memberGivenNames' => $item['item_meta']['addPtyIndivGivenNames'][0],
						'memberFamilyName' => $item['item_meta']['addPtyIndivFamilyName'][0],
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
						'isSecretary' => NULL,
						'isPublicOfficer' => NULL,
						'isShareHolder' => NULL,
						'classOfShares' => NULL,
						'numShares' => NULL,
						'benOwned' => NULL,
						'benName' => NULL,
						'memberDateJoined' => NULL,
						'memberDateLeft' => NULL,
						'memberAccountDesc' => NULL,
						'memberResidential' => $addPartyAddress,
						'addPtyType'		=> 'I'
					);
		}
		
		
		
		
				if(!is_null($item['item_meta']['currentDeedRule'][0])) {
					$changeRule = $item['item_meta']['currentDeedRule'][0];
				}
				else {
					$changeRule = $item['item_meta']['estDeedRule'][0];
				}		
			
		
		
		
		$body= array( 
				'yourRef'  => 	$yourRef,
				'fundName' => 	$item['item_meta']['fundName'][0],
				'fundABN'  => $item['item_meta']['fundABN'][0],
				'fundState' => $item['item_meta']['stateLawOfFund'][0],
				'establishmentDate'  => $item['item_meta']['establishmentDate'][0],
				'changeType'  => $changeType,
				'fundCurrentDeedVarClause' => $changeRule,
				'fundCurrentDeedNumber' => NULL,
				'chairman'  => $chairperson,
				'teeMtgAddress' => $retTrusteeMeetingAddress,
				'teeMtgElsewhere' => 1,
				'retTrusteeType'  => $retTeeType,
				'retTrusteeIndiv'  => $retTrusteeIndiv,
				'retTrusteeCompany'  => $retTrusteeCorpArray,
				'newTrusteeType'  => $newTeeType,
				'newTrusteeIndiv'  => $newTrusteeIndiv,
				'newTrusteeCompany'  => $newTrusteeCorpArray,
				'hasCompany'  => NULL,
				'companyCode'  => NULL,
				'fundAddress' => $fundAddress,
				'retCorporateTrusteeAcn'  => $item['item_meta']['retCorporateTrusteeAcn'][0],
				'retNumDirectors'  => $numRetDirectors,
				'retNumIndivs'  => $numRetIndiv,
				'retT1D1Details'  => $retT1D1Details,
				'retT2D2Details'  => $retT2D2Details,
				'retT3D3Details'  => $retT3D3Details,
				'retT4D4Details'  => $retT4D4Details,
				'newCorporateTrusteeAcn'  => $item['item_meta']['newCorporateTrusteeAcn'][0],
				'newNumDirectors'  => $numNewDirectors,
				'newNumIndivs'  => $numNewIndiv,
				'newT1D1Details'  => $newT1D1Details,
				'newT2D2Details'  => $newT2D2Details,
				'newT3D3Details'  => $newT3D3Details,
				'newT4D4Details'  => $newT4D4Details,
				'isProcessed'  => $item['item_meta']['isProcessed'][0],
				'submissionDate'  => $item['item_meta']['submissionDate'][0],
				'processedDate'  => $item['item_meta']['processedDate'][0],
				'deedVersion'  => NULL,
				'constitutionVersion'  => NULL,
				'apIndivOne'  => $apIndivOne,
				'apIndivTwo'  => NULL,
				'apCompany'  => $apCompany,
				'numVariations'  => $numVariations,
				'adviserName' => $billingName,
				'adviserCompany' => $billingCompany,
				'adviserAddress' => $billingAddresArray,
				'adviserAreaCode'  => NULL,
				'adviserPhone' => $billing_phone,
				'orderNumber' => $order_id,
				'userID'	  => $userID,
				'productID'	  => $product_id,
				'chairman'	  => $chairperson,
				'adviserEmail' => $adviserEmail,
				'orderDate'	  => $orderDate,
				'orderServiceType'  => $item['item_meta']['orderServiceType'][0],
				'wlname'					=> NULL,
				'fundCurrentDeedDate'  => $item['item_meta']['currentDeedDate'][0],
				'fundCurrentDeedNumber'  => $item['item_meta']['fundCurrentDeedNumber'][0],
				'fundPrev1DeedDate'  => $item['item_meta']['fundPrev1DeedDate'][0],
				'fundPrev2DeedDate'  => $item['item_meta']['fundPrev2DeedDate'][0],
				'fundPrev3DeedDate'  => $item['item_meta']['fundPrev3DeedDate'][0],
				'fundPrev4DeedDate'  => $item['item_meta']['fundPrev4DeedDate'][0],
				'fundPrev1DeedVarClause'  => $item['item_meta']['fundPrev1DeedVarClause'][0],
				'fundPrev2DeedVarClause'  => $item['item_meta']['fundPrev2DeedVarClause'][0],
				'fundPrev3DeedVarClause'  => $item['item_meta']['fundPrev3DeedVarClause'][0],
				'fundPrev4DeedVarClause'  => $item['item_meta']['fundPrev4DeedVarClause'][0],
				'retCorpTeeAddress' 	  => $retTrusteeCompanyRegisteredOffice,
				'newCorpTeeAddress'	  => $newTrusteeCompanyRegisteredOffice,
				'newTeeMtgAddress' => $newTrusteeMeetingAddress,
				'varRuleClause'	=> $item['item_meta']['varRuleClause'][0],
		);

        
		//$request = new WP_Http();
		//$response = $request->post($post_url, array('body' => $body));
		return $body;
}


?>