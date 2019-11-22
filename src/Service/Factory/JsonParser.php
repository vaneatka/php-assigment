<?php


namespace App\Service\Factory;




class JsonParser
{

    public function decode($contents){
        try {
            $result = ['results' => serializer->decode($contents, 'json'),
                "status" => 'processed'];
        } catch (\Exception $error){
            $result = ['results' => [[$error->getMessage()]],
                "status" => "error"];
        }
        return $result;
    }
}