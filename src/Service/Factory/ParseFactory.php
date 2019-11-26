<?php


namespace App\Service\Factory;


use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ParseFactory
{
    protected $parsers = [];

    public function parsedData(File $file): array
    {
        $result = $file instanceof UploadedFile ?
            [
                'pathName' => $file->getPathname(),
                'extension' =>  $file->getClientOriginalExtension(),
                'fileName' =>$file->getClientOriginalName(),
                'data' => [],
                'rawContent' => file_get_contents($file->getPathname())
            ] :
            [
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

        /** @var ParserInterface $parser */
        foreach ($this->parsers as $parser) {
            if ($parser->support($result['extension'])) {
                $result['data'] = $parser->decode($file);
            }
        }

        return $result;
    }

    /**
     * @param ParserInterface $parser
     * @return void
     */
    public function addParser(ParserInterface $parser): void
    {
        $this->parsers[] = $parser;
    }
}