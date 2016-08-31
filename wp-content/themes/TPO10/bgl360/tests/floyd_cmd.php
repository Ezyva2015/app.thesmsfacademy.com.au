<?php

$cmd = 'curl -X POST https://api-staging.bgl360.com.au/fund/list --header "Authorization:bearer df2f0e40-606f-4311-8066-590732fd126b';
$data = exec($cmd);

print_r($data);