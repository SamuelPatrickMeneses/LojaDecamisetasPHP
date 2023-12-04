<?php

namespace App\Entity;

class Image
{
    private $id;
    private $name;
    private $file;
    private $productVariant;
    private $product;
    public const MAX_ACEPTED_SIZE = (2 * 1048576);// 2MB

    public function __construct($registry = [])
    {
        if (count($registry) > 0) {
            $this->setId($registry['image_id']);
            $this->setName($registry['image_name']);
            $this->setFile($registry['image_file']);
            $this->setProduct($registry['product_id']);
            $this->setProductVariant($registry['variant_id']);
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
    public function getName()
    {
        return $this->name;
    }
    public function setName($name): self
    {
        $this->name = $name;

        return $this;
    }
    public function getFile()
    {
        return $this->file;
    }
    public function setFile($file): self
    {
        $this->file = $file;

        return $this;
    }
    public function getProductVariant()
    {
        return $this->productVariant;
    }
    public function setProductVariant($productVariant): self
    {
        $this->productVariant = $productVariant;

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
}
