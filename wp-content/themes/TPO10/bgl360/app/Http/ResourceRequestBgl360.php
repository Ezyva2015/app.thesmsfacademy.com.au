<?php
/**
 * Created by PhpStorm.
 * User: JESUS
 * Date: 2/1/2016
 * Time: 3:35 PM
 */

namespace App;


class ResourceRequestBgl360
{
    private $url = '';
    private $bearer = '';
    private $postManToken = '';

    /**
     * ResourceRequestBgl360 constructor.
     * @param string $bearer
     * @param string $postManToken
     * @param string $url
     */
    function __construct($bearer="6777e420-f2a1-45fa-9670-f7ba844bae83", $postManToken = 'bd9561a8-1a58-7cae-2e03-b997158a305b', $url= "https://api-staging.bgl360.com.au")
    { 
        $this->bearer = $bearer;
        $this->postManToken = $postManToken;
        $this->url = $url;
    }

    /**
     * Get data from bgl360 application using curl query
     * @param string $requestUri
     * @return mixed|string
     */
    public function getData($accessToken, $requestUri = '/fund/list') {

        echo "access token " . $accessToken . '<br>';
        echo "request url " . $this->url . $requestUri . '<br>';
        echo "working..";

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->url . $requestUri,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_HTTPHEADER => array(
                "authorization: bearer $accessToken",
                "cache-control: no-cache",
                "postman-token: $this->postManToken"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            echo "return with error";
          $response = "cURL Error #:" . $err;
        } else {
            echo "return with data <br>";
            $response = json_decode($response, true);
        }
        return $response;
    }

    public function getFundDetail(){}
    public function getTrusteesList(){}
    public function getInvestmentSummary(){}
    public function getChartOfAccounts(){}
    public function getGeneralLedger(){}
    public function getTrialBalance(){}
    public function getFundMembers(){}
    public function UserDetail(){}
}