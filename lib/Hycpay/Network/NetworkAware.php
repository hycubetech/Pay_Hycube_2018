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
abstract class NetworkAware implements NetworkAwareInterface
{
    /**
     * @var NetworkInterface
     */
    protected $network;

    /**
     * @inheritdoc
     */
    public function setNetwork(NetworkInterface $network = null)
    {
        $this->network = $network;
    }
}
