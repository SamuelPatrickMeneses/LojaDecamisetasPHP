<?php

namespace App\Validators;

use App\Entity\Grid;
use App\Entity\Image;
use Core\Validation\Validator;

class AdminProductVariantValidator extends Validator
{
    public function __construct($params)
    {
        parent::__construct($params,[
            ':variantId' => [
                'type' => 'int',
                'mim' => 1
            ],
            'productId' => [
                'type' => 'int',
                'mim' => 1
            ],
            'quantity' => [
                'type' => 'int',
                'min'  => 0,
            ],
            'size' => [
                'set' => Grid::ACEPTED_SIZES
            ],
            'gender' => [
                'set' => Grid::ACEPTED_GENDERS
            ],
            'color' => [
                'set' => $_SESSION['colorList']
            ],
            'price' => [
                'type' => 'float',
                'min' => 0,
                'max' => 10000
            ]
        ]);
    }
    public function hasImage($callback = 'nop')
    {
        if (isset($_FILES['image'])) {
            if (!preg_match('/^.*\.(jpeg|jpg|png)$/', $_FILES['image']['name'])) {
                return false;
            }
            if (strlen($_FILES['image']['name']) > 250) {
                return false;
            }
            if (intval($_FILES['image']['size']) > Image::MAX_ACEPTED_SIZE) {
                $callback(['message' => 'invalid image type']);
                return false;
            }
            return true;
        }
        return false;
    }
    public function isValidId()
    {
        return $this->validateFields([':variantId']);
    }
    public function isValidProductId()
    {
        return $this->validateFields(['productId']);
    }
    public function isValidGrid()
    {
        return $this->validateFields([
            'size',
            'color',
            'gender'
        ]);
    }
    public function isValidCreateProductVariant()
    {
        return $this->validateFields([
            'size',
            'color',
            'gender',
            'quantity',
            'price',
            'productId'
        ]);
    }
    public function isValidEditProductVariant()
    {
        return $this->validateAll();
    }
}
