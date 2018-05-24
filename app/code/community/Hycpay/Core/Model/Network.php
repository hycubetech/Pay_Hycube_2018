<?php
/**
 * @license Copyright 2011-2015 HycPay Inc., MIT License
 * @see https://github.com/hycpay/magento-plugin/blob/master/LICENSE
 */

/**
 * Used to display bitcoin networks
 */
class Hycpay_Core_Model_Network
{
    const NETWORK_LIVENET = 'livenet';
    const NETWORK_TESTNET = 'testnet';

    /**
     * @return array
     */
    public function toOptionArray()
    {
        return array(
            array('value' => self::NETWORK_LIVENET, 'label' => \Mage::helper('hycpay')->__(ucwords(self::NETWORK_LIVENET))),
            array('value' => self::NETWORK_TESTNET, 'label' => \Mage::helper('hycpay')->__(ucwords(self::NETWORK_TESTNET))),
        );
    }
}
