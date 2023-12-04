<?php

namespace App\Services;

use App\DAOs\ImageDAO;
use Exception;

class ImageService
{
    private ImageDAO $dao;

    public function __construct()
    {
        $this->dao = new ImageDAO();
    }
    public function createImage($name, $tempName, $productId, $variantId)
    {
        $tockens = explode('.', $name);
        $storName = md5(uniqid()) . md5(uniqid()) . '.' . array_pop($tockens);
        try {
            move_uploaded_file($tempName, '/var/www/public/uploads/' . $storName);
            return $this->dao->newImage($name, '/uploads/' . $storName, $variantId, $productId);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
        return false;
    }
    public function deleteById($imageId)
    {
        $image = $this->dao->findById($imageId);
        if ($image !== null) {
            $this->dao->deleteById($imageId);
            unlink('/var/www/public' . $image->getFile());
            return true;
        }
        return false;
    }
}
