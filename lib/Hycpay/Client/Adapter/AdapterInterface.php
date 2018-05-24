<?php
/**
 * @license Copyright 2011-2014 HycPay Inc., MIT License 
 * see https://github.com/hycpay/php-hycpay-client/blob/master/LICENSE
 */

namespace Hycpay\Client\Adapter;

use Hycpay\Client\RequestInterface;
use Hycpay\Client\ResponseInterface;

/**
 * A client can be configured to use a specific adapter to make requests, by
 * default the CurlAdapter is what is used.
 *
 * @package Hycpay
 */
interface AdapterInterface
{
    /**
     * Send request to HycPay
     *
     * @param RequestInterface $request
     *
     * @return ResponseInterface
     */
    public function sendRequest(RequestInterface $request);
}
