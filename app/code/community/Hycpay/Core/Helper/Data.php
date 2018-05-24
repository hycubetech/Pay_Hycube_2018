<?php
/**
 * @license Copyright 2011-2014 HycPay Inc., MIT License
 * @see https://github.com/hycpay/magento-plugin/blob/master/LICENSE
 */

/**
 */
class Hycpay_Core_Helper_Data extends Mage_Core_Helper_Abstract
{
    protected $_autoloaderRegistered;
    protected $_hycpay;
    protected $_sin;
    protected $_publicKey;
    protected $_privateKey;
    protected $_keyManager;
    protected $_client;

    /**
     * @param mixed $debugData
     */
    public function debugData($debugData)
    {
        //log information about the environment
        $phpVersion = explode('-', phpversion())[0];
        $extendedDebugData = array(
            '[PHP version] ' . $phpVersion,
            '[Magento version] ' . \Mage::getVersion(),
            '[HycPay plugin version] ' . $this->getExtensionVersion(), 
        );
        foreach($extendedDebugData as &$param)
        {
            $param = PHP_EOL . "\t\t" . $param;
        }

        if (true === isset($debugData) && false === empty($debugData)) {
            \Mage::getModel('hycpay/method_bitcoin')->debugData($extendedDebugData);
            \Mage::getModel('hycpay/method_bitcoin')->debugData($debugData);
        }
    }

    /**
     * @return boolean
     */
    public function isDebug()
    {
        return (boolean) \Mage::getStoreConfig('payment/hycpay/debug');
    }

    /**
     * Returns true if Transaction Speed has been configured
     *
     * @return boolean
     */
    public function hasTransactionSpeed()
    {
        $speed = \Mage::getStoreConfig('payment/hycpay/speed');

        return !empty($speed);
    }

    /**
     * Returns the URL where the IPN's are sent
     *
     * @return string
     */
    public function getNotificationUrl()
    {
        return \Mage::getUrl(\Mage::getStoreConfig('payment/hycpay/notification_url'));
    }

    /**
     * Returns the URL where customers are redirected
     *
     * @return string
     */
    public function getRedirectUrl()
    {
        return \Mage::getUrl(\Mage::getStoreConfig('payment/hycpay/redirect_url'));
    }

    /**
     * Registers the HycPay autoloader to run before Magento's. This MUST be
     * called before using any hycpay classes.
     */
    public function registerAutoloader()
    {
        if (true === empty($this->_autoloaderRegistered)) {
            $autoloader_filename = \Mage::getBaseDir('lib').'/Hycpay/Autoloader.php';

            if (true === is_file($autoloader_filename) && true === is_readable($autoloader_filename)) {
                require_once $autoloader_filename;
                \Hycpay\Autoloader::register();
                $this->_autoloaderRegistered = true;
                $this->debugData('[INFO] In Hycpay_Core_Helper_Data::registerAutoloader(): autoloader file was found and has been registered.');
            } else {
                $this->_autoloaderRegistered = false;
                $this->debugData('[ERROR] In Hycpay_Core_Helper_Data::registerAutoloader(): autoloader file was not found or is not readable. Cannot continue!');
                throw new \Exception('In Hycpay_Core_Helper_Data::registerAutoloader(): autoloader file was not found or is not readable. Cannot continue!');
            }
        }
    }

