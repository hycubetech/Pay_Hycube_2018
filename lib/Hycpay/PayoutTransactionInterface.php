<?php
/**
 * @license Copyright 2011-2014 HycPay Inc., MIT License
 * see https://github.com/hycpay/php-hycpay-client/blob/master/LICENSE
 */

namespace Hycpay;

/**
 * Class PayoutTransaction
 * @package Hycpay
 */
interface PayoutTransactionInterface
{
    /**
     * Get bitcoin blockchain transaction ID for the payout transaction.
     * @return mixed
     */
    public function getTransactionID();

    /**
     * The amount of bitcoin paid.
     * @return float
     */
    public function getAmount();

    /**
     * The date and time when the payment was sent.
     * @return string
     */
    public function getDate();
}
