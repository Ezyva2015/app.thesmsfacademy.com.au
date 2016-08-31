<?php
/**
 * Front to the WordPress application. This file doesn't do anything, but loads
 * wp-blog-header.php which does and tells WordPress to load the theme.
 *
 * @package WordPress
 */

//error_reporting(1);
require_once( dirname(__FILE__) . '/wp-load.php' );

//get curren user information
$current_user = wp_get_current_user();

//If not logged in then page should redirect to main website login page
if($current_user->ID < 1) { header("location: https://app.thesmsfacademy.com.au/wp-login.php"); }

/**
 * @example Safe usage: $current_user = wp_get_current_user();
 * if ( !($current_user instanceof WP_User) )
 *     return;
 */
echo '<pre>Username: ' . $current_user->user_login . '<br />';
echo 'User email: ' . $current_user->user_email . '<br />';
echo 'User first name: ' . $current_user->user_firstname . '<br />';
echo 'User last name: ' . $current_user->user_lastname . '<br />';
echo 'User display name: ' . $current_user->display_name . '<br />';
echo 'User ID: ' . $current_user->ID . '<br />';

require ("bgl360/app/Http/ServiceBgl360.php");
require ("bgl360/app/Http/AuthenticationBgl360.php");
require ("bgl360/app/Http/ResourceRequestBgl360.php");
require ("bgl360/app/Http/Time.php");

//
use App\ServiceBgl360;
use App\AuthenticationBgl360;
use App\ResourceRequestBgl360;
use App\Time;

global $wpdb;



$service_bgl360          = new ServiceBgl360($wpdb, $current_user->ID);
$authentication_bgl360   = new AuthenticationBgl360();
$resource_request_bgl360 = new ResourceRequestBgl360();
$time                    = new Time();













//Authentication set up
$authentication_bgl360->setRedirectUrlToAuthorizationPage("https://api-staging.bgl360.com.au/oauth/authorize?response_type=code&client_id=5dbf9b2c-981f-44e4-8212-d3b5c74795a1&scope=investment&redirect_uri=https://app.thesmsfacademy.com.au/wp-bgl360-landing.php");
$authentication_bgl360->setMainUri('https://api-staging.bgl360.com.au/oauth/token');
$authentication_bgl360->setAuthorizationCode($authentication_bgl360->getAuthorizationCode());
$authentication_bgl360->setGrantType('authorization_code');
$authentication_bgl360->setScope('investment');
$authentication_bgl360->setClientId('5dbf9b2c-981f-44e4-8212-d3b5c74795a1');
$authentication_bgl360->setClientSecret('b5a0ff39-ef93-4bc7-b5de-e0ace2d7a6fc');
$authentication_bgl360->setRedirectUri('https://app.thesmsfacademy.com.au/wp-bgl360-landing.php');
$authentication_bgl360->setAccessTokenUri($authentication_bgl360->getAccessTokenUri());
echo "Access Token Uri " . $authentication_bgl360->getAccessTokenUri() . '<br>';



//Insert new access token to database print insert token status
//if($service_bgl360->insertNewAccessToken(array('access_token'=>'123123', 'refresh_token'=>'sadasdasd', 'expires_in'=>'123123', 'scope'=> 'investment'))){
//    echo "inserted <br>";
//} else {
//    echo "data failed to insert<br>";
//}


