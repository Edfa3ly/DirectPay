<?php
/**
 * Created by PhpStorm.
 * User: salmah
 * Date: 7/28/15
 * Time: 3:15 PM
 */

namespace Edfa3ly\DirectPay\Methods;


use Edfa3ly\DirectPay\DirectPayRequest;

class DPGetServices extends DirectPayRequest
{
    /**
     * @return array
     */
    public function listServices()
    {
        $this->requestName = 'getServices';
        $response          = $this->sendRequest(array());

        return $this->parseXMLResponse($response);
    }

    /**
     * @param $response
     * @return array
     */
    protected function parseXMLResponse($response)
    {
        $xmlResponse = new \SimpleXmlElement($response, LIBXML_NOCDATA);
        $services = $this->xmlElementToArray($xmlResponse->asXML(),'Service');
        return $services;
    }

}