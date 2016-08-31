<?php
error_reporting(-1);
ini_set('display_errors', 'on');
echo 'test';
	require_once("ordertracking.php");
	require_once("D:\inetpub\live\wwwroot\wp-blog-header.php");
	$data = $_POST;

	echo OrderTracking::addToXero($data);

?>