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
interface NetworkAwareInterface
{
    /**
     * Set the network the object will work with
     *
     * @param NetworkInterface $network
     */
    public function setNetwork(NetworkInterface $network = null);
}
