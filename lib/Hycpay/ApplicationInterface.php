<?php
/**
 * @license Copyright 2011-2014 HycPay Inc., MIT License 
 * see https://github.com/hycpay/php-hycpay-client/blob/master/LICENSE
 */

namespace Hycpay;

/**
 * Creates an application for a new merchant account
 *
 * @package Hycpay
 */
interface ApplicationInterface
{
    /**
     * @return array
     */
    public function getUsers();

    /**
     * @return array
     */
    public function getOrgs();
}
