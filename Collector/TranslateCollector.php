<?php
/**
 * This software is part of the T73Biz\Translocation Bundle
 * See the LICENSE file for more information.
 * Copyright (c) 2014 Ronald Chaplin
 */

namespace T73Biz\Bundle\TranslocationBundle\Collector;

use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\DataCollector\DataCollector;
use Symfony\Component\Translation\MessageCatalogue;
use T73Biz\Bundle\TranslocationBundle\Extractor\TwigExtractor;
use Symfony\Bundle\FrameworkBundle\Templating\TemplateReference;
/**
 * Class TranslateCollector
 * @author Ronald Chaplin <ron.g.chaplin@gmail.com>
 */
class TranslateCollector extends DataCollector
{
	/**
	 * @var Container $container
	 */
	private $container;

	/**
	 * @var TwigExtractor $twigExtractor
	 */
	private $twigExtractor;


	/**
	 * @param TwigExtractor $twigExtractor
	 * @param Container $container
	 */
	public function __construct(TwigExtractor $twigExtractor, Container $container)
	{
		$this->container = $container;
		$this->twigExtractor = $twigExtractor;
	}

	/**
	 * Collects data for the given Request and Response.
	 *
	 * @param Request $request A Request instance
	 * @param Response $response A Response instance
	 * @param \Exception $exception An Exception instance
	 *
	 * @api
	 */
	public function collect(Request $request, Response $response, \Exception $exception = null)
	{
		$template = $request->attributes->get('_template');
		$messages = array();
		$content = $response->getContent();
        $path = '';
        $fileContent = '';
		if($template instanceof TemplateReference) {
			$locale = $request->attributes->get('_locale', $request->getLocale());
			$catalogue = new MessageCatalogue($locale);

            $path = $template->getPath();
			/**
			 * Check if $path is a resource
			 */
			if(strstr($path,'@')) {
				$kernel = $this->container->get('kernel');
				$path = $kernel->locateResource($path);
                $fileContent = file_get_contents($path);
			}
			$this->twigExtractor->extractTemplate($path, $catalogue);
			$messages = $catalogue->all();
		}

		$this->data = array(
			'content' => $content,
            'file_content' => $fileContent,
			'messages' => $messages,
            'path' => $path
		);
	}

	/**
	 * @return mixed
	 */
	public function getContent()
	{
		return $this->data['content'];
	}

    /**
     * @return mixed
     */
    public function getFileContent()
    {
        return $this->data['file_content'];
    }

	/**
	 * @return mixed
	 */
	public function getMessages()
	{
		return $this->data['messages'];
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
		return "translate";
	}

    public function getPath()
    {
        return $this->data['path'];
    }

} 
