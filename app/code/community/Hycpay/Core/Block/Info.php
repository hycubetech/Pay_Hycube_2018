<?php
/**
 * @license Copyright 2011-2014 HycPay Inc., MIT License
 * @see https://github.com/hycpay/magento-plugin/blob/master/LICENSE
 */

class Hycpay_Core_Block_Info extends Mage_Payment_Block_Info
{
    public function _construct()
    {
        parent::_construct();
        $this->setTemplate('hycpay/info/default.phtml');
    }

    public function getHycpayInvoiceUrl()
    {
        $order       = $this->getInfo()->getOrder();

        if (false === isset($order) || true === empty($order)) {
            \Mage::helper('hycpay')->debugData('[ERROR] In Hycpay_Core_Block_Info::getHycpayInvoiceUrl(): could not obtain the order.');
            throw new \Exception('In Hycpay_Core_Block_Info::getHycpayInvoiceUrl(): could not obtain the order.');
        }

        $incrementId = $order->getIncrementId();

        if (false === isset($incrementId) || true === empty($incrementId)) {
            \Mage::helper('hycpay')->debugData('[ERROR] In Hycpay_Core_Block_Info::getHycpayInvoiceUrl(): could not obtain the incrementId.');
            throw new \Exception('In Hycpay_Core_Block_Info::getHycpayInvoiceUrl(): could not obtain the incrementId.');
        }

        $hycpayInvoice = \Mage::getModel('hycpay/invoice')->load($incrementId, 'increment_id');

        if (true === isset($hycpayInvoice) && false === empty($hycpayInvoice)) {
            return $hycpayInvoice->getUrl();
        }
    }
}
