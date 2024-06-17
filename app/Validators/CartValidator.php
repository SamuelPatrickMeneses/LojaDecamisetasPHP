<?php

namespace App\Validators;

use Core\Validation\Validator;

class CartValidator extends Validator
{
    public function __construct($params)
    {
        parent::__construct($params,[
            'variantId' => [
                'type' => 'int',
                'min' => 1
            ],
            'quantity' => [
                'type' => 'int',
                'min' => 1
            ]
        ]);
    }
    public function isValidCreateItem($callback = null)
    {
        return $this->validateAll($callback);
    }
}
