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

    public function parse(UploadedFile $file)
    {
        $fileUrl = $this->getPathname($file);
        $extension = $this->getExtension($file);
//
        $encoder = [new CsvEncoder(), new XmlEncoder(), new JsonEncoder()];
        $serializer = new Serializer([], $encoder);
        $file_content = file_get_contents($fileUrl);

//        $extension = pathinfo($fileUrl, PATHINFO_EXTENSION);
        if (empty($file_content)){
            throw new Exception('The file is empty');
        }
        if ($extension == 'json'){
            $result = $serializer->decode($file_content, 'json');
//            $result = json_decode($file_content, true);
        } elseif ($extension == 'xml'){
            $result = $serializer->decode($file_content, 'xml');

//            $xml_result= simplexml_load_string($file_content);
//            $json_result = json_encode($xml_result);
//            $result = json_decode($json_result, true);
        } elseif ($extension == 'csv'){
            $result = $serializer->decode($file_content, 'csv');

//            $result= str_getcsv($file_content);
        } else {
            throw new Exception('File"s content is broken '. $fileUrl. $extension);
        }
        return $result;
    }

    public function getPathname(UploadedFile $file):string
    {
        return $fileUrl = $file->getPathname();
    }

    public function getExtension(UploadedFile $file):string {
        return $file->getClientOriginalExtension();
    }

    public function getFileName(UploadedFile $file):string {
        return $file->getClientOriginalName();
    }
}
