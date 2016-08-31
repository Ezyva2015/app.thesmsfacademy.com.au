<?php
//////////////////////////////////////////////////////////
//														//
//														//
//														//
//		 Deed Update with Individual Trustees 			//
//														//
//														//
//														//
//////////////////////////////////////////////////////////

function sdv_indiv_post_Data($item, $order_id, $deedVersion, $constitutionVersion, $billingArray, $billingName, $billingCompany, $billing_phone, $product_id, $adviserEmail, $userID, $orderDate) {
		
		
		$numVariations 	= $item['item_meta']['numVariations'][0];
		$addPtyType		= $item['item_meta']['additionalPartyType'][0];
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
		
		//Additional Party Address
		$apSw = $item['item_meta']['additionalPartyAddress'][0];
		switch ($apSw) {
		case "Same as Fund Address":
			$apAddress = $fundAddress;
			break;

		case "Other Address":
			$apAddress = array(
			'careOf' => NULL,
			'levelName' => $item['item_meta']['additionalPartyAddressLevel'][0],
			'streetName' => $item['item_meta']['additionalPartyAddressStreet'][0],
			'suburbName' => $item['item_meta']['additionalPartyAddressSuburb'][0],
			'stateName' => $item['item_meta']['additionalPartyAddressState'][0],
			'postcode' => $item['item_meta']['additionalPartyAddressPostcode'][0]
			);
			break;
		default:
			$apAddress = NULL;
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
			'streetName' => $item['item_meta']['m1Street'][0],
			'suburbName' => $item['item_meta']['m1Suburb'][0],
			'stateName' => $item['item_meta']['m1State'][0],
			'postcode' => $item['item_meta']['m1Postcode'][0]
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
		
		if ($item['item_meta']['hasAdditionalParty'][0] == "Yes"){
			If ($item['item_meta']['additionalPartyCoOrIndiv'][0] == "Individual"){
					$ap1details = array(	
						'memberNamePrefix' => NULL,//$item['item_meta']['m1MemberNamePrefix'][0],
						'memberGivenNames' => $item['item_meta']['additionalPartyDirOneGivenNames'][0],
						'memberFamilyName' => $item['item_meta']['additionalPartyDirOneFamilyName'][0],
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
						'isTrustee' => 0,
						'isChairman' => NULL,
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
						'memberResidential' => $apAddress,
						'addPtyType'		=> $addPtyType	
					);
					
				
					
					$ap2details = array(	
						'memberNamePrefix' => NULL,//$item['item_meta']['m1MemberNamePrefix'][0],
						'memberGivenNames' => $item['item_meta']['additionalPartyDirTwoGivenNames'][0],
						'memberFamilyName' => $item['item_meta']['additionalPartyDirTwoFamilyName'][0],
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
						'isTrustee' => 0,
						'isChairman' => NULL,
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
						'memberResidential' => $apAddress,	
						'addPtyType'		=> $addPtyType
					);
			}
			
			If ($item['item_meta']['additionalPartyCoOrIndiv'][0] == "Company"){
					
					if(!is_null($item['item_meta']['additionalPartyDirOneGivenNames'][0])){
						$apCompanyDirOne = $item['item_meta']['additionalPartyDirOneGivenNames'][0].' '.$item['item_meta']['additionalPartyDirOneFamilyName'][0];
					}
					else {
						$apCompanyDirOne = NULL;
					}
					
					if(!is_null($item['item_meta']['additionalPartyDirTwoGivenNames'][0])){
						$apCompanyDirTwo = $item['item_meta']['additionalPartyDirTwoGivenNames'][0].' '.$item['item_meta']['additionalPartyDirTwoFamilyName'][0];
					}
					else {
						$apCompanyDirTwo = NULL;
					}
					
					if(!is_null($item['item_meta']['additionalPartyDirThreeGivenNames'][0])){
						$apCompanyDirThree = $item['item_meta']['additionalPartyDirThreeGivenNames'][0].' '.$item['item_meta']['additionalPartyDirThreeFamilyName'][0];
					}
					else {
						$apCompanyDirThree = NULL;
					}
					
					if(!is_null($item['item_meta']['additionalPartyDirFourGivenNames'][0])){
						$apCompanyDirFour = $item['item_meta']['additionalPartyDirFourGivenNames'][0].' '.$item['item_meta']['additionalPartyDirFourFamilyName'][0];
					}
					else {
						$apCompanyDirFour = NULL;
					}
					
					
					$apCompanydetails = array(	
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
						'companyname' => $item['item_meta']['additionalPartyCompanyName'][0],
						'hasacn' => 1,
						'acn' => $item['item_meta']['additionalPartyCompanyAcn'][0],
						'companyrep1' => $apCompanyDirOne,
						'companyrep2' => $apCompanyDirTwo,
						'companyrep3' => $apCompanyDirThree,
						'companyrep4' => $apCompanyDirFour,
						'isDirector' => NULL,
						'isTrustee' => 0,
						'isChairman' => NULL,
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
						'memberResidential' => $apAddress,
						'addPtyType'		=> $addPtyType						
					);
				}
		}
		else {
			$ap1details 		= NULL;
			$ap2details 		= NULL;
			$apCompanydetails 	= NULL;
		
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
		
		$fundEstDate = $item['item_meta']['fundEstDate'][0];
		$currentDeedDate = $item['item_meta']['currentDeedDate'][0];
		$currentDeedVarClause = $item['item_meta']['currentDeedVarClause'][0];
		$firstVarDate = $item['item_meta']['firstVarDate'][0];
		$firstVarClause = $item['item_meta']['firstVarClause'][0];
		$secondVarDate = $item['item_meta']['secondVarDate'][0];
		$secondVarClause = $item['item_meta']['secondVarClause'][0];
		$thirdVarDate = $item['item_meta']['thirdVarDate'][0];
		$thirdVarClause = $item['item_meta']['thirdVarClause'][0];
		$fourthVarDate = $item['item_meta']['fourthVarDate'][0];
		$fourthVarClause = $item['item_meta']['fourthVarClause'][0];
		
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
			'establishmentDate' => $fundEstDate,
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
			'fundCurrentDeedDate' => $currentDeedDate,
			'fundCurrentDeedNumber' => NULL,
			'fundCurrentDeedVarClause' => $currentDeedVarClause,
			'fundPrev1DeedDate' => $firstVarDate,
			'fundPrev1DeedVarClause' => $firstVarClause,
			'fundPrev2DeedDate' => $secondVarDate,
			'fundPrev2DeedVarClause' => $secondVarClause,
			'fundPrev3DeedDate' => $thirdVarDate,
			'fundPrev3DeedVarClause' => $thirdVarClause,
			'fundPrev4DeedDate' => $fourthVarDate,
			'fundPrev4DeedVarClause' => $fourthVarClause,
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
			'apIndivOne' => $ap1details,
			'apIndivTwo' => $ap2details,
			'apCompany' => $apCompanydetails,
			'numVariations' => $numVariations,
			'yourRef'			=> $yourRef
			

		);

        
		//$request = new WP_Http();
		//$response = $request->post($post_url, array('body' => $body));
		return $body;
}


//////////////////////////////////////////////////////////
//														//
//														//
//														//
//  SDV with Corp Trustee which was already registered. //
//														//
//														//
//														//
//////////////////////////////////////////////////////////
function sdv_corp_post_Data($item, $order_id, $deedVersion, $constitutionVersion, $billingArray, $billingName, $billingCompany, $billing_phone, $product_id, $adviserEmail, $userID, $orderDate) {
		$numVariations 	= $item['item_meta']['numVariations'][0];
		$addPtyType		= $item['item_meta']['additionalPartyType'][0];
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
		
		//Additional Party Address
		$apSw = $item['item_meta']['additionalPartyAddress'][0];
		switch ($apSw) {
		case "Same as Fund Address":
			$apAddress = $fundAddress;
			break;

		case "Other Address":
			$apAddress = array(
			'careOf' => NULL,
			'levelName' => $item['item_meta']['additionalPartyAddressLevel'][0],
			'streetName' => $item['item_meta']['additionalPartyAddressStreet'][0],
			'suburbName' => $item['item_meta']['additionalPartyAddressSuburb'][0],
			'stateName' => $item['item_meta']['additionalPartyAddressState'][0],
			'postcode' => $item['item_meta']['additionalPartyAddressPostcode'][0]
			);
			break;
		default:
			$apAddress = NULL;
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
			'streetName' => $item['item_meta']['m1Street'][0],
			'suburbName' => $item['item_meta']['m1Suburb'][0],
			'stateName' => $item['item_meta']['m1State'][0],
			'postcode' => $item['item_meta']['m1Postcode'][0]
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
		
		if ($item['item_meta']['hasAdditionalParty'][0] == "Yes"){
			If ($item['item_meta']['additionalPartyCoOrIndiv'][0] == "Individual"){
					$ap1details = array(	
						'memberNamePrefix' => NULL,//$item['item_meta']['m1MemberNamePrefix'][0],
						'memberGivenNames' => $item['item_meta']['additionalPartyDirOneGivenNames'][0],
						'memberFamilyName' => $item['item_meta']['additionalPartyDirOneFamilyName'][0],
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
						'isTrustee' => 0,
						'isChairman' => NULL,
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
						'memberResidential' => $apAddress,
						'addPtyType'		=> NULL
					);
					
					$ap2details = array(	
						'memberNamePrefix' => NULL,//$item['item_meta']['m1MemberNamePrefix'][0],
						'memberGivenNames' => $item['item_meta']['additionalPartyDirTwoGivenNames'][0],
						'memberFamilyName' => $item['item_meta']['additionalPartyDirTwoFamilyName'][0],
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
						'isTrustee' => 0,
						'isChairman' => NULL,
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
						'memberResidential' => $apAddress,
						'addPtyType'		=> NULL
					);
			}
			
			If ($item['item_meta']['additionalPartyCoOrIndiv'][0] == "Company"){
					
					if(!is_null($item['item_meta']['additionalPartyDirOneGivenNames'][0])){
						$apCompanyDirOne = $item['item_meta']['additionalPartyDirOneGivenNames'][0].' '.$item['item_meta']['additionalPartyDirOneFamilyName'][0];
					}
					else {
						$apCompanyDirOne = NULL;
					}
					
					if(!is_null($item['item_meta']['additionalPartyDirTwoGivenNames'][0])){
						$apCompanyDirTwo = $item['item_meta']['additionalPartyDirTwoGivenNames'][0].' '.$item['item_meta']['additionalPartyDirTwoFamilyName'][0];
					}
					else {
						$apCompanyDirTwo = NULL;
					}
					
					if(!is_null($item['item_meta']['additionalPartyDirThreeGivenNames'][0])){
						$apCompanyDirThree = $item['item_meta']['additionalPartyDirThreeGivenNames'][0].' '.$item['item_meta']['additionalPartyDirThreeFamilyName'][0];
					}
					else {
						$apCompanyDirThree = NULL;
					}
					
					if(!is_null($item['item_meta']['additionalPartyDirFourGivenNames'][0])){
						$apCompanyDirFour = $item['item_meta']['additionalPartyDirFourGivenNames'][0].' '.$item['item_meta']['additionalPartyDirFourFamilyName'][0];
					}
					else {
						$apCompanyDirFour = NULL;
					}
					
					
					$apCompanydetails = array(	
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
						'companyname' => $item['item_meta']['additionalPartyCompanyName'][0],
						'hasacn' => 1,
						'acn' => $item['item_meta']['additionalPartyCompanyAcn'][0],
						'companyrep1' => $apCompanyDirOne,
						'companyrep2' => $apCompanyDirTwo,
						'companyrep3' => $apCompanyDirThree,
						'companyrep4' => $apCompanyDirFour,
						'isDirector' => NULL,
						'isTrustee' => 0,
						'isChairman' => NULL,
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
						'memberResidential' => $apAddress,
						'addPtyType'		=> NULL
					);
				}
		}
		else {
			$ap1details 		= NULL;
			$ap2details 		= NULL;
			$apCompanydetails 	= NULL;
		
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
		
		
		$fundEstDate = $item['item_meta']['fundEstDate'][0];
		$currentDeedDate = $item['item_meta']['currentDeedDate'][0];
		$currentDeedVarClause = $item['item_meta']['currentDeedVarClause'][0];
		$firstVarDate = $item['item_meta']['firstVarDate'][0];
		$firstVarClause = $item['item_meta']['firstVarClause'][0];
		$secondVarDate = $item['item_meta']['secondVarDate'][0];
		$secondVarClause = $item['item_meta']['secondVarClause'][0];
		$thirdVarDate = $item['item_meta']['thirdVarDate'][0];
		$thirdVarClause = $item['item_meta']['thirdVarClause'][0];
		$fourthVarDate = $item['item_meta']['fourthVarDate'][0];
		$fourthVarClause = $item['item_meta']['fourthVarClause'][0];
		
		
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
			'establishmentDate' => $fundEstDate,
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
			'fundCurrentDeedDate' => $currentDeedDate,
			'fundCurrentDeedNumber' => NULL,
			'fundCurrentDeedVarClause' => $currentDeedVarClause,
			'fundPrev1DeedDate' => $firstVarDate,
			'fundPrev1DeedVarClause' => $firstVarClause,
			'fundPrev2DeedDate' => $secondVarDate,
			'fundPrev2DeedVarClause' => $secondVarClause,
			'fundPrev3DeedDate' => $thirdVarDate,
			'fundPrev3DeedVarClause' => $thirdVarClause,
			'fundPrev4DeedDate' => $fourthVarDate,
			'fundPrev4DeedVarClause' => $fourthVarClause,
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
			'apIndivOne' => $ap1details,
			'apIndivTwo' => $ap2details,
			'apCompany' => $apCompanydetails,
			'numVariations' => $numVariations,
			'yourRef'			=> $yourRef
			

		);

        
		//$request = new WP_Http();
		//$response = $request->post($post_url, array('body' => $body));
		return $body;
}
?>