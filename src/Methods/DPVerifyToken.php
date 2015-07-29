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

class DPVerifyToken extends DirectPayRequest
{

    /**
     * @param $token
     * @return mixed
     * @throws DirectPayException
     */
    public function verifyToken($token)
    {
        $this->requestName = 'verifyToken';
        $response          = $this->sendRequest(array('TransactionToken'=>$token));


        $directPayResponse = $this->parseXMLResponse($response);

        if (in_array($directPayResponse->getResult(), DPCreateToken::$TOKEN_CREATION_ERRORS)
        ) {
            throw new DirectPayException($directPayResponse);
        }
        return $directPayResponse->getTransToken();
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

        $dom = new \DOMDocument();
        $dom->loadXML($xmlResponse->asXML());
        $fields   = $dom->getElementsByTagName('Service');
        $services = array();

        /** @var \DOMElement $field */
        foreach ($fields as $field) {
            $node = array();
            /** @var \DOMElement $child */
            foreach ($field->childNodes as $child) {
                $node[$child->nodeName] = $child->nodeValue;
            }
            $services[] = $node;
        }

        return $services;
    }
}