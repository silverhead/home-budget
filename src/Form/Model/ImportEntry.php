<?php

namespace App\Form\Model;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImportEntry
{
    /**
     * @var UploadedFile
     */
    private $file;

    /**
     * @return UploadedFile
     */
    public function getFile(): ?UploadedFile
    {
        return $this->file;
    }

    /**
     * @param UploadedFile $file
     * @return ImportEntry
     */
    public function setFile(UploadedFile $file): ImportEntry
    {
        $this->file = $file;

        return $this;
    }
}
