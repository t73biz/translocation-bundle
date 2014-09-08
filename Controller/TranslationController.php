<?php
/**
 * This software is part of the T73Biz\Translocation Bundle
 * See the LICENSE file for more information.
 * Copyright (c) 2014 Ronald Chaplin
 */

namespace T73Biz\Bundle\TranslocationBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;
use Symfony\Component\Translation\MessageCatalogue;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use T73Biz\Bundle\TranslocationBundle\Service\LocaleValidationService;

/**
 * Class TranslationController
 * @Route("/translations")
 */
class TranslationController extends Controller
{
    /**
     * @Route("/{locale}")
     * @Template()
     *
     * @param string $locale
     * @return array
     */
    public function indexAction($locale)
    {
        $valid = $this->getLocaleValidationService()->isValid($locale);
        $response = array();
        if ($valid) {
            $response['locale'] = $locale;
        } else {
            $response['error'] = 'Invalid Locale: ' . $locale;
        }

        return $response;
    }

    /**
     * @return LocaleValidationService
     */
    protected function getLocaleValidationService()
    {
        return $this->get('t73_biz_translocation.service.locale_validation');
    }
}
