<?php
/**
 * @license Copyright 2011-2014 HycPay Inc., MIT License
 * see https://github.com/hycpay/php-hycpay-client/blob/master/LICENSE
 */

namespace Hycpay\Client\Adapter;

use Hycpay\Client\RequestInterface;
use Hycpay\Client\ResponseInterface;
use Hycpay\Client\Response;

/**
 * Adapter that sends Request objects using CURL
 *
 * @TODO add way to configure curl with options
 *
 * @package Hycpay
 */
class CurlAdapter implements AdapterInterface
{
    /**
     * @var array
     */
    protected $curlOptions;

    /**
     * @param array $curlOptions
     */
    public function __construct(array $curlOptions = array())
    {
        $this->curlOptions = $curlOptions;
    }

    /**
     * Returns an array of curl settings to use
     *
     * @return array
     */
    public function getCurlOptions()
    {
        return $this->curlOptions;
    }

    /**
     * @inheritdoc
     */
    public function sendRequest(RequestInterface $request)
    {
        $curl = curl_init();

        $default_curl_options = $this->getCurlDefaultOptions($request);

        foreach ($this->getCurlOptions() as $curl_option_key => $curl_option_value) {
            if (!is_null($curl_option_value)) {
                $default_curl_options[$curl_option_key] = $curl_option_value;
            }
        }

        curl_setopt_array($curl, $default_curl_options);

        if (RequestInterface::METHOD_POST == $request->getMethod()) {
            curl_setopt_array(
                $curl,
                array(
                    CURLOPT_POST           => 1,
                    CURLOPT_POSTFIELDS     => $request->getBody(),
                )
            );
        }

        $raw = curl_exec($curl);

        if (false === $raw) {
            $errorMessage = curl_error($curl);
            curl_close($curl);
            throw new \Hycpay\Client\ConnectionException($errorMessage);
        }

        /** @var ResponseInterface */
        $response = Response::createFromRawResponse($raw);

        curl_close($curl);

        return $response;
    }

    /**
     * Returns an array of default curl settings to use
     *
     * @param RequestInterface $request
     * @return array
     */
    private function getCurlDefaultOptions(RequestInterface $request)
    {
        return array(
            CURLOPT_URL            => $request->getUri(),
            CURLOPT_PORT           => $request->getPort(),
            CURLOPT_CUSTOMREQUEST  => $request->getMethod(),
            CURLOPT_HTTPHEADER     => $request->getHeaderFields(),
            CURLOPT_TIMEOUT        => 10,
            CURLOPT_SSL_VERIFYPEER => 1,
            CURLOPT_SSL_VERIFYHOST => 2,
            CURLOPT_CAINFO         => __DIR__.'/ca-bundle.crt',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FORBID_REUSE   => 1,
            CURLOPT_FRESH_CONNECT  => 1,
            CURLOPT_HEADER         => true,
        );
    }
}
