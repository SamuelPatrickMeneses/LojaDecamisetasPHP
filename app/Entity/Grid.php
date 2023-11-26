<?php

namespace App\Entity;

class Grid
{
    private $id;
    private $size;
    private $color;
    private $gender;
    private $productVariants;
    public const ACEPTED_SIZES = ['PPP', 'PP', 'P', 'M', 'G', '2G', '3G', '4G'];
    public const ACEPTED_GENDERS = ['M', 'F'];

    public function __construct(array $registry = [])
    {
        if (count($registry) > 0) {
            $this->setId($registry['grid_id']);
            $this->setColor($registry['grid_color']);
            $this->setSize($registry['grid_size']);
            $this->setGender($registry['grid_gender']);
            $this->productVariants = null;
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
    public function getSize()
    {
        return $this->size;
    }
    public function setSize($size): self
    {
        $this->size = $size;

        return $this;
    }
    public function getColor()
    {
        return $this->color;
    }
    public function setColor($color): self
    {
        $this->color = $color;

        return $this;
    }
    public function getGender()
    {
        return $this->gender;
    }
    public function setGender($gender): self
    {
        $this->gender = $gender;

        return $this;
    }
    public function getProductVariants()
    {
        return $this->productVariants;
    }
    public function setProductVariants($productVariants): self
    {
        $this->productVariants = $productVariants;

        return $this;
    }
    public function getLabel()
    {
        return "$this->size/$this->color/$this->gender";
    }
}
