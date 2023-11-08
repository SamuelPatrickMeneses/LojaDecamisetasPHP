<?php

namespace Core\Routes;

use Core\Http\Request;
use Fiber;

class FilterChain
{
    private array $filters;
    private Fiber $fiber;
    private $count;
    public const OK = 0;
    public function __construct()
    {
        $this->filters = [];
        $this->count = 0;
    }

    public function start(Request $request)
    {
        $filterChain = $this;
        $this->fiber = new Fiber(function () use ($filterChain, $request) {
            if (count($filterChain->filters) == 0) {
                return;
            }
            $filter = $filterChain->filters[0];
            $filter = gettype($filter) == 'string' ? new $filter() : $filter;
            $filter->doFilter($request, $filterChain);
        });
        $this->fiber->start();
    }
    public function resume($arg)
    {
        if ($this->fiber->isRunning()) {
            $this->fiber->resume($arg);
        }
    }
    public function next(Request $request)
    {
        $count = $this->count + 1;
        if (isset($this->filters[$count])) {
            $this->count = $count;
            $filter = $this->filters[$count];
            $filter = gettype($filter) == 'string' ? new $filter() : $filter;
            $filter->doFilter($request, $this);
        } else {
            Fiber::suspend(self::OK);
        }
    }
    public function addFilter(Filter | string $filter)
    {
        $this->filters[] = $filter;
    }
}
