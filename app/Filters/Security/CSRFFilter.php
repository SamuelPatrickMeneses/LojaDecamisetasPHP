<?php

namespace app\Filters\Security;

use App\Lib\Flash;
use Core\Http\CSRF;
use Core\Http\Request;
use Core\Routes\Filter;
use Core\Routes\FilterChain;

class CSRFFilter implements Filter
{
    public function doFilter(Request $requst, FilterChain $filterChain)
    {
        $itMustInterupt = $requst->getMethod() !== 'GET'
        && !CSRF::validateToken($requst->getParams()['csrf_token']);
        if ($itMustInterupt) {
            Flash::message('error_message', "csrf fail detected try again.");
            header('location: ' . ($_SESSION['lest_page'] ?? '/home'));
            exit();
        }
        $filterChain->next($requst);
    }
}
