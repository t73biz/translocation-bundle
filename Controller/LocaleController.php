<?php
/**
 * This software is part of the T73Biz\Translocation Bundle
 * See the LICENSE file for more information.
 * Copyright (c) 2014 Ronald Chaplin
 */

namespace T73Biz\Bundle\TranslocationBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class LocaleController
 * @Route("/locale")
 * @author Ronald Chaplin <ron.g.chaplin@gmail.com>
 */
class LocaleController extends Controller
{
	/**
	 * @Route("/switch/{locale}", name="switch_locale", defaults={"locale"="%kernel.default_locale%"})
	 * @param Request $request
	 * @param string $locale
	 * @return \Symfony\Component\HttpFoundation\RedirectResponse
	 */
	public function switchAction(Request $request, $locale)
	{
		$request->getSession()->set('_locale', $locale);
		$previousUrl = $request->headers->get('referer');

		return $this->redirect($previousUrl);
	}
}
