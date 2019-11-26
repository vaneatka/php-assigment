<?php


namespace App\Service\Factory;


use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\SerializerInterface;

class CsvParser implements ParserInterface
{
    /**
     * @var SerializerInterface
     */
    private $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    public function decode(File $contents): array{

        try {
            $result = ['results' => $this->serializer->decode(file_get_contents($contents), 'csv'),
                "status" => 'processed'];
        } catch (\Exception $error){
            $result = ['results' => [[$error->getMessage()]],
                "status" => "error"];
        }
        return $result;
    }

    public function support(string $extension): bool
    {
        return $extension === 'csv';
    }
}