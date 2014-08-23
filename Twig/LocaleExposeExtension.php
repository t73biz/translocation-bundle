<?php
/**
 * This software is part of the T73Biz\Translocation Bundle
 * See the LICENSE file for more information.
 * Copyright (c) 2014 Ronald Chaplin
 */

namespace T73Biz\Bundle\TranslocationBundle\Twig;

use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LocaleExposeExtension extends \Twig_Extension
{
    /**
     * @var Container $container
     */
    private $container;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function getGlobals()
    {
        $supported_locales      = array();
        $supported_full_locales = array();

        if ($this->container->hasParameter('t73_biz_translocation.supported_locales')) {
            $supported_locales = $this->container->getParameter('t73_biz_translocation.supported_locales');
            foreach ($supported_locales as $locale) {
                $supported_full_locales[$locale] = locale_get_display_language($locale);
            }
        }

        $default_locale = array(
            'code' => 'en',
            'name' => locale_get_display_language('en')
        );

        if ($this->container->hasParameter('framework.default_locale')) {
            $locale         = $this->container->getParameter('framework.default_locale');
            $default_locale = array(
                'code' => $locale,
                'name' => locale_get_display_language($locale)
            );
        }

        return array(
            'default_locale'         => $default_locale,
            'supported_locales'      => $supported_locales,
            'supported_full_locales' => $supported_full_locales
        );
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return "supported_locale_expose_extension";
    }
}
