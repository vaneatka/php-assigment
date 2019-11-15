<?php


namespace App\Message;


use App\Entity\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ProcessFile
{
    protected $fileData;
    private $file;

    public function __construct(UploadedFile $fileData, File $file)
    {
        $this->fileData = $fileData;
        $this->file = $file;
    }

    public function getFileData()
    {
        return $this->fileData;
    }
    /**
     * @return File
     */
    public function getFile(): File
    {
        return $this->file;
    }
}