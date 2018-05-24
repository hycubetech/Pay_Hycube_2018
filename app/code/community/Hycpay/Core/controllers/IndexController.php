<?php
/**
 * @license Copyright 2011-2014 HycPay Inc., MIT License
 * @see https://github.com/hycpay/magento-plugin/blob/master/LICENSE
 */

/**
 * @route hycpay/index/
 */
class Hycpay_Core_IndexController extends Mage_Core_Controller_Front_Action
{
    /**
     * @route hycpay/index/index?quote=n
     */
    public function indexAction()
    {
        \Mage::helper('hycpay')->registerAutoloader();
        \Mage::helper('hycpay')->debugData($params);

	$params  = $this->getRequest()->getParams();
	$quoteId = $params['quote'];

	if (!is_numeric($quoteId))
	{
	    return $this->getResponse()->setHttpResponseCode(400);
	}

        $paid = \Mage::getModel('hycpay/ipn')->GetQuotePaid($quoteId);
        $this->loadLayout();
        $this->getResponse()->setHeader('Content-type', 'application/json');
        
        return $this->getResponse()->setBody(json_encode(array('paid' => $paid)));
    }
}
