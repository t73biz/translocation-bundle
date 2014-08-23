<?php
/**
 * This software is part of the T73Biz\Translocation Bundle
 * See the LICENSE file for more information.
 * Copyright (c) 2014 Ronald Chaplin
 */

namespace T73Biz\Bundle\TranslocationBundle\Collector;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\DataCollector\DataCollector;

class LocaleCollector extends DataCollector
{
    /**
     * Collects data for the given Request and Response.
     *
     * @param Request    $request   A Request instance
     * @param Response   $response  A Response instance
     * @param \Exception $exception An Exception instance
     *
     * @api
     */
    public function collect(Request $request, Response $response, \Exception $exception = null)
    {
        $current_locale   = locale_get_display_language($request->attributes->get('_locale', $request->getLocale()));
        $requested_locale = locale_get_display_language($request->headers->get('accept-language'));

        $this->data = array(
            'current_locale'   => $current_locale,
            'requested_locale' => $requested_locale,
            'display_in_wdt'   => $this->getDisplayInWdt()
        );
    }

    /**
     * Get the current locale set for the requested page
     *
     * @return mixed
     */
    public function getCurrentLocale()
    {
        return $this->data['current_locale'];
    }

    /**
     * Get the flag to display Locale Panel or not
     *
     * @return mixed
     */
    public function getDisplayInWdt()
    {
        return $this->data['display_in_wdt'];
    }

    /**
     * Get the requested locale
     *
     * @return mixed
     */
    public function getRequestedLocale()
    {
        return $this->data['requested_locale'];
    }

    /**
     * Returns the name of the collector.
     *
     * @return string The collector name
     *
     * @api
     */
    public function getName()
    {
        return "locale";
    }

    public function setDisplayInWdt($displayInWdt)
    {
        $this->data['display_in_wdt'] = $displayInWdt;
    }
}
