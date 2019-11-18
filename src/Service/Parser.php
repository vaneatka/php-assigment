<?php

namespace App\Service;

use Exception;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\CsvEncoder;


class Parser
{

    private $serializer;

    public function __construct()
    {

        $encoder = [new CsvEncoder(), new XmlEncoder(), new JsonEncoder()];
        $this->serializer = new Serializer([], $encoder);

    }


    private function parse(UploadedFile $file)
    {
        $fileUrl = $this->getPathname($file);
        $extension = $this->getExtension($file);
        $file_content = file_get_contents($fileUrl);

        if (empty($file_content)){
            return  ['results' => [['File Empty']],
                "status" => "error"];
        }

        if ($extension == 'json'){
            return $this->parseJson($file_content);
        }

        if ($extension == 'xml'){
            return $this->parseXml($file_content);
        }

        if ($extension == 'csv'){
            return $this->parseCsv($file_content);
        }

    }

    private function parseJson($content):array {
        try{
        return  ['results' => $this->serializer->decode($content, 'json'),
                    "status" => 'processed'];
        }catch (Exception $error){
          return  ['results' => [[$error->getMessage()]],
                    "status" => "error"];
        }
    }

    private function parseXml($content):array {
        try{
            return  ['results' => $this->serializer->decode($content, 'xml'),
                "status" => 'processed'];
        }catch (Exception $error){
            return  ['results' => [[$error->getMessage()]],
                "status" => "error"];
        }
    }

    private function parseCsv($content):array {
        try{
            return  ['results' => $this->serializer->decode($content, 'csv'),
                "status" => 'processed'];
        }catch (Exception $error){
            return  ['results' => [[$error->getMessage()]],
                "status" => "error"];
        }
    }



    private function getPathname(UploadedFile $file):string
    {
        return $fileUrl = $file->getPathname();
    }

    private function getExtension(UploadedFile $file):string {
        return $file->getClientOriginalExtension();
    }

    private function getFileName(UploadedFile $file):string {
        return $file->getClientOriginalName();
    }

    public function parsedData(UploadedFile $file)
    {
        return [
            'pathName' => $this->getPathname($file),
            'extension' => $this->getExtension($file),
            'fileName' => $this->getFileName($file),
            'data' => $this->parse($file)
        ];
    }


}
