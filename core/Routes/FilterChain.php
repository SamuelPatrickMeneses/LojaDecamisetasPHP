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

    public function stat(Request $request){
        $filterChain = $this;
        $this->fiber = new Fiber(function () use($filterChain, $request)
        {
            if (count($filterChain->filters) == 0) {
                return;
            }
            $filterChain->filters[0]->doFilter($request, $filterChain);
        });
    }
    public function resume($arg){
        if ($this->fiber->isRunning()) {
            $this->fiber->resume($arg);
        }
    }
    public function next(Request $request){
        $count = $this->count + 1;
        if (isset($this->filters[$count])) {
            $this->count = $count;
            $this->filters[$count]->doFilter($request, $this);
        } else {
            Fiber::suspend(self::OK);
        }
    }
    public function addFilter(Filter $filter)
    {
        $this->filters[] = $filter;
    }

}