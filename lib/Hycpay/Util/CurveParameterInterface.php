<?php
/**
 * @license Copyright 2011-2014 HycPay Inc., MIT License 
 * see https://github.com/hycpay/php-hycpay-client/blob/master/LICENSE
 */

namespace Hycpay\Util;

/**
 */
interface CurveParameterInterface
{
    public function aHex();
    public function bHex();
    public function gHex();
    public function gxHex();
    public function gyHex();
    public function hHex();
    public function nHex();
    public function pHex();
}
