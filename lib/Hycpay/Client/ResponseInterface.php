<?php
/**
 * @license Copyright 2011-2014 HycPay Inc., MIT License 
 * see https://github.com/hycpay/php-hycpay-client/blob/master/LICENSE
 */

namespace Hycpay\Client;

/**
 *
 * @package Hycpay
 */
interface ResponseInterface
{
    /**
     * @return string
     */
    public function getBody();

    /**
     * Returns the status code of the response
     *
     * @return integer
     */
    public function getStatusCode();

    /**
     * Returns a $key => $value array of http headers
     *
     * @return array
     */
    public function getHeaders();
}
