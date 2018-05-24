<?php
/**
 * @license Copyright 2011-2015 HycPay Inc., MIT License
 * @see https://github.com/hycpay/magento-plugin/blob/master/LICENSE
 */

/**
 */
class Hycpay_Core_Model_Mysql4_Ipn extends Mage_Core_Model_Mysql4_Abstract
{
    /**
     */
    protected function _construct()
    {
        $this->_init('hycpay/ipn', 'id');
    }
}
