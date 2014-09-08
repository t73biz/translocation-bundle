<?php
/**
 * This software is part of the T73Biz\Translocation Bundle
 * See the LICENSE file for more information.
 * Copyright (c) 2014 Ronald Chaplin
 */

namespace T73Biz\Bundle\TranslocationBundle\Service;

use Symfony\Component\Finder\Finder;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class TranslationDomainService
 *
 * @author Ronald Chaplin <rchaplin@t73.biz>
 */
class TranslationDomainService
{
    /**
     * @var Finder $finder
     */
    protected $finder;

    /**
     * @var string
     */
    protected $rootDir;

    /**
     * Constructor Method
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->setFinder(new Finder());
        $this->setRootDir($container->get('kernel')->getRootDir());
    }

    public function getDomains($locale)
    {
        $dirs = array(

        );
        $this->finder->files()->in($dirs);
        return array();
    }

    /**
     * @param string $rootDir
     */
    public function setRootDir($rootDir)
    {
        $this->rootDir = $rootDir;
    }

    /**
     * @return string
     */
    public function getRootDir()
    {
        return $this->rootDir;
    }

    /**
     * @param Finder $finder
     */
    public function setFinder($finder)
    {
        $this->finder = $finder;
    }

    /**
     * @return Finder
     */
    public function getFinder()
    {
        return $this->finder;
    }
}
