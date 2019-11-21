<?php

namespace App\Tests\Service;

use App\Message\ProcessFile;
use App\Service\FileHandler;
use App\Service\Parser;
use Prophecy\Argument;
use Prophecy\Promise\CallbackPromise;
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
    private $entityManagerMock;
    /**
     * @var MessageBusInterface
     */
    private $messageBusMock;
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
        $this->entityManagerMock = $this->prophesize(EntityManagerInterface::class)->reveal();
        $this->messageBusMock = $this->prophesize(MessageBusInterface::class);
        $this->messageBusMock->dispatch(Argument::type(ProcessFile::class))->willReturn(new Envelope(Argument::type(ProcessFile::class)));
        $this->serializerMock = $this->prophesize(SerializerInterface::class)->reveal();
        $this->parser = new Parser($this->serializerMock);
        $this->file = $this->prophesize(\App\Entity\File::class)->reveal();

    }


    public function testWillDispatchOnNewFile()
    {
        $file = new File(__DIR__.'/../../features/data/file.xml');
        $handler = new FileHandler($this->messageBusMock->reveal(),$this->entityManagerMock,$this->parser);
        $fileEntityMock = $this->prophesize(\App\Entity\File::class);
        $fileEntityMock->setStatus(Argument::type('string'))->willReturn(new \App\Entity\File());
        $fileEntityMock->getId()->willReturn(1);
        $assertion = $handler->handle($file, $fileEntityMock->reveal());
        $this->assertInstanceOf(\App\Entity\File::class, $assertion);
    }
}
