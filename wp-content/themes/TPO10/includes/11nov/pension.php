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
		
		if (!is_Null()){
		
		}
		
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
			
		// switch ($corpTeeAddress){
		// case "Same as Fund Address":
			// $trusteeCompanyRegisteredOffice = $fundAddress;
			// break;

		// case "Other Address":
			// $trusteeCompanyRegisteredOffice = array(
			
				// 'careOf' => $item['item_meta']['corpTeeAddressCareOf'][0],
				// 'levelName' => $item['item_meta']['corpTeeAddressLevel'][0],
				// 'streetName' => $item['item_meta']['corpTeeAddressStreet'][0], 
				// 'suburbName' => $item['item_meta']['corpTeeAddressSuburb'][0],
				// 'stateName' => $item['item_meta']['corpTeeAddressState'][0],
				// 'postcode' => $item['item_meta']['corpTeeAddressPostcode'][0]
			
			// );
			// break;
		// default: 
			// $trusteeCompanyRegisteredOffice = NULL;
		// }
		
		//Member Address
		$membersw = $item['item_meta']['memberAddressSameAsFund'][0];
		switch ($membersw) {
		case "Same as registered address":
			$memberAddress = $fundAddress;
			break;

		case "Other Address":
			$memberAddress = array(
			'careOf' => $item['item_meta']['memberAddressCareOf'][0],
			'levelName' => $item['item_meta']['memberAddressLevel'][0],
			'streetName' => $item['item_meta']['memberAddressStreet'][0],
			'suburbName' => $item['item_meta']['memberAddressSuburb'][0],
			'stateName' => $item['item_meta']['memberAddressState'][0],
			'postcode' => $item['item_meta']['memberAddressPostcode'][0]
			);
			break;
		default:
			$memberAddress = NULL;
		}

		//Reversionary Address
		$revsw = $item['item_meta']['reversionerAddressSameAsFund'][0];
		switch ($revsw) {
		case "Same as registered address":
			$revAddress = $fundAddress;
			break;

		case "Other Address":
			$revAddress = array(
			'careOf' => $item['item_meta']['reversionerAddressCareOf'][0],
			'levelName' => $item['item_meta']['reversionerAddressLevel'][0],
			'streetName' => $item['item_meta']['reversionerAddressStreet'][0],
			'suburbName' => $item['item_meta']['reversionerAddressSuburb'][0],
			'stateName' => $item['item_meta']['reversionerAddressState'][0],
			'postcode' => $item['item_meta']['reversionerAddressPostcode'][0]
			);
			break;
		default:
			$revAddress = NULL;
		}
	
		
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
		switch ($memberIs) {
		
			case 'Director 1':
				$memberNamePrefix = $item['item_meta']['t1D1Title'][0];
				$memberGivenNames = $item['item_meta']['t1D1GivenNames'][0];
				$memberFamilyName = $item['item_meta']['t1D1FamilyName'][0];
			break;
			
			case 'Director 2':
				$memberNamePrefix = $item['item_meta']['t2D2Title'][0];
				$memberGivenNames = $item['item_meta']['t2D2GivenNames'][0];
				$memberFamilyName = $item['item_meta']['t2D2FamilyName'][0];
			break;
			
			case 'Director 3':
				$memberNamePrefix = $item['item_meta']['t3D3Title'][0];
				$memberGivenNames = $item['item_meta']['t3D3GivenNames'][0];
				$memberFamilyName = $item['item_meta']['t3D3FamilyName'][0];
			break;
			
			case 'Director 4':
				$memberNamePrefix = $item['item_meta']['t4D4Title'][0];
				$memberGivenNames = $item['item_meta']['t4D4GivenNames'][0];
				$memberFamilyName = $item['item_meta']['t4D4FamilyName'][0];
			break;
		
			case 'Trustee 1':
				$memberNamePrefix = $item['item_meta']['t1D1Title'][0];
				$memberGivenNames = $item['item_meta']['t1D1GivenNames'][0];
				$memberFamilyName = $item['item_meta']['t1D1FamilyName'][0];
			break;
			
			case 'Trustee 2':
				$memberNamePrefix = $item['item_meta']['t2D2Title'][0];
				$memberGivenNames = $item['item_meta']['t2D2GivenNames'][0];
				$memberFamilyName = $item['item_meta']['t2D2FamilyName'][0];
			break;
			
			case 'Trustee 3':
				$memberNamePrefix = $item['item_meta']['t3D3Title'][0];
				$memberGivenNames = $item['item_meta']['t3D3GivenNames'][0];
				$memberFamilyName = $item['item_meta']['t3D3FamilyName'][0];
			break;
			
			case 'Trustee 4':
				$memberNamePrefix = $item['item_meta']['t4D4Title'][0];
				$memberGivenNames = $item['item_meta']['t4D4GivenNames'][0];
				$memberFamilyName = $item['item_meta']['t4D4FamilyName'][0];
			break;
			
			case 'Other Person':
				$memberNamePrefix = $item['item_meta']['memberTitle'][0];
				$memberGivenNames = $item['item_meta']['memberGivenNames'][0];
				$memberFamilyName = $item['item_meta']['memberFamilyName'][0];
			break;
		
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
			$maximum = $item['item_meta']['totalAccountBalance'][0];
			$minimum = $item['item_meta']['abpMinimum'][0];
		}
		else {
			$totalAccountBalance = $item['item_meta']['totalAccountBalance'][0];
			$maximum = $totalAccountBalance * 0.1;
			$minimum = $item['item_meta']['abpMinimum'][0];
		}
		
		//set if reversionary
		if ($item['item_meta']['nominateReversionary'][0] == "Yes") {
			$isReversionary = 1;
			$reversionerName = $item['item_meta']['reversionaryFullName'][0];
		}
		else {
			$isReversionary = 0;
			$reversionerName = 'None.';
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
		$chairpersonStr = $item['item_meta']['chairperson'][0];
		switch ($chairpersonStr) {
			case 'Trustee 1':
				$chairperson = $item['item_meta']['t1D1GivenNames'][0].' '.$item['item_meta']['t1D1FamilyName'][0];
			break;
				
			case 'Trustee 2':
				$chairperson = $item['item_meta']['t2D2GivenNames'][0].' '.$item['item_meta']['t2D2FamilyName'][0];
			break;
			
			case 'Trustee 3':
				$chairperson = $item['item_meta']['t3D3GivenNames'][0].' '.$item['item_meta']['t3D3FamilyName'][0];
			break;
			
			case 'Trustee 4':
				$chairperson = $item['item_meta']['t4D4GivenNames'][0].' '.$item['item_meta']['t4D4FamilyName'][0];
			break;
			
			case 'Director 1':
				$chairperson = $item['item_meta']['t1D1GivenNames'][0].' '.$item['item_meta']['t1D1FamilyName'][0];
			break;
			
			case 'Director 2':
				$chairperson = $item['item_meta']['t2D2GivenNames'][0].' '.$item['item_meta']['t2D2FamilyName'][0];
			break;
			
			case 'Director 3':
				$chairperson = $item['item_meta']['t3D3GivenNames'][0].' '.$item['item_meta']['t3D3FamilyName'][0];
			break;
			
			case 'Director 4':
				$chairperson = $item['item_meta']['t4D4GivenNames'][0].' '.$item['item_meta']['t4D4FamilyName'][0];
			break;
		
		}
		
		
		
		//calculate age of Member at commencement date in years
		$commencementDateStr = $item['item_meta']['commencementDate'][0];
		$commencementDateStr = str_replace('/','-', $commencementDateStr);
		$day = '';
		$month = '';
		$year = '';
		list($day, $month, $year) = explode('-', $commencementDateStr);
		if (strlen($commencementDateStr) > 1){
			$commencementDate = date('d-m-Y', strtotime($commencementDateStr));
			//$commencementDateTwo = strtotime($commencementDateStr);
			//mktime(0, 0, 0, $month, $day, $year);
			//$commencementDate = new DateTime($commencementDateStr);
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
			//$memberdobDateTwo = strtotime($memberdob);
			//mktime(0, 0, 0, $month, $day, $year);
			//$memberdobDate = new DateTime($memberdob);
		}
		else {
			$memberdobDate = NULL;
		}
		
		//$years = date('Y', $commencementDateTwo) - date('Y', $memberdobDateTwo);
		//$endMonth = date('m', $commencementDateTwo);
		//$startMonth = date('m', $memberdobDateTwo);
		
		// //calculate months
		// $months = $endMonth - $startMonth;
		// if ($months <=0) {
			// $months += 12;
			// $years --;
		
		// }
		// if ($years < 0){
			// $years = 0;
		// }
		
		// $diff = $years;
		
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
				'setAsset1Name' => NULL,
				'setAsset2Name' => NULL,
				'setAsset3Name' => NULL,
				'setAsset4Name' => NULL,
				'setAsset5Name' => NULL,
				'setAsset6Name' => NULL,
				'setAsset7Name' => NULL,
				'setAsset8Name' => NULL,
				'setAsset9Name' => NULL,
				'setAsset10Name' => NULL,
				'setAsset11Name' => NULL,
				'setAsset12Name' => NULL,
				'setAsset13Name' => NULL,
				'setAsset14Name' => NULL,
				'setAsset15Name' => NULL,
				'setAsset16Name' => NULL,
				'setAsset17Name' => NULL,
				'setAsset18Name' => NULL,
				'setAsset19Name' => NULL,
				'setAsset20Name' => NULL,
				'setAsset21Name' => NULL,
				'setAsset22Name' => NULL,
				'setAsset23Name' => NULL,
				'setAsset24Name' => NULL,
				'setAsset25Name' => NULL,
				'setAsset26Name' => NULL,
				'setAsset27Name' => NULL,
				'setAsset28Name' => NULL,
				'setAsset29Name' => NULL,
				'setAsset30Name' => NULL,
				'setAsset31Name' => NULL,
				'setAsset32Name' => NULL,
				'setAsset33Name' => NULL,
				'setAsset34Name' => NULL,
				'setAsset35Name' => NULL,
				'setAsset36Name' => NULL,
				'setAsset37Name' => NULL,
				'setAsset38Name' => NULL,
				'setAsset39Name' => NULL,
				'setAsset40Name' => NULL,
				'setAsset41Name' => NULL,
				'setAsset42Name' => NULL,
				'setAsset43Name' => NULL,
				'setAsset44Name' => NULL,
				'setAsset45Name' => NULL,
				'setAsset46Name' => NULL,
				'setAsset47Name' => NULL,
				'setAsset48Name' => NULL,
				'setAsset49Name' => NULL,
				'setAsset50Name' => NULL,
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
				'setAsset1MarketValue' => NULL,
				'setAsset2MarketValue' => NULL,
				'setAsset3MarketValue' => NULL,
				'setAsset4MarketValue' => NULL,
				'setAsset5MarketValue' => NULL,
				'setAsset6MarketValue' => NULL,
				'setAsset7MarketValue' => NULL,
				'setAsset8MarketValue' => NULL,
				'setAsset9MarketValue' => NULL,
				'setAsset10MarketValue' =>  NULL,
				'setAsset11MarketValue' => NULL,
				'setAsset12MarketValue' => NULL,
				'setAsset13MarketValue' => NULL,
				'setAsset14MarketValue' => NULL,
				'setAsset15MarketValue' => NULL,
				'setAsset16MarketValue' => NULL,
				'setAsset17MarketValue' => NULL,
				'setAsset18MarketValue' => NULL,
				'setAsset19MarketValue' => NULL,
				'setAsset20MarketValue' => NULL,
				'setAsset21MarketValue' => NULL,
				'setAsset22MarketValue' => NULL,
				'setAsset23MarketValue' => NULL,
				'setAsset24MarketValue' => NULL,
				'setAsset25MarketValue' => NULL,
				'setAsset26MarketValue' => NULL,
				'setAsset27MarketValue' => NULL,
				'setAsset28MarketValue' => NULL,
				'setAsset29MarketValue' => NULL,
				'setAsset30MarketValue' => NULL,
				'setAsset31MarketValue' => NULL,
				'setAsset32MarketValue' => NULL,
				'setAsset33MarketValue' => NULL,
				'setAsset34MarketValue' => NULL,
				'setAsset35MarketValue' => NULL,
				'setAsset36MarketValue' => NULL,
				'setAsset37MarketValue' => NULL,
				'setAsset38MarketValue' => NULL,
				'setAsset39MarketValue' => NULL,
				'setAsset40MarketValue' => NULL,
				'setAsset41MarketValue' => NULL,
				'setAsset42MarketValue' => NULL,
				'setAsset43MarketValue' => NULL,
				'setAsset44MarketValue' => NULL,
				'setAsset45MarketValue' => NULL,
				'setAsset46MarketValue' => NULL,
				'setAsset47MarketValue' => NULL,
				'setAsset48MarketValue' => NULL,
				'setAsset49MarketValue' => NULL,
				'setAsset50MarketValue' => NULL,
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
				'orderDate'	  => $orderDate
		);

        
		//$request = new WP_Http();
		//$response = $request->post($post_url, array('body' => $body));
		return $body;
}


?>