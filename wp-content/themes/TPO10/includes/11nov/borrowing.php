<?php
//////////////////////////////////////////////////////////
//														//
//														//
//														//
//					  Borrowing			 				//
//														//
//														//
//														//
//////////////////////////////////////////////////////////
function borrowing_post_Data($item, $order_id, $deedVersion, $constitutionVersion, $billingArray, $billingName, $billingCompany, $billing_phone, $product_id, $adviserEmail, $userID, $orderDate) {
	
		$yourRef 		= $item['item_meta']['yourRef'][0];
		
		//Fund Registered Address
		$fundAddress = array (
			'careOf' => $item['item_meta']['fundAddressCareOf'][0],
			'levelName' => $item['item_meta']['fundAddressLevel'][0],
			'streetName' => $item['item_meta']['fundAddressStreet'][0],
			'suburbName' => $item['item_meta']['fundAddressSuburb'][0],
			'stateName' => $item['item_meta']['fundAddressState'][0],
			'postcode' => $item['item_meta']['fundAddressPostcode'][0]
			);
		
		//Fund Corporate Trustee Address
		$trusteeCompanyRegisteredOffice = array(
			
				'careOf' => $item['item_meta']['corpTeeAddressCareOf'][0],
				'levelName' => $item['item_meta']['corpTeeAddressLevel'][0],
				'streetName' => $item['item_meta']['corpTeeAddressStreet'][0], 
				'suburbName' => $item['item_meta']['corpTeeAddressSuburb'][0],
				'stateName' => $item['item_meta']['corpTeeAddressState'][0],
				'postcode' => $item['item_meta']['corpTeeAddressPostcode'][0]
			
			);
	
		//Bare Trustee Registered Address
		if($item['item_meta']['bareTrusteeType'][0] == "Company"){
			$bareTrusteeCompanyRegisteredOffice = array(
				
					'careOf' => $item['item_meta']['bareTeeAddressCareOf'][0],
					'levelName' => $item['item_meta']['bareTeeAddressLevel'][0],
					'streetName' => $item['item_meta']['bareTeeAddressStreet'][0], 
					'suburbName' => $item['item_meta']['bareTeeAddressSuburb'][0],
					'stateName' => $item['item_meta']['bareTeeAddressState'][0],
					'postcode' => $item['item_meta']['bareTeeAddressPostcode'][0]
				
				);
			$bareTrustRegAddress = NULL;
		
		}
		else {
				$bareTrustRegAddress = array(
				
					'careOf' => $item['item_meta']['bareTeeAddressCareOf'][0],
					'levelName' => $item['item_meta']['bareTeeAddressLevel'][0],
					'streetName' => $item['item_meta']['bareTeeAddressStreet'][0], 
					'suburbName' => $item['item_meta']['bareTeeAddressSuburb'][0],
					'stateName' => $item['item_meta']['bareTeeAddressState'][0],
					'postcode' => $item['item_meta']['bareTeeAddressPostcode'][0]
				
				);
				$bareTrusteeCompanyRegisteredOffice = NULL;
				
		}
		
		
		
		
		//Adviser Address
		$adviserAddress = array(
			'levelName' => NULL,
			'streetName' => '',
			'suburbName' => '',
			'stateName' => '',
			'postcode' => ''
		);
		
		
		//Billing Address
		$billingAddresArray = array (
		
			'careOf' => NULL,
			'levelName' => NULL,
			'streetName' => $billingArray[0].' '.$billingArray[1],
			'suburbName' => $billingArray[2],
			'stateName' => $billingArray[3],
			'postcode' => $billingArray[4]
		
		);
		
		
		
		//Set number of directors or number of individual trustees
		if ($item['item_meta']['trusteeType'][0] == "Company"){
			$numIndivTees = NULL;
			$numDirectors = $item['item_meta']['corpTeeNumDirectors'][0];
		}
		else {
			$numIndivTees = $item['item_meta']['indivTeeNumTees'][0];
			$numDirectors = NULL;
		}
		
		
		//set t1d1 Member
		if ($item['item_meta']['t1D1IsMember'][0] == "Yes"){
			$t1D1IsMember = 1;
		}
		else {
			$t1D1IsMember = 0;
		}
		
		//set t2d2 Member
		if ($item['item_meta']['t1D1IsMember'][0] == "Yes"){
			$t2D2IsMember = 1;
		}
		else {
			$t2D2IsMember = 0;
		}
		
		//set t1d1 Member
		if ($item['item_meta']['t3D3IsMember'][0] == "Yes"){
			$t3D3IsMember = 1;
		}
		else {
			$t3D3IsMember = 0;
		}
		
		//set t1d1 Member
		if ($item['item_meta']['t4D4IsMember'][0] == "Yes"){
			$t4D4IsMember = 1;
		}
		else {
			$t4D4IsMember = 0;
		}
		
		//set property address
		if ($item['item_meta']['propertyAddressKnown'][0] == "Yes"){
			$propertyAddressKnown = 1;
			//Property Address
			$propertyAddress = array(
				'careOf' => NULL,
				'levelName' => $item['item_meta']['propertyAddressLevel'][0],
				'streetName' => $item['item_meta']['propertyAddressStreet'][0], 
				'suburbName' => $item['item_meta']['propertyAddressSuburb'][0],
				'stateName' => $item['item_meta']['propertyAddressState'][0],
				'postcode' => $item['item_meta']['propertyAddressPostcode'][0]
			);
		}
		else {
			$propertyAddressKnown = 0;
			$propertyAddress = NULL;
		}
		
		//Set Property Price
		if ($item['item_meta']['propertyPriceKnown'][0] == "Yes"){
			$propertyPriceKnown = 1;
			$propertyPrice = $item['item_meta']['propertyPrice'][0];
		}
		else {
			$propertyPriceKnown = 0;
			$propertyPrice = NULL;
		}
		
		//Set vendors
		if ($item['item_meta']['propertyVendorKnown'][0] == "Yes"){
			$numVendors = $item['item_meta']['propertyNumVendors'][0];
			$vendorKnown = 1;
			switch ($numVendors) {
			
				case '1' :
					$v1Name = $item['item_meta']['v1Name'][0];
					$v2Name = NULL;
					$v3Name = NULL;
					$v4Name = NULL;
					$v5Name = NULL;
					$v6Name = NULL;
				break;

				case '2' :
					$v1Name = $item['item_meta']['v1Name'][0];
					$v2Name = $item['item_meta']['v2Name'][0];
					$v3Name = NULL;
					$v4Name = NULL;
					$v5Name = NULL;
					$v6Name = NULL;
				break;
				
				case '3' :
					$v1Name = $item['item_meta']['v1Name'][0];
					$v2Name = $item['item_meta']['v2Name'][0];
					$v3Name = $item['item_meta']['v3Name'][0];
					$v4Name = NULL;
					$v5Name = NULL;
					$v6Name = NULL;
				break;
				
				case '4' :
					$v1Name = $item['item_meta']['v1Name'][0];
					$v2Name = $item['item_meta']['v2Name'][0];
					$v3Name = $item['item_meta']['v3Name'][0];
					$v4Name = $item['item_meta']['v4Name'][0];
					$v5Name = NULL;
					$v6Name = NULL;
				break;
				
				case '5' :
					$v1Name = $item['item_meta']['v1Name'][0];
					$v2Name = $item['item_meta']['v2Name'][0];
					$v3Name = $item['item_meta']['v3Name'][0];
					$v4Name = $item['item_meta']['v4Name'][0];
					$v5Name = $item['item_meta']['v5Name'][0];
					$v6Name = NULL;
				break;
			
				case '6' :
					$v1Name = $item['item_meta']['v1Name'][0];
					$v2Name = $item['item_meta']['v2Name'][0];
					$v3Name = $item['item_meta']['v3Name'][0];
					$v4Name = $item['item_meta']['v4Name'][0];
					$v5Name = $item['item_meta']['v5Name'][0];
					$v6Name = $item['item_meta']['v6Name'][0];
				break;
			}
		}
		else {
			$vendorKnown = 0;
		}
		
		//Set Related Party
		if ($item['item_meta']['isVendorRelated'][0] == "Yes"){
			$isVendorRelated = 1;
			if($item['item_meta']['isPropertyBRP'][0] == "Yes"){
				$isPropertyBRP = 1;
			}
			else{
				$isPropertyBRP = 0;
			}
			
			if($item['item_meta']['isPropertyBRPQ2'][0] == "Yes"){
				$isPropertyBRPQ2 = 1;
			}
			else {
				$isPropertyBRPQ2 = 0;
			}
		}
		else {
			$isVendorRelated = 0;
			$isPropertyBRP = 0;
			$isPropertyBRPQ2 = 0;
		}
		
		//Set Lease Details
		if ($item['item_meta']['isCurrentRelatedLease'][0] == "Yes"){
			$isCurrentRelatedLease = 1;
			if ($item['item_meta']['isCurrentRelatedLeaseContinuing'][0] == "Yes"){
				$isCurrentRelatedLeaseContinuing = 1;
				$lesseeName = $item['item_meta']['relatedLesseeName'][0];
				$lesseeAcn  = $item['item_meta']['lesseeACN'][0];
				
			}
			else {
				$isCurrentRelatedLeaseContinuing = 0;
				if($item['item_meta']['willHaveNewLease'][0] == "Yes"){
					$willHaveNewLease = 1;
					$lesseeName = $item['item_meta']['relatedLesseeName'][0];
					$lesseeAcn  = $item['item_meta']['lesseeACN'][0];
				}
				else {
					$willHaveNewLease = 0;
					$lesseeName = NULL;
					$lesseeAcn  = NULL;
				}
			}
		}
		else {
			$isCurrentRelatedLease = 0;
			$isCurrentRelatedLeaseContinuing = 0;
			if($item['item_meta']['willHaveNewLease'][0] == "Yes"){
					$willHaveNewLease = 1;
					$lesseeName = $item['item_meta']['relatedLesseeName'][0];
					$lesseeAcn  = $item['item_meta']['lesseeACN'][0];
				}
				else {
					$willHaveNewLease = 0;
					$lesseeName = NULL;
					$lesseeAcn  = NULL;
				}
			
		}
		
		//Set lender details
		if($item['item_meta']['isLenderKnown'][0] == "Yes"){
					$isLenderKnown = 1;
					if($item['item_meta']['lenderName'][0] == "Other"){
						$lenderName = $item['item_meta']['otherLenderName'][0];
					}
					else {
						$lenderName = $item['item_meta']['lenderName'][0];
					}
				}
				else {
					$isLenderKnown = 0;
					$lenderName = NULL;
				}
		
		//Set Loan Details
		
		if($item['item_meta']['loanAmountKnown'][0] == "Yes"){
			$loanAmount = $item['item_meta']['loanAmount'][0];
			$isLoanAmountKnown = 1;
				}
		else {	
			$loanAmount = NULL;	
			$isLoanAmountKnown = 0;
				}
		
		//Set Same Directors for both trustees
		if ($item['item_meta']['corpBareTeeDirectorsSameAsFundDirectors'][0] == "Yes"){
			$corpBareTeeDirectorsSameAsFundDirectors = 1;
			$indivBareTeeSameAsFundIndivTee = 0;
			$bt1D1Title 				= $item['item_meta']['t1D1Title'][0];
			$bt1D1GivenNames 			= $item['item_meta']['t1D1GivenNames'][0];
			$bt1D1FamilyName 			= $item['item_meta']['t1D1FamilyName'][0];
			$bt2D2Title 				= $item['item_meta']['t2D2Title'][0];
			$bt2D2GivenNames 			= $item['item_meta']['t2D2GivenNames'][0];
			$bt2D2FamilyName 			= $item['item_meta']['t2D2FamilyName'][0];
			$bt3D3Title					= $item['item_meta']['t3D3Title'][0];
			$bt3D3GivenNames 			= $item['item_meta']['t3D3GivenNames'][0];
			$bt3D3FamilyName 			= $item['item_meta']['t3D3FamilyName'][0];
			$bt4D4Title					= $item['item_meta']['t4D4Title'][0];
			$bt4D4GivenNames 			= $item['item_meta']['t4D4GivenNames'][0];
			$bt4D4FamilyName 			= $item['item_meta']['t4D4FamilyName'][0];
			$bareTrustNumDirectors 		= $numDirectors;
		
		}
		elseif ($item['item_meta']['indivBareTeeSameAsFundIndivTee'][0] == "Yes"){
			$corpBareTeeDirectorsSameAsFundDirectors = 0;
			$indivBareTeeSameAsFundIndivTee = 1;
			$bt1D1Title 				= $item['item_meta']['t1D1Title'][0];
			$bt1D1GivenNames 			= $item['item_meta']['t1D1GivenNames'][0];
			$bt1D1FamilyName 			= $item['item_meta']['t1D1FamilyName'][0];
			$bt2D2Title 				= $item['item_meta']['t2D2Title'][0];
			$bt2D2GivenNames 			= $item['item_meta']['t2D2GivenNames'][0];
			$bt2D2FamilyName 			= $item['item_meta']['t2D2FamilyName'][0];
			$bt3D3Title					= $item['item_meta']['t3D3Title'][0];
			$bt3D3GivenNames 			= $item['item_meta']['t3D3GivenNames'][0];
			$bt3D3FamilyName 			= $item['item_meta']['t3D3FamilyName'][0];
			$bt4D4Title					= $item['item_meta']['t4D4Title'][0];
			$bt4D4GivenNames 			= $item['item_meta']['t4D4GivenNames'][0];
			$bt4D4FamilyName 			= $item['item_meta']['t4D4FamilyName'][0];
			$bareTrustNumIndivTees	 	= $numIndivTees;
			
		}
		
		else {
			$corpBareTeeDirectorsSameAsFundDirectors = 0;
			$indivBareTeeSameAsFundIndivTee = 0;
			$bt1D1Title 				= $item['item_meta']['btT1D1Title'][0];
			$bt1D1GivenNames 			= $item['item_meta']['btT1D1GivenNames'][0];
			$bt1D1FamilyName 			= $item['item_meta']['btT1D1FamilyName'][0];
			$bt2D2Title 				= $item['item_meta']['btT2D2Title'][0];
			$bt2D2GivenNames 			= $item['item_meta']['btT2D2GivenNames'][0];
			$bt2D2FamilyName 			= $item['item_meta']['btT2D2FamilyName'][0];
			$bt3D3Title					= $item['item_meta']['btT3D3Title'][0];
			$bt3D3GivenNames 			= $item['item_meta']['btT3D3GivenNames'][0];
			$bt3D3FamilyName 			= $item['item_meta']['btT3D3FamilyName'][0];
			$bt4D4Title					= $item['item_meta']['btT4D4Title'][0];
			$bt4D4GivenNames 			= $item['item_meta']['btT4D4GivenNames'][0];
			$bt4D4FamilyName 			= $item['item_meta']['btT4D4FamilyName'][0];
			$bareTrustNumDirectors 		= $item['item_meta']['corpBareTeeNumDirectors'][0];
			$bareTrustNumIndivTees	= $item['item_meta']['indivBareTeeNumTees'][0];
		}
		
		
		$body= array( 
			'yourRef' 					=> $yourRef,
			'fundName' 					=> 	$item['item_meta']['fundName'][0],
			'fundEstablishmentDate' 	=> $item['item_meta']['fundEstDate'][0],
			'trusteeType' 				=> $item['item_meta']['trusteeType'][0],
			'numIndivTees' 				=> $numIndivTees,
			'numDirectors' 				=> $numDirectors,
			't1D1Title' 				=> $item['item_meta']['t1D1Title'][0],
			't1D1GivenNames' 			=> $item['item_meta']['t1D1GivenNames'][0],
			't1D1FamilyName' 			=> $item['item_meta']['t1D1FamilyName'][0],
			't1D1IsMember' 				=> $t1D1IsMember,
			't2D2Title' 				=> $item['item_meta']['t2D2Title'][0],
			't2D2GivenNames' 			=> $item['item_meta']['t2D2GivenNames'][0],
			't2D2FamilyName' 			=> $item['item_meta']['t2D2FamilyName'][0],
			't2D2IsMember' 				=> $t2D2IsMember,
			't3D3Title' 				=> $item['item_meta']['t3D3Title'][0],
			't3D3GivenNames' 			=> $item['item_meta']['t3D3GivenNames'][0],
			't3D3FamilyName' 			=> $item['item_meta']['t3D3FamilyName'][0],
			't3D3IsMember' 				=> $t3D3IsMember,
			't4D4Title' 				=> $item['item_meta']['t4D4Title'][0],
			't4D4GivenNames' 			=> $item['item_meta']['t4D4GivenNames'][0],
			't4D4FamilyName' 			=> $item['item_meta']['t4D4FamilyName'][0],
			't4D4IsMember' 				=> $t4D4IsMember,
			'corpTeeName' 				=> $item['item_meta']['corpTeeName'][0],
			'corpTeeAcn' 				=> $item['item_meta']['corpTeeAcn'][0],
			'fundRegAddress' 			=> $fundAddress,
			'corpTeeRegAddress' 		=> $trusteeCompanyRegisteredOffice,
			'propertyAddressKnown' 		=> $propertyAddressKnown,
			'propertyAddress' 			=> $propertyAddress,
			'propertyType' 				=> $item['item_meta']['propertyType'][0],
			'propertyPriceKnown' 		=> $propertyPriceKnown,
			'propertyPrice' 			=> $propertyPrice,
			'vendorKnown' 				=> $vendorKnown,
			'numVendors' 				=> $item['item_meta']['propertyNumVendors'][0],
			'firstVendorName' 			=> $v1Name,
			'secondVendorName' 			=> $v2Name,
			'thirdVendorName' 			=> $v3Name,
			'fourthVendorName' 			=> $v4Name,
			'fifthVendorName' 			=> $v5Name,
			'sixthVendorName' 			=> $v6Name,
			'isVendorRelated' 			=> $isVendorRelated,
			'propertyCurrentlyUsedBus' 	=> $isPropertyBRP,
			'propertyWillBeUsedBus' 	=> $isPropertyBRPQ2,
			'propertyHasRPLease' 		=> $isCurrentRelatedLease,
			'willRPLeaseContinue' 		=> $isCurrentRelatedLeaseContinuing,
			'willHaveNewLease'			=> $willHaveNewLease,
			'lesseeName' 				=> $lesseeName,
			'lesseeACN' 				=> $lesseeAcn,
			'isLenderKnown' 			=> $isLenderKnown,
			'lenderName' 				=> $lenderName,
			'isLoanAmountKnown' 		=> $isLoanAmountKnown,
			'loanAmount' 				=> $loanAmount,
			'bareTrustName' 			=> $item['item_meta']['bareTrustName'][0],
			'bareTrusteeType' 			=> $item['item_meta']['bareTrusteeType'][0],
			'bareTrustCorpTeeName' 		=> $item['item_meta']['bareTrusteeCorpName'][0],
			'bareTrustCorpTeeAcn' 		=> $item['item_meta']['bareTrusteeACN'][0],
			'bareTrustDirsSameAsFundDirs' => $corpBareTeeDirectorsSameAsFundDirectors,
			'bareTrustNumDirs' 			=> $bareTrustNumDirectors,
			'bareTrustNumIndivTees' 	=> $bareTrustNumIndivTees,
			'bareTrustIndivsSameAsFundIndivs' => $indivBareTeeSameAsFundIndivTee,
			'bt1D1Title' 				=> $bt1D1Title,
			'bt1D1GivenNames' 			=> $bt1D1GivenNames,
			'bt1D1FamilyName' 			=> $bt1D1FamilyName,
			'bt2D2Title' 				=> $bt2D2Title,
			'bt2D2GivenNames' 			=> $bt2D2GivenNames,
			'bt2D2FamilyName' 			=> $bt2D2FamilyName,
			'bt3D3Title' 				=> $bt3D3Title,
			'bt3D3GivenNames' 			=> $bt3D3GivenNames,
			'bt3D3FamilyName' 			=> $bt3D3FamilyName,
			'bt4D4Title' 				=> $bt4D4Title,
			'bt4D4GivenNames' 			=> $bt4D4GivenNames,
			'bt4D4FamilyName' 			=> $bt4D4FamilyName,
			'bareTrustRegAddress' 		=> $bareTrustRegAddress,
			'bareTrustCorpTeeRegAddress' => $bareTrusteeCompanyRegisteredOffice,
			'adviserName' 				=> $billingName,
			'adviserCompany' 			=> $billingCompany,
			'adviserAddress' 			=> $billingAddresArray,
			'adviserPhone' 				=> $billing_phone,
			'orderNumber' 				=> $order_id,
			'userID'	  				=> $userID,
			'productID'	  				=> $product_id,
			'adviserEmail' 				=> $adviserEmail,
			'orderDate'	  				=> $orderDate
		);

        
		//$request = new WP_Http();
		//$response = $request->post($post_url, array('body' => $body));
		return $body;
}


?>