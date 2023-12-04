<?php

namespace App\Services;

use App\DAOs\GridDAO;
use App\DAOs\ImageDAO;
use App\DAOs\ProductVariantDAO;
use App\Entity\ProductVariant;

class ProductVariantService
{
    private GridDAO $gridDAO;
    private ImageDAO $imageDAO;
    private ProductVariantDAO $productVariantDAO;
    public function __construct()
    {
        $this->gridDAO = new GridDAO();
        $this->productVariantDAO = new ProductVariantDAO();
        $this->imageDAO = new ImageDAO();
    }
    public function createProductVariant($productId, $quantity, $price, $size, $color, $gender)
    {
        $grid = $this->gridDAO->find($size, $color, $gender)[0];
        $productVariant = new ProductVariant();
        $productVariant->setProduct($productId)
        ->setStockQantity($quantity)
        ->setPrice($price)
        ->setGrid($grid->getId());
        return $this->productVariantDAO->insertProductVariant($productVariant);
    }
    public function getByIdWithImages($id)
    {
        $productVariant =  $this->productVariantDAO->findById($id);
        if ($productVariant !== null) {
            $this->gridDAO->populateProductVariant($productVariant);
            $this->imageDAO->populateProductVariat($productVariant);
        }
        return $productVariant;
    }
    public function getColorList()
    {
        return $this->gridDAO->getColorList();
    }
    public function updateProductVariant($id, $quantity, $price, $size, $color, $gender)
    {
        $grid = $this->gridDAO->find($size, $color, $gender)[0];
        return $this->productVariantDAO->updateVariant($id, [
            'grid' => $grid->getId(),
            'StockQuantity' => $quantity,
            'price' => $price
        ]);
    }
}
