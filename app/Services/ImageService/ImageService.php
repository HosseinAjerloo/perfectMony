<?php

namespace App\Services\ImageService;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ImageService extends ImageProvider
{
    public function saveImage($image)
    {

        $this->setObjFile($image);
        $this->provider();
        $result=$this->getObjFile()->move($this->getAddressFile(),$this->getFinalImageName());
        if ($result)
        {
            return $this->getFinalFileAddres();
        }
        return false;
    }
}
