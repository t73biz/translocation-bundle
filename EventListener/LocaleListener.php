<?php
/**
 * This software is part of the T73Biz\Translocation Bundle
 * See the LICENSE file for more information.
 * Copyright (c) 2014 Ronald Chaplin
 */

namespace T73Biz\Bundle\TranslocationBundle\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class LocaleListener
 * @author Ronald Chaplin <rchaplin@t73.biz>
 */
class LocaleListener implements EventSubscriberInterface
{
	private $defaultLocale;

	public function __construct($defaultLocale = 'en')
	{
		$this->defaultLocale = $defaultLocale;
	}

	public function onKernelRequest(GetResponseEvent $event)
	{
		$request = $event->getRequest();
		if (!$request->hasPreviousSession()) {
			return;
		}

		// try to see if the locale has been set as a _locale routing parameter
		if ($locale = $request->attributes->get('_locale')) {
			$request->getSession()->set('_locale', $locale);
		} else {
			// if no explicit locale has been set on this request, use one from the session
			$request->setLocale($request->getSession()->get('_locale', $this->defaultLocale));
		}
	}

	public static function getSubscribedEvents()
	{
		return array(
			// must be registered before the default Locale listener
			KernelEvents::REQUEST => array(array('onKernelRequest', 17)),
		);
	}
}
