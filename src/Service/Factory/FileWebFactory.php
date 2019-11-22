<?php


namespace App\Service\Factory;


use Symfony\Component\HttpFoundation\File\File;

class FileWebFactory extends AbstractFactory
{
    public function decode(File $file)
    {
        $result = [
            'pathName' => $file->getPathname(),
            'extension' =>  $file->getClientOriginalExtension(),
            'fileName' =>$file->getClientOriginalName(),
            'data' => [],
            'rawContent' => file_get_contents($file->getPathname())
        ];

        if (empty($file)){
            $result['data'] = [
                'result'=> [['File is empty']],
                'status' => 'error'
            ];
            return $result;
        }

        if ($result['extension'] == 'json') {
            $result['data'] = (new JsonParser())->decode($file);
        }

        if ($result['extension'] == 'xml') {
            $result['data'] = (new XmlParser())->decode($file);
        }

        if ($result['extension'] == 'csv') {
            $result['data'] = (new CsvParser())->decode($file);
        }


        return $result;
    }
}