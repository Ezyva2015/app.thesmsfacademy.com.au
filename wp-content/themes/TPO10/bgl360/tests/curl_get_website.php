<?php
echo "test";




$url = 'https://api-staging.bgl360.com.au/fund/list';


$chandler = curl_init();


curl_setopt($chandler, CURLOPT_URL, $url);
curl_setopt($chandler, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($chandler, CURLOPT_CONNECTTIMEOUT, 5);
$curlResutl = curl_exec($chandler);

echo "<pre>";
print_r($curlResutl);