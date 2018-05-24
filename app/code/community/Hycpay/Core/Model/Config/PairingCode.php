<?php
/**
 * @license Copyright 2011-2015 HycPay Inc., MIT License
 * @see https://github.com/hycpay/magento-plugin/blob/master/LICENSE
 */

/**
 * This class will take the pairing code the merchant entered and pair it with
 * HycPay's API.
 */
class Hycpay_Core_Model_Config_PairingCode extends Mage_Core_Model_Config_Data
{
    /**
     * @inheritdoc
     */
    public function save()
    {
        /**
         * If the user has put a paring code into the text field, we want to
         * pair the magento store to the stores keys. If the merchant is just
         * updating a configuration setting, we could care less about the
         * pairing code.
         */
        $pairingCode = trim($this->getValue());

        if (true === empty($pairingCode)) {
            return;
        }

        \Mage::helper('hycpay')->debugData('[INFO] In Hycpay_Core_Model_Config_PairingCode::save(): attempting to pair with HycPay with pairing code ' . $pairingCode);

        try {
            \Mage::helper('hycpay')->sendPairingRequest($pairingCode);
        } catch (\Exception $e) {
            \Mage::helper('hycpay')->debugData(sprintf('[ERROR] Exception thrown while calling the sendPairingRequest() function. The specific error message is: "%s"', $e->getMessage()));
            \Mage::getSingleton('core/session')->addError('There was an error while trying to pair with HycPay using the pairing code '.$pairingCode.'. Please make sure you select the correct Network (Livenet vs Testnet) and try again with a new 7 character pairing code or enable debug mode and send the "payment_hycpay.log" file to support@hycpay.com for more help.');

            return;
        }

        \Mage::getSingleton('core/session')->addSuccess('Pairing with HycPay was successful.');
    }
}
