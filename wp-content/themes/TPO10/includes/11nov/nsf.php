<?php
//////////////////////////////////////////////////////////
//														//
//														//
//														//
//  NSF with Corp Trustee which was already registered. //
//														//
//														//
//														//
//////////////////////////////////////////////////////////
function nsf_corp_already_registered_post_Data($item, $order_id, $deedVersion, $constitutionVersion, $billingArray, $billingName, $billingCompany, $billing_phone, $product_id, $adviserEmail, $userID, $orderDate) {
	
		$yourRef 		= $item['item_meta']['yourRef'][0];
		
		$fundAddress = array (
			'careOf' => $item['item_meta']['fundAddressCareOf'][0],
			'levelName' => $item['item_meta']['fundAddressLevel'][0],
			'streetName' => $item['item_meta']['fundAddressStreet'][0],
			'suburbName' => $item['item_meta']['fundAddressSuburb'][0],
			'stateName' => $item['item_meta']['fundAddressState'][0],
			'postcode' => $item['item_meta']['fundAddressPostcode'][0]
			);
		
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
		
		
		
		$trusteeCompanyPrincipalPlaceBusiness = array();
		
		$trusteeCompanyId = NULL;
		
		
		
		$chairmanSwitch = $item['item_meta']['chairmanTrustee'][0];
		
		$t = $item['item_meta']['numMembers'][0];
		
		if ($t == 1) {
		$chairmanSwitch = "Director 1";
		}
				// $to = 'tim@justsuper.com.au';
				 // $subject = 'Chairman';
				 // $message = 'Chairman Switch: '.print_r($chairmanSwitch, true).' Number of members: '.$t;
				 // wp_mail( $to, $subject, $message);
		
		
		switch ($chairmanSwitch) {
		case "Director 1":
			//$chairmanName = $item['item_meta']['m1MemberGivenNames'][0].' '.$item['item_meta']['m1MemberFamilyName'][0];
			$isTrusteeOneChairman = 1;
			$isPersonOneChairman = 0;
			$isTrusteeTwoChairman = 0;
			$isTrusteeThreeChairman = 0;
			$isTrusteeFourChairman = 0;
			break;
			
		case "Director 2":
				if ($t == '1'){
					//$chairmanName = $item['item_meta']['m2MemberGivenNames'][0].' '.$item['item_meta']['m2MemberFamilyName'][0];
					$isTrusteeOneChairman = 0;
					$isPersonOneChairman = 1;
					$isTrusteeTwoChairman = 0;
					$isTrusteeThreeChairman = 0;
					$isTrusteeFourChairman = 0;
				}
				else {
					//$chairmanName = $item['item_meta']['t2NonMemberGivenNames'][0].' '.$item['item_meta']['t2NonMemberFamilyName'][0];
					$isTrusteeOneChairman = 0;
					$isPersonOneChairman = 0;
					$isTrusteeTwoChairman = 1;
					$isTrusteeThreeChairman = 0;
					$isTrusteeFourChairman = 0;
				}
				break;
		
		case "Director 3":
			//$chairmanName = $item['item_meta']['m3MemberGivenNames'][0].' '.$item['item_meta']['m3MemberFamilyName'][0];
			$isTrusteeOneChairman = 0;
			$isPersonOneChairman = 0;
			$isTrusteeTwoChairman = 0;
			$isTrusteeThreeChairman = 1;
			$isTrusteeFourChairman = 0;
			break;
			
		case "Director 4":
			//$chairmanName = $item['item_meta']['m4MemberGivenNames'][0].' '.$item['item_meta']['m4MemberFamilyName'][0];
			$isTrusteeOneChairman = 0;
			$isPersonOneChairman = 0;
			$isTrusteeTwoChairman = 0;
			$isTrusteeThreeChairman = 0;
			$isTrusteeFourChairman = 1;
			break;
			
		default:
			//$chairmanName = NULL;
			$isTrusteeOneChairman = 0;
			$isPersonOneChairman = 0;
			$isTrusteeTwoChairman = 0;
			$isTrusteeThreeChairman = 0;
			$isTrusteeFourChairman = 0;
		}
		
		//Corporate Trustee Address
		$corpTeeAddress = $item['item_meta']['corpTeeAddressSameAsFund'][0];
		switch ($corpTeeAddress){
		case "Same as Fund Address":
			$trusteeCompanyRegisteredOffice = $fundAddress;
			break;

		case "Other Address":
			$trusteeCompanyRegisteredOffice = array(
			
				'careOf' => $item['item_meta']['corpTeeAddressCareOf'][0],
				'levelName' => $item['item_meta']['corpTeeAddressLevel'][0],
				'streetName' => $item['item_meta']['corpTeeAddressStreet'][0], 
				'suburbName' => $item['item_meta']['corpTeeAddressSuburb'][0],
				'stateName' => $item['item_meta']['corpTeeAddressState'][0],
				'postcode' => $item['item_meta']['corpTeeAddressPostcode'][0]
			
			);
			break;
		default: 
			$trusteeCompanyRegisteredOffice = NULL;
		}
		
		//M1 Address
		$m1sw = $item['item_meta']['m1MemberAddressSameAsFund'][0];
		switch ($m1sw) {
		case "Same as Fund Address":
			$m1Address = $fundAddress;
			break;

		case "Other Address":
			$m1Address = array(
			'careOf' => NULL,
			'levelName' => $item['item_meta']['m1AddressLevel'][0],
			'streetName' => $item['item_meta']['m1AddressStreet'][0],
			'suburbName' => $item['item_meta']['m1AddressSuburb'][0],
			'stateName' => $item['item_meta']['m1AddressState'][0],
			'postcode' => $item['item_meta']['m1AddressPostcode'][0]
			);
			break;
		default:
			$m1Address = NULL;
		}
		
		//M2 Address
		$m2sw = $item['item_meta']['m2MemberAddressSameAsFund'][0];
		switch ($m2sw) {
		case "Same as Fund Address":
			$m2Address = $fundAddress;
			break;
		
		case "Same as Member 1 Address":
			$m2Address = $m1Address;
			break;
			
		case "Other Address":
			$m2Address = array(
			'careOf' => NULL,
			'levelName' => $item['item_meta']['m2AddressLevel'][0],
			'streetName' => $item['item_meta']['m2AddressStreet'][0],
			'suburbName' => $item['item_meta']['m2AddressSuburb'][0],
			'stateName' => $item['item_meta']['m2AddressState'][0],
			'postcode' => $item['item_meta']['m2AddressPostcode'][0]
			);
			break;
		default:
			$m2Address = NULL;
		}
		
		//M3 Address
		$m3sw = $item['item_meta']['m3MemberAddressSameAsFund'][0];
		switch ($m3sw) {
		case "Same as Fund Address":
			$m3Address = $fundAddress;
			break;
		
		case "Same as Member 1 Address":
			$m3Address = $m1Address;
			break;
		
		case "Same as Member 2 Address":
			$m3Address = $m2Address;
			break;
		
		case "Other Address":
			$m3Address = array(
			'careOf' => NULL,
			'levelName' => $item['item_meta']['m3AddressLevel'][0],
			'streetName' => $item['item_meta']['m3AddressStreet'][0],
			'suburbName' => $item['item_meta']['m3AddressSuburb'][0],
			'stateName' => $item['item_meta']['m3AddressState'][0],
			'postcode' => $item['item_meta']['m3AddressPostcode'][0]
			);
			break;
		default:
			$m3Address = NULL;
		}
		
		//M4 Address
		$m4sw = $item['item_meta']['m4MemberAddressSameAsFund'][0];
		switch ($m4sw) {
		case "Same as Fund Address":
			$m4Address = $fundAddress;
			break;

		case "Same as Member 1 Address":
			$m4Address = $m1Address;
			break;
		
		case "Same as Member 2 Address":
			$m4Address = $m2Address;
			break;
		
		case "Same as Member 3 Address":
			$m4Address = $m3Address;
			break;
		
		case "Other Address":
			$m4Address = array(
			'careOf' => NULL,
			'levelName' => $item['item_meta']['m4AddressLevel'][0],
			'streetName' => $item['item_meta']['m4AddressStreet'][0],
			'suburbName' => $item['item_meta']['m4AddressSuburb'][0],
			'stateName' => $item['item_meta']['m4AddressState'][0],
			'postcode' => $item['item_meta']['m4AddressPostcode'][0]
			);
			break;
		default:
			$m4Address = NULL;
		}
		
		//Non-Member Director Address
		$p1sw = $item['item_meta']['d2NonMemberAddressSameAsFund'][0];
		switch ($p1sw) {
		case "Same as Fund Address":
			$nonMemberDirectorDetailsAddress = $fundAddress;
			break;
			
		case "Same as Member 1 Address":
			$nonMemberDirectorDetailsAddress = $m1Address;
			break;
		
		case "Other Address":
			$nonMemberDirectorDetailsAddress = array(
			'careOf' => NULL,
			'levelName' => $item['item_meta']['d2NonMemberAddressLevel'][0],
			'streetName' => $item['item_meta']['d2NonMemberAddressStreet'][0],
			'suburbName' => $item['item_meta']['d2NonMemberAddressSuburb'][0],
			'stateName' => $item['item_meta']['d2NonMemberAddressState'][0],
			'postcode' => $item['item_meta']['d2NonMemberAddressPostcode'][0]
			);
			break;
		default:
			$nonMemberDirectorDetailsAddress = NULL;
		}
		
		if(!is_Null($item['item_meta']['m1MemberDOB'][0])) {
			$m1dob = $item['item_meta']['m1MemberDOB'][0];
		}
		else {
			$m1dob = NULL;
		}

		if(!is_Null($item['item_meta']['m2MemberDOB'][0])) {
			$m2dob = $item['item_meta']['m2MemberDOB'][0];
		}
		else {
			$m2dob = NULL;
		}
		
		
		if(!is_Null($item['item_meta']['m3MemberDOB'][0])) {
			$m3dob = $item['item_meta']['m3MemberDOB'][0];
		}
		else {
			$m3dob = NULL;
		}
		
		if(!is_Null($item['item_meta']['m4MemberDOB'][0])) {
			$m4dob = $item['item_meta']['m4MemberDOB'][0];
		}
		else {
			$m4dob = NULL;
		}
		
		$m1details = array(	
			'memberNamePrefix' => $item['item_meta']['m1MemberNamePrefix'][0],
			'memberGivenNames' => $item['item_meta']['m1MemberGivenNames'][0],
			'memberFamilyName' => $item['item_meta']['m1MemberFamilyName'][0],
			'memberFormerGivenNames' => NULL,
			'memberFormerFamilyName' => NULL,
			'memberChangedName' => NULL,
			'memberTFN' => $item['item_meta']['m1MemberTFN'][0],
			'memberDOB' => $m1dob,
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
			'isDirector' => 1,
			'isTrustee' => 0,
			'isChairman' => $isTrusteeOneChairman,
			'isMember' => 1,
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
			'memberResidential' => $m1Address,
			'addPtyType'		=> NULL
		);
		
		//print_r(array_values($m1details));
		
		
		$m2details = array(
			'memberNamePrefix' => $item['item_meta']['m2MemberNamePrefix'][0],
			'memberGivenNames' => $item['item_meta']['m2MemberGivenNames'][0],
			'memberFamilyName' => $item['item_meta']['m2MemberFamilyName'][0],
			'memberFormerGivenNames' => NULL,
			'memberFormerFamilyName' => NULL,
			'memberChangedName' => NULL,
			'memberTFN' => $item['item_meta']['m2MemberTFN'][0],
			'memberDOB' => $m2dob,
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
			'isDirector' => 1,
			'isTrustee' => 0,
			'isChairman' => $isTrusteeTwoChairman,
			'isMember' => 1,
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
			'memberResidential' => $m2Address,
			'addPtyType'		=> NULL
		);
		
		$m3details = array(
			'memberNamePrefix' => $item['item_meta']['m3MemberNamePrefix'][0],
			'memberGivenNames' => $item['item_meta']['m3MemberGivenNames'][0],
			'memberFamilyName' => $item['item_meta']['m3MemberFamilyName'][0],
			'memberFormerGivenNames' => NULL,
			'memberFormerFamilyName' => NULL,
			'memberChangedName' => NULL,
			'memberTFN' => $item['item_meta']['m3MemberTFN'][0],
			'memberDOB' => $m3dob,
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
			'isDirector' => 1,
			'isTrustee' => 0,
			'isChairman' => $isTrusteeThreeChairman,
			'isMember' => 1,
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
			'memberResidential' => $m3Address,
			'addPtyType'		=> NULL
		);
		
		$m4details = array(
			'memberNamePrefix' => $item['item_meta']['m4MemberNamePrefix'][0],
			'memberGivenNames' => $item['item_meta']['m4MemberGivenNames'][0],
			'memberFamilyName' => $item['item_meta']['m4MemberFamilyName'][0],
			'memberFormerGivenNames' => NULL,
			'memberFormerFamilyName' => NULL,
			'memberChangedName' => NULL,
			'memberTFN' => $item['item_meta']['m4MemberTFN'][0],
			'memberDOB' => $m4dob,
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
			'isDirector' => 1,
			'isTrustee' => 0,
			'isChairman' => $isTrusteeFourChairman,
			'isMember' => 1,
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
			'memberResidential' => $m4Address,
			'addPtyType'		=> NULL
		);
		
		$nonMemberDirectorDetails = array(
			'memberNamePrefix' => $item['item_meta']['d2NonMemberNamePrefix'][0],
			'memberGivenNames' => $item['item_meta']['d2NonMemberGivenNames'][0],
			'memberFamilyName' => $item['item_meta']['d2NonMemberFamilyName'][0],
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
			'isDirector' => 1,
			'isTrustee' => 0,
			'isChairman' => $isPersonOneChairman,
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
			'memberResidential' => $nonMemberDirectorDetailsAddress,
			'addPtyType'		=> NULL
		);
		
		$p1details = NULL;
		
		$p2details = NULL;
		
		$p3details = NULL;
		
		$p4details = NULL;
		
		$t = $item['item_meta']['numMembers'][0];
		
		
		switch ($t) {
		
			case '1':
				//only one individual trustee, need to add non-member details as trustee.
				$m2details = NULL;
				$m3details = NULL;
				$m4details = NULL;
				//if $hasNonMemberDirector
				if($item['item_meta']['hasNonMemberAsD2'][0] == 'Yes'){
				$p1details = $m1details;
				$p2details = $nonMemberDirectorDetails;
				$p3details = NULL;
				$p4details = NULL;
				$numDirectors  = 2;
				}
				else {
				//else
				$p1details = $m1details;
				$p2details = NULL;
				$p3details = NULL;
				$p4details = NULL;
				$numDirectors  = 1;
				}
				
				break;
			case '2':
				//more than one individual trustee, so each member is a trustee.
				$m3details = NULL;
				$m4details = NULL;
				
				$p1details = $m1details;
				$p2details = $m2details;
				$p3details = NULL;
				$p4details = NULL;
				$numDirectors  = 2;
				
				break;
			case '3':
				//more than one individual trustee, so each member is a trustee.
				$m4details = NULL;
				
				$p1details = $m1details;
				$p2details = $m2details;
				$p3details = $m3details;
				$p4details = NULL;
				$numDirectors  = 3;
				
				break;
			case '4':
				//more than one individual trustee, so each member is a trustee.
				$p1details = $m1details;
				$p2details = $m2details;
				$p3details = $m3details;
				$p4details = $m4details;
				$numDirectors  = 4;
				break;
		}
		
		$trusteeCorpArray = array (
		
			'companyName' => $item['item_meta']['corpTeeName'][0],
			'companySuffix' => '',
			'companyACN' => $item['item_meta']['corpTeeACN'][0],
			'registeredOffice' => $trusteeCompanyRegisteredOffice,
			'D1Details' => $p1details,
			'D2Details' => $p2details,
			'D3Details' => $p3details,
			'D4Details' => $p4details
		
		);
		
		
		//This will be populated once moved to jigo-shop.
		$adviserAddress = array(
			'levelName' => NULL,
			'streetName' => '',
			'suburbName' => '',
			'stateName' => '',
			'postcode' => ''
		);
		
		$body= array( 
			'fundName' => $item['item_meta']['fundName'][0],
			'fundPreviousName' => NULL,
			'fundState' => $item['item_meta']['fundState'][0],
			'fundAddress' => $fundAddress,
			'isPostalDifferent' => NULL,
			'fundPostalAddress' => NULL,
			'isTrusteeMeetingElsewhere' => NULL,
			'trusteeMeetingAddress' => NULL,
			'trusteeType' => 'C',
			'trusteeIndiv' => NULL,
			'trusteeCompany' => $trusteeCorpArray,
			'corporateTrustee' => NULL,
			'hasCompany' => 0,
			'companyCode' => NULL,
			'establishmentDate' => NULL,
			'fundABN' => NULL,
			'corporateTrusteeAcn' => NULL,
			'numDirectors' => $numDirectors,
			'numMembers' => $item['item_meta']['numMembers'][0],
			'M1Details' => $m1details,
			'M2Details' => $m2details,
			'M3Details' => $m3details,
			'M4Details' => $m4details,
			'person1Detail' => $p1details,
			'person2Detail' => $p2details,
			'person3Detail' => $p3details,
			'person4Detail' => $p4details,
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
			'deedVersion' => $deedVersion,
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
			'publicOfficer'	=> NULL,
			'orderServiceType' 	=> $item['item_meta']['Service Type'][0]
			

		);

        
		//$request = new WP_Http();
		//$response = $request->post($post_url, array('body' => $body));
		return $body;
}

