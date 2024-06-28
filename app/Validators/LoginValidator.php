<?php

namespace App\Validators;

use Core\Validation\Validator;

class LoginValidator extends Validator
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
            'timezoneOfset' => [
                'type' => 'int',
                'max' => 13,
                'min' => -13
            ]
        ]);
    }
    public function isValidCreateItem($callback = null)
    {
        return $this->validateAll($callback);
    }
}
