<?php
/**
 * Created by PhpStorm.
 * User: salmah
 * Date: 7/28/15
 * Time: 10:50 AM
 */

namespace Edfa3ly\DirectPay\Methods;


use Edfa3ly\DirectPay\DirectPayException;
use Edfa3ly\DirectPay\DirectPayRequest;

class DPCreateToken extends DirectPayRequest
{
    CONST TRANSACTION_CREATED                    = 000;

    CONST REQUEST_MISSING_COMPANY_TOKEN          = 801;
    CONST COMPANY_TOKEN_DOEST_EXIST              = 802;
    CONST NO_REQUEST                             = 803;
    CONST ERROR_IN_XML                           = 804;
    CONST TRANSACTION_FIELDS_MISSING             = 902;
    CONST DATA_MISMATCH                          = 903;
    CONST CURRENCY_NOT_SUPPORTED                 = 904;
    CONST AMOUNT_EXCEEDED_LIMIT                  = 905;
    CONST AMOUNT_EXCEED_MONTHLY_TRANSACTION      = 906;
    CONST MISSING_MANDATORY_SERVICE              = 910;
    CONST MISSING_MANDATORY_SERVICE_FIELDS       = 911;
    CONST MISMATCH_IN_SERVICE_FIELDS             = 912;
    CONST MISSING_ALLOCATION_FIELDS              = 920;
    CONST MISMATCH_IN_ON_ALLOCATION_FIELD        = 921;
    CONST PROVIDER_DOES_NOT_EXIST                = 922;
    CONST ALLOCATED_MONEY_EXCEEDS_PAYMENT_AMOUNT = 923;
    CONST CURRENCY_CONVERSION_NOT_DEFINED        = 924;
    CONST BLOCK_PAYMENT_CODE_INCORRECT           = 930;
    CONST COMPANY_REF_ALREADY_EXISTS_AND_PAID    = 940;
    CONST REQUEST_MISSING_TRAVELER_FIELDS        = 950;
    CONST TRANSACTION_NOT_AUTHORIZED = 800;


    public static $TOKEN_CREATION_ERRORS
        = array(
            self::REQUEST_MISSING_COMPANY_TOKEN,
            self::COMPANY_TOKEN_DOEST_EXIST,
            self::NO_REQUEST,
            self::ERROR_IN_XML,
            self::TRANSACTION_FIELDS_MISSING,
            self::DATA_MISMATCH,
            self::CURRENCY_NOT_SUPPORTED,
            self::AMOUNT_EXCEEDED_LIMIT,
            self::AMOUNT_EXCEED_MONTHLY_TRANSACTION,
            self::MISSING_MANDATORY_SERVICE,
            self::MISSING_MANDATORY_SERVICE_FIELDS,
            self::MISMATCH_IN_SERVICE_FIELDS,
            self::MISSING_ALLOCATION_FIELDS,
            self::MISMATCH_IN_ON_ALLOCATION_FIELD,
            self::PROVIDER_DOES_NOT_EXIST,
            self::ALLOCATED_MONEY_EXCEEDS_PAYMENT_AMOUNT,
            self::CURRENCY_CONVERSION_NOT_DEFINED,
            self::BLOCK_PAYMENT_CODE_INCORRECT,
            self::COMPANY_REF_ALREADY_EXISTS_AND_PAID,
            self::REQUEST_MISSING_TRAVELER_FIELDS,
            self::TRANSACTION_NOT_AUTHORIZED

        );

    /**
     * @param $payLoad
     * @return mixed
     * @throws DirectPayException
     */
    public function getToken($payLoad)
    {
        $this->requestName = 'createToken';
        $response          = $this->sendRequest($payLoad);
        $directPayResponse = $this->parseXMLResponse($response);

        if (in_array($directPayResponse->getResult(), self::$TOKEN_CREATION_ERRORS)) {
            throw new DirectPayException($directPayResponse);
        }

        return $directPayResponse->getTransToken();
    }

}