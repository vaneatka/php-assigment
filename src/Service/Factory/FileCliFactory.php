<?php


namespace App\Service\Factory;


use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\SerializerInterface;

class FileCliFactory extends AbstractFactory
{

    public function decode(File $file)
    {
        $extension = $file->getExtension();

    }

    public function getFileInfo(File $file){
        return [
            'pathName' => $file->getPathname(),
            'extension' =>  $file->getExtension(),
            'fileName' => $file->getFilename()
        ];
    }
}