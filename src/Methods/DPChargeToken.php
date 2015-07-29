<?php
/**
 * Created by PhpStorm.
 * User: salmah
 * Date: 7/28/15
 * Time: 5:39 PM
 */

namespace Edfa3ly\DirectPay\Methods;


use Edfa3ly\DirectPay\DirectPayException;
use Edfa3ly\DirectPay\DirectPayRequest;

class DPChargeToken extends DirectPayRequest
{

    /**
     * @param $token
     * @return mixed
     * @throws DirectPayException
     */
    public function chargeToken($token)
    {
        $this->requestName = 'chargeTokenAuth';
        $response          = $this->sendRequest(array('TransactionToken' => $token));
        $directPayResponse = $this->parseXMLResponse($response);

        if (in_array($directPayResponse->getResult(), DPCreateToken::$TOKEN_CREATION_ERRORS)
        ) {
            throw new DirectPayException($directPayResponse);
        }

        return $directPayResponse->getTransToken();
    }
}