//////////////////////////////////////////////////////////
//														//
//														//
//														//
// 			 New Fund with Individual Trustees 			//
//														//
//														//
//														//
//////////////////////////////////////////////////////////

function nsf_individual_post_Data($item, $order_id, $deedVersion, $constitutionVersion, $billingArray, $billingName, $billingCompany, $billing_phone, $product_id, $adviserEmail, $userID, $orderDate) {
		
		
		$yourRef 		= $item['item_meta']['yourRef'][0];
		
		$fundAddress = array (
			'careOf' => NULL,
			'levelName' => $item['item_meta']['fundAddressLevel'][0],
			'streetName' => $item['item_meta']['fundAddressStreet'][0],
			'suburbName' => $item['item_meta']['fundAddressSuburb'][0],
			'stateName' => $item['item_meta']['fundAddressState'][0],
			'postcode' => $item['item_meta']['fundAddressPostcode'][0]
			);
		
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
		
		$trusteeCompanyRegisteredOffice = array();
		
		$trusteeCompanyPrincipalPlaceBusiness = array();
		
		$trusteeCompanyId = NULL;
		
		$chairmanSwitch = $item['item_meta']['chairmanTrustee'][0];
		
		$t = $item['item_meta']['numMembers'][0];
		
				// $to = 'tim@justsuper.com.au';
				 // $subject = 'Chairman';
				 // $message = 'Chairman Switch: '.print_r($chairmanSwitch, true).' Number of members: '.$t;
				 // wp_mail( $to, $subject, $message);
		
		
		switch ($chairmanSwitch) {
		case "Trustee 1":
			//$chairmanName = $item['item_meta']['m1MemberGivenNames'][0].' '.$item['item_meta']['m1MemberFamilyName'][0];
			$isTrusteeOneChairman = 1;
			$isPersonOneChairman = 0;
			$isTrusteeTwoChairman = 0;
			$isTrusteeThreeChairman = 0;
			$isTrusteeFourChairman = 0;
			break;
			
		case "Trustee 2":
				if ($t == '1'){
					//$chairmanName = $item['item_meta']['m2MemberGivenNames'][0].' '.$item['item_meta']['m2MemberFamilyName'][0];
					$isTrusteeOneChairman = 0;
					$isPersonOneChairman = 1;
					$isTrusteeTwoChairman = 0;
					$isTrusteeThreeChairman = 0;
					$isTrusteeFourChairman = 0;
				}
				else {
					//$chairmanName = $item['item_meta']['t2NonMemberGivenNames'][0].' '.$item['item_meta']['t2NonMemberFamilyName'][0];
					$isTrusteeOneChairman = 0;
					$isPersonOneChairman = 0;
					$isTrusteeTwoChairman = 1;
					$isTrusteeThreeChairman = 0;
					$isTrusteeFourChairman = 0;
				}
				break;
		
		case "Trustee 3":
			//$chairmanName = $item['item_meta']['m3MemberGivenNames'][0].' '.$item['item_meta']['m3MemberFamilyName'][0];
			$isTrusteeOneChairman = 0;
			$isPersonOneChairman = 0;
			$isTrusteeTwoChairman = 0;
			$isTrusteeThreeChairman = 1;
			$isTrusteeFourChairman = 0;
			break;
			
		case "Trustee 4":
			//$chairmanName = $item['item_meta']['m4MemberGivenNames'][0].' '.$item['item_meta']['m4MemberFamilyName'][0];
			$isTrusteeOneChairman = 0;
			$isPersonOneChairman = 0;
			$isTrusteeTwoChairman = 0;
			$isTrusteeThreeChairman = 0;
			$isTrusteeFourChairman = 1;
			break;
		default:
			//$chairmanName = NULL;
			$isTrusteeOneChairman = 'x';
			$isPersonOneChairman = 'x';
			$isTrusteeTwoChairman = 'x';
			$isTrusteeThreeChairman = 'x';
			$isTrusteeFourChairman = 'x';
			
		}
		
		
	
		
		
		//M1 Address
		$m1sw = $item['item_meta']['m1MemberAddressSameAsFund'][0];
		switch ($m1sw) {
		case "Same as Fund Address":
			$m1Address = $fundAddress;
			break;

		case "Other Address":
			$m1Address = array(
			'careOf' => NULL,
			'levelName' => $item['item_meta']['m1AddressLevel'][0],
			'streetName' => $item['item_meta']['m1AddressStreet'][0],
			'suburbName' => $item['item_meta']['m1AddressSuburb'][0],
			'stateName' => $item['item_meta']['m1AddressState'][0],
			'postcode' => $item['item_meta']['m1AddressPostcode'][0]
			);
			break;
		default:
			$m1Address = NULL;
		}
		
		//M2 Address
		$m2sw = $item['item_meta']['m2MemberAddressSameAsFund'][0];
		switch ($m2sw) {
		case "Same as Fund Address":
			$m2Address = $fundAddress;
			break;
			  
		case "Same as Member 1 Address":
			$m2Address = $m1Address;
			break;

		case "Other Address":
			$m2Address = array(
			'careOf' => NULL,
			'levelName' => $item['item_meta']['m2AddressLevel'][0],
			'streetName' => $item['item_meta']['m2AddressStreet'][0],
			'suburbName' => $item['item_meta']['m2AddressSuburb'][0],
			'stateName' => $item['item_meta']['m2AddressState'][0],
			'postcode' => $item['item_meta']['m2AddressPostcode'][0]
			);
			break;
		default:
			$m2Address = NULL;
		}
		
		//M3 Address
		$m3sw = $item['item_meta']['m3MemberAddressSameAsFund'][0];
		switch ($m3sw) {
		case "Same as Fund Address":
			$m3Address = $fundAddress;
			break;

		case "Same as Member 1 Address":
			$m3Address = $m1Address;
			break;
			
		case "Same as Member 2 Address":
			$m3Address = $m2Address;
			break;
		
		case "Other Address":
			$m3Address = array(
			'careOf' => NULL,
			'levelName' => $item['item_meta']['m3AddressLevel'][0],
			'streetName' => $item['item_meta']['m3AddressStreet'][0],
			'suburbName' => $item['item_meta']['m3AddressSuburb'][0],
			'stateName' => $item['item_meta']['m3AddressState'][0],
			'postcode' => $item['item_meta']['m3AddressPostcode'][0]
			);
			break;
		default:
			$m3Address = NULL;
		}
		
		//M4 Address
		$m4sw = $item['item_meta']['m4MemberAddressSameAsFund'][0];
		switch ($m4sw) {
		case "Same as Fund Address":
			$m4Address = $fundAddress;
			break;

		case "Same as Member 1 Address":
			$m4Address = $m1Address;
			break;
			
		case "Same as Member 2 Address":
			$m4Address = $m2Address;
			break;	
		
		case "Same as Member 3 Address":
			$m4Address = $m3Address;
			break;
		
		case "Other Address":
			$m4Address = array(
			'careOf' => NULL,
			'levelName' => $item['item_meta']['m4AddressLevel'][0],
			'streetName' => $item['item_meta']['m4AddressStreet'][0],
			'suburbName' => $item['item_meta']['m4AddressSuburb'][0],
			'stateName' => $item['item_meta']['m4AddressState'][0],
			'postcode' => $item['item_meta']['m4AddressPostcode'][0]
			);
			break;
		default:
			$m4Address = NULL;
		}
		
		//P1 Address
		$p1sw = $item['item_meta']['t2NonMemberAddressSameAsFund'][0];
		switch ($p1sw) {
		case "Same as Fund Address":
			$p1Address = $fundAddress;
			break;
		
		case "Same as Member 1 Address":
			$p1Address = $m1Address;
			break;		

		case "Other Address":
			if(!is_null($item['item_meta']['t2NonMemberAddressLevel'][0])){
			$t2nonMemberLevel = $item['item_meta']['t2NonMemberAddressLevel'][0];
			}
			else {
			$t2nonMemberLevel = NULL;
			}
			$p1Address = array(
			'careOf' => NULL,
			'levelName' => $t2nonMemberLevel,
			'streetName' => $item['item_meta']['t2NonMemberAddressStreet'][0],
			'suburbName' => $item['item_meta']['t2NonMemberAddressSuburb'][0],
			'stateName' => $item['item_meta']['t2NonMemberAddressState'][0],
			'postcode' => $item['item_meta']['t2NonMemberAddressPostcode'][0]
			);
			break;
		default:
			$p1Address = NULL;
		}
		
		if(!is_Null($item['item_meta']['m1MemberDOB'][0])) {
			$m1dob = $item['item_meta']['m1MemberDOB'][0];
		}
		else {
			$m1dob = NULL;
		}
		
		if(!is_Null($item['item_meta']['m2MemberDOB'][0])) {
			$m2dob = $item['item_meta']['m2MemberDOB'][0];
		}
		else {
			$m2dob = NULL;
		}
		
		if(!is_Null($item['item_meta']['m3MemberDOB'][0])) {
			$m3dob = $item['item_meta']['m3MemberDOB'][0];
		}
		else {
			$m3dob = NULL;
		}
		
		if(!is_Null($item['item_meta']['m4MemberDOB'][0])) {
			$m4dob = $item['item_meta']['m4MemberDOB'][0];
		}
		else {
			$m4dob = NULL;
		}
		
		
		$m1details = array(	
			'memberNamePrefix' => $item['item_meta']['m1MemberNamePrefix'][0],
			'memberGivenNames' => $item['item_meta']['m1MemberGivenNames'][0],
			'memberFamilyName' => $item['item_meta']['m1MemberFamilyName'][0],
			'memberFormerGivenNames' => NULL,
			'memberFormerFamilyName' => NULL,
			'memberChangedName' => NULL,
			'memberTFN' => $item['item_meta']['m1MemberTFN'][0],
			'memberDOB' => $m1dob,
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
			'isDirector' => NULL,
			'isTrustee' => 1,
			'isChairman' => $isTrusteeOneChairman,
			'isMember' => 1,
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
			'memberResidential' => $m1Address,
			'addPtyType'		=> NULL			
		);
		
		//print_r(array_values($m1details));
		
		
		$m2details = array(
			'memberNamePrefix' => $item['item_meta']['m2MemberNamePrefix'][0],
			'memberGivenNames' => $item['item_meta']['m2MemberGivenNames'][0],
			'memberFamilyName' => $item['item_meta']['m2MemberFamilyName'][0],
			'memberFormerGivenNames' => NULL,
			'memberFormerFamilyName' => NULL,
			'memberChangedName' => NULL,
			'memberTFN' => $item['item_meta']['m2MemberTFN'][0],
			'memberDOB' => $m2dob,
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
			'isDirector' => NULL,
			'isTrustee' => 1,
			'isChairman' => $isTrusteeTwoChairman,
			'isMember' => 1,
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
			'memberResidential' => $m2Address,
			'addPtyType'		=> NULL
		);
		
		$m3details = array(
			'memberNamePrefix' => $item['item_meta']['m3MemberNamePrefix'][0],
			'memberGivenNames' => $item['item_meta']['m3MemberGivenNames'][0],
			'memberFamilyName' => $item['item_meta']['m3MemberFamilyName'][0],
			'memberFormerGivenNames' => NULL,
			'memberFormerFamilyName' => NULL,
			'memberChangedName' => NULL,
			'memberTFN' => $item['item_meta']['m3MemberTFN'][0],
			'memberDOB' => $m3dob,
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
			'isDirector' => NULL,
			'isTrustee' => 1,
			'isChairman' => $isTrusteeThreeChairman,
			'isMember' => 1,
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
			'memberResidential' => $m3Address,
			'addPtyType'		=> NULL
		);
		
		$m4details = array(
			'memberNamePrefix' => $item['item_meta']['m4MemberNamePrefix'][0],
			'memberGivenNames' => $item['item_meta']['m4MemberGivenNames'][0],
			'memberFamilyName' => $item['item_meta']['m4MemberFamilyName'][0],
			'memberFormerGivenNames' => NULL,
			'memberFormerFamilyName' => NULL,
			'memberChangedName' => NULL,
			'memberTFN' => $item['item_meta']['m4MemberTFN'][0],
			'memberDOB' => $m4dob,
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
			'isDirector' => NULL,
			'isTrustee' => 1,
			'isChairman' => $isTrusteeFourChairman,
			'isMember' => 1,
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
			'memberResidential' => $m4Address,
			'addPtyType'		=> NULL
		);
		
		$p1details = array(
			'memberNamePrefix' => $item['item_meta']['t2NonMemberNamePrefix'][0],
			'memberGivenNames' => $item['item_meta']['t2NonMemberGivenNames'][0],
			'memberFamilyName' => $item['item_meta']['t2NonMemberFamilyName'][0],
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
			'isDirector' => NULL,
			'isTrustee' => 1,
			'isChairman' => $isPersonOneChairman,
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
			'memberResidential' => $p1Address,
			'addPtyType'		=> NULL
		);
		
		$p2details = NULL;
		
		$p3details = NULL;
		
		$p4details = NULL;
		
		$t = $item['item_meta']['numMembers'][0];
		
		
		switch ($t) {
		
			case '1':
				//only one individual trustee, need to add non-member details as trustee.
				$m2details = NULL;
				$m3details = NULL;
				$m4details = NULL;
				
				$trusteeIndiv = array(
					'T1Details' => $m1details,
					'isT1M1' => 1,
					'T2Details' => $p1details,
					'isT2M2' => 0,
					'isT2P1' => 1,
					'T3Details' => NULL,
					'isT3M3' => 0,
					'T4Details' => NULL,
					'isT4M4' => 0
														
				);
				//var_dump($trusteeIndiv);
				break;
			case '2':
				//more than one individual trustee, so each member is a trustee.
				$m3details = NULL;
				$m4details = NULL;
				$p1details = NULL;
				
				$trusteeIndiv = array(
					'T1Details' => $m1details,
					'isT1M1' => 1,
					'T2Details' => $m2details,
					'isT2M2' => 1,
					'isT2P1' => 0,
					'T3Details' => NULL,
					'isT3M3' => 0,
					'T4Details' => NULL,
					'isT4M4' => 0
				);
				break;
			case '3':
				//more than one individual trustee, so each member is a trustee.
				$m4details = NULL;
				$p1details = NULL;
				
				$trusteeIndiv = array(
					'T1Details' => $m1details,
					'isT1M1' => 1,
					'T2Details' => $m2details,
					'isT2M2' => 1,
					'isT2P1' => 0,
					'T3Details' => $m3details,
					'isT3M3' => 1,
					'T4Details' => NULL,
					'isT4M4' => 0
				);
				break;
			case '4':
				//more than one individual trustee, so each member is a trustee.
				$p1details = NULL;
				$trusteeIndiv = array(
					'T1Details' => $m1details,
					'isT1M1' => 1,
					'T2Details' => $m2details,
					'isT2M2' => 1,
					'isT2P1' => 0,
					'T3Details' => $m3details,
					'isT3M3' => 1,
					'T4Details' => $m4details,
					'isT4M4' => 1
				);			
				break;
		}
		
		//This will be populated once moved to jigo-shop.
		$adviserAddress = array(
			'levelName' => NULL,
			'streetName' => '',
			'suburbName' => '',
			'stateName' => '',
			'postcode' => ''
		);
		
		$body= array( 
			'fundName' => $item['item_meta']['fundName'][0],
			'fundPreviousName' => NULL,
			'fundState' => $item['item_meta']['fundState'][0],
			'fundAddress' => $fundAddress,
			'isPostalDifferent' => NULL,
			'fundPostalAddress' => NULL,
			'isTrusteeMeetingElsewhere' => NULL,
			'trusteeMeetingAddress' => NULL,
			'trusteeType' => 'I',
			'trusteeIndiv' => $trusteeIndiv,
			'trusteeCompany' => NULL,
			'corporateTrustee' => NULL,
			'hasCompany' => NULL,
			'companyCode' => NULL,
			'establishmentDate' => NULL,
			'fundABN' => NULL,
			'corporateTrusteeAcn' => NULL,
			'numDirectors' => NULL,
			'numMembers' => $item['item_meta']['numMembers'][0],
			'M1Details' => $m1details,
			'M2Details' => $m2details,
			'M3Details' => $m3details,
			'M4Details' => $m4details,
			'person1Detail' => $p1details,
			'person2Detail' => $p2details,
			'person3Detail' => $p3details,
			'person4Detail' => $p4details,
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
			'deedVersion' => $deedVersion,
			'constitutionVersion' => $constitutionVersion,
			'orderNumber' => $order_id,
			'hasInvStrat' => 0,
			'hasBDBN'	  => 0,
			'hasNBDBN'	  => 0,
			'userID'	  => $userID,
			'productID'	  => $product_id,
			'chairman'	  => $chairmanTrustee,
			'adviserEmail' => $adviserEmail,
			'orderDate'	  => $orderDate,
			'apIndivOne' => NULL,
			'apIndivTwo' => NULL,
			'apCompany' => NULL,
			'numVariations' => NULL,
			'yourRef'			=> $yourRef,
			'publicOfficer'	=> NULL,
			'orderServiceType' 	=> $item['item_meta']['Service Type'][0]
			

		);

        
		//$request = new WP_Http();
		//$response = $request->post($post_url, array('body' => $body));
		return $body;
}


