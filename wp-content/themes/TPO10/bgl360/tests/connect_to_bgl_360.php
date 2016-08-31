<?php
// create curl resource
$ch = curl_init();

// set url
curl_setopt($ch, CURLOPT_URL, 'https://api-staging.bgl360.com.au/fund/list --header "Authorization:bearer df2f0e40-606f-4311-8066-590732fd126b"');

//return the transfer as a string
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

// $output contains the output string
$output = curl_exec($ch);

// close curl resource to free up system resources
curl_close($ch);


print_r($output );