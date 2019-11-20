<?php

namespace App\Tests\Service;


use App\Service\Parser;
use PHPUnit\Framework\TestCase;

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\SerializerInterface;


class ParseTest extends TestCase
{
    private $parser;

    /**
     * @var \Prophecy\Prophecy\ObjectProphecy|SerializerInterface
     */
    private $serializerMock;

    protected function setUp()
    {
        $this->serializerMock = $this->prophesize(SerializerInterface::class)->reveal();
        $this->parser = new Parser($this->serializerMock);
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
        $file = new File(__DIR__.'/../../features/data/file.json');
        $result = $this->parser->parsedData($file);
        $this->assertIsArray($result['data']);
    }
}
