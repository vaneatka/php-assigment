<?php


namespace App\Service\Factory;


use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Serializer\SerializerInterface;

class ParseFactory extends AbstractFactory
{
    public function __construct(SerializerInterface $serializer)
    {
        parent::__construct($serializer);
    }

    public function parsedData(File $file)
    {
        $parser = $file instanceof UploadedFile ? new FileWebFactory($this->serializer) : new FileCliFactory($this->serializer);

    return $parser->decode($file);
    }

}