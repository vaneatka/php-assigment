<?php


namespace App\MessageHamdler;


use App\Entity\Map;
use App\Message\ProcessFile;
use App\Service\Parser;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class ProcessFileHandler implements MessageHandlerInterface
{

    private $parser;
    private $entityManager;

    public function __construct(Parser $parser, EntityManagerInterface $entityManager)
    {
        $this->parser=$parser;
        $this->entityManager = $entityManager;
    }


    public function __invoke(ProcessFile $processFile )
    {

        $file_data=$processFile->getFileData();
        $file=$processFile->getFile();

        $file->setCreatedAt(new \DateTime())
            ->setDocumentType($this->parser->getExtension($file_data))
            ->setFileName($this->parser->getFileName($file_data))
            ->setStatus('pending');
        $this->entityManager->persist($file);
        $this->entityManager->flush();
        dd($file);
        try {
            $result = $this->parser->parse($file_data);
            foreach ($result as $item){
                $map = new Map();
                $map->setContent($item);
                $file->addMap($map);
                $this->entityManager->persist($map);
            }
            $this->entityManager->persist($file);
            $this->entityManager->flush();
        } catch (\Exception $e) {
            dd($e);
        }


    }
}