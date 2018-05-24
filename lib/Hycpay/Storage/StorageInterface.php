<?php
/**
 * @license Copyright 2011-2014 HycPay Inc., MIT License 
 * see https://github.com/hycpay/php-hycpay-client/blob/master/LICENSE
 */

namespace Hycpay\Storage;

/**
 * @package Bitcore
 */
interface StorageInterface
{
    /**
     * @param KeyInterface $key
     */
    public function persist(\Hycpay\KeyInterface $key);

    /**
     * @param string $id
     *
     * @return KeyInterface
     */
    public function load($id);
}
