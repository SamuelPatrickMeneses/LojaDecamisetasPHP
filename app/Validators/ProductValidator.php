<?php

namespace App\Validators;

use Core\Validation\Validator;

class ProductValidator extends Validator
{
    public function __construct(&$params)
    {
        parent::__construct($params,[
            ':id' => [
                'type' => 'int',
                'mim' => 1
            ],
            'ps' => [
                'type' => 'int',
                'min'  => 1,
                'max'  => 50
            ],
            'pn' => [
                'type' => 'int',
                'min' => 1
            ],
            'search' => [
                'checkAll' => [
                    function($val)
                    {
                        return filter_var($val, FILTER_SANITIZE_SPECIAL_CHARS) === $val;
                    }
                ]
            ]
        ]);
    }
    public function isValidId()
    {
        return $this->validateFields(['id']);
    }
    public function isValidPagination()
    {
        return $this->validateFields(['ps', 'pn']);
    }
    public function isValidSearch()
    {
        return $this->validateFields(['search']);
    }
}
