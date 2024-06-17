<?php

namespace App\Validators;

use Core\Validation\Validator;

class AddressValidator extends Validator
{
    public function __construct($params)
    {
        parent::__construct($params,[
            'street' => [
                'regx' => '/^[ a-zA-Z0-9]{1,160}$/'
            ],
            'number' => [
                'type' => 'int',
                'num' => 0,
                'max' => 20000
            ],
            'complement' => [
                'regx' => '/^[ a-zA-Z0-9]{1,40}$/'
            ],
            'country' => [
                'set' => COUNTRIES
            ],
            'city' => [
                'regx' => '/^[ a-zA-Z0-9]{1,99}$/'
            ],
            'region' => [
                'regx' => '/^[ a-zA-Z0-9]{1,50}$/'
            ],
            'locality' => [
                'regx' => '/^[ a-zA-Z0-9]{1,60}$/'
            ],
            'postalCode' => [
                'regx' => '/^\d{5}-\d{3}$/'
            ],
        ]);
    }
    public function isValidAddress($callback)
    {
        return $this->validateAll($callback);
    }
}