//////////////////////////////////////////////////////////
//														//
//														//
//														//
//			  NSF & Company Registration. 				//
//														//
//														//
//														//
//////////////////////////////////////////////////////////
function nsf_and_corp_post_data($item, $order_id, $deedVersion, $constitutionVersion, $billingArray, $billingName, $billingCompany, $billing_phone, $product_id, $adviserEmail, $userID, $orderDate) {
	
		$yourRef 		= $item['item_meta']['yourRef'][0];
		
		$fundAddress = array (
			'careOf' => $item['item_meta']['fundAddressCareOf'][0],
			'levelName' => $item['item_meta']['fundAddressLevel'][0],
			'streetName' => $item['item_meta']['fundAddressStreet'][0],
			'suburbName' => $item['item_meta']['fundAddressSuburb'][0],
			'stateName' => $item['item_meta']['fundAddressState'][0],
			'postcode' => $item['item_meta']['fundAddressPostcode'][0]
			);
		
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
		
		
		
		$trusteeCompanyPrincipalPlaceBusiness = array();
		
		$trusteeCompanyId = NULL;
		
		
		
		$chairmanSwitch = $item['item_meta']['chairmanTrustee'][0];
		
		$t = $item['item_meta']['numMembers'][0];
		
		if ($t == 1) {
		$chairmanSwitch = "Director 1";
		}
				// $to = 'tim@justsuper.com.au';
				 // $subject = 'Chairman';
				 // $message = 'Chairman Switch: '.print_r($chairmanSwitch, true).' Number of members: '.$t;
				 // wp_mail( $to, $subject, $message);
		
		
		switch ($chairmanSwitch) {
		case "Director 1":
			//$chairmanName = $item['item_meta']['m1MemberGivenNames'][0].' '.$item['item_meta']['m1MemberFamilyName'][0];
			$isTrusteeOneChairman = 1;
			$isPersonOneChairman = 0;
			$isTrusteeTwoChairman = 0;
			$isTrusteeThreeChairman = 0;
			$isTrusteeFourChairman = 0;
			break;
			
		case "Director 2":
				if ($t == '1'){
					//$chairmanName = $item['item_meta']['m2MemberGivenNames'][0].' '.$item['item_meta']['m2MemberFamilyName'][0];
					$isTrusteeOneChairman = 0;
					$isPersonOneChairman = 1;
					$isTrusteeTwoChairman = 0;
					$isTrusteeThreeChairman = 0;
					$isTrusteeFourChairman = 0;
				}
				else {
					//$chairmanName = $item['item_meta']['t2NonMemberGivenNames'][0].' '.$item['item_meta']['t2NonMemberFamilyName'][0];
					$isTrusteeOneChairman = 0;
					$isPersonOneChairman = 0;
					$isTrusteeTwoChairman = 1;
					$isTrusteeThreeChairman = 0;
					$isTrusteeFourChairman = 0;
				}
				break;
		
		case "Director 3":
			//$chairmanName = $item['item_meta']['m3MemberGivenNames'][0].' '.$item['item_meta']['m3MemberFamilyName'][0];
			$isTrusteeOneChairman = 0;
			$isPersonOneChairman = 0;
			$isTrusteeTwoChairman = 0;
			$isTrusteeThreeChairman = 1;
			$isTrusteeFourChairman = 0;
			break;
			
		case "Director 4":
			//$chairmanName = $item['item_meta']['m4MemberGivenNames'][0].' '.$item['item_meta']['m4MemberFamilyName'][0];
			$isTrusteeOneChairman = 0;
			$isPersonOneChairman = 0;
			$isTrusteeTwoChairman = 0;
			$isTrusteeThreeChairman = 0;
			$isTrusteeFourChairman = 1;
			break;
			
		default:
			//$chairmanName = NULL;
			$isTrusteeOneChairman = 0;
			$isPersonOneChairman = 0;
			$isTrusteeTwoChairman = 0;
			$isTrusteeThreeChairman = 0;
			$isTrusteeFourChairman = 0;
		}
		
		
		//publicOfficer
		
			$isTrusteeOnePublicOfficer = 0;
			$isPersonOnePublicOfficer = 0;
			$isTrusteeTwoPublicOfficer = 0;
			$isTrusteeThreePublicOfficer = 0;
			$isTrusteeFourPublicOfficer = 0;
		// $publicOfficerSwitch = $item['item_meta']['publicOfficerTrustee'][0];
		// if ($t == 1) {
			// $publicOfficerSwitch = "Director 1";
		// }
				// // $to = 'tim@justsuper.com.au';
				 // // $subject = 'Chairman';
				 // // $message = 'Chairman Switch: '.print_r($chairmanSwitch, true).' Number of members: '.$t;
				 // // wp_mail( $to, $subject, $message);
		
		
		// switch ($publicOfficerSwitch) {
		// case "Director 1":
			
				// $isTrusteeOnePublicOfficer = 1;
				// $isPersonOnePublicOfficer = 0;
				// $isTrusteeTwoPublicOfficer = 0;
				// $isTrusteeThreePublicOfficer = 0;
				// $isTrusteeFourPublicOfficer = 0;
				// break;
			
		// case "Director 2":
				// if ($t == '1'){
					// //$chairmanName = $item['item_meta']['m2MemberGivenNames'][0].' '.$item['item_meta']['m2MemberFamilyName'][0];
					// $isTrusteeOnePublicOfficer = 0;
					// $isPersonOnePublicOfficer = 1;
					// $isTrusteeTwoPublicOfficer = 0;
					// $isTrusteeThreePublicOfficer = 0;
					// $isTrusteeFourPublicOfficer = 0;
				// }
				// else {
					// //$chairmanName = $item['item_meta']['t2NonMemberGivenNames'][0].' '.$item['item_meta']['t2NonMemberFamilyName'][0];
					// $isTrusteeOnePublicOfficer = 0;
					// $isPersonOnePublicOfficer = 0;
					// $isTrusteeTwoPublicOfficer = 1;
					// $isTrusteeThreePublicOfficer = 0;
					// $isTrusteeFourPublicOfficer = 0;
				// }
				// break;
		
		// case "Director 3":
			// //$chairmanName = $item['item_meta']['m3MemberGivenNames'][0].' '.$item['item_meta']['m3MemberFamilyName'][0];
					// $isTrusteeOnePublicOfficer = 0;
					// $isPersonOnePublicOfficer = 0;
					// $isTrusteeTwoPublicOfficer = 0;
					// $isTrusteeThreePublicOfficer = 1;
					// $isTrusteeFourPublicOfficer = 0;
			// break;
			
		// case "Director 4":
			// //$chairmanName = $item['item_meta']['m4MemberGivenNames'][0].' '.$item['item_meta']['m4MemberFamilyName'][0];
					// $isTrusteeOnePublicOfficer = 0;
					// $isPersonOnePublicOfficer = 0;
					// $isTrusteeTwoPublicOfficer = 0;
					// $isTrusteeThreePublicOfficer = 0;
					// $isTrusteeFourPublicOfficer = 1;
			// break;
			
		// default:
			// //$chairmanName = NULL;
					// $isTrusteeOnePublicOfficer = 0;
					// $isPersonOnePublicOfficer = 0;
					// $isTrusteeTwoPublicOfficer = 0;
					// $isTrusteeThreePublicOfficer = 0;
					// $isTrusteeFourPublicOfficer = 0;
		// }
		
		
		//Corporate Trustee Address
		$corpTeeAddress = $item['item_meta']['corpTeeAddressSameAsFund'][0];
		switch ($corpTeeAddress){
		case "Same as Fund Address":
			$trusteeCompanyRegisteredOffice = $fundAddress;
			break;

		case "Other Address":
			$trusteeCompanyRegisteredOffice = array(
			
				'careOf' => $item['item_meta']['corpTeeAddressCareOf'][0],
				'levelName' => $item['item_meta']['corpTeeAddressLevel'][0],
				'streetName' => $item['item_meta']['corpTeeAddressStreet'][0], 
				'suburbName' => $item['item_meta']['corpTeeAddressSuburb'][0],
				'stateName' => $item['item_meta']['corpTeeAddressState'][0],
				'postcode' => $item['item_meta']['corpTeeAddressPostcode'][0]
			
			);
			break;
		default: 
			$trusteeCompanyRegisteredOffice = NULL;
		}
		
		//M1 Address
		$m1sw = $item['item_meta']['m1MemberAddressSameAsFund'][0];
		switch ($m1sw) {
		case "Same as Fund Address":
			$m1Address = $fundAddress;
			break;

		case "Other Address":
			$m1Address = array(
			'careOf' => $item['item_meta']['m1AddressCareOf'][0],
			'levelName' => $item['item_meta']['m1AddressLevel'][0],
			'streetName' => $item['item_meta']['m1AddressStreet'][0],
			'suburbName' => $item['item_meta']['m1AddressSuburb'][0],
			'stateName' => $item['item_meta']['m1AddressState'][0],
			'postcode' => $item['item_meta']['m1AddressPostcode'][0]
			);
			break;
		default:
			$m1Address = NULL;
		}
		
		//M2 Address
		$m2sw = $item['item_meta']['m2MemberAddressSameAsFund'][0];
		switch ($m2sw) {
		case "Same as Fund Address":
			$m2Address = $fundAddress;
			break;
		
		case "Same as Member 1 Address":
			$m2Address = $m1Address;
			break;
		
		case "Other Address":
			$m2Address = array(
			'careOf' => $item['item_meta']['m2AddressCareOf'][0],
			'levelName' => $item['item_meta']['m2AddressLevel'][0],
			'streetName' => $item['item_meta']['m2AddressStreet'][0],
			'suburbName' => $item['item_meta']['m2AddressSuburb'][0],
			'stateName' => $item['item_meta']['m2AddressState'][0],
			'postcode' => $item['item_meta']['m2AddressPostcode'][0]
			);
			break;
		default:
			$m2Address = NULL;
		}
		
		//M3 Address
		$m3sw = $item['item_meta']['m3MemberAddressSameAsFund'][0];
		switch ($m3sw) {
		case "Same as Fund Address":
			$m3Address = $fundAddress;
			break;

		case "Same as Member 1 Address":
			$m3Address = $m1Address;
			break;	
		
		case "Same as Member 2 Address":
			$m3Address = $m2Address;
			break;
		
		case "Other Address":
			$m3Address = array(
			'careOf' => $item['item_meta']['m3AddressCareOf'][0],
			'levelName' => $item['item_meta']['m3AddressLevel'][0],
			'streetName' => $item['item_meta']['m3AddressStreet'][0],
			'suburbName' => $item['item_meta']['m3AddressSuburb'][0],
			'stateName' => $item['item_meta']['m3AddressState'][0],
			'postcode' => $item['item_meta']['m3AddressPostcode'][0]
			);
			break;
		default:
			$m3Address = NULL;
		}
		
		//M4 Address
		$m4sw = $item['item_meta']['m4MemberAddressSameAsFund'][0];
		switch ($m4sw) {
		case "Same as Fund Address":
			$m4Address = $fundAddress;
			break;
		
		case "Same as Member 1 Address":
			$m4Address = $m1Address;
			break;	
		
		case "Same as Member 2 Address":
			$m4Address = $m2Address;
			break;
		
		case "Same as Member 3 Address":
			$m4Address = $m3Address;
			break;
		
		case "Other Address":
			$m4Address = array(
			'careOf' => $item['item_meta']['m4AddressCareOf'][0],
			'levelName' => $item['item_meta']['m4AddressLevel'][0],
			'streetName' => $item['item_meta']['m4AddressStreet'][0],
			'suburbName' => $item['item_meta']['m4AddressSuburb'][0],
			'stateName' => $item['item_meta']['m4AddressState'][0],
			'postcode' => $item['item_meta']['m4AddressPostcode'][0]
			);
			break;
		default:
			$m4Address = NULL;
		}
		
		//Non-Member Director Address
		$p1sw = $item['item_meta']['d2NonMemberAddressSameAsFund'][0];
		switch ($p1sw) {
		case "Same as Fund Address":
			$nonMemberDirectorDetailsAddress = $fundAddress;
			break;

		case "Same as Member 1 Address":
			$nonMemberDirectorDetailsAddress = $m1Address;
			break;		
			
		case "Other Address":
			$nonMemberDirectorDetailsAddress = array(
			'careOf' => $item['item_meta']['d2NonMemberAddressCareOf'][0],
			'levelName' => $item['item_meta']['d2NonMemberAddressLevel'][0],
			'streetName' => $item['item_meta']['d2NonMemberAddressStreet'][0],
			'suburbName' => $item['item_meta']['d2NonMemberAddressSuburb'][0],
			'stateName' => $item['item_meta']['d2NonMemberAddressState'][0],
			'postcode' => $item['item_meta']['d2NonMemberAddressPostcode'][0]
			);
			break;
		default:
			$nonMemberDirectorDetailsAddress = NULL;
		}
		
		
		//Applicant Address
		$appsw = $item['item_meta']['applicantAddressSameAsFund'][0];
		switch ($appsw) {
		case "Same as Fund Address":
			$applicantAddress = $fundAddress;
			break;

		case "Other Address":
			$applicantAddress = array(
			'careOf' => $item['item_meta']['applicantAddressCareOf'][0],
			'levelName' => $item['item_meta']['applicantAddressLevel'][0],
			'streetName' => $item['item_meta']['applicantAddressStreet'][0],
			'suburbName' => $item['item_meta']['applicantAddressSuburb'][0],
			'stateName' => $item['item_meta']['applicantAddressState'][0],
			'postcode' => $item['item_meta']['applicantAddressPostcode'][0]
			);
			break;
		default:
			$applicantAddress = NULL;
		}
		
		if(!is_Null($item['item_meta']['m1MemberDOB'][0])) {
			$m1dob = $item['item_meta']['m1MemberDOB'][0];
		}
		else {
			$m1dob = NULL;
		}

		if(!is_Null($item['item_meta']['m2MemberDOB'][0])) {
			$m2dob = $item['item_meta']['m2MemberDOB'][0];
		}
		else {
			$m2dob = NULL;
		}
		
		
		if(!is_Null($item['item_meta']['m3MemberDOB'][0])) {
			$m3dob = $item['item_meta']['m3MemberDOB'][0];
		}
		else {
			$m3dob = NULL;
		}
		
		if(!is_Null($item['item_meta']['m4MemberDOB'][0])) {
			$m4dob = $item['item_meta']['m4MemberDOB'][0];
		}
		else {
			$m4dob = NULL;
		}
		
		
		
		
		if($item['item_meta']['m1isSecretary'][0] == "Yes"){
			$m1isSecretary = 1;
		}
		else {
			$m1isSecretary = 0;
		}
		if($item['item_meta']['m1isShareholder'][0] == "Yes"){
			$m1isShareholder = 1;
		}
		else {
			$m1isShareholder = 0;
		}
		
		if($item['item_meta']['m2isSecretary'][0] == "Yes"){
			$m2isSecretary = 1;
		}
		else {
			$m2isSecretary = 0;
		}
		if($item['item_meta']['m2isShareholder'][0] == "Yes"){
			$m2isShareholder = 1;
		}
		else {
			$m2isShareholder = 0;
		}
		
		if($item['item_meta']['m3isSecretary'][0] == "Yes"){
			$m3isSecretary = 1;
		}
		else {
			$m3isSecretary = 0;
		}
		if($item['item_meta']['m3isShareholder'][0] == "Yes"){
			$m3isShareholder = 1;
		}
		else {
			$m3isShareholder = 0;
		}
		
		if($item['item_meta']['m4isSecretary'][0] == "Yes"){
			$m4isSecretary = 1;
		}
		else {
			$m4isSecretary = 0;
		}
		if($item['item_meta']['m4isShareholder'][0] == "Yes"){
			$m4isShareholder = 1;
		}
		else {
			$m4isShareholder = 0;
		}
		
		if($item['item_meta']['d2NonMemberisSecretary'][0] == "Yes"){
			$d2NonMemberisSecretary = 1;
		}
		else {
			$d2NonMemberisSecretary = 0;
		}
		if($item['item_meta']['d2NonMemberisShareholder'][0] == "Yes"){
			$d2NonMemberisShareholder = 1;
		}
		else {
			$d2NonMemberisShareholder = 0;
		}
		
		$m1TownOfBirth = $item['item_meta']['m1CityOfBirth'][0];
		$m1StateOfBirth = $item['item_meta']['m1StateOfBirth'][0];
		$m1CountryOfBirth = $item['item_meta']['m1CountryOfBirth'][0];
		
		
		If ($m1StateOfBirth == "Other - International") {
			$m1StateOfBirth = NULL;
		}
		else {
			$m1CountryOfBirth = "Australia";
		}
		
		
		$m1details = array(	
			'memberNamePrefix' => $item['item_meta']['m1MemberNamePrefix'][0],
			'memberGivenNames' => $item['item_meta']['m1MemberGivenNames'][0],
			'memberFamilyName' => $item['item_meta']['m1MemberFamilyName'][0],
			'memberFormerGivenNames' => NULL,
			'memberFormerFamilyName' => NULL,
			'memberChangedName' => NULL,
			'memberTFN' => $item['item_meta']['m1MemberTFN'][0],
			'memberDOB' => $m1dob,
			'memberGender' => NULL,
			'memberTownOfBirth' => $m1TownOfBirth,
			'memberStateOfBirth' => $m1StateOfBirth,
			'memberCountryOfBirth' => $m1CountryOfBirth,
			'memberOccupation' => NULL,
			'isCompany' => NULL,
			'companyname' => NULL,
			'hasacn' => NULL,
			'acn' => NULL,
			'companyrep1' => NULL,
			'companyrep2' => NULL,
			'companyrep3' => NULL,
			'companyrep4' => NULL,
			'isDirector' => 1,
			'isTrustee' => 0,
			'isChairman' => $isTrusteeOneChairman,
			'isMember' => 1,
			'isSecretary' => $m1isSecretary,
			'isPublicOfficer' => $isTrusteeOnePublicOfficer,
			'isShareHolder' => $m1isShareholder,
			'classOfShares' => $item['item_meta']['m1ShareClass'][0],
			'numShares' => $item['item_meta']['m1NumShares'][0],
			'benOwned' => 1,
			'benName' => '',
			'memberDateJoined' => NULL,
			'memberDateLeft' => NULL,
			'memberAccountDesc' => NULL,
			'memberResidential' => $m1Address,
			'addPtyType'		=> NULL
		);
		
		
				 
		//print_r(array_values($m1details));
		
		$m2TownOfBirth = $item['item_meta']['m2CityOfBirth'][0];
		$m2StateOfBirth = $item['item_meta']['m2StateOfBirth'][0];
		$m2CountryOfBirth = $item['item_meta']['m2CountryOfBirth'][0];
		
		If ($m2StateOfBirth == "Other - International") {
			$m2StateOfBirth = NULL;
		}
		else {
			$m2CountryOfBirth = "Australia";
		}
		
		$m2details = array(
			'memberNamePrefix' => $item['item_meta']['m2MemberNamePrefix'][0],
			'memberGivenNames' => $item['item_meta']['m2MemberGivenNames'][0],
			'memberFamilyName' => $item['item_meta']['m2MemberFamilyName'][0],
			'memberFormerGivenNames' => NULL,
			'memberFormerFamilyName' => NULL,
			'memberChangedName' => NULL,
			'memberTFN' => $item['item_meta']['m2MemberTFN'][0],
			'memberDOB' => $m2dob,
			'memberGender' => NULL,
			'memberTownOfBirth' => $m2TownOfBirth,
			'memberStateOfBirth' => $m2StateOfBirth,
			'memberCountryOfBirth' => $m2CountryOfBirth,
			'memberOccupation' => NULL,
			'isCompany' => NULL,
			'companyname' => NULL,
			'hasacn' => NULL,
			'acn' => NULL,
			'companyrep1' => NULL,
			'companyrep2' => NULL,
			'companyrep3' => NULL,
			'companyrep4' => NULL,
			'isDirector' => 1,
			'isTrustee' => 0,
			'isChairman' => $isTrusteeTwoChairman,
			'isMember' => 1,
			'isSecretary' => $m2isSecretary,
			'isPublicOfficer' => $isTrusteeTwoPublicOfficer,
			'isShareHolder' => $m2isShareholder,
			'classOfShares' => $item['item_meta']['m2ShareClass'][0],
			'numShares' => $item['item_meta']['m2NumShares'][0],
			'benOwned' => 1,
			'benName' => '',
			'memberDateJoined' => NULL,
			'memberDateLeft' => NULL,
			'memberAccountDesc' => NULL,
			'memberResidential' => $m2Address,
			'addPtyType'		=> NULL
		);
		
		
		$m3TownOfBirth = $item['item_meta']['m3CityOfBirth'][0];
		$m3StateOfBirth = $item['item_meta']['m3StateOfBirth'][0];
		$m3CountryOfBirth = $item['item_meta']['m3CountryOfBirth'][0];
		
		If ($m3StateOfBirth == "Other - International") {
			$m3StateOfBirth = NULL;
		}
		else {
			$m3CountryOfBirth = "Australia";
		}
		
		$m3details = array(
			'memberNamePrefix' => $item['item_meta']['m3MemberNamePrefix'][0],
			'memberGivenNames' => $item['item_meta']['m3MemberGivenNames'][0],
			'memberFamilyName' => $item['item_meta']['m3MemberFamilyName'][0],
			'memberFormerGivenNames' => NULL,
			'memberFormerFamilyName' => NULL,
			'memberChangedName' => NULL,
			'memberTFN' => $item['item_meta']['m3MemberTFN'][0],
			'memberDOB' => $m3dob,
			'memberGender' => NULL,
			'memberTownOfBirth' => $m3TownOfBirth,
			'memberStateOfBirth' => $m3StateOfBirth,
			'memberCountryOfBirth' => $m3CountryOfBirth,
			'memberOccupation' => NULL,
			'isCompany' => NULL,
			'companyname' => NULL,
			'hasacn' => NULL,
			'acn' => NULL,
			'companyrep1' => NULL,
			'companyrep2' => NULL,
			'companyrep3' => NULL,
			'companyrep4' => NULL,
			'isDirector' => 1,
			'isTrustee' => 0,
			'isChairman' => $isTrusteeThreeChairman,
			'isMember' => 1,
			'isSecretary' => $m3isSecretary,
			'isPublicOfficer' => $isTrusteeThreePublicOfficer,
			'isShareHolder' => $m3isShareholder,
			'classOfShares' => $item['item_meta']['m3ShareClass'][0],
			'numShares' => $item['item_meta']['m3NumShares'][0],
			'benOwned' => 1,
			'benName' => '',
			'memberDateJoined' => NULL,
			'memberDateLeft' => NULL,
			'memberAccountDesc' => NULL,
			'memberResidential' => $m3Address,
			'addPtyType'		=> NULL
		);
		
		$m4TownOfBirth = $item['item_meta']['m4CityOfBirth'][0];
		$m4StateOfBirth = $item['item_meta']['m4StateOfBirth'][0];
		$m4CountryOfBirth = $item['item_meta']['m4CountryOfBirth'][0];
		
		If ($m4StateOfBirth == "Other - International") {
			$m4StateOfBirth = NULL;
		}
		else {
			$m4CountryOfBirth = "Australia";
		}
		
		$m4details = array(
			'memberNamePrefix' => $item['item_meta']['m4MemberNamePrefix'][0],
			'memberGivenNames' => $item['item_meta']['m4MemberGivenNames'][0],
			'memberFamilyName' => $item['item_meta']['m4MemberFamilyName'][0],
			'memberFormerGivenNames' => NULL,
			'memberFormerFamilyName' => NULL,
			'memberChangedName' => NULL,
			'memberTFN' => $item['item_meta']['m4MemberTFN'][0],
			'memberDOB' => $m4dob,
			'memberGender' => NULL,
			'memberTownOfBirth' => $m4TownOfBirth,
			'memberStateOfBirth' => $m4StateOfBirth,
			'memberCountryOfBirth' => $m4CountryOfBirth,
			'memberOccupation' => NULL,
			'isCompany' => NULL,
			'companyname' => NULL,
			'hasacn' => NULL,
			'acn' => NULL,
			'companyrep1' => NULL,
			'companyrep2' => NULL,
			'companyrep3' => NULL,
			'companyrep4' => NULL,
			'isDirector' => 1,
			'isTrustee' => 0,
			'isChairman' => $isTrusteeFourChairman,
			'isMember' => 1,
			'isSecretary' => $m4isSecretary,
			'isPublicOfficer' => $isTrusteeFourPublicOfficer,
			'isShareHolder' => $m4isShareholder,
			'classOfShares' => $item['item_meta']['m4ShareClass'][0],
			'numShares' => $item['item_meta']['m4NumShares'][0],
			'benOwned' => 1,
			'benName' => '',
			'memberDateJoined' => NULL,
			'memberDateLeft' => NULL,
			'memberAccountDesc' => NULL,
			'memberResidential' => $m4Address,
			'addPtyType'		=> NULL
		);
		
		
		$d2NonMemberTownOfBirth = $item['item_meta']['d2NonMemberCityOfBirth'][0];
		$d2NonMemberStateOfBirth = $item['item_meta']['d2NonMemberStateOfBirth'][0];
		$d2NonMemberCountryOfBirth = $item['item_meta']['d2NonMemberCountryOfBirth'][0];
		
		
		If ($d2NonMemberStateOfBirth == "Other - International") {
			$d2NonMemberStateOfBirth = NULL;
		}
		else {
			$d2NonMemberCountryOfBirth = "Australia";
		}		
				 
		$nonMemberDirectorDetails = array(
			'memberNamePrefix' => $item['item_meta']['d2NonMemberNamePrefix'][0],
			'memberGivenNames' => $item['item_meta']['d2NonMemberGivenNames'][0],
			'memberFamilyName' => $item['item_meta']['d2NonMemberFamilyName'][0],
			'memberFormerGivenNames' => NULL,
			'memberFormerFamilyName' => NULL,
			'memberChangedName' => NULL,
			'memberTFN' => NULL,
			'memberDOB' => $item['item_meta']['d2NonMemberDOB'][0],
			'memberGender' => NULL,
			'memberTownOfBirth' => $d2NonMemberTownOfBirth,
			'memberStateOfBirth' => $d2NonMemberStateOfBirth,
			'memberCountryOfBirth' => $d2NonMemberCountryOfBirth,
			'memberOccupation' => NULL,
			'isCompany' => NULL,
			'companyname' => NULL,
			'hasacn' => NULL,
			'acn' => NULL,
			'companyrep1' => NULL,
			'companyrep2' => NULL,
			'companyrep3' => NULL,
			'companyrep4' => NULL,
			'isDirector' => 1,
			'isTrustee' => 0,
			'isChairman' => $isPersonOneChairman,
			'isMember' => 0,
			'isSecretary' => $d2NonMemberisSecretary,
			'isPublicOfficer' => $isPersonOnePublicOfficer,
			'isShareHolder' => $d2NonMemberisShareholder,
			'classOfShares' => $item['item_meta']['d2NonMemberShareClass'][0],
			'numShares' => $item['item_meta']['d2NonMemberNumShares'][0],
			'benOwned' => 1,
			'benName' => '',
			'memberDateJoined' => NULL,
			'memberDateLeft' => NULL,
			'memberAccountDesc' => NULL,
			'memberResidential' => $nonMemberDirectorDetailsAddress,
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
		
		$t = $item['item_meta']['numMembers'][0];
		
		
		switch ($t) {
		
			case '1':
				//only one member , need to add non-member details as director.
				$m2details = NULL;
				$m3details = NULL;
				$m4details = NULL;
				//if $hasNonMemberDirector
				if($item['item_meta']['hasNonMemberAsD2'][0] == 'Yes'){
				$p1details = $m1details;
				$p2details = $nonMemberDirectorDetails;
				$p3details = NULL;
				$p4details = NULL;
				$numDirectors  = 2;
				}
				else {
				//else
				$p1details = $m1details;
				$p2details = NULL;
				$p3details = NULL;
				$p4details = NULL;
				$numDirectors  = 1;
				}
				
				break;
			case '2':
				//more than one member, so each member is a director.
				$m3details = NULL;
				$m4details = NULL;
				
				$p1details = $m1details;
				$p2details = $m2details;
				$p3details = NULL;
				$p4details = NULL;
				$numDirectors  = 2;
				
				break;
			case '3':
				//more than one individual trustee, so each member is a trustee.
				$m4details = NULL;
				
				$p1details = $m1details;
				$p2details = $m2details;
				$p3details = $m3details;
				$p4details = NULL;
				$numDirectors  = 3;
				
				break;
			case '4':
				//more than one individual trustee, so each member is a trustee.
				$p1details = $m1details;
				$p2details = $m2details;
				$p3details = $m3details;
				$p4details = $m4details;
				$numDirectors  = 4;
				break;
		}
		
		
				 
		$trusteeCorpArray = array (
		
			'companyName' => $item['item_meta']['corpTeeName'][0],
			'companySuffix' => $item['item_meta']['corpTeeNameSuffix'][0],
			'companyACN' => $item['item_meta']['corpTeeACN'][0],
			'registeredOffice' => $trusteeCompanyRegisteredOffice,
			'D1Details' => $p1details,
			'D2Details' => $p2details,
			'D3Details' => $p3details,
			'D4Details' => $p4details
		
		);
		
		$isSolePurposeTxt = $item['item_meta']['isSolePurpose'][0];
		if ($isSolePurposeTxt == "Yes"){
			$isSolePurposeBit = 1;
		}
		else {
			$isSolePurposeBit = 0;
		}
		
		$hasSolePurposeDecTxt = $item['item_meta']['hasSolePurposeDec'][0];
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
				 
		$nameOfOccupier = $item['item_meta']['nameOfOccupier'][0];
				 
		$newCorprateTrusteeArray = array (
				'companyName' => $item['item_meta']['corpTeeName'][0],
				'companySuffix' => $item['item_meta']['corpTeeNameSuffix'][0],
				'registeredState' => $item['item_meta']['corpTeeRegState'][0],
				'isNameReserved' => 0,
				'isIdenticalBusinessName' => 0,
				'identicalBusinessNumber' => 0,
				'identicalBusinessStates' => NULL,
				'isSolePurpose' => $isSolePurposeBit,
				'solePurposeDec' => $hasSolePurposeDecBit,
				'registeredOffice' => $trusteeCompanyRegisteredOffice,
				'isOccupyingRegOffice' => $isOccupyingRegOfficeBit,
				'occupiersName' => $nameOfOccupier,
				'occupiersConsent' => $hasOccupiersConsentBit,
				'principalPlaceBusiness' => $trusteeCompanyRegisteredOffice,
				'share_Price' => $item['item_meta']['sharePrice'][0],
				'numOfficeholders' => $numDirectors,
				'D1Details' => $p1details,
				'D2Details' => $p2details,
				'D3Details' => $p3details,
				'D4Details' => $p4details,
				'numShareholders' => $numDirectors,
				'SH1Details' => NULL,
				'SH2Details' => NULL,
				'SH3Details' => NULL,
				'SH4Details' => NULL,
				'applicant'  => $applicantDetails,
				'manualReview' => $manualReview,
		);
		
		
		//This will be populated once moved to jigo-shop.
		$adviserAddress = array(
			'levelName' => NULL,
			'streetName' => '',
			'suburbName' => '',
			'stateName' => '',
			'postcode' => ''
		);
		
		$body= array( 
			'fundName' => $item['item_meta']['fundName'][0],
			'fundPreviousName' => NULL,
			'fundState' => $item['item_meta']['fundState'][0],
			'fundAddress' => $fundAddress,
			'isPostalDifferent' => NULL,
			'fundPostalAddress' => NULL,
			'isTrusteeMeetingElsewhere' => NULL,
			'trusteeMeetingAddress' => NULL,
			'trusteeType' => 'C',
			'trusteeIndiv' => NULL,
			'trusteeCompany' => $trusteeCorpArray,
			'corporateTrustee' => $newCorprateTrusteeArray,
			'hasCompany' => 1,
			'companyCode' => NULL,
			'establishmentDate' => NULL,
			'fundABN' => NULL,
			'corporateTrusteeAcn' => NULL,
			'numDirectors' => $numDirectors,
			'numMembers' => $item['item_meta']['numMembers'][0],
			'M1Details' => $m1details,
			'M2Details' => $m2details,
			'M3Details' => $m3details,
			'M4Details' => $m4details,
			'person1Detail' => $p1details,
			'person2Detail' => $p2details,
			'person3Detail' => $p3details,
			'person4Detail' => $p4details,
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
			'deedVersion' => $deedVersion,
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