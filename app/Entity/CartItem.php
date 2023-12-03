<?php

namespace App\Entity;

class CartItem
{
    private $id;
    private $user;
    private $product;
    private $variant;
    private $itemQuantity;
    private $itemPrice;
    private $image;
    public function __construct($registry = [])
    {
        if (count($registry) > 0) {
            $this->setId($registry['item_id']);
            $this->setProduct($registry['product_id']);
            $this->setVariant($registry['variant_id']);
            $this->setUser($registry['user_id']);
            $this->setItemPrice($registry['cart_item_price']);
            $this->setItemQuantity($registry['cart_item_quantity']);
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