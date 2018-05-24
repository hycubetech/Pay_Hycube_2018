<?php
/**
 * @license Copyright 2011-2014 HycPay Inc., MIT License
 * @see https://github.com/hycpay/magento-plugin/blob/master/LICENSE
 */

class Hycpay_Core_Block_Form_Hycpay extends Mage_Payment_Block_Form
{
    protected function _construct()
    {
        $payment_template = 'hycpay/form/hycpay.phtml';

        parent::_construct();
        
        $this->setTemplate($payment_template);
    }
}
