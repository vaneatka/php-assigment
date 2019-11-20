<?php

use App\Service\Parser;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Behat\Behat\Context\Context;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * This context class contains the definitions of the steps used by the demo
 * feature file. Learn how to get started with Behat and BDD on Behat's website.
 *
 * @see http://behat.org/en/latest/quick_start.html
 */
class FileParseContext implements Context
{
    /**
     * @var KernelInterface
     */
    private $kernel;

    private $fileType;
    private $uploadedFileType;
    private $arrayFromFileType;
    private $arrayFromUpdatedFileType;

    public function __construct(KernelInterface $kernel)
    {

        $this->kernel = $kernel;
    }

    /**
     * @Given We recieve :arg1 from command line
     */
    public function weRecieveFromCommandLine($arg1)
    {
        $file = new File("/app/features/data/$arg1");
        $this->fileType = $file;
        if ($file instanceof File){
        return true;
        }else{
            throw new Exception('no');
        }


    }

    /**
     * @Given We recieve :arg1 from Web
     */
    public function weRecieveFromWeb($arg1)
    {
        $file = new Symfony\Component\HttpFoundation\File\UploadedFile("/app/features/data/$arg1", $arg1);
        $this->uploadedFileType = $file;
        if ($file instanceof File){
            return true;
        }else {
            throw new Exception('no');
        }
    }

    /**
     * @When I run parse, the result is an array
     */
    public function iRunParseTheResultIsAnArray()
    {
        $parser = $this->kernel->getContainer()->get(Parser::class);
        $resultOfFileType = $parser->parsedData($this->fileType);
        $this->arrayFromFileType = $resultOfFileType;
        $resultOfUpdatedFileType = $parser->parsedData($this->uploadedFileType);
        $this->arrayFromUpdatedFileType = $resultOfUpdatedFileType;
        if (is_array($resultOfFileType) && is_array($resultOfUpdatedFileType)){
            return true;
        } else {
            throw new Exception('wrong result type');
        }
    }

    /**
     * @Then The resulted array contain parsed data
     */
    public function theResultedArrayContainParsedData()
    {
        if ($this->arrayFromFileType['data'] == $this->arrayFromFileType['data'] && !empty($this->arrayFromFileType['data']) )
        {
        return true;
        }
        throw new Exception('aaaaaaaaaaaa');
    }

}
