<?php

namespace App\Validators;

use Core\Validation\Validator;

class AdminProductValidator extends Validator
{
    public function __construct($params)
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
            ],
            'title' => [
                'checkAll' => [
                    function($val)
                    {
                        return filter_var($val, FILTER_SANITIZE_SPECIAL_CHARS) === $val;
                    }
                ],
                'max' => 500,
                'min' => 3
            ],
            'description' => [
                'checkAll' => [
                    function($val)
                    {
                        return filter_var($val, FILTER_SANITIZE_SPECIAL_CHARS) === $val;
                    }
                ],
                'max' => 1000,
                'min' => 3
            ],
            'price' => [
                'type' => 'float',
                'min' => 0
            ]
        ]);
    }
    public function isValidId()
    {
        return $this->validateFields([':id']);
    }
    public function isValidPagination()
    {
        return $this->validateFields(['ps', 'pn']);
    }
    public function isValidCreateUser()
    {
        return $this->validateFields(['price', 'description', 'title']);
    }
    public function isValidEditUser()
    {
        return $this->isValidCreateUser()
        && $this->isValidId();
    }
}
