<?php
/**
 * This software is part of the T73Biz\Translocation Bundle
 * See the LICENSE file for more information.
 * Copyright (c) 2014 Ronald Chaplin
 */

namespace T73Biz\Bundle\TranslocationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class TranslateController
 * @Route("/translate")
 */
class TranslateController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }

    /**
     * @Route("/configure")
     * @Template()
     */
    public function configureAction()
    {
        return array();
    }
}
