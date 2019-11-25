<?php

namespace App\Tests\Service;


use App\Service\Factory\ParseFactory;
use App\Service\Parser;
use PhpParser\ParserFactory;
use PHPUnit\Framework\TestCase;

use Prophecy\Argument;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Encoder\DecoderInterface;
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
        $this->serializerMock = $this->prophesize(SerializerInterface::class)->willImplement(DecoderInterface::class);
        $this->parser = new ParseFactory($this->serializerMock->reveal());
    }


    public function testXmlParser()
    {
        $this->serializerMock->decode(Argument::any(), 'xml')->shouldBeCalled()->willReturn([]);
        $file = new File(__DIR__.'/../../features/data/file.xml');
        $result = $this->parser->parsedData($file);
        $this->assertEquals('processed', $result['data']['status']);
    }

    public function testCsvParser()
    {
        $this->serializerMock->decode(Argument::any(), 'csv')->shouldBeCalled()->willReturn([]);
        $file = new File(__DIR__.'/../../features/data/file.csv');
        $result = $this->parser->parsedData($file);
        $this->assertEquals('processed', $result['data']['status']);
    }

    public function testJsonParser()
    {
        $this->serializerMock->decode(Argument::any(), 'json')->shouldBeCalled()->willReturn([]);
        $file = new File(__DIR__ . '/../../features/data/file.json');
        $result = $this->parser->parsedData($file);
        $this->assertEquals('processed', $result['data']['status']);
    }

    public function testEmptyFile()
    {
//        $this->serializerMock->decode(Argument::any(), 'json')->shouldBeCalled()->willReturn([]);
        $file = new File(__DIR__.'/../../features/data/empty.json');
        $result = $this->parser->parsedData($file);
        $this->assertEquals('error', $result['data']['status']);
    }

    public function testDamagedFile()
    {
        $this->serializerMock->decode(Argument::any(), 'json')->shouldBeCalled()->willThrow(new \Exception('Syntax Error'));
        $file = new File(__DIR__.'/../../features/data/file.json');
        $result = $this->parser->parsedData($file);

        $this->assertEquals('error', $result['data']['status']);
    }
}
