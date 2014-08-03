<?php
/**
 * This software is part of the T73Biz\Translocation Bundle
 * See the LICENSE file for more information.
 * Copyright (c) 2014 Ronald Chaplin
 */


namespace T73Biz\Bundle\TranslocationBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class T73BizTranslocationExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

		if (!isset($config['supported_locales'])) {
			throw new \InvalidArgumentException(
				'The "supported_locales" option must be set'
			);
		}
		$asseticBundle = $container->getParameter('assetic.bundles');
		$asseticBundle[] = 'T73BizTranslocationBundle';
		$container->setParameter('assetic.bundles', $asseticBundle);

		$container->setParameter(
			't73_biz_translocation.supported_locales',
			$config['supported_locales']
		);

        if(!isset($config['locale_wdt'])) {
            $container->setParameter('t73_biz_translocation.locale_wdt',false);
        }
        else
        {
            $container->setParameter('t73_biz_translocation.locale_wdt', $config['locale_wdt']);
        }

    }
}
