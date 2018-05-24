<?php
/**
 * @license Copyright 2011-2014 HycPay Inc., MIT License
 * @see https://github.com/hycpay/magento-plugin/blob/master/LICENSE
 */

/**
 * This is used to display php extensions and if they are installed or not
 */
class Hycpay_Core_Block_Adminhtml_System_Config_Form_Field_Extension extends Mage_Adminhtml_Block_System_Config_Form_Field
{
    /**
     * @param Varien_Data_Form_Element_Abstract $element
     * @return string
     */
    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element)
    {
        if (false === isset($element) || true === empty($element)) {
            \Mage::helper('hycpay')->debugData('[ERROR] In Hycpay_Core_Block_Adminhtml_System_Config_Form_Field_Extension::_getElementHtml(): Missing or invalid $element parameter passed to function.');
            throw new \Exception('In Hycpay_Core_Block_Adminhtml_System_Config_Form_Field_Extension::_getElementHtml(): Missing or invalid $element parameter passed to function.');
        }

        $phpExtension = $element->getFieldConfig()->php_extension;

        if (true === in_array($phpExtension, get_loaded_extensions())) {
            return 'Installed';
        }

        return 'Not Installed';
    }
}
