<?php
/**
 * @license Copyright 2011-2014 HycPay Inc., MIT License 
 * see https://github.com/hycpay/php-hycpay-client/blob/master/LICENSE
 */

namespace Hycpay;

/**
 * @package Bitcore
 */
interface KeyInterface extends \Serializable
{
    /**
     * Generates a new key
     */
    public function generate();

    /**
     * @return boolean
     */
    public function isValid();
}
