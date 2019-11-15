<?php


namespace App\Message;


use Symfony\Component\HttpFoundation\File\UploadedFile;

class ProcessFile
{
    protected $fileData;
    private $file;

    public function __construct(UploadedFile $fileData,int $file)
    {
        $this->fileData = $fileData;
        $this->file = $file;
    }

    public function getFileData()
    {
        return $this->fileData;
    }
    /**
     * @return integer
     */
    public function getFile(): int
    {
        return $this->file;
    }
}