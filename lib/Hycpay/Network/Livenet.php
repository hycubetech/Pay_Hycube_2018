<?php
/**
 * @license Copyright 2011-2014 HycPay Inc., MIT License 
 * see https://github.com/hycpay/php-hycpay-client/blob/master/LICENSE
 */

namespace Hycpay\Network;

/**
 *
 * @package Bitcore
 */
class Livenet implements NetworkInterface
{
    public function getName()
    {
        return 'livenet';
    }

    public function getAddressVersion()
    {
        return 0x00;
    }

    public function getApiHost()
    {
        return 'hycpay.com';
    }

    public function getApiPort()
    {
        return 443;
    }
}
