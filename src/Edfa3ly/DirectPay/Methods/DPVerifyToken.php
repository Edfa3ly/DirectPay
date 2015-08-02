<?php
/**
 * Created by PhpStorm.
 * User: salmah
 * Date: 7/28/15
 * Time: 5:55 PM
 */

namespace Edfa3ly\DirectPay\Methods;


use Edfa3ly\DirectPay\DirectPayException;
use Edfa3ly\DirectPay\DirectPayRequest;
use Edfa3ly\DirectPay\DirectPayVerifyTokenResponse;

class DPVerifyToken extends DirectPayRequest
{
    //transaction related
    CONST PASSED_PTL                = 903;
    CONST TRANSACTION_CANCELLED     = 902;
    CONST MISSING_TRANSACTION_TOKEN = 950;
    CONST MISSING_VERIFY_TOKEN      = 951;
    CONST NOT_PAID_YET              = 900;
    CONST DECLINED                  = 901;
    CONST NO_TRANSACTION            = 904;
    //FRAUD related
    CONST FRAUD_DETECTED_ACTION_REQUIRED = 001;
    CONST FRAUD_DETECTED_ACTION_TAKEN    = 002;

    public static $FRAUDS
        = [
            self::FRAUD_DETECTED_ACTION_TAKEN
        ];


    public static $TRANSACTION_ERRORS
        = [
            self::REQUEST_MISSING_COMPANY_TOKEN,
            self::COMPANY_TOKEN_DOEST_EXIST,
            self::NO_REQUEST,
            self::ERROR_IN_XML,
            self::REQUEST_MISSING_COMPANY_TOKEN,
            self::COMPANY_TOKEN_DOEST_EXIST,
            self::NO_REQUEST,
            self::ERROR_IN_XML,
            self::PASSED_PTL,
            self::TRANSACTION_CANCELLED,
            self::MISSING_TRANSACTION_TOKEN,
            self::MISSING_VERIFY_TOKEN,
            self::DECLINED,
            self::NOT_PAID_YET,
            self::NO_TRANSACTION
        ];

    /**
     * @param $token
     * @return mixed
     * @throws DirectPayException
     */
    public function verifyToken($token)
    {
        $this->requestName = 'verifyToken';
        $response          = $this->sendRequest(array('TransactionToken' => $token));

        /** @var DirectPayVerifyTokenResponse $directPayResponse */
        $directPayResponse = $this->parseXMLResponse($response);

        if (in_array($directPayResponse->getResult(), self::$TRANSACTION_ERRORS)
        ) {
            throw new DirectPayException($directPayResponse);
        }

        if (in_array($directPayResponse->getFraudAlert(), self::$FRAUDS)
        ) {
            throw new DirectPayException($directPayResponse, $directPayResponse->getFraudExplanation(), $directPayResponse->getFraudAlert());
        }

        return $directPayResponse;
    }


    /**
     * @param $response
     * @return array
     */
    protected function parseXMLResponse($response)
    {

        $xmlResponse = new \SimpleXmlElement($response, LIBXML_NOCDATA);

        $dom = new \DOMDocument();
        $dom->loadXML($xmlResponse->asXML());

        $DPResponse = new DirectPayVerifyTokenResponse();

        $DPResponse->setResultExplanation($dom->getElementsByTagName('ResultExplanation')->item(0)->nodeValue);
        $DPResponse->setResult($dom->getElementsByTagName('Result')->item(0)->nodeValue);
        $DPResponse->setTransactionAmount($dom->getElementsByTagName('TransactionAmount')->item(0)->nodeValue);
        $DPResponse->setTransactionCurrency($dom->getElementsByTagName('TransactionCurrency')->item(0)->nodeValue);
        $DPResponse->setTransactionApproval($dom->getElementsByTagName('TransactionApproval')->item(0)->nodeValue);
        $DPResponse->setFraudAlert($dom->getElementsByTagName('FraudAlert')->item(0)->nodeValue);
        $DPResponse->setFraudExplanation($dom->getElementsByTagName('FraudExplnation')->item(0)->nodeValue);


        return $DPResponse;
    }
}