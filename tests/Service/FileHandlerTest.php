<?php

namespace App\Tests\Service;

use App\Message\ProcessFile;
use App\Service\FileHandler;
use App\Service\Parser;
use PHPUnit\Framework\Constraint\Attribute;
use Prophecy\Argument;
use Ramsey\Uuid\Uuid;
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
        $this->entityManagerMock = $this->prophesize(EntityManagerInterface::class);
        $this->messageBusMock = $this->prophesize(MessageBusInterface::class);
        $this->messageBusMock->dispatch(Argument::type(ProcessFile::class))->willReturn(new Envelope(Argument::type(ProcessFile::class)));
        $this->serializerMock = $this->prophesize(SerializerInterface::class)->reveal();
        $this->parser = new Parser($this->serializerMock);
        $this->file = $this->prophesize(\App\Entity\File::class)->reveal();

    }


    public function testWillDispatchOnNewFile()
    {
        $file = new File(__DIR__.'/../../features/data/file.xml');
        $handler = new FileHandler($this->messageBusMock->reveal(),$this->entityManagerMock->reveal(),$this->parser);
        $handledFile = new \App\Entity\File();
        $handledFile->setId(Uuid::uuid4()->toString())->setStatus('testing');
        $assertion = $handler->handle($file, $handledFile);
        $this->entityManagerMock->persist($handledFile)->shouldBeCalled();
        $this->entityManagerMock->flush()->shouldBeCalledOnce();
        $this->messageBusMock->dispatch(Argument::type(ProcessFile::class))->shouldBeCalled();
        $this->assertInstanceOf(\App\Entity\File::class, $assertion);
    }
}
