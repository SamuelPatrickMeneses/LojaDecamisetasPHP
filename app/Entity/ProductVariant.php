<?php

namespace App\Entity;

use Core\DAOs\Entity;
use Core\DAOs\ObjectRelacionalModel;

class ProductVariant
{
    private $id;
    private $product;
    private $price;
    private $grid;
    private $images;
    private $stockQantity;
    private $status = 1;

    use Entity;
    public static function getORM(): ObjectRelacionalModel
    {
        if (!isset(self::$orm)) {
            self::$orm =  new ObjectRelacionalModel(self::class, 'product_variants');
            self::$orm->
                add('id','variant_id', ['increment' => true])->
                add('product', 'product_id')->
                add('grid', 'grid_id')->
                add('price', 'variant_price')->
                add('stockQuantity', 'stock_quantity')->
                add('status', 'variant_status')->
                setPrimaryKey('variant_id');
        } 
        return self::$orm;
    }
    public function __construct(array $registry = [])
    {
        $this->construct($this, $registry);
        $this->images = null;
        $this->setGrid($registry['grid_label'] ?? $registry['grid_id'] ?? '');
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
