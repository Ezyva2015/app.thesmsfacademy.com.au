<?php
/**
 * Created by PhpStorm.
 * User: JESUS
 * Date: 2/3/2016
 * Time: 11:26 AM
 */

namespace App;


class Time
{

    private $currentDate;
    private $currentTime;
    private $currentDateTime;
    private $accessTokenExpirationDate;

    /**
     * Time constructor.
     */
    public function  __construct()
    {
        $this->currentDateTime = date("Y-m-d h:i:s");
        $this->currentDate     = date("Y-m-d");
        $this->currentTime     = date("h:i:s");
        $date = date_create($this->currentDate);
        date_add($date, date_interval_create_from_date_string('6 days'));
        $this->accessTokenExpirationDate = date_format($date, 'Y-m-d') . ' ' . $this->currentTime;
    }

    /**
     * @param $currentDate
     * @param $expiredDate
     * @return float|int
     */
    public function getTotalRemainingDays($currentDate, $expiredDate)
    {
        $date1 = $currentDate;
        $date2 = $expiredDate;

        $diff   = abs(strtotime($date2) - strtotime($date1));

        $years  = floor($diff / (365*60*60*24));
        $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
        $days   = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

        return ($days < 0) ? 0 : $days;
    }

    /**
     * Convert date and time to date only
     * @param $dateTime
     * @return mixed
     */
    public function toDate($dateTime)
    {
        $date = explode(' ', $dateTime);
        return (!empty($date[0])) ? $date[0] : $dateTime;
    }

    /**
     * Get access token expired date
     * this is extended with 6th days from the access token added to database
     * and this is the basis when to expire the date
     * @return string
     */
    public function getAccessTokenExpireDateTime()
    {
        return $this->accessTokenExpirationDate;
    }

    /**
     * Get current date when the access token is being retrieved from bgl360 application
     * @return bool|string
     */
    public function getAccessDate()
    {
        return $this->currentDate;
    }

    /**
     * Get current date
     * @return bool|string
     */
    public function getCurrentDate()
    {
        return $this->currentDate;
    }

    /**
     * Get current time
     * @return bool|string
     */
    public function getCurrentTime()
    {
        return $this->currentTime;
    }

    /**
     * Get the time where access token is being retrieved
     * @return bool|string
     */
    public function getAccessTime()
    {
        return $this->currentTime;
    }

    /**
     * Get current date and time
     * @return bool|string
     */
    public function getCurrentDateTime()
    {
        return  $this->currentDateTime;
    }
}