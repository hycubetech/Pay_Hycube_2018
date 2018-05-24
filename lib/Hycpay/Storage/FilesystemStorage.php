<?php
/**
 * @license Copyright 2011-2014 HycPay Inc., MIT License 
 * see https://github.com/hycpay/php-hycpay-client/blob/master/LICENSE
 */

namespace Hycpay\Storage;

/**
 * Used to persist keys to the filesystem
 */
class FilesystemStorage implements StorageInterface
{
    /**
     * @inheritdoc
     */
    public function persist(\Hycpay\KeyInterface $key)
    {
        $path = $key->getId();
        file_put_contents($path, serialize($key));
    }

    /**
     * @inheritdoc
     */
    public function load($id)
    {
        if (!is_file($id)) {
            throw new \Exception(sprintf('Could not find "%s"', $id));
        }

        if (!is_readable($id)) {
            throw new \Exception(sprintf('"%s" cannot be read, check permissions', $id));
        }

        return unserialize(file_get_contents($id));
    }
}
