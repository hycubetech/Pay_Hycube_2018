<?php
/**
 * @license Copyright 2011-2014 HycPay Inc., MIT License
 * @see https://github.com/hycpay/magento-plugin/blob/master/LICENSE
 */
$this->startSetup();

/**
 * IPN Log Table, used to keep track of incoming IPNs
 * 
 * Fixes `curent_time` typo
 */
$ipnTable = new Varien_Db_Ddl_Table();
$this->getConnection()->changeColumn($this->getTable('hycpay/ipn'), 'curent_time', 'current_time', array('type' => Varien_Db_Ddl_Table::TYPE_INTEGER));

$this->endSetup();
