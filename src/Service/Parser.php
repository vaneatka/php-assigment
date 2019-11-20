<?php

namespace App\Service;

use Exception;
use Symfony\Component\HttpFoundation\File\File as FileInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Serializer\SerializerInterface;


class Parser
{

    private $serializer;

    /**
     * Parser constructor.
     * @param SerializerInterface $serializer
     */
    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }


    private function parse(FileInterface $file)
    {
        $fileUrl = $file->getPathname();
        $extension = $file instanceof UploadedFile ? $file->getClientOriginalExtension() : $file->getExtension() ;
        $file_content = file_get_contents($fileUrl);

        if (empty($file_content)){
            $result =  ['results' => [['File Empty']],
                "status" => "error"];
        }

        if ($extension == 'json'){
            $result = $this->parseJson($file_content);
        }

        if ($extension == 'xml'){
            $result = $this->parseXml($file_content);
        }

        if ($extension == 'csv'){
            $result = $this->parseCsv($file_content);
        }

        return $result;
    }

    private function parseJson($content):array {
        try{
        $result =  ['results' => $this->serializer->decode($content, 'json'),
                    "status" => 'processed'];
        }catch (Exception $error){
          $result =  ['results' => [[$error->getMessage()]],
                    "status" => "error"];
        }
        return $result;
    }

    private function parseXml($content):array {
        try{
            $result =  ['results' => $this->serializer->decode($content, 'xml'),
                "status" => 'processed'];
        }catch (Exception $error){
            $result =  ['results' => [[$error->getMessage()]],
                "status" => "error"];
        }
        return $result ;
    }

    private function parseCsv($content):array {
        try {
            $result = ['results' => $this->serializer->decode($content, 'csv'),
                "status" => 'processed'];
        } catch (Exception $error){
            $result = ['results' => [[$error->getMessage()]],
                "status" => "error"];
        }
        return $result;
    }


    public function parsedData(FileInterface $file)
    {
        return [
            'pathName' => $file->getPathname(),
            'extension' =>  $file instanceof UploadedFile ? $file->getClientOriginalExtension() : $file->getExtension(),
            'fileName' => $file instanceof UploadedFile ? $file->getClientOriginalName() : $file->getFilename(),
            'data' => $this->parse($file),
            'rawContent' => file_get_contents($file->getPathname())
        ];
    }


}
