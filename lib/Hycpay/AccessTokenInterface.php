<?php
/**
 * @license Copyright 2011-2015 HycPay Inc., MIT License 
 * see https://github.com/hycpay/php-hycpay-client/blob/master/LICENSE
 */

namespace Hycpay;

/**
 * Creates an access token for the given client
 *
 * @package Hycpay
 */
interface AccessTokenInterface
{
    /**
     * @return string
     */
    public function getId();

    /**
     * @return string
     */
    public function getEmail();

    /**
     * @return string
     */
    public function getLabel();

    /**
     * @return boolean
     */
    public function isNonceDisabled();
}
