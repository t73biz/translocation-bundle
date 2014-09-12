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
 * @author Ronald Chaplin <rchaplin@t73.biz>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode    = $treeBuilder->root('t73_biz_translocation');

        $rootNode
            ->children()
            ->arrayNode('supported_locales')
            ->prototype('scalar')->end()
            ->end()
            ->scalarNode('locale_wdt')->defaultFalse()->end()
            ->scalarNode('php_extractor')->defaultTrue()->end()
            ->end();

        return $treeBuilder;
    }
}
