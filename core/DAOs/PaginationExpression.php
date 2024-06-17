<?php

namespace Core\DAOs;

use Error;

class PaginationExpression
{
    public function __construct(private int $size = 0, private int $number = 1)
    {
        if ($size < 0) {
            throw new Error('Pagination size nust by more thet 0!');
        }
        if ($number < 1) {
            throw new Error('Pagination number must by more thet 1!');
        }

    }
    public function __toString(): string
    {
        return $this->size === 0 ? '' : ' LIMIT ' . $this->size . ' OFFSET ' . ($this->number - 1) * $this->size;
    }
}
