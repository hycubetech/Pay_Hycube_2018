<?php
/**
 * @license Copyright 2011-2014 HycPay Inc., MIT License
 * @see https://github.com/hycpay/magento-plugin/blob/master/LICENSE
 */

/**
 * Used to display header on the admin configuration page
 */
class Hycpay_Core_Block_Adminhtml_System_Config_Form_Field_Header extends Mage_Adminhtml_Block_Abstract implements Varien_Data_Form_Element_Renderer_Interface
{
    /**
     * This is the location of the template used to display the output
     * on the page. Please modifiy the template.
     *
     * @var string
     */
    protected $_template = 'hycpay/system/config/field/header.phtml';

    /**
     * @param Varien_Data_Form_Element_Abstract $element
     * @return string
     */
    public function render(Varien_Data_Form_Element_Abstract $element)
    {
        if (false === isset($element) || true === empty($element)) {
            \Mage::helper('hycpay')->debugData('[ERROR] In Hycpay_Core_Block_Adminhtml_System_Config_Form_Field_Header::render(): Missing or invalid $element parameter passed to function.');
            throw new \Exception('In Hycpay_Core_Block_Adminhtml_System_Config_Form_Field_Header::render(): Missing or invalid $element parameter passed to function.');
        }

        return $this->toHtml();
    }
}
