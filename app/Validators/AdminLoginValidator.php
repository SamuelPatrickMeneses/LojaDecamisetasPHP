<?php

namespace App\Validators;

use Core\Validation\Validator;

class AdminLoginValidator extends Validator
{
    public function __construct($params)
    {
        parent::__construct($params,[
            'name' => [
                'regx' => '/^[a-zA-Z0-9]{5,100}$/'
            ],
            'password' => [
                'regx' => '/^[A-Za-z0-9@#$%]{8,33}$/'
            ]
        ]);
    }
    public function validateInputs($callback = null)
    {
        return $this->validateAll($callback);
    }
}
