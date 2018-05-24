<?php
/**
 * @license Copyright 2011-2015 HycPay Inc., MIT License
 * @see https://github.com/hycpay/magento-plugin/blob/master/LICENSE
 */

class Hycpay_Core_Model_Status
{
    const STATUS_NEW       = 'new';
    const STATUS_PAID      = 'paid';
    const STATUS_CONFIRMED = 'confirmed';
    const STATUS_COMPLETE  = 'complete';
    const STATUS_EXPIRED   = 'expired';
    const STATUS_INVALID   = 'invalid';

    /**
     * @return array
     */
    public function toOptionArray()
    {
        return array(
            array('value' => self::STATUS_NEW, 'label'       => \Mage::helper('hycpay')->__(ucwords(self::STATUS_NEW))),
            array('value' => self::STATUS_PAID, 'label'      => \Mage::helper('hycpay')->__(ucwords(self::STATUS_PAID))),
            array('value' => self::STATUS_CONFIRMED, 'label' => \Mage::helper('hycpay')->__(ucwords(self::STATUS_CONFIRMED))),
            array('value' => self::STATUS_COMPLETE, 'label'  => \Mage::helper('hycpay')->__(ucwords(self::STATUS_COMPLETE))),
            array('value' => self::STATUS_EXPIRED, 'label'   => \Mage::helper('hycpay')->__(ucwords(self::STATUS_EXPIRED))),
            array('value' => self::STATUS_INVALID, 'label'   => \Mage::helper('hycpay')->__(ucwords(self::STATUS_INVALID))),
        );
    }
}
