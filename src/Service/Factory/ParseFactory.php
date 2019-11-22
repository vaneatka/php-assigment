<?php


namespace App\Service\Factory;


use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ParseFactory extends AbstractFactory
{
        public function decode(File $file)
    {
        $parser = $file instanceof UploadedFile ? new FileWebFactory() : new FileCliFactory();
    return $parser->decode($file);
    }

}