<?php

namespace Tests\Core\Router;

use PHPUnit\Framework\TestCase;
use Core\Validation\Validator;

class ValidatorTest extends TestCase
{
    public function setup(): void
    {
    }
    public function testMaxCheck()
    {   $params = ['foo' => 1];
        $defnitions = [
            'foo' => [
                    'type' => 'int',
                    'max' => 10,
            ]
        ];
        $valid = new Validator($params, $defnitions);
        $valid->validateAll(fn() => $this->assertTrue(false));
        $params = ['foo' => 12];
        $valid = new Validator($params, $defnitions);
        $valid->validateAll(fn() => $this->assertTrue(true));

    }
    public function testMinLengthCheck()
    {   $params = ['foo' => '101'];
        $defnitions = [
            'foo' => [
                    'min' => 3,
            ]
        ];
        $valid = new Validator($params, $defnitions);
        $valid->validateAll(fn() => $this->assertTrue(false));
        $params = ['foo' => '2'];
        $valid = new Validator($params, $defnitions);
        $valid->validateAll(fn() => $this->assertTrue(true));

    }
    public function testMaxLengthCheck()
    {   $params = ['foo' => '10'];
        $defnitions = [
            'foo' => [
                    'max' => 3,
            ]
        ];
        $valid = new Validator($params, $defnitions);
        $valid->validateAll(fn() => $this->assertTrue(false));
        $params = ['foo' => '1211'];
        $valid = new Validator($params, $defnitions);
        $valid->validateAll(fn() => $this->assertTrue(true));

    }
    public function testMinCheck()
    {   $params = ['foo' => 10];
        $defnitions = [
            'foo' => [
                    'type' => 'int',
                    'min' => 10,
            ]
        ];
        $valid = new Validator($params, $defnitions);
        $valid->validateAll(fn() => $this->assertTrue(false));
        $params = ['foo' => 2];
        $valid = new Validator($params, $defnitions);
        $valid->validateAll(fn() => $this->assertTrue(true));

    }
    public function testRegexCheck()
    {   $params = ['foo' => 'LuisRicardo'];
        $defnitions = [
            'foo' => [
                    'regx' => '/^[a-zA-Z]{6,12}$/',
            ]
        ];
        $valid = new Validator($params, $defnitions);
        $valid->validateAll(fn() => $this->assertTrue(false));
        $params = ['foo' => 'Luis_Ricardo'];
        $valid = new Validator($params, $defnitions);
        $valid->validateAll(fn() => $this->assertTrue(true));

    }
    public function testEnumStringCheck()
    {   $params = ['foo' => 'LuisRicardo'];
        $defnitions = [
            'foo' => [
                    'set' => ['LuisRicardo'],
            ]
        ];
        $valid = new Validator($params, $defnitions);
        $valid->validateAll(fn() => $this->assertTrue(false));
        $params = ['foo' => 'Luis_Ricardo'];
        $valid = new Validator($params, $defnitions);
        $valid->validateAll(fn() => $this->assertTrue(true));

    }
    public function testEnumIntCheck()
    {   $params = ['foo' => '7'];
        $defnitions = [
            'foo' => [
                    'type' => 'int',
                    'set' => [1, 3, 7],
            ]
        ];
        $valid = new Validator($params, $defnitions);
        $valid->validateAll(fn() => $this->assertTrue(false));
        $params = ['foo' => '2'];
        $valid = new Validator($params, $defnitions);
        $valid->validateAll(fn() => $this->assertTrue(true));

    }
    public function testRequiredCheck()
    {
        $params = [
            'foo' => 'foo'
        ];
        $definitions = [
                'foo' => []
            ];
        $valid = new Validator(
            $params,
            $definitions,
            fn() => $this->assertTrue(false)
        );
        $valid->validateAll();
        $params = [];
        $valid = new Validator(
            $params,
            $definitions,
            fn() => $this->assertTrue(true) 
        );
        $valid->validateAll();
    }
}
