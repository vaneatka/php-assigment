<?php


namespace App\Service;


use App\Entity\File;
use App\Message\ProcessFile;
use Symfony\Component\HttpFoundation\File\File as FileInterface;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Messenger\MessageBusInterface;

class FileHandler
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var Parser
     */
    private $parser;
    /**
     * @var MessageBusInterface
     */
    private $messageBus;

    public function __construct(MessageBusInterface $messageBus,EntityManagerInterface $entityManager, Parser $parser)
    {
        $this->entityManager = $entityManager;
        $this->parser = $parser;
        $this->messageBus = $messageBus;
    }

    public function handle(FileInterface $fileData)
    {
        $file = new File();
        $file->setStatus('pending')
            ->setCreatedAt(new \DateTime());
        $this->entityManager->persist($file);
        $this->entityManager->flush();

        $message = new ProcessFile($this->parser->parsedData($fileData), $file->getId());
        $this->messageBus->dispatch($message);
    }

}