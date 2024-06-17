<?php

namespace App\Entity;

use Core\DAOs\Entity;
use Core\DAOs\ObjectRelacionalModel;

class CartItem
{
    private $id;
    private $user;
    private $product;
    private $variant;
    private $itemQuantity;
    private $itemPrice;
    private $image;

    use Entity;
    public static function getORM(): ObjectRelacionalModel
    {
        if (!isset(self::$orm)) {
            self::$orm =  new ObjectRelacionalModel(self::class, 'cart_items');
            self::$orm->
                add('id','item_id', ['increment' => true])->
                add('product', 'product_id')->
                add('varinat', 'varinat_id')->
                add('user', 'user_id')->
                add('itemPrice', 'cart_item_price')->
                add('itemQuantity', 'cart_item_quantity')->
                setPrimaryKey('item_id');
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
    public function getUser()
    {
        return $this->user;
    }
    public function setUser($user): self
    {
        $this->user = $user;

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
    public function getVariant()
    {
        return $this->variant;
    }
    public function setVariant($variant): self
    {
        $this->variant = $variant;

        return $this;
    }
    public function getItemQuantity()
    {
        return $this->itemQuantity;
    }
    public function setItemQuantity($itemQuantity): self
    {
        $this->itemQuantity = $itemQuantity;

        return $this;
    }
    public function getItemPrice()
    {
        return $this->itemPrice;
    }
    public function setItemPrice($itemPrice): self
    {
        $this->itemPrice = $itemPrice;

        return $this;
    }
    public function getImage()
    {
        return $this->image;
    }
    public function setImage($image): self
    {
        $this->image = $image;

        return $this;
    }
}
