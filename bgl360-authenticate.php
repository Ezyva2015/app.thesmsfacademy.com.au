<?php
echo "<pre>";
/**
 * Include WordPress configuration
 */
require_once( dirname(__FILE__) . '/wp-load.php' );

/**
 * Get wp user
 */
$current_user = wp_get_current_user();

//If not logged in then page should redirect to main website login page
if($current_user->ID < 1) { header("location: https://app.thesmsfacademy.com.au/wp-login.php"); }

/**
 * Include relevant files
 */
require ("bgl360/app/Http/ServiceBgl360.php");
require ("bgl360/app/Http/AuthenticationBgl360.php");
require ("bgl360/app/Http/ResourceRequestBgl360.php");
require ("bgl360/app/Http/Time.php");

/**
 * Call namespaces
 */
use App\ServiceBgl360;
use App\AuthenticationBgl360;
use App\ResourceRequestBgl360;
use App\Time;

/**
 * Declare local and global variables
 */
global $wpdb;

/**
 * Instantiate classes
 */
$service_bgl360          = new ServiceBgl360($wpdb, $current_user->ID);
$authentication_bgl360   = new AuthenticationBgl360();
$resource_request_bgl360 = new ResourceRequestBgl360();
$time                    = new Time();

/**
 * Set up authentication data
 */

$authentication_bgl360->setRedirectUrlToAuthorizationPage("https://api-staging.bgl360.com.au/oauth/authorize?response_type=code&client_id=5dbf9b2c-981f-44e4-8212-d3b5c74795a1&scope=investment&redirect_uri=https://app.thesmsfacademy.com.au/bgl360-authenticate.php");
$authentication_bgl360->setMainUri('https://api-staging.bgl360.com.au/oauth/token');
$authentication_bgl360->setAuthorizationCode($authentication_bgl360->getAuthorizationCode());
$authentication_bgl360->setGrantType('authorization_code');
$authentication_bgl360->setScope('investment');
$authentication_bgl360->setClientId('5dbf9b2c-981f-44e4-8212-d3b5c74795a1');
$authentication_bgl360->setClientSecret('b5a0ff39-ef93-4bc7-b5de-e0ace2d7a6fc');
$authentication_bgl360->setRedirectUri('https://app.thesmsfacademy.com.au/bgl360-authenticate.php');
$authentication_bgl360->setAccessTokenUri($authentication_bgl360->getAccessTokenUri());

if($service_bgl360->isExistAccessToken())
{
    // Get access token from database
    $userCurrentAccessToken = $service_bgl360->getCurrentAccessTokenByUser();

    // If access token is expired then refresh user's current token
    if($service_bgl360->isUserAccessTokenExpired($userCurrentAccessToken[0]['expires_in']))
    {
        echo "Access Token is expired <br>";
        $authentication_bgl360->setRefreshTokenUrl($userCurrentAccessToken[0]['refresh_token']);
        $authentication_bgl360->setAccessToken($userCurrentAccessToken[0]['access_token']);
        $response = $authentication_bgl360->getRefreshTokenData();

        if($response['error'] == 'invalid_token')
        {
            echo "Refresh token is already used to retrieved new access token <br>";
        }
        else
        {
            // Update access token, refresh token, expired_at and updated_at
            $service_bgl360->updateAccessToken(array(
                'access_token'  => $response['access_token'],
                'refresh_token' => $response['refresh_token'],
                'expired_at'    => $time->getAccessTokenExpireDateTime(),
                'updated_at'    => $time->getCurrentDateTime()
            ));
        }
    }
    else
    {
        // Do nothing
        echo "Access Token is not expired <br>";
    }
}
else
{
    $accessToken = $authentication_bgl360->getAccessToken();

    /**
     * If retrieving access token got an error then should redirect the bgl360 application
     * I think this can be explore more later
     */
    if($accessToken['error'] == 'invalid_grant')
    {
        echo "Invalid grant <br>";
        /**
         * has invalid response
         * then redirect to application authenticate the data
         */
        $authentication_bgl360->redirectUrlToAuthorizationPage();
    }
    else
    {

        echo "Insert new access token<br>";
        // If user don't have access token yet - so new access token must be inserted
        $service_bgl360->insertNewAccessToken(
            array(
                'user_id'=> $current_user->ID ,
                'access_token' => $accessToken['access_token'],
                'token_type' => $accessToken['token_type'],
                'refresh_token' => $accessToken['refresh_token'],
                'expires_in'=> $accessToken['expires_in'],
                'scope'=>$accessToken['scope'],
                'expired_at'=>$time->getAccessTokenExpireDateTime(),
                'updated_at'=>$time->getCurrentDateTime()
            )
        );
    }
}