    /**
     * This function will generate keys that will need to be paired with HycPay
     * using
     */
    public function generateAndSaveKeys()
    {
        $this->debugData('[INFO] In Hycpay_Core_Helper_Data::generateAndSaveKeys(): attempting to generate new keypair and save to database.');

        if (true === empty($this->_autoloaderRegistered)) {
            $this->registerAutoloader();
        }

        $this->_privateKey = new Hycpay\PrivateKey('payment/hycpay/private_key');

        if (false === isset($this->_privateKey) || true === empty($this->_privateKey)) {
            $this->debugData('[ERROR] In Hycpay_Core_Helper_Data::generateAndSaveKeys(): could not create new Hycpay private key object. Cannot continue!');
            throw new \Exception('In Hycpay_Core_Helper_Data::generateAndSaveKeys(): could not create new Hycpay private key object. Cannot continue!');
        } else {
            $this->_privateKey->generate();
        }

        $this->_publicKey = new Hycpay\PublicKey('payment/hycpay/public_key');

        if (false === isset($this->_publicKey) || true === empty($this->_publicKey)) {
            $this->debugData('[ERROR] In Hycpay_Core_Helper_Data::generateAndSaveKeys(): could not create new Hycpay public key object. Cannot continue!');
            throw new \Exception('In Hycpay_Core_Helper_Data::generateAndSaveKeys(): could not create new Hycpay public key object. Cannot continue!');
        } else {
            $this->_publicKey
                 ->setPrivateKey($this->_privateKey)
                 ->generate();
        }

        $this->getKeyManager()->persist($this->_publicKey);
        $this->getKeyManager()->persist($this->_privateKey);

        $this->debugData('[INFO] In Hycpay_Core_Helper_Data::generateAndSaveKeys(): key manager called to persist keypair to database.');
    }

    /**
     * Send a pairing request to HycPay to receive a Token
     */
    public function sendPairingRequest($pairingCode)
    {
        if (false === isset($pairingCode) || true === empty($pairingCode)) {
            $this->debugData('[ERROR] In Hycpay_Core_Helper_Data::sendPairingRequest(): missing or invalid pairingCode parameter.');
            throw new \Exception('In Hycpay_Core_Helper_Data::sendPairingRequest(): missing or invalid pairingCode parameter.');
        } else {
            $this->debugData('[INFO] In Hycpay_Core_Helper_Data::sendPairingRequest(): function called with the pairingCode parameter: ' . $pairingCode);
        }

        if (true === empty($this->_autoloaderRegistered)) {
            $this->registerAutoloader();
        }

        // Generate/Regenerate keys
        $this->generateAndSaveKeys();
        $sin = $this->getSinKey();

        if (false === isset($sin) || true === empty($sin)) {
            $this->debugData('[ERROR] In Hycpay_Core_Helper_Data::sendPairingRequest(): could not retrieve the SIN parameter. Cannot continue!');
            throw new \Exception('In Hycpay_Core_Helper_Data::sendPairingRequest(): could not retrieve the SIN parameter. Cannot continue!');
        } else {
            $this->debugData('[INFO] In Hycpay_Core_Helper_Data::sendPairingRequest(): attempting to pair with the SIN parameter: ' . $sin);
        }

        // Sanitize label
        $label = preg_replace('/[^a-zA-Z0-9 ]/', '', \Mage::app()->getStore()->getName());
        $label = substr('Magento ' . $label, 0, 59);

        $this->debugData('[INFO] In Hycpay_Core_Helper_Data::sendPairingRequest(): using the label "' . $label . '".');

        $token = $this->getHycpayClient()->createToken(
                                                       array(
                                                            'id'          => (string) $sin,
                                                            'pairingCode' => (string) $pairingCode,
                                                            'label'       => (string) $label,
                                                       )
                                           );
        $network = \Mage::getStoreConfig('payment/hycpay/network');
        $this->debugData('[INFO] In Hycpay_Core_Helper_Data::sendPairingRequest(): using the network "' . $network . '".');

        if (false === isset($token) || true === empty($token)) {
            $this->debugData('[ERROR] In Hycpay_Core_Helper_Data::sendPairingRequest(): could not obtain the token from the pairing process. Cannot continue!');
            throw new \Exception('In Hycpay_Core_Helper_Data::sendPairingRequest(): could not obtain the token from the pairing process. Cannot continue!');
        } else {
            $this->debugData('[INFO] In Hycpay_Core_Helper_Data::sendPairingRequest(): token successfully obtained.');
        }

        $config = new \Mage_Core_Model_Config();

        if (false === isset($config) || true === empty($config)) {
            $this->debugData('[ERROR] In Hycpay_Core_Helper_Data::sendPairingRequest(): could not create new Mage_Core_Model_Config object. Cannot continue!');
            throw new \Exception('In Hycpay_Core_Helper_Data::sendPairingRequest(): could not create new Mage_Core_Model_Config object. Cannot continue!');
        }

        if($config->saveConfig('payment/hycpay/token', $token->getToken())) {
            $this->debugData('[INFO] In Hycpay_Core_Helper_Data::sendPairingRequest(): token saved to database.');
        } else {
            $this->debugData('[ERROR] In Hycpay_Core_Helper_Data::sendPairingRequest(): token could not be saved to database.');
            throw new \Exception('In Hycpay_Core_Helper_Data::sendPairingRequest(): token could not be saved to database.');
        }
    }

