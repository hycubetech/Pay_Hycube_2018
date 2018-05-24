<?php
/**
 * @license Copyright 2011-2014 HycPay Inc., MIT License 
 * see https://github.com/hycpay/php-hycpay-client/blob/master/LICENSE
 */

namespace Hycpay;

/**
 * This is the currency code set for the price setting.  The pricing currencies
 * currently supported are USD, EUR, BTC, and all of the codes listed on this page:
 * https://hycpay.com/bitcoin­exchange­rates
 *
 * @package Hycpay
 */
interface CurrencyInterface
{
    /**
     * @return string
     */
    public function getCode();

    /**
     * @return string
     */
    public function getSymbol();

    /**
     * @return string
     */
    public function getPrecision();

    /**
     * @return string
     */
    public function getExchangePctFee();

    /**
     * @return boolean
     */
    public function isPayoutEnabled();

    /**
     * @return string
     */
    public function getName();

    /**
     * @return string
     */
    public function getPluralName();

    /**
     * @return array
     */
    public function getAlts();

    /**
     * @return array
     */
    public function getPayoutFields();
}
