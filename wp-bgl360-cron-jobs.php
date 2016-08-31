<?php
echo "working <br>"; 
error_reporting(E_ALL);
ini_set("display_errors", 1); 
 

/**
 * Include wordpress configuration
 */
require_once( dirname(__FILE__) . '/wp-load.php' );

/**
 * Get wp user
 */
$current_user = wp_get_current_user();

/**
 * Require data
 */
require ("bgl360/app/Http/ServiceBgl360.php");
require ("bgl360/app/Http/AuthenticationBgl360.php");
require ("bgl360/app/Http/ResourceRequestBgl360.php");
require ("bgl360/app/Http/Time.php");
require ("bgl360/app/Http/Controller/AccessToken.php");

/**
 * Class namespace
 */
use App\ServiceBgl360;
use App\AuthenticationBgl360;
use App\ResourceRequestBgl360;
use App\Time;
use App\AccessToken;

/**
 * Initialized global and local variables
 */
global $wpdb;
$totalDaysRemaining = 0;

/**
 * Instantiate classes
 */
$service_bgl360          = new ServiceBgl360($wpdb, $current_user->ID);
$authentication_bgl360   = new AuthenticationBgl360();
$resource_request_bgl360 = new ResourceRequestBgl360();
$time                    = new Time();

/**
 * Get all access token saved to database
 */
$accessData = $service_bgl360->getAccessTokens();

foreach($accessData as $accessToken)
{
    echo "id = " . $accessToken['id'] . "<br>";
    echo " current date " . $time->getCurrentDate() . '<br>';
    echo " expired at date " . $time->toDate($accessToken['expired_at'])  . '<br>';
    echo " Total remaining days " . $time->getTotalRemainingDays($time->getCurrentDate(), $time->toDate($accessToken['expired_at'])) . '<br>'  ;

    /**
     * Get total days remaining
     */
    if($time->getTotalRemainingDays($time->getCurrentDate(), $time->toDate($accessToken['expired_at'])) == 0)
    {
        /**
         * Update access token because total days passed days is 6
         */
        echo "<hr>";
        $accessToken = new AccessToken($wpdb, $accessToken['user_id']);
        $accessToken->refreshAndUpdateAccessToken();

    }
    else
    {
        echo " <span style='color:green'>Nothing to update, all are doing great!</span><br>";
        /**
         * Don't update access token because total days is not yet 6th
         */
    }
}