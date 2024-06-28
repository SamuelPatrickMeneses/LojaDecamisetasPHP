<?php

namespace App\Validators;

use Core\Validation\Validator;

class SigningValidator extends Validator
{
    public function __construct($params)
    {
        parent::__construct($params,[
            'email' => [
                'filters' => [FILTER_VALIDATE_EMAIL],
                'max' => 50
            ],
            'password' => [
                'regx' => '/^[A-Za-z0-9@#$%]{8,33}$/'
            ],
            'name' => [
                'regx' => '/^[a-zA-Z0-9]{5,100}$/',
            ],
            'password2' => [
                'set' => [
                    $params['password']
                ]
            ]
        ]);
    }
    public function validateInputs($callback = null)
    {
        return $this->validateAll($callback);
    }
}
