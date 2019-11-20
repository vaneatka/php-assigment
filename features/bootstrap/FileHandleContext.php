<?php


use App\Service\FileHandler;
use App\Service\Parser;
use Behat\Behat\Context\Context;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\HttpFoundation\File\File;

class FileHandleContext implements Context
{
    /**
     * @var KernelInterface
     */
    private $kernel;

    private $fileToBeParsed;
    /**
     * @var \App\Entity\File
     */
    private $savedFile;


    public function __construct(KernelInterface $kernel )
    {
        $this->kernel = $kernel;

    }

    /**
     * @Given We gave a valid :arg1 to be processed
     */
    public function weGaveAValidToBeProcessed($arg1)
    {
        $file = new File("/app/features/data/$arg1");
        $resultArray = $this->kernel->getContainer()->get(Parser::class)->parsedData($file);
        if (!empty($resultArray['data'])){
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
        $result =  $handler->handle($this->fileToBeParsed);
        if ($result->getId() !== null){
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
        if ($arg1 == $this->savedFile->getStatus()){
            return true;
        } else {
            $message = $this->savedFile->getStatus();
            throw new Exception("the status is $message");
        }
    }

}