<?php

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
    private $extensions = ['csv', 'json', 'xml'];
    private $fileUrl = __DIR__ . '/../data/';
    private $result;

    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }


    /**
     * @Given /^a "([^"]*)" to be parsed$/
     */
    public function aToBeParsed($arg1)
    {
        $path=$this->fileUrl.$arg1;
        if (!$path){
            throw new Exception('the path_name is not given '. $path);
        }
        return false;
    }

    /**
     * @When /^the "([^"]*)" is parsed$/
     */
    public function theIsParsed($arg1)
    {
        $parser = $this->kernel->getContainer()->get(\App\Service\Parser::class);
        $this->result =  $parser->parse($this->fileUrl.$arg1);
        return true;
    }


    /**
     * @Then the result was an array
     */
    public function theResultWasAnArray()
    {
        if(!is_array($this->result)){
            throw new Exception('The result is not an array');
        }
        return true;
    }



}
