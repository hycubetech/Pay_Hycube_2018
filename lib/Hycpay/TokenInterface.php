<?php
/**
 * @license Copyright 2011-2014 HycPay Inc., MIT License 
 * see https://github.com/hycpay/php-hycpay-client/blob/master/LICENSE
 */

namespace Hycpay;

/**
 * @package Hycpay
 */
interface TokenInterface
{
    /**
     * @return string
     */
    public function getToken();

    /**
     * @return string
     */
    public function getResource();

    /**
     * @return string
     */
    public function getFacade();

    /**
     * @return \DateTime
     */
    public function getCreatedAt();

    /**
     * @return array
     */
    public function getPolicies();
    
    /**
     * @return string
     */
    public function getPairingCode();

    /**
     * @return \DateTime
     */
    public function getPairingExpiration();
}
