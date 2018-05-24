<?php
/**
 * @license Copyright 2011-2015 HycPay Inc., MIT License
 * @see https://github.com/hycpay/magento-plugin/blob/master/LICENSE
 */

class Hycpay_Core_Model_TransactionSpeed
{
    const SPEED_LOW    = 'low';
    const SPEED_MEDIUM = 'medium';
    const SPEED_HIGH   = 'high';

    /**
     * @return array
     */
    public function toOptionArray()
    {
        return array(
            array('value' => self::SPEED_LOW, 'label'    => \Mage::helper('hycpay')->__(ucwords(self::SPEED_LOW))),
            array('value' => self::SPEED_MEDIUM, 'label' => \Mage::helper('hycpay')->__(ucwords(self::SPEED_MEDIUM))),
            array('value' => self::SPEED_HIGH, 'label'   => \Mage::helper('hycpay')->__(ucwords(self::SPEED_HIGH))),
        );
    }
}
