<?php


namespace App\MessageHamdler;


use App\Entity\File;
use App\Entity\Map;
use App\Message\ProcessFile;
use App\Repository\FileRepository;
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


    public function __invoke(ProcessFile $processFile)
    {
        $fileId=$processFile->getFile();
        $file = $this->entityManager->getRepository(File::class)->find($fileId);
        $file_data=$processFile->getFileData();
        try {
            $fileParsedData = $this->parser->parse($file_data);
            foreach ($fileParsedData as $item){
                $map = new Map();
                $map->setContent($item);
                $file->addMap($map);
                $this->entityManager->persist($map);
            }
            $file->setStatus('processed')
                ->setFileName($this->parser->getFileName($file_data))
                ->setDocumentType($this->parser->getExtension($file_data));
            $this->entityManager->persist($file);
            $this->entityManager->flush();
        } catch (\Exception $e) {
            dd($e);
        }
    }
}