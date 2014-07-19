<?php
/**
 * This software is part of the T73Biz\Translocation Bundle
 * See the LICENSE file for more information.
 * Copyright (c) 2014 Ronald Chaplin
 */

namespace T73Biz\Bundle\TranslocationBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * @author Ronald Chaplin <ron.g.chaplin@gmail.com>
 */
class Configuration implements ConfigurationInterface
{
	private $debug;

	/**
	 * Constructor
	 *
	 * @param Boolean $debug Whether to use the debug mode
	 */
	public function  __construct($debug)
	{
		$this->debug = (Boolean) $debug;
	}

    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('t73_biz_translocation');

		$rootNode
			->children()
				->arrayNode('template')
					->children()
						->scalarNode('base')->defaultValue('base.html.twig')->end()
					->end()
				->end()
				->arrayNode('supported_locales')
					->prototype('scalar')->end()
				->end()

			->end();

        return $treeBuilder;
    }
}
