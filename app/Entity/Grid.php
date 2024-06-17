<?php

namespace App\Entity;

use Core\DAOs\Entity;
use Core\DAOs\ObjectRelacionalModel;

class Grid
{
    private $id;
    private $size;
    private $color;
    private $gender;
    private $label;
    private $productVariants;
    public const ACEPTED_SIZES = ['PPP', 'PP', 'P', 'M', 'G', '2G', '3G', '4G'];
    public const ACEPTED_GENDERS = ['M', 'F'];

    use Entity;
    public static function getORM(): ObjectRelacionalModel
    {
        if (!isset(self::$orm)) {
            self::$orm =  new ObjectRelacionalModel(self::class, 'grids');
            self::$orm->
                add('id','grid_id', ['increment' => true])->
                add('color', 'grid_color')->
                add('size', 'grid_size')->
                add('gender', 'grid_gender')->
                add('label', 'grid_label')->
                setPrimaryKey('grid_id');
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
        return isset($this->label)
            ? $this->label
            : "$this->size/$this->color/$this->gender";
    }
    public function setLabel($label)
    {
        $this->label = $label;
    }
}
