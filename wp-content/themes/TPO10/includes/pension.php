<?php
//////////////////////////////////////////////////////////
//														//
//														//
//														//
//					  Pensions.			 				//
//														//
//														//
//														//
//////////////////////////////////////////////////////////
function pension_post_Data($item, $order_id, $deedVersion, $constitutionVersion, $billingArray, $billingName, $billingCompany, $billing_phone, $product_id, $adviserEmail, $userID, $orderDate) {
	
		$yourRef 		= $item['item_meta']['yourRef'][0];
		
		if(!is_null($item['item_meta']['isParatusDeed'][0])){
			if($item['item_meta']['isParatusDeed'][0] == 'yes'){
				$isParatusDeed = 1;
			}
			else{
				$isParatusDeed = 0;
			}
		}
		
		
		$fundAddress = array (
			'careOf' => $item['item_meta']['fundAddressCareOf'][0],
			'levelName' => $item['item_meta']['fundAddressLevel'][0],
			'streetName' => $item['item_meta']['fundAddressStreet'][0],
			'suburbName' => $item['item_meta']['fundAddressSuburb'][0],
			'stateName' => $item['item_meta']['fundAddressState'][0],
			'postcode' => $item['item_meta']['fundAddressPostcode'][0]
			);
		
		
		
		$trusteeMeetingAddress = array(
			'careOf' => NULL,
			'levelName' => $item['item_meta']['teeMeetingAddressLevel'][0],
			'streetName' => $item['item_meta']['teeMeetingAddressStreet'][0],
			'suburbName' => $item['item_meta']['teeMeetingAddressSuburb'][0],
			'stateName' => $item['item_meta']['teeMeetingAddressState'][0],
			'postcode' => $item['item_meta']['teeMeetingAddressPostcode'][0],
		);
				
		
		$billingAddresArray = array (
		
			'careOf' => NULL,
			'levelName' => NULL,
			'streetName' => $billingArray[0].' '.$billingArray[1],
			'suburbName' => $billingArray[2],
			'stateName' => $billingArray[3],
			'postcode' => $billingArray[4]
		
		);
		
		
		//Corporate Trustee Address
		$trusteeCompanyRegisteredOffice = array(
			
				'careOf' => $item['item_meta']['corpTeeAddressCareOf'][0],
				'levelName' => $item['item_meta']['corpTeeAddressLevel'][0],
				'streetName' => $item['item_meta']['corpTeeAddressStreet'][0], 
				'suburbName' => $item['item_meta']['corpTeeAddressSuburb'][0],
				'stateName' => $item['item_meta']['corpTeeAddressState'][0],
				'postcode' => $item['item_meta']['corpTeeAddressPostcode'][0]
			
			);

			//Member Address
		$memberAddress = array(
			'careOf' => $item['item_meta']['memberAddressCareOf'][0],
			'levelName' => $item['item_meta']['memberAddressLevel'][0],
			'streetName' => $item['item_meta']['memberAddressStreet'][0],
			'suburbName' => $item['item_meta']['memberAddressSuburb'][0],
			'stateName' => $item['item_meta']['memberAddressState'][0],
			'postcode' => $item['item_meta']['memberAddressPostcode'][0]
			);

		//Reversionary Address
		$revAddress = array(
			'careOf' => $item['item_meta']['reversionerAddressCareOf'][0],
			'levelName' => $item['item_meta']['reversionerAddressLevel'][0],
			'streetName' => $item['item_meta']['reversionerAddressStreet'][0],
			'suburbName' => $item['item_meta']['reversionerAddressSuburb'][0],
			'stateName' => $item['item_meta']['reversionerAddressState'][0],
			'postcode' => $item['item_meta']['reversionerAddressPostcode'][0]
			);
	
		
		if(!is_Null($item['item_meta']['memberDOB'][0])) {
			$memberdob = $item['item_meta']['memberDOB'][0];
		}
		else {
			$memberdob = NULL;
		}

		if(!is_Null($item['item_meta']['reversionerDOB'][0])) {
			$revdob = $item['item_meta']['reversionerDOB'][0];
		}
		else {
			$revdob = NULL;
		}
		
		
		//copy details of tee/dir to member details
		//create switch statement
		$memberIs = $item['item_meta']['memberIs'][0];
		if($memberIs == $item['item_meta']['t1D1GivenNames'][0].' '.$item['item_meta']['t1D1FamilyName'][0]){
				$memberNamePrefix = $item['item_meta']['t1D1Title'][0];
				$memberGivenNames = $item['item_meta']['t1D1GivenNames'][0];
				$memberFamilyName = $item['item_meta']['t1D1FamilyName'][0];
		
		}
		elseif($memberIs == $item['item_meta']['t2D2GivenNames'][0].' '.$item['item_meta']['t2D2FamilyName'][0]){
				$memberNamePrefix = $item['item_meta']['t2D2Title'][0];
				$memberGivenNames = $item['item_meta']['t2D2GivenNames'][0];
				$memberFamilyName = $item['item_meta']['t2D2FamilyName'][0];
		}
		elseif($memberIs == $item['item_meta']['t3D3GivenNames'][0].' '.$item['item_meta']['t3D3FamilyName'][0]){
				$memberNamePrefix = $item['item_meta']['t3D3Title'][0];
				$memberGivenNames = $item['item_meta']['t3D3GivenNames'][0];
				$memberFamilyName = $item['item_meta']['t3D3FamilyName'][0];
		}
		elseif($memberIs == $item['item_meta']['t4D4GivenNames'][0].' '.$item['item_meta']['t4D4FamilyName'][0]){
				$memberNamePrefix = $item['item_meta']['t4D4Title'][0];
				$memberGivenNames = $item['item_meta']['t4D4GivenNames'][0];
				$memberFamilyName = $item['item_meta']['t4D4FamilyName'][0];
		}
		
		
		$memberdetails = array(	
			'memberNamePrefix' => $memberNamePrefix,
			'memberGivenNames' => $memberGivenNames,
			'memberFamilyName' => $memberFamilyName,
			'memberFormerGivenNames' => NULL,
			'memberFormerFamilyName' => NULL,
			'memberChangedName' => NULL,
			'memberTFN' => $item['item_meta']['memberTFN'][0],
			'memberDOB' => $memberdob,
			'memberGender' => $item['item_meta']['memberGender'][0],
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
			'isShareHolder' => NULL,
			'classOfShares' => NULL,
			'numShares' => NULL,
			'benOwned' => NULL,
			'benName' => NULL,
			'memberDateJoined' => NULL,
			'memberDateLeft' => NULL,
			'memberAccountDesc' => NULL,
			'memberResidential' => $memberAddress,
			'addPtyType'		=> NULL
		);
		
		
		$adviserAddress = array(
			'levelName' => NULL,
			'streetName' => '',
			'suburbName' => '',
			'stateName' => '',
			'postcode' => ''
		);
		
		
		//Set if trustee meeting elsewhere
		if ($item['item_meta']['trusteeMeetingElsewhere'][0] == "Yes"){
			$teeMtgElsewhere = 1;
		}
		else {
			$teeMtgElsewhere = 0;
		}
		
		//Set number of directors or number of individual trustees
		if ($item['item_meta']['trusteeType'][0] == "Company"){
			$numIndivTees = NULL;
			$numDirectors = $item['item_meta']['numDirectors'][0];
		}
		else {
			$numIndivTees = $item['item_meta']['numIndivTees'][0];
			$numDirectors = NULL;
		}
		
		//set if using entire balance for pension
		if ($item['item_meta']['useEntireBalance'][0] == "Yes"){
			$useEntireBalance = 1;
		}
		else {
			$useEntireBalance = 0;
		}
		
		//set purchase price
		if ($useEntireBalance == 1){
			$purchasePrice = $item['item_meta']['totalAccountBalance'][0];
		}
		else {
			$purchasePrice = $item['item_meta']['purchasePriceAmount'][0];
		}
		
		//set maximum and minimum based on pension type
		//note - variable 'abpMinimum' is used for both TRIS and ABP calcs - ignore the name, it does both.
		if ($item['item_meta']['pensionType'][0] == "Account Based Pension (ABP)") {
			$maximum = $purchasePrice;
			$minimum = $item['item_meta']['abpMinimum'][0];
		}
		else {
			$totalAccountBalance = $item['item_meta']['totalAccountBalance'][0];
			$maximum = $purchasePrice * 0.1;
			$minimum = $item['item_meta']['abpMinimum'][0];
		}
		
		//set if reversionary
		if ($item['item_meta']['nominateReversionary'][0] == "Yes") {
			$isReversionary = 1;
			$reversionerName = $item['item_meta']['reversionaryFullName'][0];
		}
		else {
			$isReversionary = 0;
			$reversionerName = 'None';
		}
		
		//set if has segregated assets
		if ($item['item_meta']['hasSegAssets'][0] == "Yes"){
			$hasSegAssets = 1;
		}
		else {
			$hasSegAssets = 0;
		}
		
		//set if balance is known at commencement
		if ($item['item_meta']['accountBalanceKnown'][0] == "Yes"){
			$isBalanceKnown = 1;
		}
		else {
			$isBalanceKnown = 0;
		}
		
		//Chairperson
		$chairperson = $item['item_meta']['chairperson'][0];
		
		
		//calculate age of Member at commencement date in years
		$commencementDateStr = $item['item_meta']['commencementDate'][0];
		$commencementDateStr = str_replace('/','-', $commencementDateStr);
		$day = '';
		$month = '';
		$year = '';
		list($day, $month, $year) = explode('-', $commencementDateStr);
		if (strlen($commencementDateStr) > 1){
			$commencementDate = date('d-m-Y', strtotime($commencementDateStr));
		}
		else {
			$commencementDate = NULL;
		}
		
		
		$memberdob = str_replace('/','-', $memberdob);
		$day = '';
		$month = '';
		$year = '';
		list($day, $month, $year) = explode('-', $memberdob);
		if (strlen($memberdob) > 1){
			$memberdobDate = date('Y-m-d', strtotime($memberdob));
		}
		else {
			$memberdobDate = NULL;
		}
		
		
		
		//set nominated amount based on user choice
		$nominatedAmountChoice = $item['item_meta']['nominatedAmount'][0];
		switch ($nominatedAmountChoice) {
			
			case 'Maximum' :
				$nominatedAmount = $maximum;
			break;
			
			case 'Minimum' :
				$nominatedAmount = $minimum;
			break;
			
			case 'Other - Specify' :
				$nominatedAmount = $item['item_meta']['nominatedAmountOther'][0];
			break;
			
		
		}
		
		
		
		$body= array( 
				'yourRef'  => 	$yourRef,
				'fundName' => 	$item['item_meta']['fundName'][0],
				'fundAbn' => 	$item['item_meta']['fundABN'][0],
				'fundAddress' => $fundAddress,
				'trusteeType' => $item['item_meta']['trusteeType'][0],
				'chairperson' => $chairperson,
				'teeMtgAddress' => $trusteeMeetingAddress,
				'teeMtgElsewhere' => $teeMtgElsewhere,
				'numIndivTees' => $numIndivTees,
				'numDirectors' => $numDirectors,
				'corpTeeName' => $item['item_meta']['corpTeeName'][0],
				'corpTeeAcn'  => $item['item_meta']['corpTeeAcn'][0],
				'corpTeeRegAddress' => $trusteeCompanyRegisteredOffice,
				't1D1Title' => $item['item_meta']['t1D1Title'][0],
				't1D1GivenNames' => $item['item_meta']['t1D1GivenNames'][0],
				't1D1FamilyName' => $item['item_meta']['t1D1FamilyName'][0],
				't2D2Title' => $item['item_meta']['t2D2Title'][0],
				't2D2GivenNames' =>  $item['item_meta']['t2D2GivenNames'][0],
				't2D2FamilyName' => $item['item_meta']['t2D2FamilyName'][0],
				't3D3Title' => $item['item_meta']['t3D3Title'][0],
				't3D3GivenNames' => $item['item_meta']['t3D3GivenNames'][0],
				't3D3FamilyName' => $item['item_meta']['t3D3FamilyName'][0],
				't4D4Title' => $item['item_meta']['t4D4Title'][0],
				't4D4GivenNames' => $item['item_meta']['t4D4GivenNames'][0],
				't4D4FamilyName' => $item['item_meta']['t4D4FamilyName'][0],
				'member' => $memberdetails,
				'memberPreservationAge' => $item['item_meta']['memberPreservationAge'][0],
				'commencementDate' => $item['item_meta']['commencementDate'][0],
				'memberAgeAtCommencement' => $item['item_meta']['memberAge'][0],
				'typeOfBenefit' => $item['item_meta']['pensionType'][0],
				'conditionMet' => $item['item_meta']['conditionOfReleaseMet'][0],
				'isBalanceKnownAtCommencement' => $isBalanceKnown,
				'taxFreeComponent' => $item['item_meta']['taxFreeComponent'][0],
				'taxableComponent' => $item['item_meta']['taxableComponent'][0],
				'balanceAtCommencement' => $item['item_meta']['totalAccountBalance'][0],
				'taxFreePercentage' => $item['item_meta']['taxfreePurchaseIsEntire'][0],
				'taxablePercentage' => $item['item_meta']['taxablePurchaseIsEntire'][0],
				'isEntireAccountBalance' => $useEntireBalance,
				'totalPurchasePrice' => $purchasePrice,
				'maximum' => $maximum,
				'minimum' => $minimum,
				'paymentFrequency' => $item['item_meta']['paymentFrequency'][0],
				'nominatedAmount' => $nominatedAmount,
				'isReversionary' => $isReversionary,
				'reversionaryFullName' => $reversionerName,
				'reversionaryGender' => $item['item_meta']['reversionaryGender'][0],
				'reversionaryDOB' => $revdob,
				'reversionaryRelationToMember' => $item['item_meta']['reversionaryRelationship'][0],
				'reversionaryAddress' => $revAddress,
				'isSettingAsideAssets' => $hasSegAssets,
				'setAsset1Name' => $item['item_meta']['assetType1Name'][0],
				'setAsset2Name' => $item['item_meta']['assetType2Name'][0],
				'setAsset3Name' => $item['item_meta']['assetType3Name'][0],
				'setAsset4Name' => $item['item_meta']['assetType4Name'][0],
				'setAsset5Name' => $item['item_meta']['assetType5Name'][0],
				'setAsset6Name' => $item['item_meta']['assetType6Name'][0],
				'setAsset7Name' => $item['item_meta']['assetType7Name'][0],
				'setAsset8Name' => $item['item_meta']['assetType8Name'][0],
				'setAsset9Name' => $item['item_meta']['assetType9Name'][0],
				'setAsset10Name' => $item['item_meta']['assetType10Name'][0],
				'setAsset11Name' => $item['item_meta']['assetType11Name'][0],
				'setAsset12Name' => $item['item_meta']['assetType12Name'][0],
				'setAsset13Name' => $item['item_meta']['assetType13Name'][0],
				'setAsset14Name' => $item['item_meta']['assetType14Name'][0],
				'setAsset15Name' => $item['item_meta']['assetType15Name'][0],
				'setAsset16Name' => $item['item_meta']['assetType16Name'][0],
				'setAsset17Name' => $item['item_meta']['assetType17Name'][0],
				'setAsset18Name' => $item['item_meta']['assetType18Name'][0],
				'setAsset19Name' => $item['item_meta']['assetType19Name'][0],
				'setAsset20Name' => $item['item_meta']['assetType20Name'][0],
				'setAsset21Name' => $item['item_meta']['assetType21Name'][0],
				'setAsset22Name' => $item['item_meta']['assetType22Name'][0],
				'setAsset23Name' => $item['item_meta']['assetType23Name'][0],
				'setAsset24Name' => $item['item_meta']['assetType24Name'][0],
				'setAsset25Name' => $item['item_meta']['assetType25Name'][0],
				'setAsset26Name' => $item['item_meta']['assetType26Name'][0],
				'setAsset27Name' => $item['item_meta']['assetType27Name'][0],
				'setAsset28Name' => $item['item_meta']['assetType28Name'][0],
				'setAsset29Name' => $item['item_meta']['assetType29Name'][0],
				'setAsset30Name' => $item['item_meta']['assetType30Name'][0],
				'setAsset31Name' => $item['item_meta']['assetType31Name'][0],
				'setAsset32Name' => $item['item_meta']['assetType32Name'][0],
				'setAsset33Name' => $item['item_meta']['assetType33Name'][0],
				'setAsset34Name' => $item['item_meta']['assetType34Name'][0],
				'setAsset35Name' => $item['item_meta']['assetType35Name'][0],
				'setAsset36Name' => $item['item_meta']['assetType36Name'][0],
				'setAsset37Name' => $item['item_meta']['assetType37Name'][0],
				'setAsset38Name' => $item['item_meta']['assetType38Name'][0],
				'setAsset39Name' => $item['item_meta']['assetType39Name'][0],
				'setAsset40Name' => $item['item_meta']['assetType40Name'][0],
				'setAsset41Name' => $item['item_meta']['assetType41Name'][0],
				'setAsset42Name' => $item['item_meta']['assetType42Name'][0],
				'setAsset43Name' => $item['item_meta']['assetType43Name'][0],
				'setAsset44Name' => $item['item_meta']['assetType44Name'][0],
				'setAsset45Name' => $item['item_meta']['assetType45Name'][0],
				'setAsset46Name' => $item['item_meta']['assetType46Name'][0],
				'setAsset47Name' => $item['item_meta']['assetType47Name'][0],
				'setAsset48Name' => $item['item_meta']['assetType48Name'][0],
				'setAsset49Name' => $item['item_meta']['assetType49Name'][0],
				'setAsset40Name' => $item['item_meta']['assetType50Name'][0],
				'setAsset1Qty' => NULL,
				'setAsset2Qty' => NULL,
				'setAsset3Qty' => NULL,
				'setAsset4Qty' => NULL,
				'setAsset5Qty' => NULL,
				'setAsset6Qty' => NULL,
				'setAsset7Qty' => NULL,
				'setAsset8Qty' => NULL,
				'setAsset9Qty' => NULL,
				'setAsset10Qty' => NULL,
				'setAsset11Qty' => NULL,
				'setAsset12Qty' => NULL,
				'setAsset13Qty' => NULL,
				'setAsset14Qty' => NULL,
				'setAsset15Qty' => NULL,
				'setAsset16Qty' => NULL,
				'setAsset17Qty' => NULL,
				'setAsset18Qty' => NULL,
				'setAsset19Qty' => NULL,
				'setAsset20Qty' => NULL,
				'setAsset21Qty' => NULL,
				'setAsset22Qty' => NULL,
				'setAsset23Qty' => NULL,
				'setAsset24Qty' => NULL,
				'setAsset25Qty' => NULL,
				'setAsset26Qty' => NULL,
				'setAsset27Qty' => NULL,
				'setAsset28Qty' => NULL,
				'setAsset29Qty' => NULL,
				'setAsset30Qty' => NULL,
				'setAsset31Qty' => NULL,
				'setAsset32Qty' => NULL,
				'setAsset33Qty' => NULL,
				'setAsset34Qty' => NULL,
				'setAsset35Qty' => NULL,
				'setAsset36Qty' => NULL,
				'setAsset37Qty' => NULL,
				'setAsset38Qty' => NULL,
				'setAsset39Qty' => NULL,
				'setAsset40Qty' => NULL,
				'setAsset41Qty' => NULL,
				'setAsset42Qty' => NULL,
				'setAsset43Qty' => NULL,
				'setAsset44Qty' => NULL,
				'setAsset45Qty' => NULL,
				'setAsset46Qty' => NULL,
				'setAsset47Qty' => NULL,
				'setAsset48Qty' => NULL,
				'setAsset49Qty' => NULL,
				'setAsset50Qty' => NULL,
				'setAsset1MarketValue' => $item['item_meta']['assetType1MarketValue'][0],
				'setAsset2MarketValue' => $item['item_meta']['assetType2MarketValue'][0],
				'setAsset3MarketValue' => $item['item_meta']['assetType3MarketValue'][0],
				'setAsset4MarketValue' => $item['item_meta']['assetType4MarketValue'][0],
				'setAsset5MarketValue' => $item['item_meta']['assetType5MarketValue'][0],
				'setAsset6MarketValue' => $item['item_meta']['assetType6MarketValue'][0],
				'setAsset7MarketValue' => $item['item_meta']['assetType7MarketValue'][0],
				'setAsset8MarketValue' => $item['item_meta']['assetType8MarketValue'][0],
				'setAsset9MarketValue' => $item['item_meta']['assetType9MarketValue'][0],
				'setAsset10MarketValue' =>  $item['item_meta']['assetType10MarketValue'][0],
				'setAsset11MarketValue' => $item['item_meta']['assetType11MarketValue'][0],
				'setAsset12MarketValue' => $item['item_meta']['assetType12MarketValue'][0],
				'setAsset13MarketValue' => $item['item_meta']['assetType13MarketValue'][0],
				'setAsset14MarketValue' => $item['item_meta']['assetType14MarketValue'][0],
				'setAsset15MarketValue' => $item['item_meta']['assetType15MarketValue'][0],
				'setAsset16MarketValue' => $item['item_meta']['assetType16MarketValue'][0],
				'setAsset17MarketValue' => $item['item_meta']['assetType17MarketValue'][0],
				'setAsset18MarketValue' => $item['item_meta']['assetType18MarketValue'][0],
				'setAsset19MarketValue' => $item['item_meta']['assetType19MarketValue'][0],
				'setAsset20MarketValue' =>  $item['item_meta']['assetType20MarketValue'][0],
				'setAsset21MarketValue' => $item['item_meta']['assetType21MarketValue'][0],
				'setAsset22MarketValue' => $item['item_meta']['assetType22MarketValue'][0],
				'setAsset23MarketValue' => $item['item_meta']['assetType23MarketValue'][0],
				'setAsset24MarketValue' => $item['item_meta']['assetType24MarketValue'][0],
				'setAsset25MarketValue' => $item['item_meta']['assetType25MarketValue'][0],
				'setAsset26MarketValue' => $item['item_meta']['assetType26MarketValue'][0],
				'setAsset27MarketValue' => $item['item_meta']['assetType27MarketValue'][0],
				'setAsset28MarketValue' => $item['item_meta']['assetType28MarketValue'][0],
				'setAsset29MarketValue' => $item['item_meta']['assetType29MarketValue'][0],
				'setAsset30MarketValue' =>  $item['item_meta']['assetType30MarketValue'][0],
				'setAsset31MarketValue' => $item['item_meta']['assetType31MarketValue'][0],
				'setAsset32MarketValue' => $item['item_meta']['assetType32MarketValue'][0],
				'setAsset33MarketValue' => $item['item_meta']['assetType33MarketValue'][0],
				'setAsset34MarketValue' => $item['item_meta']['assetType34MarketValue'][0],
				'setAsset35MarketValue' => $item['item_meta']['assetType35MarketValue'][0],
				'setAsset36MarketValue' => $item['item_meta']['assetType36MarketValue'][0],
				'setAsset37MarketValue' => $item['item_meta']['assetType37MarketValue'][0],
				'setAsset38MarketValue' => $item['item_meta']['assetType38MarketValue'][0],
				'setAsset39MarketValue' => $item['item_meta']['assetType39MarketValue'][0],
				'setAsset40MarketValue' =>  $item['item_meta']['assetType40MarketValue'][0],
				'setAsset41MarketValue' => $item['item_meta']['assetType41MarketValue'][0],
				'setAsset42MarketValue' => $item['item_meta']['assetType42MarketValue'][0],
				'setAsset43MarketValue' => $item['item_meta']['assetType43MarketValue'][0],
				'setAsset44MarketValue' => $item['item_meta']['assetType44MarketValue'][0],
				'setAsset45MarketValue' => $item['item_meta']['assetType45MarketValue'][0],
				'setAsset46MarketValue' => $item['item_meta']['assetType46MarketValue'][0],
				'setAsset47MarketValue' => $item['item_meta']['assetType47MarketValue'][0],
				'setAsset48MarketValue' => $item['item_meta']['assetType48MarketValue'][0],
				'setAsset49MarketValue' => $item['item_meta']['assetType49MarketValue'][0],
				'setAsset50MarketValue' =>  $item['item_meta']['assetType50MarketValue'][0],
				'adviserName' => $billingName,
				'adviserCompany' => $billingCompany,
				'adviserAddress' => $billingAddresArray,
				'adviserPhone' => $billing_phone,
				'pensionRuleNum' => $item['item_meta']['pensionRuleNumber'][0],
				'pensionRuleType' => $item['item_meta']['typeOfRule'][0],
				'orderNumber' => $order_id,
				'userID'	  => $userID,
				'productID'	  => $product_id,
				'chairman'	  => $chairperson,
				'adviserEmail' => $adviserEmail,
				'orderDate'	  => $orderDate,
				'taxFreePreserved' => $item['item_meta']['taxFreePreserved'][0],
				'taxFreeRestricted' => $item['item_meta']['taxFreeRestricted'][0],
				'taxFreeUnrestricted' => $item['item_meta']['taxFreeUnrestricted'][0],
				'taxablePreserved' => $item['item_meta']['taxablePreserved'][0],
				'taxableRestricted' => $item['item_meta']['taxableRestricted'][0],
				'taxableUnrestricted' => $item['item_meta']['taxableUnrestricted'][0],
				'numTypeSegAssets' => $item['item_meta']['numTypeSegAssets'][0],
				'wlname'					=> NULL,
				'isParatusDeed' 	=> $isParatusDeed,
		);

        
		//$request = new WP_Http();
		//$response = $request->post($post_url, array('body' => $body));
		return $body;
}


?>