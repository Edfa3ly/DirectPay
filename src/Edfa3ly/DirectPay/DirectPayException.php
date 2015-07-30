<?php
/**
 * Created by PhpStorm.
 * User: salmah
 * Date: 7/28/15
 * Time: 10:28 AM
 */

namespace Edfa3ly\DirectPay;


use Edfa3ly\DirectPay\DirectPayResponse;

class DirectPayException extends \Exception
{

    public function __construct(DirectPayResponse $data, $message = null, $code = null)
    {
        if (!$message) {
            $message = sprintf('%s ,code = %s', $data->getResultExplanation(), $data->getResult(), $data->getResult());
        }
        if (!$code) {
            $code = $data->getResult();
        }
        parent::__construct($message, $code);
    }
}