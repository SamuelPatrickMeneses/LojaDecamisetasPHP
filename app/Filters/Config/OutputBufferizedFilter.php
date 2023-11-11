<?php

namespace app\Filters\Config;

use Core\Http\Request;
use Core\Routes\Filter;
use Core\Routes\FilterChain;

class OutputBufferizedFilter implements Filter
{
    public function doFilter(Request $requst, FilterChain $filterChain)
    {
        ob_start();
        $filterChain->next($requst);
        ob_end_flush();
    }
}
