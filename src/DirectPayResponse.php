<?php
/**
 * Created by PhpStorm.
 * User: salmah
 * Date: 7/28/15
 * Time: 1:29 PM
 */

namespace Edfa3ly\DirectPayBundle\DirectPay;


/**
 * Class DirectPayResponse
 * @package Edfa3ly\DirectPayBundle\DirectPay
 */
class DirectPayResponse
{

    /**
     * @var
     */
    public $Result;

    /**
     */
    public $resultExplanation;

    /**
     */
    public $transToken;


    /**
     * @return mixed
     */
    public function getResult()
    {
        return $this->Result;
    }

    /**
     * @param mixed $result
     */
    public function setResult($result)
    {
        $this->Result = $result;
    }

    /**
     * @return mixed
     */
    public function getResultExplanation()
    {
        return $this->resultExplanation;
    }

    /**
     * @param mixed $resultExplanation
     */
    public function setResultExplanation($resultExplanation)
    {
        $this->resultExplanation = $resultExplanation;
    }

    /**
     * @return mixed
     */
    public function getTransToken()
    {
        return $this->transToken;
    }

    /**
     * @param mixed $transToken
     */
    public function setTransToken($transToken)
    {
        $this->transToken = $transToken;
    }



}