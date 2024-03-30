<?php

namespace App\Exceptions;

use Exception;

class ENVException extends Exception
{
    public function __construct(string $messenge)
    {
        parent::__construct($messenge);
    }

    public static function checkEnv($envName)
    {
        if ($_ENV[$envName] === '') {
            throw new ENVException("the enviroment viroment variable $envName doesen't be brovided");
        }
    }
}
