<?php

namespace App\Validators;

use Core\Validation\Validator;

class AdminImageValidator extends Validator
{
    public function __construct($params)
    {
        parent::__construct($params,[
            ':id' => [
                'type' => 'int',
                'mim' => 1
            ]
        ]);
    }
    public function isValidId($callback = null)
    {
        return $this->validateAll($callback);
    }
}
