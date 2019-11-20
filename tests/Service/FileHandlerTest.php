<?php

namespace App\Tests\Service;

use App\Message\ProcessFile;
use App\Service\FileHandler;
use App\Service\Parser;
use Prophecy\Argument;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Serializer\SerializerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\MessageBusInterface;


class FileHandlerTest extends TestCase
{
    /**
     * @var EntityManagerInterface|object
     */
    private $entityManager;
    /**
     * @var MessageBusInterface
     */
    private $messageBus;
    /**
     * @var object|SerializerInterface
     */
    private $serializerMock;
    /**
     * @var Parser
     */
    private $parser;
    /**
     * @var \App\Entity\File|\Prophecy\Prophecy\ObjectProphecy
     */
    private $file;
    /**
     * @var ProcessFile|object
     */
    private $processFile;

    protected function setUp()
    {
        $this->entityManager = $this->prophesize(EntityManagerInterface::class)->reveal();
        $this->messageBus = $this->prophesize(MessageBusInterface::class);
        $this->serializerMock = $this->prophesize(SerializerInterface::class)->reveal();
        $this->parser = new Parser($this->serializerMock);
        $this->file = $this->prophesize(\App\Entity\File::class)->reveal();
        $this->processFile = $this->prophesize(ProcessFile::class)->reveal();

    }


    public function testWillDispatchOnNewFile()
    {
        $file = new File(__DIR__.'/../../features/data/file.xml');

        $handler =$this->prophesize( FileHandler::class)->willBeConstructedWith([$this->messageBus->reveal(),$this->entityManager, $this->parser])
            ->makeProphecyMethodCall('handle',  [$file])->willReturn();

        $handler->handle($file);
        $this->assertInstanceOf(\App\Entity\File::class,$handler->handle($file));


    }
}
