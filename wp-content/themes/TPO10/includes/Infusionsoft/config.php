<?php

$infusionsoft_host = 'zs170.infusionsoft.com';
$infusionsoft_api_key = '63a06aa02bb30148cd7c5d471d8d566d';

//To Add Custom Fields, use the addCustomField method like below.
//Infusionsoft_Contact::addCustomField('_LeadScore');

//Below is just some magic...  Unless you are going to be communicating with more than one APP at the SAME TIME.  You can ignore it.
Infusionsoft_AppPool::addApp(new Infusionsoft_App($infusionsoft_host, $infusionsoft_api_key, 443));