<?php

namespace App\Entity;

use Core\DAOs\Entity;
use Core\DAOs\ObjectRelacionalModel;

class Image
{
    private $id;
    private $name;
    private $file;
    private $productVariant;
    private $product;
    public const MAX_ACEPTED_SIZE = (2 * 1048576);// 2MB

    use Entity;
    public static function getORM(): ObjectRelacionalModel
    {
        if (!isset(self::$orm)) {
            self::$orm =  new ObjectRelacionalModel(self::class, 'images');
            self::$orm->
                add('id','image_id', ['increment' => true])->
                add('name', 'image_name')->
                add('file', 'image_file')->
                add('product', 'product_id')->
                add('productVariant', 'variant_id')->
                setPrimaryKey('image_id');
        }
        return self::$orm;
    }
    public function __construct($registry = [])
    {
        $this->construct($this, $registry);
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
