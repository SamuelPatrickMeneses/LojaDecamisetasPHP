<?php

namespace Core\DAOs;

class SelectExpression
{
    private $alias;
    private string $columnName;
    public function __construct(string $column, string $alias = '')
    {
        $this->columnName = $column;
        $this->alias = $alias;
    }
    public function __toString(): string
    {
        $acumulator = $this->columnName;
        if ($this->alias != '') {
            $acumulator .= ' AS ' . $this->alias;
        }
        return $acumulator;
    }
}
