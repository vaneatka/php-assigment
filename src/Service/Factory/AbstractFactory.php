<?php


namespace App\Service\Factory;


use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\SerializerInterface;

abstract class AbstractFactory
{
    /**
     * @var SerializerInterface
     */
    public $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    abstract public function parsedData(File $file);
}