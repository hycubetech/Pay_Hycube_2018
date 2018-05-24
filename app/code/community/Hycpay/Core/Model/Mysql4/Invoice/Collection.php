<?php
/**
 * @license Copyright 2011-2015 HycPay Inc., MIT License
 * @see https://github.com/hycpay/magento-plugin/blob/master/LICENSE
 */

/**
 */
class Hycpay_Core_Model_Mysql4_Invoice_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    protected $_isPkAutoIncrement = false;

    /**
     */
    protected function _construct()
    {
        $this->_init('hycpay/invoice');
    }
}
