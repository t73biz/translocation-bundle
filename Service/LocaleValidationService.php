<?php
/**
 * This software is part of the T73Biz\Translocation Bundle
 * See the LICENSE file for more information.
 * Copyright (c) 2014 Ronald Chaplin
 */

namespace T73Biz\Bundle\TranslocationBundle\Service;

use Symfony\Component\DependencyInjection\Container;

/**
 * Class LocaleValidationService
 * @author Ronald Chaplin <rchaplin@t73.biz>
 */
class LocaleValidationService
{
    /**
     * @var array
     */
    protected $supportedLocales;

    /**
     * Constructor Method
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->setSupportedLocales($container->getParameter('t73_biz_translocation.supported_locales'));
    }

    /**
     * Validation method for determining if a supplied locale is supported.
     *
     * @param $locale
     * @return bool
     */
    public function isValid($locale)
    {
        return in_array($locale, $this->getSupportedLocales());
    }

    /**
     * @param array $supportedLocales
     */
    public function setSupportedLocales($supportedLocales)
    {
        $this->supportedLocales = $supportedLocales;
    }

    /**
     * @return array
     */
    public function getSupportedLocales()
    {
        return $this->supportedLocales;
    }
}
