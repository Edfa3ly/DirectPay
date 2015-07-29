<?php
/**
 * Created by PhpStorm.
 * User: salmah
 * Date: 7/28/15
 * Time: 5:21 PM
 */

namespace Edfa3ly\DirectPay\Methods;


use Buzz\Message\Response;
use Edfa3ly\DirectPay\DirectPayException;
use Edfa3ly\DirectPay\DirectPayRequest;

class DPMobilePaymentOptions extends DirectPayRequest
{

    CONST NEW_INVOICE = 0130;
    CONST AUTHORIZED  = 001;

    CONST CAN_NOT_MOBILE_PAY_TRANSACTION = 904;


    /**
     * @param $token
     * @return array
     */
    public function getMobilePaymentOptions($token)
    {
        $this->requestName = 'GetMobilePaymentOptions';
        $response          = $this->sendRequest(array('TransactionToken' => $token));
        $options           = $this->parseXMLResponse($response);

        return $options;
    }


    /**
     * @param Response $response
     * @return array
     */
    protected function parseXMLResponse(Response $response)
    {
        $xmlResponse = new \SimpleXmlElement($response, LIBXML_NOCDATA);

        $p = xml_parser_create();
        xml_parse_into_struct($p, $xmlResponse->asXML(), $values, $indexes);
        xml_parser_free($p);

        $options = $this->xmlElementToArray($xmlResponse->asXML(), 'mobileoption');

        return $options;
    }

}