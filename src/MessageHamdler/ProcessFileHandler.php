<?php


namespace App\MessageHamdler;


use App\Entity\File;
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


    public function __invoke(ProcessFile $processFile)
    {
        $file = $this->entityManager->getRepository(File::class)->find($processFile->getFile());
        try {
        $file_data=$processFile->getFileData();
        $fileParsedData = $file_data['data']['results'];
            foreach ($fileParsedData as $item){
                $map = new Map();
                $map->setContent($item);
                $file->addMap($map);
                $this->entityManager->persist($map);
            }

            $file->setStatus($file_data['data']['status'])
                ->setFileName($file_data['fileName'])
                ->setDocumentType($file_data['extension'])
                ->setRawText($file_data['rawContent']);
            $this->entityManager->persist($file);
            $this->entityManager->flush();

        } catch (\Exception $e) {
            $file->setStatus('error')
                ->setFileName($file_data['fileName'])
                ->setDocumentType($file_data['extension'])
                ->setRawText($file_data['rawContent']);

            $this->entityManager->persist($file);
            $this->entityManager->flush();
        }
    }
}