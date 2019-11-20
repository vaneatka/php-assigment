<?php

namespace App\Tests\Service;


use App\Service\Parser;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpFoundation\File\File;


class ParseTest extends KernelTestCase
{
    private $parser;

    protected function setUp()
    {
        $kernel = self::bootKernel();
        $this->parser = $kernel->getContainer()->get(Parser::class);
    }

    public function testXmlParser()
    {
        $file = new File(__DIR__.'/../../features/data/file.xml');
        $result = $this->parser->parsedData($file);
        $this->assertIsArray($result['data']);
    }
    public function testCsvParser()
    {
        $file = new File(__DIR__.'/../../features/data/file.csv');
        $result = $this->parser->parsedData($file);
        $this->assertIsArray($result['data']);
    }
    public function testJsonParser()
    {
        $file = new File(__DIR__.'/../../features/data/file.csv');
        $result = $this->parser->parsedData($file);
        $this->assertIsArray($result['data']);
    }
}
