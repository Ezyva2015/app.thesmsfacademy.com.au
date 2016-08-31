<?php
    if(isset($_POST['input_130'])) {
	require_once($_SERVER['DOCUMENT_ROOT'].'/wp-blog-header.php');
	$entry = GFAPI::get_entry($_POST['input_130']);
	//$entry = GFAPI::get_entry(1431);
	$response = array();
	$response['companyName'] = $entry['1'];
	
	
	
	if($entry['389'] == 'Manual Address Input'){
		$response['companyAddress'] = $entry['141'].' '.$entry['142'].' '.$entry['143'].' '.$entry['144'].' '.$entry['145'];
	}
	else {
		$response['companyAddress'] = $entry['391'].' '.$entry['392'].' '.$entry['393'].' '.$entry['394'].' '.$entry['395'];
	}
	
	switch($entry['83']){
		case 1:
			$response['d1'] = $entry['519'];
			$response['numdirs'] = 1;
		break;
		
		case 2:
			$response['d1'] = $entry['519'];
			$response['d2'] = $entry['520'];
			$response['numdirs'] = 2;
		break;
		
		case 3:
			$response['d1'] = $entry['519'];
			$response['d2'] = $entry['520'];
			$response['d3'] = $entry['521'];
			$response['numdirs'] = 3;
		break;
		
		case 4:
			$response['d1'] = $entry['519'];
			$response['d2'] = $entry['520'];
			$response['d3'] = $entry['521'];
			$response['d4'] = $entry['522'];
			$response['numdirs'] = 4;
		break;
		
	}
	
	
	echo json_encode($response);

}

?>