<?php
/**
 * This software is part of the T73Biz\Translocation Bundle
 * See the LICENSE file for more information.
 * Copyright (c) 2014 Ronald Chaplin
 */

namespace T73Biz\Bundle\TranslocationBundle\Extractor;

use PhpParser\Error;
use PhpParser\Lexer;
use PhpParser\Node;
use PhpParser\Node\Stmt;
use PhpParser\NodeTraverser;
use PhpParser\Parser;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Translation\MessageCatalogue;
use Symfony\Component\Translation\Extractor\ExtractorInterface;
use Symfony\Component\Validator\Exception\InvalidArgumentException;
use T73Biz\Bundle\TranslocationBundle\NodeVisitor\TransNodeVisitor;
use T73Biz\Bundle\TranslocationBundle\NodeVisitor\TransChoiceNodeVisitor;

/**
 * PhpExtractor extracts translation messages from a PHP template
 * using the vendor library from @link https://github.com/nikic/PHP-Parser
 *
 * @author Ronald Chaplin <rchaplin@t73.biz>
 */
class PhpExtractor implements ExtractorInterface
{
    /**
     * @var MessageCatalogue $catalogue
     * The catalogue object used for gathering translations
     */
    private $catalogue;

    /**
     * Prefix for new found message.
     *
     * @var string
     */
    private $prefix = '';

    /**
     * @var array $nodes
     */
    public $messages = array();

    /**
     * @param string           $directory
     * @param MessageCatalogue $catalogue
     * @throw InvalidArgumentException
     */
    public function extract($directory, MessageCatalogue $catalogue)
    {
        $this->catalogue = $catalogue;
        $this->parseFiles($directory);
    }

    public function parseFiles($directory)
    {
        if (!is_dir($directory)) {
            throw new InvalidArgumentException(
                'Invalid directory. ' . $directory . ' does not exist or is not accessible.'
            );
        }

        $parser = new Parser(new Lexer);
        try {
            $finder = new Finder();
            $finder->files()->name('*.php')->in($directory);
            /**
             * @var \SplFileInfo $file
             */
            foreach ($finder as $file) {
                $content = file_get_contents($file->getRealpath());
                $node = $parser->parse($content);
                $this->traverseNode($node);
            }
        } catch (Error $error) {
            echo 'Parse Error: ', $error->getMessage();
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
     * @param $node
     */
    public function traverseNode($node)
    {
        $traverser = new NodeTraverser;
        $transNodeVisitor = new TransNodeVisitor;
        $transChoiceNodeVisitor = new TransChoiceNodeVisitor;
        $traverser->addVisitor($transNodeVisitor);
        $traverser->addVisitor($transChoiceNodeVisitor);
        $traverser->traverse($node);
        $this->setCatalogue($transNodeVisitor->getMatches());
        $this->setCatalogue($transChoiceNodeVisitor->getMatches());
    }

    protected function setCatalogue($set)
    {
        foreach ($set as $message) {
            $this->catalogue->set($message['key'], $message['key'], $message['domain']);
        }
    }
}
