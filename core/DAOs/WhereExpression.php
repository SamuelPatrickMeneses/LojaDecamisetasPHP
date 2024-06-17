<?php

namespace Core\DAOs;

class WhereExpression
{
    public const EQUAL = '=';
    public const MORE = '>';
    public const LESS = '<';
    public const MORE_OR_EQUAL = '>=';
    public const LESS_OR_EQUAL = '>=';
    public const DIFFERENT = '!='; 
    public const LOGIC_AND = '&&';
    public const LOGIC_OR = '||';
    public const LOGIC_XOR = 'XOR';
    public const LIKE = 'LIKE';

    public function __construct(
        private string  $operator,
        private string | WhereExpression $left,
        private string | WhereExpression $right)
    {}
    public function and(WhereExpression $exp)
    {
        return new WhereExpression(
            WhereExpression::LOGIC_AND,
            $this,
            $exp
        );
    }
    public function __toString(): string
    {
        return join(' ', [
            strval($this->left),
            $this->operator,
            strval($this->right)
        ]);
    }
}
