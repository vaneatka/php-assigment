<?php
declare(strict_types=1);

namespace App\Tests\Service;


use App\Service\Factory\ParseFactory;
use App\Service\Factory\ParserInterface;

use PHPUnit\Framework\TestCase;

use Prophecy\Argument;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Encoder\DecoderInterface;

class ParseFactoryTest extends TestCase
{
    private $factory;

    protected function setUp()
    {

        $this->factory = new ParseFactory();


    }


    public function testXmlParser()
    {
        $file = new File(__DIR__.'/../../features/data/file.xml');
        $xmlParserMock = $this->prophesize(ParserInterface::class);
        $xmlParserMock->support('xml')->shouldBeCalled()->willReturn(true);
        $xmlParserMock->decode($file)->shouldBeCalled()->willReturn([
            'status' => 'processed',
        ]);
        $this->factory->addParser($xmlParserMock->reveal());
        $result = $this->factory->parsedData($file);
        $this->assertEquals('processed', $result['data']['status']);
    }

    public function testCsvParser()
    {
        $file = new File(__DIR__.'/../../features/data/file.csv');
        $csvParserMock = $this->prophesize(ParserInterface::class);
        $csvParserMock->support('csv')->shouldBeCalled()->willReturn(true);
        $csvParserMock->decode($file)->shouldBeCalled()->willReturn([
            'status' => 'processed',
        ]);
        $this->factory->addParser($csvParserMock->reveal());
        $result = $this->factory->parsedData($file);
        $this->assertEquals('processed', $result['data']['status']);
    }

    public function testJsonParser()
    {
        $file = new File(__DIR__.'/../../features/data/file.json');
        $jsonParserMock = $this->prophesize(ParserInterface::class);
        $jsonParserMock->support('json')->shouldBeCalled()->willReturn(true);
        $jsonParserMock->decode($file)->shouldBeCalled()->willReturn([
            'status' => 'processed',
        ]);
        $this->factory->addParser($jsonParserMock->reveal());
        $result = $this->factory->parsedData($file);
        $this->assertEquals('processed', $result['data']['status']);
    }

    public function testEmptyFile()
    {

        $file = new File(__DIR__.'/../../features/data/file.json');
        $jsonParserMock = $this->prophesize(ParserInterface::class);
        $jsonParserMock->support('json')->shouldBeCalled()->willReturn(true);
        $jsonParserMock->decode($file)->shouldBeCalled()->willReturn([
            'status' => 'error',
        ]);
        $this->factory->addParser($jsonParserMock->reveal());
        $result = $this->factory->parsedData($file);
        $this->assertEquals('error', $result['data']['status']);
    }

    public function testDamagedFile()
    {
        $file = new File(__DIR__.'/../../features/data/file.json');
        $jsonParserMock = $this->prophesize(ParserInterface::class);
        $jsonParserMock->support('json')->shouldBeCalled()->willReturn(true);
        $jsonParserMock->decode($file)->shouldBeCalled()->willReturn([
            'status' => 'error',
        ]);
        $this->factory->addParser($jsonParserMock->reveal());
        $result = $this->factory->parsedData($file);
        $this->assertEquals('error', $result['data']['status']);
    }
}
