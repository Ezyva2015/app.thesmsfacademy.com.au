<?php
///////////////////////////////////////////////////////////////////////
//																	 //
//																	 //
//																	 //
//  Fixed Unit Trust with Corp Trustee which was already registered. //
//																	 //
//																	 //
//																	 //
///////////////////////////////////////////////////////////////////////
function fut_corp_already_registered_post_Data($item, $order_id, $billingArray, $billingName, $billingCompany, $billing_phone, $product_id, $adviserEmail, $userID, $orderDate) {
	
		$yourRef 		= $item['item_meta']['yourRef'][0];
		
		$trusteeMeetingAddress = array(
			'careOf' => NULL,
			'levelName' => $item['item_meta']['teeMeetingAddressLevel'][0],
			'streetName' => $item['item_meta']['teeMeetingAddressStreet'][0],
			'suburbName' => $item['item_meta']['teeMeetingAddressSuburb'][0],
			'stateName' => $item['item_meta']['teeMeetingAddressState'][0],
			'postcode' => $item['item_meta']['teeMeetingAddressPostcode'][0]
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
		
		$chairmanName = $item['item_meta']['chairman'][0];
		
			
		//Corporate Trustee Address
		$trusteeCompanyRegisteredOffice = array(
				'careOf' => $item['item_meta']['corpTeeAddressCareOf'][0],
				'levelName' => $item['item_meta']['corpTeeAddressLevel'][0],
				'streetName' => $item['item_meta']['corpTeeAddressStreet'][0], 
				'suburbName' => $item['item_meta']['corpTeeAddressSuburb'][0],
				'stateName' => $item['item_meta']['corpTeeAddressState'][0],
				'postcode' => $item['item_meta']['corpTeeAddressPostcode'][0]
			);
			
		
		
		//Unitholder 1 Address
		$uh1Address = array(
			'careOf' => NULL,
			'levelName' => $item['item_meta']['uh1AddressLevel'][0],
			'streetName' => $item['item_meta']['uh1AddressStreet'][0],
			'suburbName' => $item['item_meta']['uh1AddressSuburb'][0],
			'stateName' => $item['item_meta']['uh1AddressState'][0],
			'postcode' => $item['item_meta']['uh1AddressPostcode'][0]
		);
		
		//Unitholder 2 Address
		$uh2Address = array(
			'careOf' => NULL,
			'levelName' => $item['item_meta']['uh2AddressLevel'][0],
			'streetName' => $item['item_meta']['uh2AddressStreet'][0],
			'suburbName' => $item['item_meta']['uh2AddressSuburb'][0],
			'stateName' => $item['item_meta']['uh2AddressState'][0],
			'postcode' => $item['item_meta']['uh2AddressPostcode'][0]
		);
		
		//Unitholder 3 Address
		$uh3Address = array(
			'careOf' => NULL,
			'levelName' => $item['item_meta']['uh3AddressLevel'][0],
			'streetName' => $item['item_meta']['uh3AddressStreet'][0],
			'suburbName' => $item['item_meta']['uh3AddressSuburb'][0],
			'stateName' => $item['item_meta']['uh3AddressState'][0],
			'postcode' => $item['item_meta']['uh3AddressPostcode'][0]
		);
		
		//Unitholder 4 Address
		$uh4Address = array(
			'careOf' => NULL,
			'levelName' => $item['item_meta']['uh4AddressLevel'][0],
			'streetName' => $item['item_meta']['uh4AddressStreet'][0],
			'suburbName' => $item['item_meta']['uh4AddressSuburb'][0],
			'stateName' => $item['item_meta']['uh4AddressState'][0],
			'postcode' => $item['item_meta']['uh4AddressPostcode'][0]
		);
		
		//Director 1 Address
		$t1D1Address = array(
			'careOf' => NULL,
			'levelName' => $item['item_meta']['t1D1AddressLevel'][0],
			'streetName' => $item['item_meta']['t1D1AddressStreet'][0],
			'suburbName' => $item['item_meta']['t1D1AddressSuburb'][0],
			'stateName' => $item['item_meta']['t1D1AddressState'][0],
			'postcode' => $item['item_meta']['t1D1AddressPostcode'][0]
		);
		
		//Director 2 Address
		$t2D2Address = array(
			'careOf' => NULL,
			'levelName' => $item['item_meta']['t2D2AddressLevel'][0],
			'streetName' => $item['item_meta']['t2D2AddressStreet'][0],
			'suburbName' => $item['item_meta']['t2D2AddressSuburb'][0],
			'stateName' => $item['item_meta']['t2D2AddressState'][0],
			'postcode' => $item['item_meta']['t2D2AddressPostcode'][0]
		);
		
		//Director 3 Address
		$t3D3Address = array(
			'careOf' => NULL,
			'levelName' => $item['item_meta']['t3D3AddressLevel'][0],
			'streetName' => $item['item_meta']['t3D3AddressStreet'][0],
			'suburbName' => $item['item_meta']['t3D3AddressSuburb'][0],
			'stateName' => $item['item_meta']['t3D3AddressState'][0],
			'postcode' => $item['item_meta']['t3D3AddressPostcode'][0]
		);
		
		//Director 4 Address
		$t4D4Address = array(
			'careOf' => NULL,
			'levelName' => $item['item_meta']['t4D4AddressLevel'][0],
			'streetName' => $item['item_meta']['t4D4AddressStreet'][0],
			'suburbName' => $item['item_meta']['t4D4AddressSuburb'][0],
			'stateName' => $item['item_meta']['t4D4AddressState'][0],
			'postcode' => $item['item_meta']['t4D4AddressPostcode'][0]
		);
		
		if(!is_Null($item['item_meta']['uh1DOB'][0])) {
			$uh1dob = $item['item_meta']['uh1DOB'][0];
		}
		else {
			$uh1dob = NULL;
		}
		
		if(!is_Null($item['item_meta']['uh2DOB'][0])) {
			$uh2dob = $item['item_meta']['uh2DOB'][0];
		}
		else {
			$uh2dob = NULL;
		}
		
		if(!is_Null($item['item_meta']['uh3DOB'][0])) {
			$uh3dob = $item['item_meta']['uh3DOB'][0];
		}
		else {
			$uh3dob = NULL;
		}
		
		if(!is_Null($item['item_meta']['uh4DOB'][0])) {
			$uh4dob = $item['item_meta']['uh4DOB'][0];
		}
		else {
			$uh4dob = NULL;
		}
		
		//Unitholder 1 Details
		if($item['item_meta']['uh1Type'] == 'Individual'){
				$uh1details = array(	
					'memberNamePrefix' => $item['item_meta']['uh1Title'][0],
					'memberGivenNames' => $item['item_meta']['uh1GivenNames'][0],
					'memberFamilyName' => $item['item_meta']['uh1FamilyName'][0],
					'memberFormerGivenNames' => NULL,
					'memberFormerFamilyName' => NULL,
					'memberChangedName' => NULL,
					'memberTFN' => NULL,
					'memberDOB' => $uh1dob,
					'memberGender' => NULL,
					'memberTownOfBirth' => NULL,
					'memberStateOfBirth' => NULL,
					'memberCountryOfBirth' => NULL,
					'memberOccupation' => NULL,
					'isCompany' => 0,
					'companyname' => $item['item_meta']['uh1CoName'][0],
					'hasacn' => NULL,
					'acn' => $item['item_meta']['uh1CoAcn'][0],
					'companyrep1' => NULL,
					'companyrep2' => NULL,
					'companyrep3' => NULL,
					'companyrep4' => NULL,
					'isDirector' => 0,
					'isTrustee' => 0,
					'isChairman' => 0,
					'isMember' => 1,
					'isSecretary' => NULL,
					'isPublicOfficer' => NULL,
					'isShareHolder' => 1,
					'classOfShares' => $item['item_meta']['uh1UnitType'][0],
					'numShares' => $item['item_meta']['uh1NumberUnits'][0],
					'benOwned' => NULL,
					'benName' => NULL,
					'memberDateJoined' => NULL,
					'memberDateLeft' => NULL,
					'memberAccountDesc' => NULL,
					'memberResidential' => $uh1Address,
					'addPtyType'		=> NULL
				);
		}
		else {
			$uh1details = array(	
					'memberNamePrefix' => NULL,
					'memberGivenNames' => '*COMPANY UNITHOLDER*',
					'memberFamilyName' => NULL,
					'memberFormerGivenNames' => NULL,
					'memberFormerFamilyName' => NULL,
					'memberChangedName' => NULL,
					'memberTFN' => NULL,
					'memberDOB' => $uh1dob,
					'memberGender' => NULL,
					'memberTownOfBirth' => NULL,
					'memberStateOfBirth' => NULL,
					'memberCountryOfBirth' => NULL,
					'memberOccupation' => NULL,
					'isCompany' => 1,
					'companyname' => $item['item_meta']['uh1CoName'][0],
					'hasacn' => NULL,
					'acn' => $item['item_meta']['uh1CoAcn'][0],
					'companyrep1' => NULL,
					'companyrep2' => NULL,
					'companyrep3' => NULL,
					'companyrep4' => NULL,
					'isDirector' => 0,
					'isTrustee' => 0,
					'isChairman' => 0,
					'isMember' => 1,
					'isSecretary' => NULL,
					'isPublicOfficer' => NULL,
					'isShareHolder' => 1,
					'classOfShares' => $item['item_meta']['uh1UnitType'][0],
					'numShares' => $item['item_meta']['uh1NumberUnits'][0],
					'benOwned' => NULL,
					'benName' => NULL,
					'memberDateJoined' => NULL,
					'memberDateLeft' => NULL,
					'memberAccountDesc' => NULL,
					'memberResidential' => $uh1Address,
					'addPtyType'		=> NULL
				);
		}
		
		//Unitholder 2 Details
		if($item['item_meta']['uh2Type'] == 'Individual'){
			$uh2details = array(	
				'memberNamePrefix' => NULL,
				'memberGivenNames' => '*COMPANY UNITHOLDER*',
				'memberFamilyName' => NULL,
				'memberFormerGivenNames' => NULL,
				'memberFormerFamilyName' => NULL,
				'memberChangedName' => NULL,
				'memberTFN' => NULL,
				'memberDOB' => $uh2dob,
				'memberGender' => NULL,
				'memberTownOfBirth' => NULL,
				'memberStateOfBirth' => NULL,
				'memberCountryOfBirth' => NULL,
				'memberOccupation' => NULL,
				'isCompany' => 0,
				'companyname' => $item['item_meta']['uh2CoName'][0],
				'hasacn' => NULL,
				'acn' => $item['item_meta']['uh2CoAcn'][0],
				'companyrep1' => NULL,
				'companyrep2' => NULL,
				'companyrep3' => NULL,
				'companyrep4' => NULL,
				'isDirector' => 0,
				'isTrustee' => 0,
				'isChairman' => 0,
				'isMember' => 1,
				'isSecretary' => NULL,
				'isPublicOfficer' => NULL,
				'isShareHolder' => 1,
				'classOfShares' => $item['item_meta']['uh2UnitType'][0],
				'numShares' => $item['item_meta']['uh2NumberUnits'][0],
				'benOwned' => NULL,
				'benName' => NULL,
				'memberDateJoined' => NULL,
				'memberDateLeft' => NULL,
				'memberAccountDesc' => NULL,
				'memberResidential' => $uh2Address,
				'addPtyType'		=> NULL
			);
		}
		else {
			$uh2details = array(	
				'memberNamePrefix' => $item['item_meta']['uh2Title'][0],
				'memberGivenNames' => $item['item_meta']['uh2GivenNames'][0],
				'memberFamilyName' => $item['item_meta']['uh2FamilyName'][0],
				'memberFormerGivenNames' => NULL,
				'memberFormerFamilyName' => NULL,
				'memberChangedName' => NULL,
				'memberTFN' => NULL,
				'memberDOB' => $uh2dob,
				'memberGender' => NULL,
				'memberTownOfBirth' => NULL,
				'memberStateOfBirth' => NULL,
				'memberCountryOfBirth' => NULL,
				'memberOccupation' => NULL,
				'isCompany' => 1,
				'companyname' => $item['item_meta']['uh2CoName'][0],
				'hasacn' => NULL,
				'acn' => $item['item_meta']['uh2CoAcn'][0],
				'companyrep1' => NULL,
				'companyrep2' => NULL,
				'companyrep3' => NULL,
				'companyrep4' => NULL,
				'isDirector' => 0,
				'isTrustee' => 0,
				'isChairman' => 0,
				'isMember' => 1,
				'isSecretary' => NULL,
				'isPublicOfficer' => NULL,
				'isShareHolder' => 1,
				'classOfShares' => $item['item_meta']['uh2UnitType'][0],
				'numShares' => $item['item_meta']['uh2NumberUnits'][0],
				'benOwned' => NULL,
				'benName' => NULL,
				'memberDateJoined' => NULL,
				'memberDateLeft' => NULL,
				'memberAccountDesc' => NULL,
				'memberResidential' => $uh2Address,
				'addPtyType'		=> NULL
			);
		
		}
		
		//Unitholder 3 Details
		if($item['item_meta']['uh3ype'] == 'Individual'){
			$uh3details = array(	
				'memberNamePrefix' => $item['item_meta']['uh3Title'][0],
				'memberGivenNames' => $item['item_meta']['uh3GivenNames'][0],
				'memberFamilyName' => $item['item_meta']['uh3FamilyName'][0],
				'memberFormerGivenNames' => NULL,
				'memberFormerFamilyName' => NULL,
				'memberChangedName' => NULL,
				'memberTFN' => NULL,
				'memberDOB' => $uh3dob,
				'memberGender' => NULL,
				'memberTownOfBirth' => NULL,
				'memberStateOfBirth' => NULL,
				'memberCountryOfBirth' => NULL,
				'memberOccupation' => NULL,
				'isCompany' => 0,
				'companyname' => $item['item_meta']['uh3CoName'][0],
				'hasacn' => NULL,
				'acn' => $item['item_meta']['uh3CoAcn'][0],
				'companyrep1' => NULL,
				'companyrep2' => NULL,
				'companyrep3' => NULL,
				'companyrep4' => NULL,
				'isDirector' => 0,
				'isTrustee' => 0,
				'isChairman' => 0,
				'isMember' => 1,
				'isSecretary' => NULL,
				'isPublicOfficer' => NULL,
				'isShareHolder' => 1,
				'classOfShares' => $item['item_meta']['uh3UnitType'][0],
				'numShares' => $item['item_meta']['uh3NumberUnits'][0],
				'benOwned' => NULL,
				'benName' => NULL,
				'memberDateJoined' => NULL,
				'memberDateLeft' => NULL,
				'memberAccountDesc' => NULL,
				'memberResidential' => $uh3Address,
				'addPtyType'		=> NULL
			);
		}
		else{
			$uh3details = array(	
				'memberNamePrefix' => NULL,
				'memberGivenNames' => '*COMPANY UNITHOLDER*',
				'memberFamilyName' => NULL,
				'memberFormerGivenNames' => NULL,
				'memberFormerFamilyName' => NULL,
				'memberChangedName' => NULL,
				'memberTFN' => NULL,
				'memberDOB' => $uh3dob,
				'memberGender' => NULL,
				'memberTownOfBirth' => NULL,
				'memberStateOfBirth' => NULL,
				'memberCountryOfBirth' => NULL,
				'memberOccupation' => NULL,
				'isCompany' => 1,
				'companyname' => $item['item_meta']['uh3CoName'][0],
				'hasacn' => NULL,
				'acn' => $item['item_meta']['uh3CoAcn'][0],
				'companyrep1' => NULL,
				'companyrep2' => NULL,
				'companyrep3' => NULL,
				'companyrep4' => NULL,
				'isDirector' => 0,
				'isTrustee' => 0,
				'isChairman' => 0,
				'isMember' => 1,
				'isSecretary' => NULL,
				'isPublicOfficer' => NULL,
				'isShareHolder' => 1,
				'classOfShares' => $item['item_meta']['uh3UnitType'][0],
				'numShares' => $item['item_meta']['uh3NumberUnits'][0],
				'benOwned' => NULL,
				'benName' => NULL,
				'memberDateJoined' => NULL,
				'memberDateLeft' => NULL,
				'memberAccountDesc' => NULL,
				'memberResidential' => $uh3Address,
				'addPtyType'		=> NULL
			);

		}
		
		//Unitholder 4 Details
		if($item['item_meta']['uh4ype'] == 'Individual'){
			$uh4details = array(	
				'memberNamePrefix' => $item['item_meta']['uh4Title'][0],
				'memberGivenNames' => $item['item_meta']['uh4GivenNames'][0],
				'memberFamilyName' => $item['item_meta']['uh4FamilyName'][0],
				'memberFormerGivenNames' => NULL,
				'memberFormerFamilyName' => NULL,
				'memberChangedName' => NULL,
				'memberTFN' => NULL,
				'memberDOB' => $uh4dob,
				'memberGender' => NULL,
				'memberTownOfBirth' => NULL,
				'memberStateOfBirth' => NULL,
				'memberCountryOfBirth' => NULL,
				'memberOccupation' => NULL,
				'isCompany' => 0,
				'companyname' => $item['item_meta']['uh4CoName'][0],
				'hasacn' => NULL,
				'acn' => $item['item_meta']['uh4CoAcn'][0],
				'companyrep1' => NULL,
				'companyrep2' => NULL,
				'companyrep3' => NULL,
				'companyrep4' => NULL,
				'isDirector' => 0,
				'isTrustee' => 0,
				'isChairman' => 0,
				'isMember' => 1,
				'isSecretary' => NULL,
				'isPublicOfficer' => NULL,
				'isShareHolder' => 1,
				'classOfShares' => $item['item_meta']['uh4UnitType'][0],
				'numShares' => $item['item_meta']['uh4NumberUnits'][0],
				'benOwned' => NULL,
				'benName' => NULL,
				'memberDateJoined' => NULL,
				'memberDateLeft' => NULL,
				'memberAccountDesc' => NULL,
				'memberResidential' => $uh4Address,
				'addPtyType'		=> NULL
			);
		}	
		else{
			$uh4details = array(	
			'memberNamePrefix' => NULL,
			'memberGivenNames' => '*COMPANY UNITHOLDER*',
			'memberFamilyName' => NULL,
			'memberFormerGivenNames' => NULL,
			'memberFormerFamilyName' => NULL,
			'memberChangedName' => NULL,
			'memberTFN' => NULL,
			'memberDOB' => $uh4dob,
			'memberGender' => NULL,
			'memberTownOfBirth' => NULL,
			'memberStateOfBirth' => NULL,
			'memberCountryOfBirth' => NULL,
			'memberOccupation' => NULL,
			'isCompany' => 1,
			'companyname' => $item['item_meta']['uh4CoName'][0],
			'hasacn' => NULL,
			'acn' => $item['item_meta']['uh4CoAcn'][0],
			'companyrep1' => NULL,
			'companyrep2' => NULL,
			'companyrep3' => NULL,
			'companyrep4' => NULL,
			'isDirector' => 0,
			'isTrustee' => 0,
			'isChairman' => 0,
			'isMember' => 1,
			'isSecretary' => NULL,
			'isPublicOfficer' => NULL,
			'isShareHolder' => 1,
			'classOfShares' => $item['item_meta']['uh4UnitType'][0],
			'numShares' => $item['item_meta']['uh4NumberUnits'][0],
			'benOwned' => NULL,
			'benName' => NULL,
			'memberDateJoined' => NULL,
			'memberDateLeft' => NULL,
			'memberAccountDesc' => NULL,
			'memberResidential' => $uh4Address,
			'addPtyType'		=> NULL
		);
		}
		
		//Director 1 Details
		$director1 = array(
			'memberNamePrefix' 					=> $item['item_meta']['t1D1Title'][0],
			'memberGivenNames' 					=> $item['item_meta']['t1D1GivenNames'][0],
			'memberFamilyName' 					=> $item['item_meta']['t1D1FamilyName'][0],
			'memberFormerGivenNames' 			=> NULL,
			'memberFormerFamilyName' 			=> NULL,
			'memberChangedName' 				=> NULL,
			'memberTFN' 						=> NULL,
			'memberDOB' 						=> NULL,
			'memberGender' 						=> NULL,
			'memberTownOfBirth' 				=> NULL,
			'memberStateOfBirth' 				=> NULL,
			'memberCountryOfBirth' 				=> NULL,
			'memberOccupation' 					=> NULL,
			'isCompany' 						=> NULL,
			'companyname' 						=> NULL,
			'hasacn' 							=> NULL,
			'acn' 								=> NULL,
			'companyrep1' 						=> NULL,
			'companyrep2' 						=> NULL,
			'companyrep3' 						=> NULL,
			'companyrep4' 						=> NULL,
			'isDirector' 						=> 1,
			'isTrustee' 						=> 0,
			'isChairman' 						=> 0,
			'isMember' 							=> 0,
			'isSecretary' 						=> NULL,
			'isPublicOfficer' 					=> NULL,
			'isShareHolder' 					=> NULL,
			'classOfShares' 					=> NULL,
			'numShares' 						=> NULL,
			'benOwned' 							=> NULL,
			'benName' 							=> NULL,
			'memberDateJoined' 					=> NULL,
			'memberDateLeft' 					=> NULL,
			'memberAccountDesc' 				=> NULL,
			'memberResidential' 				=> $t1D1Address,
			'addPtyType'						=> NULL
		);
		
		//Director 2 Details
		$director2 = array(
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
			'isDirector' => 1,
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
			'memberResidential' => $t2D2Address,
			'addPtyType'		=> NULL
		);
		
		//Director 3 Details
		$director3 = array(
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
			'isDirector' => 1,
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
			'memberResidential' => $t3D3Address,
			'addPtyType'		=> NULL
		);
		
		//Director 4 Details
		$director4 = array(
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
			'isDirector' => 1,
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
			'memberResidential' => $t4D4Address,
			'addPtyType'		=> NULL
		);
		
		$numDirectors = $item['item_meta']['numDirectors'][0];
		
		
		// switch ($numDirectors) {
		
			// case '1':
				// //only one director.
				// $t2D2details = NULL;
				// $t3D3details = NULL;
				// $t4D4details = NULL;
				// break;
				
			// case '2':
				// $t3D3details = NULL;
				// $t4D4details = NULL;
				// break;
				
			// case '3':
				// $t4D4details = NULL;
				// break;
			// case '4':
				// break;
		// }
		
		$numUnitholders = $item['item_meta']['numUnitholders'][0];
		
		
		switch ($numUnitholders) {
		
			case '1':
				//only one director.
				$uh2details = NULL;
				$uh3details = NULL;
				$uh4details = NULL;
				break;
				
			case '2':
				$uh3details = NULL;
				$uh4details = NULL;
				break;
				
			case '3':
				$uh4details = NULL;
				break;
			case '4':
				break;
		}
		
		
		
		
		
		$body= array( 
			'trustStateLaw' 					=> $item['item_meta']['stateLaw'][0],
			'establishmentDate' 				=> $item['item_meta']['estDate'][0],
			'unitPrice'							=> $item['item_meta']['unitPrice'][0],
			'orderServiceType' 					=> $item['item_meta']['service-type'][0],
			'yourRef'							=> $yourRef,
			'trustName'						 	=> $item['item_meta']['trustName'][0],
			'trusteeType' 						=> 'C',
			'trusteeMeetingAddress' 			=> $trusteeMeetingAddress,
			'corporateTrusteeAddress'			=> $trusteeCompanyRegisteredOffice,
			'numIndivTrustees'					=> NULL,
			'numDirectors' 						=> $numDirectors,
			'trusteeCompanyName'				=> $item['item_meta']['corpTeeName'][0],
			'trusteeCompanyACN'					=> $item['item_meta']['corpTeeACN'][0],
			'numUnitholders' 					=> $item['item_meta']['numUnitholders'][0],
			't1D1Details'						=> $director1,
			't2D2Details'						=> $director2,
			't3D3Details'						=> $director3,
			't4D4Details'						=> $director4,
			'uh1Details' 						=> $uh1details,
			'uh2Details' 						=> $uh2details,
			'uh3Details' 						=> $uh3details,
			'uh4Details' 						=> $uh4details,
			'adviserEmail'						=> $adviserEmail,
			'adviserName' 						=> $billingName,
			'adviserCompany' 					=> $billingCompany,
			'adviserAddress' 					=> $billingAddresArray,
			'chairman'	  						=> $chairmanName,
			'orderNumber' 						=> $order_id,
			'userID'	  						=> $userID,
			'productID'	  						=> $product_id,
			'orderDate'	  						=> $orderDate
		);
		
		
        
		return $body;
}



///////////////////////////////////////////////////////////////////////
//																	 //
//																	 //
//																	 //
//  		Fixed Unit Trust with Individual Trustees. 				 //
//																	 //
//																	 //
//																	 //
///////////////////////////////////////////////////////////////////////
function fut_individual_post_Data($item, $order_id, $billingArray, $billingName, $billingCompany, $billing_phone, $product_id, $adviserEmail, $userID, $orderDate) {
	
		$yourRef 		= $item['item_meta']['yourRef'][0];
		
		$trusteeMeetingAddress = array(
			'careOf' => NULL,
			'levelName' => $item['item_meta']['teeMeetingAddressLevel'][0],
			'streetName' => $item['item_meta']['teeMeetingAddressStreet'][0],
			'suburbName' => $item['item_meta']['teeMeetingAddressSuburb'][0],
			'stateName' => $item['item_meta']['teeMeetingAddressState'][0],
			'postcode' => $item['item_meta']['teeMeetingAddressPostcode'][0]
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
		
		$chairmanName = $item['item_meta']['chairmanTrustee'][0];
		
		//Unitholder 1 Address
		$uh1Address = array(
			'careOf' => NULL,
			'levelName' => $item['item_meta']['uh1AddressLevel'][0],
			'streetName' => $item['item_meta']['uh1AddressStreet'][0],
			'suburbName' => $item['item_meta']['uh1AddressSuburb'][0],
			'stateName' => $item['item_meta']['uh1AddressState'][0],
			'postcode' => $item['item_meta']['uh1AddressPostcode'][0]
		);
		
		//Unitholder 2 Address
		$uh1Address = array(
			'careOf' => NULL,
			'levelName' => $item['item_meta']['uh2AddressLevel'][0],
			'streetName' => $item['item_meta']['uh2AddressStreet'][0],
			'suburbName' => $item['item_meta']['uh2AddressSuburb'][0],
			'stateName' => $item['item_meta']['uh2AddressState'][0],
			'postcode' => $item['item_meta']['uh2AddressPostcode'][0]
		);
		
		//Unitholder 3 Address
		$uh1Address = array(
			'careOf' => NULL,
			'levelName' => $item['item_meta']['uh3AddressLevel'][0],
			'streetName' => $item['item_meta']['uh3AddressStreet'][0],
			'suburbName' => $item['item_meta']['uh3AddressSuburb'][0],
			'stateName' => $item['item_meta']['uh3AddressState'][0],
			'postcode' => $item['item_meta']['uh3AddressPostcode'][0]
		);
		
		//Unitholder 4 Address
		$uh1Address = array(
			'careOf' => NULL,
			'levelName' => $item['item_meta']['uh4AddressLevel'][0],
			'streetName' => $item['item_meta']['uh4AddressStreet'][0],
			'suburbName' => $item['item_meta']['uh4AddressSuburb'][0],
			'stateName' => $item['item_meta']['uh4AddressState'][0],
			'postcode' => $item['item_meta']['uh4AddressPostcode'][0]
		);
		
		//Trustee 1 Address
		$t1D1Address = array(
			'careOf' => NULL,
			'levelName' => $item['item_meta']['t1D1AddressLevel'][0],
			'streetName' => $item['item_meta']['t1D1AddressStreet'][0],
			'suburbName' => $item['item_meta']['t1D1AddressSuburb'][0],
			'stateName' => $item['item_meta']['t1D1AddressState'][0],
			'postcode' => $item['item_meta']['t1D1AddressPostcode'][0]
		);
		
		//Trustee 2 Address
		$t2D2Address = array(
			'careOf' => NULL,
			'levelName' => $item['item_meta']['t2D2AddressLevel'][0],
			'streetName' => $item['item_meta']['t2D2AddressStreet'][0],
			'suburbName' => $item['item_meta']['t2D2AddressSuburb'][0],
			'stateName' => $item['item_meta']['t2D2AddressState'][0],
			'postcode' => $item['item_meta']['t2D2AddressPostcode'][0]
		);
		
		//Trustee 3 Address
		$t3D3Address = array(
			'careOf' => NULL,
			'levelName' => $item['item_meta']['t3D3AddressLevel'][0],
			'streetName' => $item['item_meta']['t3D3AddressStreet'][0],
			'suburbName' => $item['item_meta']['t3D3AddressSuburb'][0],
			'stateName' => $item['item_meta']['t3D3AddressState'][0],
			'postcode' => $item['item_meta']['t3D3AddressPostcode'][0]
		);
		
		//Trustee 4 Address
		$t4D4Address = array(
			'careOf' => NULL,
			'levelName' => $item['item_meta']['t4D4AddressLevel'][0],
			'streetName' => $item['item_meta']['t4D4AddressStreet'][0],
			'suburbName' => $item['item_meta']['t4D4AddressSuburb'][0],
			'stateName' => $item['item_meta']['t4D4AddressState'][0],
			'postcode' => $item['item_meta']['t4D4AddressPostcode'][0]
		);
		
		if(!is_Null($item['item_meta']['uh1DOB'][0])) {
			$uh1dob = $item['item_meta']['uh1DOB'][0];
		}
		else {
			$uh1dob = NULL;
		}
		
		if(!is_Null($item['item_meta']['uh2DOB'][0])) {
			$uh2dob = $item['item_meta']['uh2DOB'][0];
		}
		else {
			$uh2dob = NULL;
		}
		
		if(!is_Null($item['item_meta']['uh3DOB'][0])) {
			$uh3dob = $item['item_meta']['uh3DOB'][0];
		}
		else {
			$uh3dob = NULL;
		}
		
		if(!is_Null($item['item_meta']['uh4DOB'][0])) {
			$uh4dob = $item['item_meta']['uh4DOB'][0];
		}
		else {
			$uh4dob = NULL;
		}

		
		
		//Unitholder 1 Details
		$uh1details = array(	
			'memberNamePrefix' => $item['item_meta']['uh1Title'][0],
			'memberGivenNames' => $item['item_meta']['uh1GivenNames'][0],
			'memberFamilyName' => $item['item_meta']['uh1FamilyName'][0],
			'memberFormerGivenNames' => NULL,
			'memberFormerFamilyName' => NULL,
			'memberChangedName' => NULL,
			'memberTFN' => NULL,
			'memberDOB' => $uh1dob,
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
			'isMember' => 1,
			'isSecretary' => NULL,
			'isPublicOfficer' => NULL,
			'isShareHolder' => 1,
			'classOfShares' => $item['item_meta']['uh1UnitType'][0],
			'numShares' => $item['item_meta']['uh1NumUnits'][0],
			'benOwned' => NULL,
			'benName' => NULL,
			'memberDateJoined' => NULL,
			'memberDateLeft' => NULL,
			'memberAccountDesc' => NULL,
			'memberResidential' => $uh1Address,
			'addPtyType'		=> NULL
		);
		
		//Unitholder 2 Details
		$uh2details = array(	
			'memberNamePrefix' => $item['item_meta']['uh2Title'][0],
			'memberGivenNames' => $item['item_meta']['uh2GivenNames'][0],
			'memberFamilyName' => $item['item_meta']['uh2FamilyName'][0],
			'memberFormerGivenNames' => NULL,
			'memberFormerFamilyName' => NULL,
			'memberChangedName' => NULL,
			'memberTFN' => NULL,
			'memberDOB' => $uh2dob,
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
			'isMember' => 1,
			'isSecretary' => NULL,
			'isPublicOfficer' => NULL,
			'isShareHolder' => 1,
			'classOfShares' => $item['item_meta']['uh2UnitType'][0],
			'numShares' => $item['item_meta']['uh2NumUnits'][0],
			'benOwned' => NULL,
			'benName' => NULL,
			'memberDateJoined' => NULL,
			'memberDateLeft' => NULL,
			'memberAccountDesc' => NULL,
			'memberResidential' => $uh2Address,
			'addPtyType'		=> NULL
		);
		
		//Unitholder 3 Details
		$uh3details = array(	
			'memberNamePrefix' => $item['item_meta']['uh3Title'][0],
			'memberGivenNames' => $item['item_meta']['uh3GivenNames'][0],
			'memberFamilyName' => $item['item_meta']['uh3FamilyName'][0],
			'memberFormerGivenNames' => NULL,
			'memberFormerFamilyName' => NULL,
			'memberChangedName' => NULL,
			'memberTFN' => NULL,
			'memberDOB' => $uh3dob,
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
			'isMember' => 1,
			'isSecretary' => NULL,
			'isPublicOfficer' => NULL,
			'isShareHolder' => 1,
			'classOfShares' => $item['item_meta']['uh3UnitType'][0],
			'numShares' => $item['item_meta']['uh3NumUnits'][0],
			'benOwned' => NULL,
			'benName' => NULL,
			'memberDateJoined' => NULL,
			'memberDateLeft' => NULL,
			'memberAccountDesc' => NULL,
			'memberResidential' => $uh3Address,
			'addPtyType'		=> NULL
		);
		
		//Unitholder 4 Details
		$uh4details = array(	
			'memberNamePrefix' => $item['item_meta']['uh4Title'][0],
			'memberGivenNames' => $item['item_meta']['uh4GivenNames'][0],
			'memberFamilyName' => $item['item_meta']['uh4FamilyName'][0],
			'memberFormerGivenNames' => NULL,
			'memberFormerFamilyName' => NULL,
			'memberChangedName' => NULL,
			'memberTFN' => NULL,
			'memberDOB' => $uh4dob,
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
			'isMember' => 1,
			'isSecretary' => NULL,
			'isPublicOfficer' => NULL,
			'isShareHolder' => 1,
			'classOfShares' => $item['item_meta']['uh4UnitType'][0],
			'numShares' => $item['item_meta']['uh4NumUnits'][0],
			'benOwned' => NULL,
			'benName' => NULL,
			'memberDateJoined' => NULL,
			'memberDateLeft' => NULL,
			'memberAccountDesc' => NULL,
			'memberResidential' => $uh4Address,
			'addPtyType'		=> NULL
		);
		
		//Trustee 1 Details
		$t1D1details = array(
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
			'isTrustee' => 1,
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
			'memberResidential' => $t1D1Address,
			'addPtyType'		=> NULL
		);
		
		//Trustee 2 Details
		$t2D2details = array(
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
			'isTrustee' => 1,
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
			'memberResidential' => $t2D2Address,
			'addPtyType'		=> NULL
		);
		
		//Trustee 3 Details
		$t3D3details = array(
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
			'isTrustee' => 1,
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
			'memberResidential' => $t3D3Address,
			'addPtyType'		=> NULL
		);
		
		//Trustee 4 Details
		$t4D4details = array(
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
			'isTrustee' => 1,
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
			'memberResidential' => $t4D4Address,
			'addPtyType'		=> NULL
		);
		
		$numTrustees = $item['item_meta']['numTrustees'][0];
		
		
		// switch ($numTrustees) {
		
			// case '1':
				// //only one trustee.
				// $t2D2details = NULL;
				// $t3D3details = NULL;
				// $t4D4details = NULL;
				
				// $trusteeIndiv = array(
					// 'T1Details' => $t1D1details,
					// 'isT1M1' => 0,
					// 'T2Details' => $t2D2details,
					// 'isT2M2' => 0,
					// 'isT2P1' => 0,
					// 'T3Details' => $t3D3details,
					// 'isT3M3' => 0,
					// 'T4Details' => $t4D4details,
					// 'isT4M4' => 0
				// );
				// break;
				
			// case '2':
				// $t3D3details = NULL;
				// $t4D4details = NULL;
				
				// $trusteeIndiv = array(
					// 'T1Details' => $t1D1details,
					// 'isT1M1' => 0,
					// 'T2Details' => $t2D2details,
					// 'isT2M2' => 0,
					// 'isT2P1' => 0,
					// 'T3Details' => $t3D3details,
					// 'isT3M3' => 0,
					// 'T4Details' => $t4D4details,
					// 'isT4M4' => 0
				// );
				// break;
				
			// case '3':
				// $t4D4details = NULL;
				
				// $trusteeIndiv = array(
					// 'T1Details' => $t1D1details,
					// 'isT1M1' => 0,
					// 'T2Details' => $t2D2details,
					// 'isT2M2' => 0,
					// 'isT2P1' => 0,
					// 'T3Details' => $t3D3details,
					// 'isT3M3' => 0,
					// 'T4Details' => $t4D4details,
					// 'isT4M4' => 0
				// );
				// break;
			// case '4':
				// $trusteeIndiv = array(
					// 'T1Details' => $t1D1details,
					// 'isT1M1' => 0,
					// 'T2Details' => $t2D2details,
					// 'isT2M2' => 0,
					// 'isT2P1' => 0,
					// 'T3Details' => $t3D3details,
					// 'isT3M3' => 0,
					// 'T4Details' => $t4D4details,
					// 'isT4M4' => 0
				// );
				// break;
		// }
		
		$numUnitholders = $item['item_meta']['numUnitholders'][0];
		
		
		switch ($numUnitholders) {
		
			case '1':
				//only one director.
				$uh2details = NULL;
				$uh3details = NULL;
				$uh4details = NULL;
				break;
				
			case '2':
				$uh3details = NULL;
				$uh4details = NULL;
				break;
				
			case '3':
				$uh4details = NULL;
				break;
			case '4':
				break;
		}
		
		
		
		$body= array( 
			'trustStateLaw' 					=> $item['item_meta']['stateLaw'][0],
			'establishmentDate' 				=> $item['item_meta']['estDate'][0],
			'unitPrice'							=> $item['item_meta']['unitPrice'][0],
			'orderServiceType' 					=> $item['item_meta']['service-type'][0],
			'yourRef'							=> $yourRef,
			'trustName'						 	=> $item['item_meta']['trustName'][0],
			'trusteeType' 						=> 'I',
			'trusteeMeetingAddress' 			=> $trusteeMeetingAddress,
			'corporateTrusteeAddress'			=> NULL,
			'numIndivTrustees'					=> $numTrustees,
			'numDirectors' 						=> NULL,
			'trusteeCompanyName'				=> NULL,
			'trusteeCompanyACN'					=> NULL,
			'numUnitholders' 					=> $item['item_meta']['numUnitholders'][0],
			't1D1Details'						=> $t1D1Details,
			't2D2Details'						=> $t2D2Details,
			't3D3Details'						=> $t3D3Details,
			't4D4Details'						=> $t4D4Details,
			'uh1Details' 						=> $uh1details,
			'uh2Details' 						=> $uh2details,
			'uh3Details' 						=> $uh3details,
			'uh4Details' 						=> $uh4details,
			'adviserEmail'						=> $adviserEmail,
			'adviserName' 						=> $billingName,
			'adviserCompany' 					=> $billingCompany,
			'adviserAddress' 					=> $billingAddresArray,
			'chairman'	  						=> $chairmanName,
			'orderNumber' 						=> $order_id,
			'userID'	  						=> $userID,
			'productID'	  						=> $product_id,
			'orderDate'	  						=> $orderDate
		);
		
		// $body= array( 
			// 'numUnitholders' => $numUnitholders,
			// 'unitPrice'			=> $item['item_meta']['unitPrice'][0],
			
		// );

        
		return $body;
}



?>