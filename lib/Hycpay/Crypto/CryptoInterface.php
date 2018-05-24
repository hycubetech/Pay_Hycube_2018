<?php
/**
 * @license Copyright 2011-2014 HycPay Inc., MIT License 
 * see https://github.com/hycpay/php-hycpay-client/blob/master/LICENSE
 */

namespace Hycpay\Crypto;

/**
 * All crypto extensions MUST support this interface
 */
interface CryptoInterface
{
    /**
     * If the users system supports the cryto extension, this should return
     * true, otherwise it should return false.
     *
     * @return boolean
     */
    public static function hasSupport();

    /**
     * @return array
     */
    public function getAlgos();
}
