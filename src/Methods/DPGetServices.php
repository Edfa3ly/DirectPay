<?php
/**
 * Created by PhpStorm.
 * User: salmah
 * Date: 7/28/15
 * Time: 3:15 PM
 */

namespace Edfa3ly\DirectPayBundle\DirectPay\Methods;


use Edfa3ly\DirectPayBundle\DirectPay\DirectPayRequest;

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

        $p = xml_parser_create();
        xml_parse_into_struct($p, $xmlResponse->asXML(), $values, $indexes);
        xml_parser_free($p);

        $services = $this->xmlElementToArray($xmlResponse->asXML(),'Service');

        return $services;
    }

}