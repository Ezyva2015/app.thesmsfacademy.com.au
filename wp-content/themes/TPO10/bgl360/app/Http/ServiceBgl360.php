<?php
/**
 * Created by PhpStorm.
 * User: JESUS
 * Date: 2/1/2016
 * Time: 1:03 PM
 */

namespace App;


class ServiceBgl360
{
    private $wpdb;
    private $user_id;
    private $table  = 'service_bgl360';
    private $limit = 10;

    /**
     * ServiceBgl360 constructor.
     * @param $wpdb
     * @param $user_id
     */
    function __construct($wpdb, $user_id)
    {
        //echo " AuthenticationBgl360 Init<br>";
        $this->wpdb = $wpdb;
        $this->user_id = $user_id;
        //ECHO "ServiceBgl360 initialized and user id = " . $this->$user_id . '<br>';
    }

    /**
     * Insert new information to service_bgl360 table this is using wordPress wpdb query
     //======================================================================
     //DATABASE TABLE, CONTENT AND VARIABLES
     //======================================================================
     * @param id - Id of the users token
     * @param user_id - User id of WordPress user who currently logged in to the system
     * @param access_token - Access token provided by the bgl360 application
     * @param token_type - Type of the token ex: "bearer"
     * @param refresh_token - Refresh token provided by bgl360 application
     * @param expires_in - Expiration number I think its the seconds or minutes not sure ex: 234323
     * @param expired_at - Date and time when is the expiration date
     * @param updated_at - Date and time when its being updated
     //======================================================================
     // Local function variables
     //======================================================================
     * @param array $data - This is where the data added
     * @return mixed
     */
    public function insertNewAccessToken($data=array())
    {
        $this->user_id = (!empty($data['user_id'])) ? $data['user_id'] : $this->user_id;
        // echo "Insert now " . $this->user_id . " <br>";
        // print_r($data);
        return $this->wpdb->insert(
            'service_bgl360',
            array(
                'user_id'=> $this->user_id,
                'access_token' => $data['access_token'],
                'token_type' => $data['token_type'],
                'refresh_token' => $data['refresh_token'],
                'expires_in'=>$data['expires_in'],
                'scope'=>$data['scope'],
                'expired_at'=>$data['expired_at'],
                'updated_at'=>$data['updated_at']
            ),
            array(
                '%d',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s'
            )
        );
    }

    /**
     * @param $user_id
     */
    public function deleteAccessToken($user_id) {}

    /**
     //======================================================================
     //DATABASE TABLE, CONTENT AND VARIABLES - Only updated
     //======================================================================
     * @param access_token
     * @param refresh_token
     * @param expired_at
     * @param updated_at
     //======================================================================
     // Local function variables
     //======================================================================
     * @param array $token - Arrays of token values to updated
     * @return mixed
     */
    public function updateAccessToken($token=array())
    {
        $this->user_id =  (!empty($token['user_id'])) ? $token['user_id'] : $this->user_id;

        echo "<br>updated id = " . $this->user_id ;
        print_r($token);
        echo "<hr>";


       return $this->wpdb->update(
            'service_bgl360',
            array(
                'access_token'  => $token['access_token'],
                'refresh_token' => $token['refresh_token'],
                'expired_at'    => $token['expired_at'],
                'updated_at'    => $token['updated_at']
            ),
            array( 'user_id' => $this->user_id ),
            array(
                '%s',
                '%s'
            ),
            array( '%d' )
        );

    }

    /**
     * Get current access token of the users
     * @param null $user_id
     * @return mixed
     */
    public function getCurrentAccessTokenByUser($user_id=NULL)
    {
        $this->user_id = (!empty($user_id)) ? $user_id : $this->user_id;
        $results = $this->wpdb->get_results( 'SELECT * FROM service_bgl360 WHERE user_id = ' . $this->user_id, ARRAY_A  );
        return $results;
    }

    /**
     * Detect if users access token exist to database
     * @param null $user_id
     * @return bool
     */
    public function isExistAccessToken($user_id=NULL)
    {
        // echo "b4 select user access token user id " . $this->user_id . "<br>";
        $this->user_id = (!empty($user_id)) ? $user_id : $this->user_id;
        // echo "after select user access token user id " . $this->user_id . "<br>";
        $results = $this->wpdb->get_results( 'SELECT * FROM service_bgl360 WHERE user_id = ' . $this->user_id, ARRAY_A  );
        // print_r($results);
        if(count($results) > 0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     *
     */
    public function isUserHasAccessToken(){}

    /**
     * This is to be coded
     * return is just a dummy response
     * @param $expires_in
     * @return bool
     */
    public function isUserAccessTokenExpired($expires_in)
    {
        return false;
    }

    /**
     * @param $totalDaysRemaining
     */
    public function isRefreshAccessToken($totalDaysRemaining)
    {
        //
    }

    /**
     * Get all access token and limit it by adding the parameter if parameter is not set the 10 result will show
     * @param int $limit
     * @return mixed
     */
    public function getAccessTokens($limit=10)
    {
        $this->limit = (!empty($limit)) ? $limit : $this->limit;
        $results = $this->wpdb->get_results( 'SELECT * FROM service_bgl360 WHERE user_id > 0  ORDER BY id DESC  limit ' . $this->limit , ARRAY_A  );
        return $results;

    }
}