<?php

namespace Tests\Router;

use Core\Http\Request;
use Core\Routes\Filter;
use Core\Routes\FilterChain;
use PHPUnit\Framework\Assert;

class MockFilter implements Filter
{
    public function doFilter(Request $requst, FilterChain $filterChain)
    {
        Assert::assertTrue(true);
        $filterChain->next($requst);
        Assert::assertTrue(true);
    }
}
