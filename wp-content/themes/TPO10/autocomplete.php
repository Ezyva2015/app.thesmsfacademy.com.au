<?php

define('DB_HOST', 'localhost');
define('DB_NAME', 'tpocom_tpdash');
define('DB_USER','tpocom_tpdash');
define('DB_PASSWORD','w2P!9A-Si0');

$con=mysql_connect(DB_HOST,DB_USER,DB_PASSWORD) or die("Failed to connect to MySQL: " . mysql_error());
$db=mysql_select_db(DB_NAME,$con) or die("Failed to connect to MySQL: " . mysql_error());


if($_GET['type'] == 'document'){
	$result = mysql_query("SELECT name,url FROM document_list where name LIKE '".strtoupper($_GET['name_startsWith'])."%'");
	$data = array();
	while ($row = mysql_fetch_array($result)) {
		array_push($data, array($row['name'],$row['url']));
	}	
	echo json_encode($data);
	
}


?>