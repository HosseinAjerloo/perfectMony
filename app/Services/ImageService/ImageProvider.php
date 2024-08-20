<?php

namespace App\Services\ImageService;

class ImageProvider
{
    protected $rootFolder;
    protected $fileFolder;
    protected $fileName;
    protected $fileType;
    protected $objFile;
    protected $fileSize;
    protected $addressFile;

    /**
     * @return mixed
     */
    protected function getAddressFile()
    {
        return $this->addressFile;
    }

    /**
     * @param mixed $address
     */
    protected function setAddressFile($addressFile): void
    {
        $this->addressFile = $addressFile;
    }

    /**
     * @return mixed
     */
    public function getRootFolder()
    {
        return $this->rootFolder;
    }

    /**
     * @param mixed $rootFolder
     */
    public function setRootFolder($rootFolder): void
    {
        $rootFolder = str_replace("\\/", DIRECTORY_SEPARATOR, $rootFolder);
        $this->rootFolder = trim($rootFolder, "\\/");
    }

    /**
     * @return mixed
     */
    public function getFileFolder()
    {
        return $this->fileFolder;
    }

    /**
     * @param mixed $fileFolder
     */
    public function setFileFolder($fileFolder): void
    {
        $fileFolder = str_replace("\\/", DIRECTORY_SEPARATOR, $fileFolder);
        $this->fileFolder = trim($fileFolder, "\\/");
    }

    /**
     * @return mixed
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * @param mixed $fileName
     */
    public function setFileName($fileName): void
    {
        $this->fileName = $fileName;
    }

    /**
     * @return mixed
     */
    public function getFileType()
    {
        return $this->fileType;
    }

    /**
     * @param mixed $fileType
     */
    public function setFileType($fileType): void
    {
        $this->fileType = $fileType;
    }

    /**
     * @return mixed
     */
    public function getObjFile()
    {
        return $this->objFile;
    }

    /**
     * @param mixed $objFile
     */
    protected function setObjFile($objFile): void
    {
        $this->objFile = $objFile;
    }

    /**
     * @return mixed
     */
    public function getFileSize()
    {
        return $this->fileSize;
    }

    /**
     * @param mixed $fileSize
     */
    public function setFileSize($fileSize): void
    {
        $this->fileSize = $fileSize;
    }

    /**
     * @return mixed
     */
    public function getFinalFileAddres()
    {
        return $this->getAddressFile().DIRECTORY_SEPARATOR.$this->getFinalImageName();
    }

    /**
     * @param mixed $finalFileAddress
     */


    public function getFinalImageName()
    {
        return $this->getFileName() . '.' . $this->getFileType();
    }

    protected function generate()
    {
        if (!file_exists($this->getAddressFile()))
        {
            mkdir($this->getAddressFile(),0755,true);
        }
    }

    protected function provider()
    {
        $rootFolder=$this->getRootFolder()??date('Y').DIRECTORY_SEPARATOR.date('m').DIRECTORY_SEPARATOR.date('d');
        $fileFolder=$this->getFileFolder()??date('Y').DIRECTORY_SEPARATOR.date('m').DIRECTORY_SEPARATOR.date('d');
        $this->setAddressFile($rootFolder.DIRECTORY_SEPARATOR.$fileFolder);
        $fileName=$this->getFileName()??time();
        $fileType=$this->getFileType()??$this->getObjFile()->getClientOriginalExtension();
        $this->setFileSize($this->getObjFile()->getSize());
        $this->setFileType($fileType);
        $this->setFileName($fileName);
        $this->generate();
    }


}
