<?php
/**
 * @license Copyright 2011-2014 HycPay Inc., MIT License 
 * see https://github.com/hycpay/php-hycpay-client/blob/master/LICENSE
 */

namespace Hycpay;

/**
 * Used to manage keys
 *
 * @package Bitcore
 */
class KeyManager
{
    /**
     * @var Hycpay\Storage\StorageInterface
     */
    protected $storage;

    /**
     * @param StorageInterface $storage
     */
    public function __construct(\Hycpay\Storage\StorageInterface $storage)
    {
        $this->storage = $storage;
    }

    /**
     * @param KeyInterface $key
     */
    public function persist(KeyInterface $key)
    {
        $this->storage->persist($key);
    }

    /**
     * @return KeyInterface
     */
    public function load($id)
    {
        return $this->storage->load($id);
    }
}
