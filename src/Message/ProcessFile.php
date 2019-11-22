<?php


namespace App\Message;


use Ramsey\Uuid\UuidInterface;

class ProcessFile
{
    private $fileData;
    private $file;

    public function __construct(array $fileData, string $file)
    {
        $this->fileData = $fileData;
        $this->file = $file;
    }

    public function getFileData()
    {
        return $this->fileData;
    }
    /**
     * @return string
     */
    public function getFile(): string
    {
        return $this->file;
    }
}