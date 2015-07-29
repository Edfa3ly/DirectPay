<?php
/**
 * Created by PhpStorm.
 * User: salmah
 * Date: 7/28/15
 * Time: 10:28 AM
 */

namespace Edfa3ly\DirectPay;


class DirectPayException extends \Exception
{

    public function __construct(DirectPayResponse $data)
    {
        parent::__construct(sprintf('%s ,code = %s', $data->getResultExplanation(), $data->getResult(), $data->getResult()),$data->getResult());
    }
}