    /**
     * @return Hycpay\SinKey
     */
    public function getSinKey()
    {
        if (false === empty($this->_sin)) {
            return $this->_sin;
        }

        $this->debugData('[INFO] In Hycpay_Core_Helper_Data::getSinKey(): attempting to get the SIN parameter.');

        if (true === empty($this->_autoloaderRegistered)) {
            $this->registerAutoloader();
        }

        $this->_sin = new Hycpay\SinKey();

        if (false === isset($this->_sin) || true === empty($this->_sin)) {
            $this->debugData('[ERROR] In Hycpay_Core_Helper_Data::getSinKey(): could not create new HycPay SinKey object. Cannot continue!');
            throw new \Exception('In Hycpay_Core_Helper_Data::getSinKey(): could not create new HycPay SinKey object. Cannot continue!');
        }

        $this->_sin
             ->setPublicKey($this->getPublicKey())
             ->generate();

        if (false === isset($this->_sin) || true === empty($this->_sin)) {
            $this->debugData('[ERROR] In Hycpay_Core_Helper_Data::getSinKey(): could not generate a new SIN from the public key. Cannot continue!');
            throw new \Exception('In Hycpay_Core_Helper_Data::getSinKey(): could not generate a new SIN from the public key. Cannot continue!');
        }

        return $this->_sin;
    }

    public function getPublicKey()
    {
        if (true === isset($this->_publicKey) && false === empty($this->_publicKey)) {
            $this->debugData('[INFO] In Hycpay_Core_Helper_Data::getPublicKey(): found an existing public key, returning that.');
            return $this->_publicKey;
        }

        if (true === empty($this->_autoloaderRegistered)) {
            $this->registerAutoloader();
        }

        $this->debugData('[INFO] In Hycpay_Core_Helper_Data::getPublicKey(): did not find an existing public key, attempting to load one from the key manager.');

        $this->_publicKey = $this->getKeyManager()->load('payment/hycpay/public_key');

        if (true === empty($this->_publicKey)) {
            $this->debugData('[INFO] In Hycpay_Core_Helper_Data::getPublicKey(): could not load a public key from the key manager, generating a new one.');
            $this->generateAndSaveKeys();
        } else {
            $this->debugData('[INFO] In Hycpay_Core_Helper_Data::getPublicKey(): successfully loaded public key from the key manager, returning that.');
            return $this->_publicKey;
        }

        if (false === empty($this->_publicKey)) {
            $this->debugData('[INFO] In Hycpay_Core_Helper_Data::getPublicKey(): successfully generated a new public key.');
            return $this->_publicKey;
        } else {
            $this->debugData('[ERROR] In Hycpay_Core_Helper_Data::getPublicKey(): could not load or generate a new public key. Cannot continue!');
            throw new \Exception('In Hycpay_Core_Helper_Data::getPublicKey(): could not load or generate a new public key. Cannot continue!');
        }
    }

