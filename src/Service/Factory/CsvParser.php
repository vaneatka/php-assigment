<?php


namespace App\Service\Factory;


use Symfony\Component\Serializer\SerializerInterface;

class CsvParser extends AbstractFactory
{


    public function decode($contents){
        try {
            $result = ['results' => parent::$serializer->decode($contents, 'csv'),
                "status" => 'processed'];
        } catch (\Exception $error){
            $result = ['results' => [[$error->getMessage()]],
                "status" => "error"];
        }
        return $result;
    }

}