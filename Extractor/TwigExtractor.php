<?php
/**
 * This software is part of the T73Biz\Translocation Bundle
 * Patterned after the Symfony Bridge TwigExtractor
 * See the LICENSE file for more information.
 * (c) Fabien Potencier <fabien@symfony.com>
 */

namespace T73Biz\Bundle\TranslocationBundle\Extractor;

use Symfony\Component\Finder\Finder;
use Symfony\Component\Translation\Extractor\ExtractorInterface;
use Symfony\Component\Translation\MessageCatalogue;
use Symfony\Bridge\Twig\NodeVisitor\TranslationNodeVisitor;
use Twig_TokenStream;

/**
 * TwigExtractor extracts translation messages from a twig template.
 *
 * @author Michel Salib <michelsalib@hotmail.com>
 * @author Fabien Potencier <fabien@symfony.com>
 * @author Ronald Chaplin <rchaplin@t73.biz>
 */
class TwigExtractor implements ExtractorInterface
{
	/**
	 * Default domain for found messages.
	 *
	 * @var string
	 */
	private $defaultDomain = 'messages';

	/**
	 * Prefix for found message.
	 *
	 * @var string
	 */
	private $prefix = '';

	/**
	 * The twig environment.
	 *
	 * @var \Twig_Environment
	 */
	private $twig;

	/**
	 * @param \Twig_Environment $twig
	 */
	public function __construct(\Twig_Environment $twig)
	{
		$this->twig = $twig;
	}

	/**
	 * {@inheritdoc}
	 */
	public function extract($directory, MessageCatalogue $catalogue)
	{
		// load any existing translation files
		$finder = new Finder();
		$files = $finder->files()->name('*.twig')->sortByName()->in($directory);
		foreach ($files as $file) {
			$this->extractTemplate($file->getPathname(), $catalogue);
		}
	}

	/**
	 * {@inheritdoc}
	 */
	public function setPrefix($prefix)
	{
		$this->prefix = $prefix;
	}

    /**
     * @return \Twig_Environment
     */
    public function getTwig()
    {
        return $this->twig;
    }

    /**
	 * Extract messages from a single template
	 * @param $templatePath
	 * @param \Symfony\Component\Translation\MessageCatalogue $catalogue
	 * @return string
	 */
	public function extractTemplate($templatePath, MessageCatalogue $catalogue)
	{
		$content = file_get_contents($templatePath);
        $translator = $this->twig->getExtension('translator');

		/**
		 * @var TranslationNodeVisitor $visitor
		 */
		$visitor = $translator->getTranslationNodeVisitor();
		$visitor->enable();
        $tokens = $this->twig->tokenize($content);
		$this->twig->parse($tokens);

		foreach ($visitor->getMessages() as $message) {
			$catalogue->set(trim($message[0]), $this->prefix.trim($message[0]), $message[1] ? $message[1] : $this->defaultDomain);
		}

		$visitor->disable();

		return $content;
	}
}
