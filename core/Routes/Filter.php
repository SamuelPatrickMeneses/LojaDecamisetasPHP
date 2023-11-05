<?php

namespace Core\Routes;

use Core\Http\Request;

interface Filter
{
    public function doFilter(Request $requst, FilterChain $filterChain);
}