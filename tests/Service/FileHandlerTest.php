<?php

namespace App\Tests\Service;

use App\Service\FileHandler;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class FileHandlerTest extends KernelTestCase
{
   private $kernel;

    public function __construct(KernelInterface $kernel)
    {
         $this->kernel = $kernel;
         parent::__construct();
    }


    public function willDispatchOnNewFile()
    {
        $file = new File(__DIR__.'/../../features/data/file.xml');
        $result = $this->kernel->getContainer()->get(FileHandler::class)->handle($file);
        $this->assertInstanceOf(\App\Entity\File::class, $result);
    }
}
