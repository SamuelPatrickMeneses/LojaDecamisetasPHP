<?php

namespace Core\Validation;

use Core\Validation\FieldValidator;

class Validator
{
    private array $validators = [];
    public function __construct(
        protected array &$params = [],
        array $definitions = [], 
        private  $callback = 'nop')
    {
        foreach ($definitions as $prop => $def) {
            if (!isset($def['callback'])) {
                $def['callback'] = $callback;
            }
            $def['name'] = $prop;
            $this->validators[$prop] = new FieldValidator($def);
        }
    }
    public function validateFields($filds, $callback = null)
    {
        foreach ($this->validators as $prop => $validator) {
            if ( in_array($prop, $filds) ) {
                $result = $validator->valid(
                    $this->params[$prop],
                    $callback ?? $this->callback
                );
                if (!$result) {
                    return false;
                }
            }
        }
        return true;
    }
    public function validateAll($callback = null)
    {
        foreach ($this->validators as $prop => $validator) {
            $result = $validator->valid(
                $this->params[$prop],
                $callback ?? $this->callback
            );
            if (!$result) {
                return false;
            }
        }
        return true;
    }

}
