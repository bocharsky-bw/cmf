<?php

namespace BW\BreadcrumbsBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class BWBreadcrumbsExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('bw_breadcrumbs.navigation', $config['navigation']);
        $container->setParameter('bw_breadcrumbs.show_first', $config['show_first']);
        $container->setParameter('bw_breadcrumbs.show_last', $config['show_last']);
        $container->setParameter('bw_breadcrumbs.last_as_link', $config['last_as_link']);
        $container->setParameter('bw_breadcrumbs.show_separator', $config['show_separator']);
        $container->setParameter('bw_breadcrumbs.separator_character', $config['separator_character']);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
    }
}
