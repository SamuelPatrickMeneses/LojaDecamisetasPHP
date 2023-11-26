<?php

namespace App\Entity;

class ProductVariant
{
    private $id;
    private $product;
    private $price;
    private $grid;
    private $images;
    private $stockQantity;
    private $status;

    public function __construct(array $registry = [])
    {
        if (count($registry) > 0) {
            $this->setId($registry['variant_id']);
            $this->setProduct($registry['product_id']);
            $this->setPrice($registry['price']);
            $this->setGrid($registry['grid_label'] ?? $registry['grid_id']);
            $this->setStockQantity($registry['stock_quantity']);
            $this->setStatus($registry['variant_status']);
            $this->images = null;
        }
    }
    

    public function getId()
    {
        return $this->id;
    }
    public function setId($id): self
    {
        $this->id = $id;

        return $this;
    }
    public function getProduct()
    {
        return $this->product;
    }
    public function setProduct($product): self
    {
        $this->product = $product;

        return $this;
    }
    public function getPrice()
    {
        return $this->price;
    }
    public function setPrice($price): self
    {
        $this->price = $price;

        return $this;
    }
    public function getGrid()
    {
        return $this->grid;
    }
    public function setGrid($grid): self
    {
        $this->grid = $grid;

        return $this;
    }
    public function getImages()
    {
        return $this->images;
    }
    public function setImages($images): self
    {
        $this->images = $images;

        return $this;
    }
    public function getStockQantity()
    {
        return $this->stockQantity;
    }
    public function setStockQantity($stockQantity): self
    {
        $this->stockQantity = $stockQantity;

        return $this;
    }
    public function getStatus()
    {
        return $this->status;
    }
    public function setStatus($status): self
    {
        $this->status = $status;

        return $this;
    }
}
