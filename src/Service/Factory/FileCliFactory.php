<?php


namespace App\Service\Factory;


use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\SerializerInterface;

class FileCliFactory extends ParseFactory
{
    public function __construct(SerializerInterface $serializer)
    {
        parent::__construct($serializer);
    }


    public function decode(File $file)
    {
        $result = [
            'pathName' => $file->getPathname(),
            'extension' =>  $file->getExtension(),
            'fileName' => $file->getFilename(),
            'data' => [],
            'rawContent' => file_get_contents($file->getPathname())
        ];

        if (empty(file_get_contents($file))){
            $result['data'] = [
                'result'=> [['File is empty']],
                'status' => 'error'
            ];
            return $result;
        }

        if ($result['extension'] == 'json') {
            $result['data'] = (new JsonParser($this->serializer))->decode($file);
        }

        if ($result['extension'] == 'xml') {
            $result['data'] = (new XmlParser($this->serializer))->decode($file);
        }

        if ($result['extension'] == 'csv') {
            $result['data'] = (new CsvParser($this->serializer))->decode($file);
        }

        return $result;
    }
}