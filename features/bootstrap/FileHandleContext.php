<?php


use App\Service\Factory\ParseFactory;
use App\Service\FileHandler;
use Behat\Behat\Context\Context;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\HttpFoundation\File\File;

class FileHandleContext implements Context
{
    /**
     * @var KernelInterface
     */
    private $kernel;

    /**
     * @var File
     */
    private $fileToBeParsed;

    /**
     * @var \App\Entity\File
     */
    private $savedFile;
    /**
     * @var \App\Service\Factory\ParseFactory
     */
    private $parseFactory;
    /**
     * @var \Doctrine\ORM\EntityManagerInterface
     */
    private $entityManager;


    public function __construct(KernelInterface $kernel )
    {
        $this->kernel = $kernel;

        $this->parseFactory = $this->kernel->getContainer()->get(ParseFactory::class);
        $this->entityManager = $entityManager;
    }

    /**
     * @Given We gave a valid :arg1 to be processed
     */
    public function weGaveAValidToBeProcessed($arg1)
    {
        $file = new File("/app/features/data/$arg1");
        $resultArray = $this->parseFactory->parsedData($file);
        if (!empty($resultArray['data'])){
            $this->fileToBeParsed = $resultArray;
            $this->fileToBeParsed = $file;
            return true;
        }else{
        throw new Exception($resultArray['data']);
        }
    }

    /**
     * @Given The contents are persisted to database
     */
    public function theContentsArePersistedToDatabase()
    {
        $handler = $this->kernel->getContainer()->get(FileHandler::class);

        $this->savedFile = new \App\Entity\File();

        $this->savedFile
            ->setId(\Ramsey\Uuid\Uuid::uuid4()->toString())
            ->setStatus('input');
        $result =  $handler->handle($this->fileToBeParsed, $this->savedFile);
        sleep(2);
        if ($result->getStatus() == 'pending'){
            $this->savedFile = $result;
            return true;
        } else {
        throw new Exception('file did not persist');
        }
    }

    /**
     * @When We will get Maps we get aan array
     */
    public function weWillGetMapsWeGetAanArray()
    {
        $map = $this->savedFile->getMaps()->getValues();
        if (is_array($map)){
            return true;
        } else {
        throw new Exception('Maps not found');
        }
    }

    /**
     * @Then The file entity status is :arg1
     */
    public function theFileEntityStatusIs($arg1)
    {
        $file = $this->kernel->getContainer()->get(\App\Repository\FileRepository::class)->find($this->savedFile->getId());

        if ($arg1 == $file->getStatus()){
            return true;
        } else {
            $message = $file->getStatus();
            throw new Exception("the status is $message");
        }
    }

}