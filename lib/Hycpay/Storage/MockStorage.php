<?php
/**
 * @license Copyright 2011-2014 HycPay Inc., MIT License 
 * see https://github.com/hycpay/php-hycpay-client/blob/master/LICENSE
 */

namespace Hycpay\Storage;

/**
 * @codeCoverageIgnore
 * @package Bitcore
 */
class MockStorage implements StorageInterface
{
    public function persist(\Hycpay\KeyInterface $key)
    {
    }

    public function load($id)
    {
        return;
    }
}
