<?php

namespace app\Filters\Security;

use App\Lib\Flash;
use Core\Http\Request;
use Core\Routes\Filter;
use Core\Routes\FilterChain;

class CheckUserAuthenticationFilter implements Filter
{
    private $methods = [];

    public function __construct(array $methods = [])
    {
        $this->methods = $methods;
    }
    public function doFilter(Request $requst, FilterChain $filterChain)
    {
        $redirect = in_array($requst->getMethod(), $this->methods)
        && !isset($_SESSION['user']); 
        if ($redirect) {
            Flash::message('error_message', "do login to use uor service.");
            header('location: /login');
            exit();
        }
        $filterChain->next($requst);
    }
}
