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
class Customnet implements NetworkInterface
{
    protected $host_url;

    protected $host_port;

    public $isPortRequiredInUrl;

    public function __construct($url, $port, $isPortRequiredInUrl = false)
    {
        $this->host_url = $url;
        $this->host_port = $port;
        $this->isPortRequiredInUrl = $isPortRequiredInUrl;
    }

    public function getName()
    {
        return 'Custom Network';
    }

    public function getAddressVersion()
    {
        return 0x00;
    }

    public function getApiHost()
    {
        return $this->host_url;
    }

    public function getApiPort()
    {
        return $this->host_port;
    }
}
