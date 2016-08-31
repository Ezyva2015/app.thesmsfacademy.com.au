<?php
/**
 * Created by PhpStorm.
 * User: JESUS
 * Date: 2/1/2016
 * Time: 3:10 PM
 */

namespace App;

class AuthenticationBgl360
{
    private $code;
    private $secretKey;
    private $secretClientId;
    private $scope;
    private $granType;
    private $redirectUri;
    private $AuthorizationCode;
    private $clientId;
    private $clientSecret;
    private $mainUri;
    private $accessTokenUri;
    private $authorizationUrl;
    private $refreshToken;
    private $accessToken;

    /**
     * AuthenticationBgl360 constructor.
     */
    function __construct()
    {
        // echo " AuthenticationBgl360 Init<br>";
    }

    /**
     * Set the main url of the api to be called anywhere in the script
     * @param null $mainUri
     */
    public function setMainUri($mainUri=NULL){
        $this->mainUri = $mainUri;
    }

    /**
     * Set authorization and if the code is empty then default "Y3K3mI" but that is not valid so
     * script should redirect bgl360 application to generate fresh and valid authorization code
     * @param null $code
     */
    public function setAuthorizationCode($code=NULL){
        $this->code = (!empty($code)) ? $code : 'Y3K3mI';
    }

    /**
     * Set the secretkey
     * @param null $secretKey
     */
    public function setSecretKey($secretKey=NULL){
        $this->secretKey = $secretKey;
    }

    /**
     * Set the client id
     * @param null $clientId
     */
    public function setClientId($clientId=NULL){
        $this->clientId = $clientId;
    }

    /**
     * Set the client secret
     * @param $clientSecret
     */
    public function setClientSecret($clientSecret){
        $this->clientSecret = $clientSecret;
    }

    /**
     * Set the scope ex: investment
     * @param null $scope
     */
    public function setScope($scope=NULL){
        $this->scope = $scope;
    }

    /**
     * Set grant type so it could be authorization code, access token or refresh token, not sure and let your self discover :-p
     * @param null $granType
     */
    public function setGrantType($granType=NULL){
        $this->granType = $granType;
    }

    /**
     * Set redirect uri
     * @param null $redirectUri 
     */
    public function setRedirectUri($redirectUri=NULL){
        $this->redirectUri = $redirectUri;
    }

    /**
     * Set access token uri
     * @param $accessTokenUri
     */
    public function setAccessTokenUri($accessTokenUri){
        $this->accessTokenUri = $accessTokenUri;
    }

    /**
     * Set redirect url to authorization code - this is where the composed url added 
     * Composed url is the result of the get set above functions
     * @param $authorizationUrl
     */
    public function setRedirectUrlToAuthorizationPage($authorizationUrl)
    {
        $this->authorizationUrl = $authorizationUrl;
    }

    /**
     * Set refresh token url
     * @param $refreshToken
     */
    public function setRefreshTokenUrl($refreshToken)
    {
        $this->refreshToken = 'https://api-staging.bgl360.com.au/oauth/token?grant_type=refresh_token&client_secret=' . $this->clientSecret . '&refresh_token=' . $refreshToken . '&client_id=' . $this->clientId . '&scope=' . $this->scope;
    }

    /**
     * Here you can add private and public data to be cleared before running any other scrip
     * This is ussually used when your script is repeating
     */
    public function clear()
    {
        $this->refreshToken = '';
    }

    /**
     * Set access token - access token is what we get when we do the query by the composed url functions above
     * @param $accessToken
     */
    public function setAccessToken($accessToken){
        $this->accessToken = $accessToken;
    }

    /**
     * Redirect url from setRedirectUrlToAuthorizationPage(@param) function
     */
    public function redirectUrlToAuthorizationPage()
    {
        ?>
            <script>
                document.location = '<?php echo $this->authorizationUrl; ?>';
            </script>
        <?php
    }

    /**
     * Get refresh token using curl functionality
     * This code is generated via postman
     * Refresh token is used to get new access token when its expired
     * @param null $refreshToken = full url to retrieve the refresh token
     * @return mixed|string
     */
    public function getRefreshTokenData($refreshToken=null)
    {
        $this->refreshToken = (!empty($this->refreshToken)) ? $this->refreshToken : $refreshToken; 
        //echo "get refresh token url " .   $this->refreshToken  . '<br>';
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->refreshToken,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_HTTPHEADER => array(
                "authorization: bearer " . $this->accessToken,
                "cache-control: no-cache",
                "postman-token: 719c9185-479e-aaba-b7a4-610bb8dbd39a"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return "cURL Error #: " . $err;
        } else {
            $response = json_decode($response, true);
            return $response;
        }
    }

    /**
     * Get refresh token url and that is being set from  setRefreshTokenUrl(@param)
     * @return mixed
     */
    public function getRefreshTokenUrl()
    {
        return  $this->refreshToken; //'https://api-staging.bgl360.com.au/oauth/token?grant_type=refresh_token&client_secret=' . $this->clientSecret . '&refresh_token=' . $this->refreshToken . '&client_id=' . $this->clientId . '&scope=' . $this->scope;
    }

    /**
     * Get authorization code from $_GET[] request
     * Bgl360 application sending code using GET request to authenticated website
     * @param null $code
     * @return null
     */
    public function getAuthorizationCode($code=NULL ) {
        return (!empty($_GET['code'])) ? $_GET['code'] : $code;
    }

    /**
     * Compose and get the access token url, variables are being set fron the set functions above
     * All the variables are private
     * @return string
     */
    public function getAccessTokenUri(){

        $composeUri =  $this->mainUri
            . '?grant_type=' . $this->granType
            . '&code=' . $this->code . ''
            . '&scope=' . $this->scope . ''
            . '&client_id=' . $this->clientId. ''
            . '&client_secret=' . $this->clientSecret . ''
            . '&redirect_uri=' .$this->redirectUri . '';

        //https://api-staging.bgl360.com.au/oauth/token?
        //grant_type=authorization_code&
        //code=Y3K3mI
        //&scope=developer&
        //client_id=5dbf9b2c-981f-44e4-8212-d3b5c74795a1&
        //client_secret=b5a0ff39-ef93-4bc7-b5de-e0ace2d7a6fc&
        //redirect_uri=https://app.thesmsfacademy.com.au/wp-content/bgl360/index.php
        return $composeUri;
    }

    /**
     * Get access token using curl provided with the access token url compose from set functions above.
     * @return mixed|string
     */
    public function getAccessToken(){

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->accessTokenUri,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "postman-token: 93e27fae-9973-848a-d983-6cc07657c14d"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            // echo "cURL Error #:" . $err;
            return "cURL Error #: " . $err;
        } else {
            $response = json_decode($response, true);
        }
        return $response;
    }
}