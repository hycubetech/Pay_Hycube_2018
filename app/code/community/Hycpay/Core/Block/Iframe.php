<?php
/**
 * @license Copyright 2011-2014 HycPay Inc., MIT License
 * @see https://github.com/hycpay/magento-plugin/blob/master/LICENSE
 * 
 */

class Hycpay_Core_Block_Iframe extends Mage_Checkout_Block_Onepage_Payment
{
    /**
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setTemplate('hycpay/iframe.phtml');
    }

    /**
     * create an invoice and return the url so that iframe.phtml can display it
     *
     * @return string
     */
    public function getIframeUrl()
    {

        if (!($quote = Mage::getSingleton('checkout/session')->getQuote()) 
            or !($payment = $quote->getPayment())
            or !($paymentMethod = $payment->getMethod())
            or ($paymentMethod !== 'hycpay')
            or (Mage::getStoreConfig('payment/hycpay/fullscreen')))
        {
            return 'nothycpay';
        }

        \Mage::helper('hycpay')->registerAutoloader();

        // fullscreen disabled?
        if (Mage::getStoreConfig('payment/hycpay/fullscreen'))
        {
            return 'disabled';
        }

        if (\Mage::getModel('hycpay/ipn')->getQuotePaid($this->getQuote()->getId())) {
            return 'paid'; // quote's already paid, so don't show the iframe
        }

        return 'hycpay';
    }
}
