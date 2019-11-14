<?php

namespace App\Service;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\CsvEncoder;

class Parser
{

    public function parse($fileUrl)
    {
        $encoder = [new CsvEncoder(), new XmlEncoder(), new JsonEncoder()];
        $serializer = new Serializer([], $encoder);
        $file_content = file_get_contents($fileUrl);
        $extension = pathinfo($fileUrl, PATHINFO_EXTENSION);
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
            throw new Exception('File/"s content is broken');
        }
        return $result;
    }
    }
