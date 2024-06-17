<?php

namespace App\Entity;

use Core\DAOs\Entity;
use Core\DAOs\ObjectRelacionalModel;

class Product
{
    private $id;
    private $title;
    private $description;
    private $price;
    private $variants;
    private $images;
    private $status = 1;

    use Entity;
    public static function getORM(): ObjectRelacionalModel
    {
        if (!isset(self::$orm)) {
            self::$orm =  new ObjectRelacionalModel(self::class, 'products');
            self::$orm->
                add('id','product_id', ['increment' => true])->
                add('title', 'product_title')->
                add('description', 'product_description')->
                add('price', 'product_price')->
                add('status', 'product_status')->
                setPrimaryKey('product_id');
        } 
        return self::$orm;
    }
    public function __construct($registry = [])
    {
        $this->construct($this, $registry);
        if (isset($registry['image_file'])) {
            $this->images = [$registry['image_file']];
        } else {
            $this->images = null;
        }
        $this->variants = null;
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