//
//$results = $wpdb->get_results( 'SELECT * FROM service_bgl360 WHERE user_id = 1', ARRAY_A  );
//print_r($results );
//check if access token for the user is exist
if($service_bgl360->isExistAccessToken())
{
    echo "User id ". $current_user->ID . " has an access token <br>";
    //get access token from database
    $userCurrentAccessToken = $service_bgl360->getCurrentAccessTokenByUser();
    //print_r( $userCurrentAccessToken );
    echo "Current logged in access token " . $userCurrentAccessToken[0]['access_token'] . '<br>';
    echo "Current logged in refresh token " . $userCurrentAccessToken[0]['refresh_token'] . '<br>';
    echo "Is access token expired?<br>" .  $userCurrentAccessToken[0]['id'] . '  <BR>';
    if(!$service_bgl360->isUserAccessTokenExpired($userCurrentAccessToken[0]['expires_in']))
    {
        //@todo store value from database to session
        //@todo redirect to dashboard
    }
    else
    {
        // @todo get access token by refresh token smsf database.
        echo "Token is automatically refreshed <br>";
        $authentication_bgl360->setRefreshTokenUrl($userCurrentAccessToken[0]['refresh_token']);
        $authentication_bgl360->setAccessToken($userCurrentAccessToken[0]['access_token']);
        $response = $authentication_bgl360->getRefreshTokenData();
        print_r($response);
        if($response['error'] == 'invalid_token')
        {
            echo "Refresh token is already used to retrieved new access token <br>";
        }
        else
        {
            //Update access token and refresh token
            $service_bgl360->updateAccessToken(array(
                'access_token'  => $response['access_token'],
                'refresh_token' => $response['refresh_token'],
                'expired_at'    => $time->getAccessTokenExpireDateTime(),
                'updated_at'    => $time->getCurrentDateTime()
            ));
        }
    }
}
else
{

    $accessToken = $authentication_bgl360->getAccessToken();
    PRINT_R($accessToken);

    if($accessToken['error'] == 'invalid_grant')
    {
        echo "invalid grant so redirect <br>";
        /**
         * has invalid response
         * then redirect to application authenticate the data
         */
        $authentication_bgl360->redirectUrlToAuthorizationPage();
    }
    else
    {

        echo "inserting new data<br>";
        /**
         * If user don't have access token yet - so must be inserted
         */
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
    //save data to database
    //$authentication_bgl360->redirectUrlToAuthorizationPage();
    //echo "User id 1 don't have access token";
}
























exit; 
//print access token
echo "<pre>";
print_r($authentication_bgl360->getAccessToken());
echo "<br><br><br>";

//print data retrieved
print_r($resource_request_bgl360->getData('/fund/list'));
echo"</pre>";








//
/**
 * Tells WordPress to load the WordPress theme and output it.
 *
 * @var bool
 */

/** Loads the WordPress Environment and Template */
//require( dirname( __FILE__ ) . '/wp-blog-header.php' );



//echo "This will hundle the authentication <br>";
 echo "<br> <pre>";
//$code = $_GET['code'];
/**
 * Curl query to the bgl360 application
 * https://api-staging.bgl360.com.au/oauth/token
 * ?grant_type=authorization_code
 * &code=%3CAuth-Code%3E
 * &scope=%3CScope%3E
 * &client_id=%3CAPI-Client-ID%3E
 * &client_secret=%3CAPI-Client-Secret
 * REQUIREMENT:
 * grant type = authorization_code
 * code = qQiNrL
 * scope = developer
 * client id = 5dbf9b2c-981f-44e4-8212-d3b5c74795a1
 * client secret = 7005380b-fc86-40df-8457-d4f42f539d2c
 */

/**
 * Call wordpress  information
 */
/**
 * Load wp data
 */




exit;

/**
 * Insert test
 * service_bgl360
 * Insert
 */

$wpdb->insert(
    'service_bgl360',
    array(
        'user_id'=> 1,
        'access_token' => 'value1',
        'refresh_token' => 123,
    ),
    array(
        '%d',
        '%s',
        '%s'
    )
);

/**
 * Custom query
 */
//echo "This is the <br>";
//$data = $wpdb->get_results("SELECT post_id FROM  service_bgl360  WHERE  (user_id = 1)");

$results = $wpdb->get_results( 'SELECT * FROM service_bgl360 WHERE user_id = 1', ARRAY_A  );
//echo "<pre>";
//print_r($results);
//echo "</pre>";

/**
 * Update
 */

$wpdb->update(
    'service_bgl360',
    array(
        'access_token' => 'value2 updated'	// integer (number)
    ),
    array( 'user_id' => 2 ),
    array(
        '%s',	// value1
    ),
    array( '%d' )
);


/**
 * Delete
 */

$wpdb->delete( 'service_bgl360', array( 'user_id' => 2 ), array( '%d' ) );




/**
 * Process get access authentication key, access token and data
 */
$postManToken = '93e27fae-9973-848a-d983-6cc07657c14d';
$grant_type = 'authorization_code';
$code = (!empty($_GET['code'])) ? $_GET['code'] : 'Y3K3mI';
$scope = 'developer';
$clientId = '5dbf9b2c-981f-44e4-8212-d3b5c74795a1';
$clientSecret = 'b5a0ff39-ef93-4bc7-b5de-e0ace2d7a6fc';
$redirectUril = 'https://app.thesmsfacademy.com.au/wp-content/bgl360/index.php';
$getAccessToken = "https://api-staging.bgl360.com.au/oauth/token?grant_type=$grant_type&code=$code&scope=$scope&client_id=$clientId&client_secret=$clientSecret&redirect_uri=$redirectUril";

$curlPostUri    = "https://api-staging.bgl360.com.au/oauth/token?grant_type=$grant_type&code=$code&scope=$scope&client_id=$clientId&client_secret=$clientSecret&redirect_uri=$redirectUril";
$curlPostFields = "grant_type=$grant_type&code=iq04CF&scope=$scope&client_id=$clientId&client_secret=$clientSecret&redirect_uri=$redirectUril";
$curlPostUriBase = "https://api-staging.bgl360.com.au/oauth/token";

echo "
    <hr>
    <h1> Actual Data Retrieved </h1>
    Authorization code =  $code <br>
    Grant Type = $grant_type <br>
    Scope = $scope <br>
    client id = $clientId <br>
    Client Secret = $clientSecret<br>
    Redirect Uri = $redirectUril <br>
    Access Token Url = $getAccessToken <br>
    <hr>
    <h1> curl </h1>
      curlPostUri = $curlPostUri <br>
      curlPostFields = $curlPostFields  <br>
      curlPostUriBase = $curlPostUriBase  <br>
    ";

$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_URL => $getAccessToken,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_HTTPHEADER => array(
        "cache-control: no-cache",
        "postman-token: $postManToken"
    ),
));

$response = curl_exec($curl);
$err = curl_error($curl);
curl_close($curl);
if ($err) {
    echo "cURL Error #:" . $err;
} else {
    $response = json_decode($response, true);
    print_r($response);
}

$queryData['access_token']  = '6777e420-f2a1-45fa-9670-f7ba844bae83';
$queryData['token_type']    = 'bearer';
$queryData['refresh_token'] = '36108c23-3255-4636-818d-4e5a69c32173';
$queryData['expires_in'   ] = '535034';
$queryData['scope']         = 'developer';




echo "<hr>";
echo "<h3> Retrieve fund list </h3>";

$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => "https://api-staging.bgl360.com.au/fund/list",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_HTTPHEADER => array(
        "authorization: bearer 6777e420-f2a1-45fa-9670-f7ba844bae83",
        "cache-control: no-cache",
        "postman-token: bd9561a8-1a58-7cae-2e03-b997158a305b"
    ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
    echo "cURL Error #:" . $err;
} else {
    $response = json_decode($response, true);
    print_r($response);
}