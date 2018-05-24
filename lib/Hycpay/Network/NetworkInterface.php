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
interface NetworkInterface
{
    /**
     * Name of network, currently on livenet and testnet
     *
     * @return string
     */
    public function getName();

    /**
     * @return string
     */
    public function getAddressVersion();

    /**
     * The host that is used to interact with this network
     *
     * @see https://github.com/hycpay/insight
     * @see https://github.com/hycpay/insight-api
     *
     * @return string
     */
    public function getApiHost();

    /**
     * The port of the host
     *
     * @return integer
     */
    public function getApiPort();
}
