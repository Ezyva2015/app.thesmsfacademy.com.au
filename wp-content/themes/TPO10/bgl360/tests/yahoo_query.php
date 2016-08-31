<?php
$handle = curl_init();

curl_setopt_array(
    $handle,
    array(
        CURLOPT_URL => ' http://search.yahooapis.com/WebSearchService/V1/webSearch',
        CURLOPT_POST => TRUE,
        CURLOPT_POSTFIELDS =>'appid=YahooDemo&query=persimmon&results=10',
        CURLOPT_RETURNTRANSFER =>TRUE,
    )
);

$response = curl_exec($handle);

curl_close($handle);

echo "<pre>";
print_r($response);
echo "</pre>";