<?php

namespace App\Services;

use App\DAOs\ImageDAO;
use App\DAOs\ProductDAO;
use App\DAOs\ProductVariantDAO;
use App\Entity\Product;

class ProductService
{   
    private ProductDAO $productDAO;
    private ProductVariantDAO $productVariantDAO;
    private ImageDAO $imageDAO;
    public function __construct()
    {
        $this->productDAO = new ProductDAO();
        $this->productVariantDAO = new ProductVariantDAO();
        $this->imageDAO = new ImageDAO();
    }
    public function newProduct($title, $description, $price)
    {
        $product = new Product();
        $product->setTitle($title);
        $product->setDescription($description);
        $product->setPrice($price);
        $product->setStatus(1);
        return $this->productDAO->insertProduct($product);
    }
    public function count()
    {
        return $this->productDAO->count();
    }
    public function editProduct($id, $title, $description, $price)
    {
        return $this->productDAO->updateProduct($id, [
            'title' => $title,
            'description' => $description,
            'price' => $price,
        ]);
    }
    public function getProducts($size = 10, $number = 1)
    {
        return $this->productDAO->findAll($size, $number);
    }
    public function getProductsWithOneImage($size = 10, $number = 1)
    {
        return $this->productDAO->findAllWithOneImage($size, $number);
    }
    public function getById($id)
    {
        $product =  $this->productDAO->findById($id);
        if (isset($product)) {
            $this->productVariantDAO->fetchProductVariants($product, 0);
        }
        return $product;
    }
    public function getByIdwithImages($id)
    {
        $product =  $this->productDAO->findById($id);
        if (isset($product)) {
            $this->productVariantDAO->fetchProductVariants($product, 0);
        }
        $this->imageDAO->fatchProductImages($product);
        return $product;
    }
}