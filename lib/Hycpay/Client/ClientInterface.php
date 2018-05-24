<?php
/**
 * @license Copyright 2011-2014 HycPay Inc., MIT License 
 * see https://github.com/hycpay/php-hycpay-client/blob/master/LICENSE
 */

namespace Hycpay\Client;

use Hycpay\InvoiceInterface;
use Hycpay\PayoutInterface;

/**
 * Sends request(s) to hycpay server
 *
 * @package Hycpay
 */
interface ClientInterface
{
    const TESTNET = '0x6F';
    const LIVENET = '0x00';

    /**
     * These can be changed/updated so when the request is sent to HycPay it
     * gives insight into what is making the calls.
     *
     * @see RFC2616 section 14.43 for User-Agent Format
     */
    const NAME    = 'HycPay PHP-Client';
    const VERSION = '2.2.20';

    //public function createApplication(ApplicationInterface $application);

    //public function createBill(BillInterface $bill);
    //public function getBills($status = null);
    //public function getBill($billId);
    //public function updateBill(BillInterface $bill);

    //public function createAccessToken(AccessTokenInterface $accessToken);
    //public function getAccessTokens();
    //public function getAccessToken($keyId);

    public function getCurrencies();

    /**
     * @param InvoiceInterface $invoiceId
     * @return \Hycpay\Invoice
     * @throws \Exception
     */
    public function createInvoice(InvoiceInterface $invoice);
    //public function getInvoices();

    /**
     * @param $invoiceId
     * @return InvoiceInterface
     * @throws \Exception
     */
    public function getInvoice($invoiceId);



    //public function getLedgers();
    //public function getLedger(CurrencyInterface $currency);

    //public function getOrgs();
    //public function getOrg($orgId);
    //public function updateOrg(OrgInterface $org);

    /**
     * Create a Payout Request on Hycpay
     * @param PayoutInterface $payout
     * @return PayoutInterface|mixed
     * @throws \Exception
     */
    public function createPayout(PayoutInterface $payout);

    /**
     * @param null $status
     * @return array
     * @throws \Exception
     */
    public function getPayouts($status = null);

    /**
     * @param $payoutId
     * @return \Hycpay\Payout
     * @throws \Exception
     */
    public function getPayout($payoutId);

    /**
     * @param PayoutInterface
     * @return PayoutInterface|mixed
     * @throws \Exception
     */
    public function deletePayout(PayoutInterface $payout);

    //public function updatePayout(PayoutInterface $payout);

    //public function getRates();
    //public function getRate(CurrencyInterface $currency);

    /**
     * Get an array of tokens indexed by facade
     * @return array
     * @throws \Exception
     */
    public function getTokens();

    //public function getUser();
    //public function updateUser(UserInterface $user);
}
