<?php
/**
 * @license Copyright 2011-2015 HycPay Inc., MIT License
 * @see https://github.com/hycpay/magento-plugin/blob/master/LICENSE
 */

class Hycpay_Core_Model_Observer {

	public function implementOrderStatus($e) {
		$order = $e -> getOrder();
		$paymentCode = $order -> getPayment() -> getMethodInstance() -> getCode();
		if ($paymentCode == 'hycpay') {
			$order -> setState(Mage_Sales_Model_Order::STATE_NEW, true);
			$order -> save();
		}

		//	Mage::log('$order = $event->getOrder();' . $order -> getState());
	}

	/*
	 * Queries HycPay to update the order states in magento to make sure that
	 * open orders are closed/canceled if the HycPay invoice expires or becomes
	 * invalid.
	 */
	public function updateOrderStates() {
		$apiKey = \Mage::getStoreConfig('payment/hycpay/api_key');

		if (false === isset($apiKey) || empty($apiKey)) {
			\Mage::helper('hycpay') -> debugData('[INFO] Hycpay_Core_Model_Observer::updateOrderStates() could not start job to update the order states because the API key was not set.');
			return;
		} else {
			\Mage::helper('hycpay') -> debugData('[INFO] Hycpay_Core_Model_Observer::updateOrderStates() started job to query HycPay to update the existing order states.');
		}

		/*
		 * Get all of the orders that are open and have not received an IPN for
		 * complete, expired, or invalid.
		 */
		$orders = \Mage::getModel('hycpay/ipn') -> getOpenOrders();

		if (false === isset($orders) || empty($orders)) {
			\Mage::helper('hycpay') -> debugData('[INFO] Hycpay_Core_Model_Observer::updateOrderStates() could not retrieve the open orders.');
			return;
		} else {
			\Mage::helper('hycpay') -> debugData('[INFO] Hycpay_Core_Model_Observer::updateOrderStates() successfully retrieved existing open orders.');
		}

		/*
		 * Get all orders that have been paid using hycpay and
		 * are not complete/closed/etc
		 */
		foreach ($orders as $order) {
			/*
			 * Query HycPay with the invoice ID to get the status. We must take
			 * care not to anger the API limiting gods and disable our access
			 * to the API.
			 */
			$status = null;

			// TODO:
			// Does the order need to be updated?
			// Yes? Update Order Status
			// No? continue
		}

		\Mage::helper('hycpay') -> debugData('[INFO] Hycpay_Core_Model_Observer::updateOrderStates() order status update job finished.');
	}

	/**
	 * Method that is called via the magento cron to update orders if the
	 * invoice has expired
	 */
	public function cleanExpired() {
		\Mage::helper('hycpay') -> debugData('[INFO] Hycpay_Core_Model_Observer::cleanExpired() called.');
		\Mage::helper('hycpay') -> cleanExpired();
	}
        
        /**
        * Event Hook: checkout_onepage_controller_success_action
        * @param $observer Varien_Event_Observer
        */
        public function redirectToCartIfExpired(Varien_Event_Observer $observer)
        {
            if ($observer->getEvent()->getName() == 'checkout_onepage_controller_success_action')
            {
                $lastOrderId = null;
                foreach(\Mage::app()->getRequest()->getParams() as $key=>$value)
                {
                    if($key == 'order_id')
                        $lastOrderId = $value;
                }

               if($lastOrderId != null)
               {                
                    //get order
                    $order = \Mage::getModel('sales/order')->load($lastOrderId);
                    if (false === isset($order) || true === empty($order)) {
                        \Mage::helper('hycpay')->debugData('[ERROR] In Hycpay_Core_Model_Observer::redirectToCartIfExpired(), Invalid Order ID received.');
                        return;
                    }
                    //check if order is pending
                    if($order->getStatus() != 'pending')
                        return;

                    //check if invoice for order exist in hycpay_invoices table
                    $hycpayInvoice = \Mage::getModel('hycpay/invoice')->load($order->getIncrementId(), 'increment_id');
                    $hycpayInvoiceData = $hycpayInvoice->getData();
                    //if is empty or not is array abort
                    if(!is_array($hycpayInvoiceData) || is_array($hycpayInvoiceData) && empty($hycpayInvoiceData))
                        return;

                    //check if hycpay invoice id expired
                    $invoiceExpirationTime = $hycpayInvoiceData['expiration_time'];
                    if($invoiceExpirationTime < strtotime('now'))
                    {
                        $failure_url = \Mage::getUrl(\Mage::getStoreConfig('payment/hycpay/failure_url'));
                        \Mage::app()->getResponse()->setRedirect($failure_url)->sendResponse();
                    }
                }           
            }        
        }
}
