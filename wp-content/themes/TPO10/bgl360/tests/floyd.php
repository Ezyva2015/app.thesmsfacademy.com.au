<?php

https://api-staging.bgl360.com.au/oauth/authorize?
//response_type=code
//&client_id=5dbf9b2c-981f-44e4-8212-d3b5c74795a1&scope=developer
//&redirect_uri=https://app.thesmsfacademy.com.au/wp-content/bgl360/index.php
//https://app.thesmsfacademy.com.au/bgl360-connect


$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => "https://api-staging.bgl360.com.au/oauth/authorize?response_type=code&client_id=5dbf9b2c-981f-44e4-8212-d3b5c74795a1&scope=developer&redirect_uri=https://app.thesmsfacademy.com.au/bgl360-connect",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_HTTPHEADER =>  array('Content-Type: application/json' , "Authorization:bearer df2f0e40-606f-4311-8066-590732fd126b" ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
    echo "cURL Error #:" . $err;
} else {
    echo $response;
}
?>