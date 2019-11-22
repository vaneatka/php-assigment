<?php


namespace App\Service\Factory;


use Symfony\Component\Serializer\SerializerInterface;

class XmlParser
{
    /**
     * @var SerializerInterface
     */
    private $serializer;


    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    public function decode($contents){
        try {
            $result = ['results' => $this->serializer->decode($contents, 'xml'),
                "status" => 'processed'];
        } catch (\Exception $error){
            $result = ['results' => [[$error->getMessage()]],
                "status" => "error"];
        }
        return $result;
    }

}