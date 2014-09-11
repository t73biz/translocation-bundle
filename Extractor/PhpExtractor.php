<?php
/**
 * This software is part of the T73Biz\Translocation Bundle
 * See the LICENSE file for more information.
 * Copyright (c) 2014 Ronald Chaplin
 */

namespace T73Biz\Bundle\TranslocationBundle\Extractor;

use Symfony\Component\Finder\Finder;
use Symfony\Component\Translation\MessageCatalogue;
use Symfony\Component\Translation\Extractor\ExtractorInterface;
use Symfony\Component\Validator\Exception\InvalidArgumentException;
use T73Biz\Bundle\TranslocationBundle\NodeVisitor\TransNodeVisitor;
use T73Biz\Bundle\TranslocationBundle\NodeVisitor\TransChoiceNodeVisitor;
use PhpParser\Error;
use PhpParser\Lexer;
use PhpParser\Node;
use PhpParser\Node\Stmt;
use PhpParser\NodeTraverser;
use PhpParser\Parser;

/**
 * PhpExtractor extracts translation messages from a PHP template
 * using the vendor library from @link https://github.com/nikic/PHP-Parser
 *
 * @author Ronald Chaplin <rchaplin@t73.biz>
 */
class PhpExtractor implements ExtractorInterface
{
    /**
     * @var  array $files
     * The files found with Finder
     */
    private $files;

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
        $vendorDir = __DIR__ . '/../vendor';
        if (!@require $vendorDir . '/nikic/php-parser/lib/bootstrap.php') {
            die("We could not find the PHP Parser Bootstrap");
        }
        $this->catalogue = $catalogue;
        $this->findPhpFiles($directory);
        $this->parseFiles();
        $this->setCatalogue();
    }

    /**
     * @param string $directory
     */
    public function findPhpFiles($directory)
    {
        if (!is_dir($directory)) {
            throw new InvalidArgumentException(
                'Invalid directory. ' . $directory . ' does not exist or is not accessible.'
            );
        }

        $finder = new Finder();
        $this->files = $finder->files()->name('*.php')->in($directory);
    }

    public function parseFiles()
    {
        $parser = new Parser(new Lexer);
        try {
            foreach ($this->files as $file) {
                $node = $parser->parse(file_get_contents($file->getPathName()));
                $this->traverseNode($node);
            }
        } catch (Error $error) {
            echo 'Parse Error: ', $error->getMessage();
        }
    }

    public function setCatalogue()
    {
        foreach ($this->messages as $message) {
            $this->catalogue->set($message['key'], $message['domain']);
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
        $this->messages[] = array_merge(
            $transNodeVisitor->getMatches(),
            $transChoiceNodeVisitor->getMatches()
        );
    }
}
