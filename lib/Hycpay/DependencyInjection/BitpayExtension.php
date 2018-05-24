<?php
/**
 * @license Copyright 2011-2014 HycPay Inc., MIT License
 * see https://github.com/hycpay/php-hycpay-client/blob/master/LICENSE
 */

namespace Hycpay\DependencyInjection;

use Hycpay\Config\Configuration;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;

/**
 * @package Hycpay
 */
class HycpayExtension implements ExtensionInterface
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $processor = new Processor();
        $config    = $processor->processConfiguration(new Configuration(), $configs);

        foreach (array_keys($config) as $key) {
            $container->setParameter('hycpay.'.$key, $config[$key]);
        }

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__));
        $loader->load('services.xml');

        $container->setParameter('network.class', 'Hycpay\Network\\'.ContainerBuilder::camelize($config['network']));
        $container->setParameter(
            'adapter.class',
            'Hycpay\Client\Adapter\\'.ContainerBuilder::camelize($config['adapter']).'Adapter'
        );
        $container->setParameter('key_storage.class', $config['key_storage']);
    }

    /**
     * @codeCoverageIgnore
     */
    public function getAlias()
    {
        return 'hycpay';
    }

    /**
     * @codeCoverageIgnore
     */
    public function getNamespace()
    {
        return 'http://example.org/schema/dic/hycpay';
    }

    /**
     * @codeCoverageIgnore
     */
    public function getXsdValidationBasePath()
    {
        return false;
    }
}
