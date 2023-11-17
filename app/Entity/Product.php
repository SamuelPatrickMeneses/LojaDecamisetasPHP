<?php

namespace App\Entity;

class Product
{
    private $id;
    private $title;
    private $description;
    private $price;
    private $variants;
    private $images;

    public function __construct(array $registry = [])
    {
        if (count($registry) > 0) {
            $this->setId($registry['product_id']);
            $this->setTitle($registry['product_title']);
            $this->setDescription($registry['product_description']);
            $this->setPrice($registry['product_price']);
            $this->variants = null;
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
    public function getTitle()
    {
        return $this->title;
    }
    public function setTitle($title): self
    {
        $this->title = $title;

        return $this;
    }
    public function getDescription()
    {
        return $this->description;
    }
    public function setDescription($description): self
    {
        $this->description = $description;

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
    public function getVariants()
    {
        return $this->variants;
    }
    public function setVariants($variants): self
    {
        $this->variants = $variants;

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
}
