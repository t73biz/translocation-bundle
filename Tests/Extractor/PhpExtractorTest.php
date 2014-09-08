<?php
/**
 * This software is part of the T73Biz\Translocation Bundle
 * See the LICENSE file for more information.
 * Copyright (c) 2014 Ronald Chaplin
 */

namespace T73Biz\Bundle\TranslocationBundle\Tests;

use T73Biz\Bundle\TranslocationBundle\Extractor\PhpExtractor;
use Symfony\Component\Translation\MessageCatalogue;

/**
 * Class PhpExtractorTest
 *
 * @author Ronald Chaplin <rchaplin@t73.biz>
 */
class PhpExtractorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var string $badDirectory
     */
    protected $badDirectory = './foobar';

    /**
     * @var string $goodDirectory
     */
    protected $goodDirectory ='';

    /**
     * @var string $locale
     */
    protected $locale = 'en';

    /**
     * @var MessageCatalogue $messageCatalogue
     */
    protected $messageCatalogue;

    /**
     * @var PhpExtractor $phpExtractor
     */
    protected $phpExtractor;

    /**
     * @inheritdoc
     */
    protected function setUp()
    {
        parent::setUp();
        $this->goodDirectory = __DIR__ . "/../Sources";
        $this->phpExtractor = new PhpExtractor();
        $this->messageCatalogue = new MessageCatalogue($this->locale);
    }

    /**
     * Test Class setup
     */
    public function testClassHasProperSetup()
    {
        $this->assertTrue(property_exists($this->phpExtractor, 'files'));
        $this->assertTrue(property_exists($this->phpExtractor, 'catalogue'));
        $this->assertTrue(property_exists($this->phpExtractor, 'prefix'));
        $this->assertTrue(property_exists($this->phpExtractor, 'messages'));
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testFindPhpFilesException()
    {
        $this->phpExtractor->findPhpFiles($this->badDirectory, $this->messageCatalogue);
    }

    /**
     * Test file finding functionality
     */
    public function testFilesFound()
    {
        $this->phpExtractor->findPhpFiles($this->goodDirectory);
        $this->assertAttributeNotEmpty('files', $this->phpExtractor);
    }

    /**
     * Test file parsing functionality
     */
    public function testParseFiles()
    {
        $this->phpExtractor->findPhpFiles($this->goodDirectory);
        $this->phpExtractor->parseFiles();
        $this->assertAttributeNotEmpty('messages', $this->phpExtractor);
    }
}
