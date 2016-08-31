<style>#message{  display: none; } .red {color:red} .green{color:green} .yellow {color:yellow} .black {color:black} </style>
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
//echo "this is authentication page <br>";



$clientId = 'f937a03e-db37-4213-9d37-9484e7eab33d';
$clientSecret = '9a88e4bc-ab1c-41b3-a8b3-a5f7b32502de';
$basicAuthorizationHeader = 'ZjkzN2EwM2UtZGIzNy00MjEzLTlkMzctOTQ4NGU3ZWFiMzNkOjlhODhlNGJjLWFiMWMtNDFiMy1hOGIzLWE1ZjdiMzI1MDJkZQ==';


$authentication_bgl360->setRedirectUrlToAuthorizationPage("https://api.bgl360.com.au/oauth/authorize?response_type=code&client_id=$clientId&scope=investment&redirect_uri=https://app.thesmsfacademy.com.au/wp-bgl360-authenticate.php");
$authentication_bgl360->setMainUri('https://api.bgl360.com.au/oauth/token');
$authentication_bgl360->setAuthorizationCode($authentication_bgl360->getAuthorizationCode());
$authentication_bgl360->setGrantType('authorization_code');
$authentication_bgl360->setScope('investment');
$authentication_bgl360->setClientId($clientId);
$authentication_bgl360->setClientSecret($clientSecret);
$authentication_bgl360->setRedirectUri('https://app.thesmsfacademy.com.au/wp-bgl360-authenticate.php');
$authentication_bgl360->setAccessTokenUri($authentication_bgl360->getAccessTokenUri());

//echo " auth code " . $authentication_bgl360->getAuthorizationCode() . '<br>';
//echo " access token url " . $authentication_bgl360->getAccessTokenUri();
//



if($service_bgl360->isExistAccessToken())
{
    // Get access token from database
    $userCurrentAccessToken = $service_bgl360->getCurrentAccessTokenByUser();

    // If access token is expired then refresh user's current token
    if($service_bgl360->isUserAccessTokenExpired($userCurrentAccessToken[0]['expires_in']))
    {
        echo "<span class='red' >Access Token is expired! </span><br>";
        $authentication_bgl360->setRefreshTokenUrl($userCurrentAccessToken[0]['refresh_token']);
        $authentication_bgl360->setAccessToken($userCurrentAccessToken[0]['access_token']);
        $response = $authentication_bgl360->getRefreshTokenData();


        if($response['error'] == 'invalid_token')
        {
            echo "<span class='red' >Refresh token is already used to retrieved new access token.</span> <br>";

        }
        else
        {
            echo "<span class='yellow' >Updating access token by refresh token...</span><br>";
            // Update access token, refresh token, expired_at and updated_at
            $status = $service_bgl360->updateAccessToken(array(
                'access_token'  => $response['access_token'],
                'refresh_token' => $response['refresh_token'],
                'expired_at'    => $time->getAccessTokenExpireDateTime(),
                'updated_at'    => $time->getCurrentDateTime()
            ));

            if($status == TRUE)
            {
                echo "<span class='green' >Token successfully updated...</span><br>";
            }
            else
            {
                echo "<span class='red' >Token failed to update...</span><br>";
            }
        }
    }
    else
    {
        // Do nothing
        $accessToken = $service_bgl360->getCurrentAccessTokenByUser($current_user->ID);
        echo "<span class='green' >Access Token is active! </span> <br>";
        echo "<span class='green' >Remaining days: " . $time->getTotalRemainingDays($time->getCurrentDate(), $time->toDate( $accessToken[0]['expired_at'])) . " </span> <br><br><br><br>";
        echo "<span class='green'><b>[This should redirect to homepage when launch]</b></span>";
//        header("location:bgl360-import");
    }
}
else
{
    $accessToken = $authentication_bgl360->getAccessToken();

   // echo "<pre>";
    //print_r($accessToken );


//    exit;
    /**
     * If retrieving access token got an error then should redirect the bgl360 application
     * I think this can be explore more later
     */
    if($accessToken['error'] == 'invalid_grant')
    {
        echo "<span class='red'> Authenticating to bgl360 application... </span> <br>";
        /**
         * has invalid response
         * then redirect to application authenticate the data
         */
        $authentication_bgl360->redirectUrlToAuthorizationPage();
    }
    else
    {
        echo "<span class='green' >Inserting new tokens for " . $current_user->display_name . "</span><br>";
        echo "<span class='green' >Inserting...</span><br>";


        // If user don't have access token yet - so new access token must be inserted
        $status = $service_bgl360->insertNewAccessToken(
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

        if($status == TRUE)
        {
            echo "<span class='green'>New tokens successfully added!</span><br>";
            echo "<span class='black'>Information Preview: </span><br>";
            echo "<span class='green'><b>Access Token:</b>  ". $accessToken['access_token'] . "</span><br>";
            echo "<span class='green'><b>Refresh Token:</b> " .  $accessToken['refresh_token'] . " </span><br><br><br>";
            echo "<span class='green'><b>[This should redirect to homepage when launch]</b></span>";
            header("location:bgl360-import");
        }
        else
        {
            echo "<span class='red'>New tokens failed to insert, please try again or contact the administrator.</span><br>";
        }


    }
}




?>