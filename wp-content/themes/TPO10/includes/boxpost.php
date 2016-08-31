<?php 
	
	//Create Folder
	$relativeFilePath = 'includes.rar';
	$relativeFilePath = realpath($relativeFilePath);
	//echo $relativeFilePath;
	$folder = '1169288163';
	$fields = array('action' => 'upload_file', 'file_path' => $relativeFilePath, 'folder' => $folder);
	$result = execCurl('https://www.paratus.com.au/wp-content/themes/goodchoice/includes/paratus-box-api/boxapi/app/index.php', $fields);
	print_r($result);
	
	function execCurl($url, $fields)

	{

		$ch = curl_init(); 

		curl_setopt($ch, CURLOPT_URL, $url);

		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);

		curl_setopt($ch, CURLOPT_POST, true);

		curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

		$result = curl_exec($ch); 

		curl_close($ch);	

		

		return $result;

	}
	
?>