    public function getPrivateKey()
    {
        if (false === empty($this->_privateKey)) {
            $this->debugData('[INFO] In Hycpay_Core_Helper_Data::getPrivateKey(): found an existing private key, returning that.');
            return $this->_privateKey;
        }

        if (true === empty($this->_autoloaderRegistered)) {
            $this->registerAutoloader();
        }

        $this->debugData('[INFO] In Hycpay_Core_Helper_Data::getPrivateKey(): did not find an existing private key, attempting to load one from the key manager.');

        $this->_privateKey = $this->getKeyManager()->load('payment/hycpay/private_key');

        if (true === empty($this->_privateKey)) {
            $this->debugData('[INFO] In Hycpay_Core_Helper_Data::getPrivateKey(): could not load a private key from the key manager, generating a new one.');
            $this->generateAndSaveKeys();
        } else {
            $this->debugData('[INFO] In Hycpay_Core_Helper_Data::getPrivateKey(): successfully loaded private key from the key manager, returning that.');
            return $this->_privateKey;
        }

        if (false === empty($this->_privateKey)) {
            $this->debugData('[INFO] In Hycpay_Core_Helper_Data::getPrivateKey(): successfully generated a new private key.');
            return $this->_privateKey;
        } else {
            $this->debugData('[ERROR] In Hycpay_Core_Helper_Data::getPrivateKey(): could not load or generate a new private key. Cannot continue!');
            throw new \Exception('In Hycpay_Core_Helper_Data::getPrivateKey(): could not load or generate a new private key. Cannot continue!');
        }
    }

    /**
     * @return Hycpay\KeyManager
     */
    public function getKeyManager()
    {
        if (true === empty($this->_keyManager)) {
            if (true === empty($this->_autoloaderRegistered)) {
                $this->registerAutoloader();
            }

            $this->_keyManager = new Hycpay\KeyManager(new Hycpay\Storage\MagentoStorage());

            if (false === isset($this->_keyManager) || true === empty($this->_keyManager)) {
                $this->debugData('[ERROR] In Hycpay_Core_Helper_Data::getKeyManager(): could not create new HycPay KeyManager object. Cannot continue!');
                throw new \Exception('In Hycpay_Core_Helper_Data::getKeyManager(): could not create new HycPay KeyManager object. Cannot continue!');
            } else {
                $this->debugData('[INFO] In Hycpay_Core_Helper_Data::getKeyManager(): successfully created new HycPay KeyManager object.');
            }
        }

        return $this->_keyManager;
    }

    /**
     * @return Hycpay\Client
     */
    public function getHycpayClient()
    {
        if (false === empty($this->_client)) {
            return $this->_client;
        }

        if (true === empty($this->_autoloaderRegistered)) {
            $this->registerAutoloader();
        }

        $this->_client = new Hycpay\Client\Client();

        if (false === isset($this->_client) || true === empty($this->_client)) {
            $this->debugData('[ERROR] In Hycpay_Core_Helper_Data::getHycpayClient(): could not create new HycPay Client object. Cannot continue!');
            throw new \Exception('In Hycpay_Core_Helper_Data::getHycpayClient(): could not create new HycPay Client object. Cannot continue!');
        } else {
            $this->debugData('[INFO] In Hycpay_Core_Helper_Data::getHycpayClient(): successfully created new HycPay Client object.');
        }

        if(\Mage::getStoreConfig('payment/hycpay/network') === 'livenet') {
          $network = new Hycpay\Network\Livenet();
        } else {
          $network = new Hycpay\Network\Testnet();
        }
        $adapter = new Hycpay\Client\Adapter\CurlAdapter();

        $this->_client->setPublicKey($this->getPublicKey());
        $this->_client->setPrivateKey($this->getPrivateKey());
        $this->_client->setNetwork($network);
        $this->_client->setAdapter($adapter);
        $this->_client->setToken($this->getToken());

        return $this->_client;
    }

    public function getToken()
    {
        if (true === empty($this->_autoloaderRegistered)) {
            $this->registerAutoloader();
        }

        $token = new Hycpay\Token();

        if (false === isset($token) || true === empty($token)) {
            $this->debugData('[ERROR] In Hycpay_Core_Helper_Data::getToken(): could not create new HycPay Token object. Cannot continue!');
            throw new \Exception('In Hycpay_Core_Helper_Data::getToken(): could not create new HycPay Token object. Cannot continue!');
        } else {
            $this->debugData('[INFO] In Hycpay_Core_Helper_Data::getToken(): successfully created new HycPay Token object.');
        }

        $token->setToken(\Mage::getStoreConfig('payment/hycpay/token'));

        return $token;
    }

    /**
     * @return string
     */
    public function getLogFile()
    {
        return "payment_hycpay.log";
    }
    
    public function getExtensionVersion()
    {
        return (string) \Mage::getConfig()->getNode()->modules->Hycpay_Core->version;        
    }
}
