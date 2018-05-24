<?php
/**
 * @license Copyright 2011-2014 HycPay Inc., MIT License
 * see https://github.com/hycpay/php-hycpay-client/blob/master/LICENSE
 */

namespace Hycpay;

/**
 * Interface PayoutInstructionInterface
 * @package Hycpay
 */
interface PayoutInstructionInterface
{

    /**
     * Get Hycpay ID for this instruction.
     * @return string
     */
    public function getId();

    /**
     * Get Label for instruction payout.
     * @return string
     */
    public function getLabel();

    /**
     * Get the bitcoin address for the recipient.
     * @return string
     */
    public function getAddress();

    /**
     * Return the amount to pay the recipient.
     * @return string
     */
    public function getAmount();

    /**
     * Get the BTC array (once rates are set)
     * @return array
     */
    public function getBtc();

    /**
     * Return the status of this payout instruction
     * @return string
     */
    public function getStatus();

    /**
     * Return the transactions for this payout
     * @return array
     */
    public function getTransactions();
}
