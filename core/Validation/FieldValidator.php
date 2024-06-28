<?php

namespace Core\Validation;

use Exception;

class FieldValidator
{

    private string $type = 'string';
    private int | float $max = PHP_INT_MAX;
    private int | float $min = 0;
    private string $regx;
    private bool $required = true;
    private $callback = 'nop';
    private string $name;
    private array $set;
    private array $filters = [];
    private array $checkAll = [];
    private $errors = [];
    public const ACCEPTED_TYPES = [
        'string' => [
            'cast' => 'strval',
            'is' => 'is_string',
            'valid' => 'validString'
        ],
        'int' => [
            'cast' => 'intval',
            'is' => 'is_int_string',
            'valid' => 'validNumber'
        ],
        'float' => [
            'cast' => 'floatval',
            'is' => 'is_float_string',
            'valid' => 'validNumber'
        ]
    ];

    public function __construct($props)
    {
        $vars = get_class_vars(self::class);
        $vars = array_keys($vars);
        foreach ($vars as $var) {
            if (isset($props[$var]) && $var !== 'errors') {
                $this->$var = $props[$var];
            }
        }
        if (!isset(self::ACCEPTED_TYPES[$this->type])) {
            throw new Exception("filsd type unaccepted in $this->name!");
        }
    }
    public function valid(&$val, $callback)
    {
        $error = $callback ?? $this->callback; 
        if ($this->required && !isset($val)) {
            $this->addError("the field $this->name is required");
        }
        foreach ($this->filters as $filter) {
            if (!filter_var($val, $filter)) {
                $this->addError("the field $this->name don't pass on the filter " . getFilterName($filter) . '!' );
            }
        }
        foreach ($this->checkAll as $check) {
            if (!$check($val)) {
                $this->addError("The field $this->name value is invalid!");            
            }
        }
        $type = $this->type;
        $typeValidator =  self::ACCEPTED_TYPES[$type];
        if (!$typeValidator['is']($val)){
            $this->addError("The field $this->name should be type $type!");
        } 
        $val = $typeValidator['cast']($val);
        if (isset($this->set) && !in_array($val, $this->set)) {
            $this->addError("The field $this->name value is invalid!");
        } 
        $valid = $typeValidator['valid']; 
        $this->$valid($val);
        return count($this->errors) > 0
            ? $error($this->errors)
            : true;
    }
    private function validString($val)
    {
        if (strlen($val) < $this->min) {
            $this->addError("The field $this->name must have at least $this->min characters!");
        } elseif (strlen($val) > $this->max) {
            $this->addError("The field $this->name must have a maximun of $this->max characters!");
        } elseif (isset($this->regx) && !preg_match($this->regx, $val)) {
            $this->addError("The field $this->name is out of pattern!");
        }
    }
    private function validNumber($val)
    {
        if ($val < $this->min) {
            $this->addError("The field $this->name must be at least $this->min!");
        } elseif ($val > $this->max) {
            $this->addError("The field $this->name must be at most $this->max!");
        }
    }
    private function addError($message)
    {
        $this->errors[] = [
            'message' => $message
        ];
    }
}
