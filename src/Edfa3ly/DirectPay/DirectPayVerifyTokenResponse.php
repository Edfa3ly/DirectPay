<?php
/**
 * Created by PhpStorm.
 * User: salmah
 * Date: 7/30/15
 * Time: 3:18 PM
 */

namespace Edfa3ly\DirectPay;


class DirectPayVerifyTokenResponse extends DirectPayResponse
{

    private $transactionApproval;
    private $transactionCurrency;
    private $transactionAmount;
    private $fraudAlert;
    private $FraudExplanation;

    /**
     * @return mixed
     */
    public function getTransactionApproval()
    {
        return $this->transactionApproval;
    }

    /**
     * @param mixed $transactionApproval
     */
    public function setTransactionApproval($transactionApproval)
    {
        $this->transactionApproval = $transactionApproval;
    }

    /**
     * @return mixed
     */
    public function getTransactionCurrency()
    {
        return $this->transactionCurrency;
    }

    /**
     * @param mixed $transactionCurrency
     */
    public function setTransactionCurrency($transactionCurrency)
    {
        $this->transactionCurrency = $transactionCurrency;
    }

    /**
     * @return mixed
     */
    public function getTransactionAmount()
    {
        return $this->transactionAmount;
    }

    /**
     * @param mixed $transactionAmount
     */
    public function setTransactionAmount($transactionAmount)
    {
        $this->transactionAmount = $transactionAmount;
    }

    /**
     * @return mixed
     */
    public function getFraudAlert()
    {
        return $this->fraudAlert;
    }

    /**
     * @param mixed $fraudAlert
     */
    public function setFraudAlert($fraudAlert)
    {
        $this->fraudAlert = $fraudAlert;
    }

    /**
     * @return mixed
     */
    public function getFraudExplanation()
    {
        return $this->FraudExplanation;
    }

    /**
     * @param mixed $FraudExplanation
     */
    public function setFraudExplanation($FraudExplanation)
    {
        $this->FraudExplanation = $FraudExplanation;
    }


}