<?php
/**
 * Created by PhpStorm.
 * User: salmah
 * Date: 7/28/15
 * Time: 10:52 AM
 */

namespace Edfa3ly\DirectPayBundle\DirectPay;


use Buzz\Browser;
use Buzz\Client\Curl;
use Buzz\Message\Response;

class DirectPayRequest
{

    protected $config;
    protected $companyRef;
    protected $apiURL;
    protected $requestName;

    /**
     * @param $config
     */
    public function __construct($config)
    {
        $this->config     = $config;
        $this->companyRef = $this->config['company_ref'];
        $this->apiURL     = $this->config['api_url'];

    }


    /**
     * @param $payload
     * @return mixed
     * @throws DirectPayException
     */
    public function sendRequest($payload)
    {
        $xml = new \SimpleXMLElement('<API3G/>');
        $xml->addChild('CompanyToken', $this->companyRef);
        $xml->addChild('Request', $this->requestName);
        $this->toXML($xml, $payload);
        $cURL = $this->initCurl($xml->asXML());
        $browser  = new Browser($cURL);
        $response = $browser->post($this->apiURL);
        $this->verifyResponse($response);
        return $response;
    }


    /**
     * @return Curl
     */
    private function initCurl($postData)
    {
        $ch = new Curl();

        $ch->setOption(CURLOPT_URL, $this->apiURL);
        $ch->setOption(CURLOPT_HEADER, 0);
        $ch->setOption(CURLOPT_SSL_VERIFYHOST, 0); //ssl stuff
        $ch->setOption(CURLOPT_SSL_VERIFYPEER, 0);
        $ch->setOption(CURLOPT_POST, 1);
        $ch->setOption(CURLOPT_HTTPHEADER, array('Content-Type:  application/x-www-form-urlencoded'));
        $ch->setOption(CURLOPT_POSTFIELDS, $postData);
        $ch->setOption(CURLOPT_RETURNTRANSFER, 1);
        $ch->setTimeout(30);

        return $ch;
    }


    /**
     * @param \SimpleXMLElement $xml
     * @param array             $payLoad
     * @return \SimpleXMLElement
     */
    private function toXML(\SimpleXMLElement &$xml, array $payLoad)
    {
        foreach ($payLoad as $key => $value) {
            if (is_array($value)) {
                $this->toXML($xml->addChild($key), $value);
            } else {
                $xml->addChild($key, $value);
            }
        }

        return $xml->asXML();
    }

    /**
     * @param $response
     * @return DirectPayResponse
     */
    protected function parseXMLResponse(Response $response)
    {
        $xmlResponse = new \SimpleXmlElement($response, LIBXML_NOCDATA);
        $p           = xml_parser_create();
        xml_parse_into_struct($p, $xmlResponse->asXML(), $values);
        xml_parser_free($p);

        $DPResponse = new DirectPayResponse();
        foreach ($values as $key => $value) {
            if ($value['tag'] == 'RESULT') {
                $DPResponse->setResult($value['value']);
            }
            if ($value['tag'] == 'RESULTEXPLANATION') {
                $DPResponse->setResultExplanation($value['value']);
            }
            if ($value['tag'] == 'TRANSTOKEN') {
                $DPResponse->setTransToken($value['value']);
            }
        }

        return $DPResponse;
    }

    /**
     * @param Response $response
     * @throws DirectPayException
     */
    private function verifyResponse(Response $response)
    {
        if (!$response->getContent() && !$response->getHeaders()) {
            $DPResponse = new DirectPayResponse();
            $DPResponse->setResult(0);
            $DPResponse->setResultExplanation("No API Replay");
            throw new DirectPayException($DPResponse);
        }
    }

    /**
     * @param $xml
     * @param $name
     * @return array
     */
    protected function xmlElementToArray($xml, $name)
    {
        $dom = new \DOMDocument();
        $dom->loadXML($xml);
        $fields   = $dom->getElementsByTagName($name);
        $data = array();

        /** @var \DOMElement $field */
        foreach ($fields as $field) {
            $node = array();
            /** @var \DOMElement $child */
            foreach ($field->childNodes as $child) {
                $node[$child->nodeName] = $child->nodeValue;
            }
            $data[] = $node;
        }
        return $data;
    }
}