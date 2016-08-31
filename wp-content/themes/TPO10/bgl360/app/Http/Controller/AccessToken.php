<?php
namespace App;

use App\ServiceBgl360;
use App\AuthenticationBgl360;
use App\ResourceRequestBgl360;
use App\Time;
 
class AccessToken
{
    private $user_id;
    private $authentication_bgl360;

    /**
     * AccessToken constructor.
     * @param $wpdb
     * @param $user_id
     */
    function __construct($wpdb, $user_id)
    {

        $this->user_id = $user_id;
        $this->wpdb    = $wpdb;

        // echo "alright <br>";
        // echo "user id " . $this->user_id . '<br>';
        $this->authentication_bgl360   = new AuthenticationBgl360();

        //Authentication set up
        $this->authentication_bgl360->setRedirectUrlToAuthorizationPage("https://api-staging.bgl360.com.au/oauth/authorize?response_type=code&client_id=5dbf9b2c-981f-44e4-8212-d3b5c74795a1&scope=investment&redirect_uri=https://app.thesmsfacademy.com.au/wp-bgl360-landing.php");
        $this->authentication_bgl360->setMainUri('https://api-staging.bgl360.com.au/oauth/token');
        $this->authentication_bgl360->setAuthorizationCode($this->authentication_bgl360->getAuthorizationCode());
        $this->authentication_bgl360->setGrantType('authorization_code');
        $this->authentication_bgl360->setScope('investment');
        $this->authentication_bgl360->setClientId('5dbf9b2c-981f-44e4-8212-d3b5c74795a1');
        $this->authentication_bgl360->setClientSecret('b5a0ff39-ef93-4bc7-b5de-e0ace2d7a6fc');
        $this->authentication_bgl360->setRedirectUri('https://app.thesmsfacademy.com.au/wp-bgl360-landing.php');
        $this->authentication_bgl360->setAccessTokenUri($this->authentication_bgl360->getAccessTokenUri());
        //echo "Access Token Uri " . $authentication_bgl360->getAccessTokenUri() . '<br>';
    } 
    
    /**
     * This function will update the refresh token by the specific user 
     */
    public function refreshAndUpdateAccessToken()
    {
        $service_bgl360          = new ServiceBgl360($this->wpdb, $this->user_id);
        $time                    = new Time(); 
    
        //Get specific access token
        $userCurrentAccessToken  = $service_bgl360->getCurrentAccessTokenByUser($this->user_id);
 
        // $this->authentication_bgl360->clear(); 
        // print_r( $userCurrentAccessToken );
        // echo "Current logged in access token " . $userCurrentAccessToken[0]['access_token'] . '<br>';
        // echo "Current logged in refresh token " . $userCurrentAccessToken[0]['refresh_token'] . '<br>';
        // echo "Is access token expired?<br>" .  $userCurrentAccessToken[0]['id'] . '  <BR>';
        // @todo get access token by refresh token smsf database.
        // echo "Token is automatically refreshed <br>"; 
        // echo "refresh token " . $userCurrentAccessToken[0]['refresh_token'] . '<br>'; 
        
        // Set the refresh token
        $this->authentication_bgl360->setRefreshTokenUrl($userCurrentAccessToken[0]['refresh_token']);
        
        // Set the access token
        $this->authentication_bgl360->setAccessToken($userCurrentAccessToken[0]['access_token']);

        // Get the refresh token data composed by the set access and refresh tokens
        $response = $this->authentication_bgl360->getRefreshTokenData($this->authentication_bgl360->getRefreshTokenUrl());

        // print_r($response);
        // echo "This is refresh url => " . $this->authentication_bgl360->getRefreshTokenUrl() . '<br>'; 

        // If there is something wrong with the refresh token provided then response will include "invalid_token"
        if($response['error'] == 'invalid_token')
        { 
            echo "<span style='color:red' >Refresh token is already used to retrieved new access token </span><br>";
        }
        else
        { 
            echo "<span style='color:green' > New access token updated</span>";  

            // Update access token and refresh token by the user in SMSF database 
            $service_bgl360->updateAccessToken(array(
                'access_token'  => $response['access_token'],
                'refresh_token' => $response['refresh_token'],
                'expired_at'    => $time->getAccessTokenExpireDateTime(),
                'updated_at'    => $time->getCurrentDateTime()
            ));
        }
    }
}