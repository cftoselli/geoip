<?php

namespace Opinaia\GeoIpBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class OpinaiaGeoIpExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        // User id to use Maxmind web service
        if (isset($config['user_id'])) {
            $container->setParameter( 'opinaia_geo_ip.user_id', $config['user_id']);
        } else {
            $container->setParameter( 'opinaia_geo_ip.user_id', "");
        }
        // Api Key to use Maxmind web service
        if (isset($config['api_key'])) {
            $container->setParameter( 'opinaia_geo_ip.api_key', $config['api_key']);
        } else {
            $container->setParameter( 'opinaia_geo_ip.api_key', "");
        }

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
    }
}
