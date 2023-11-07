<?php

namespace Core\Routes;

use Core\Http\Request;
use Core\Http\RequestFactory;
use App\Controllers\NotFoundConreoller;
use Core\Routes\Exceptions\SubrouteNotExistsException;

class Route
{
    private $errorControllers = [];
    private $subRoutes = [];
    private $controllers = [
        'GET' => [],
        'POST' => [],
        'PUT' => [],
        'DELETE' => []
    ];
    private $dinamic;
    private $labels = [];
    private FilterChain $filterChain;
    public function __construct()
    {
        $this->filterChain = new FilterChain();
    }
    public static function explodeURI($path)
    {
        $splitedPath = explode('/', $path);
        array_shift($splitedPath);
        if (str_ends_with($path, '/')) {
            array_pop($splitedPath);
        }
        return $splitedPath;
    }
    public function putErrorController($code, $data)
    {
        if (!isset($this->errorControllers[$code])) {
            $this->errorControllers[$code] = [];
        }
        $this->errorControllers[$code]['class'] = $data[0];
        $this->errorControllers[$code]['action'] = $data[1];
    }
    public function get($path, $data)
    {
        $this->addDinamicRoute($path, $data);
    }

    public function delete($path, $data)
    {
        $this->addDinamicRoute($path, $data, 'DELETE');
    }

    public function post($path, $data)
    {
        $this->addDinamicRoute($path, $data, 'POST');
    }

    public function put($path, $data)
    {
        $this->addDinamicRoute($path, $data, 'PUT');
    }
    public function use(Filter | string $filter, array | string $path = '/')
    {
        if (gettype($path) == 'string') {
            $splitedPath = $path === '/' ? [] : self::explodeURI($path);
            $this->use($filter, $splitedPath);
        } elseif (isset($path[0])) {
            if (preg_match('/^:[a-z,_]+$/', $path[0])) {
                if (!isset($this->dinamic)) {
                    throw new SubrouteNotExistsException();
                }
                array_shift($path);
                $this->dinamic->use($filter, $path);
            } elseif (isset($path[0]) & isset($this->subRoutes[$path[0]])) {
                $subRouteName = $path[0];
                array_shift($path);
                $this->subRoutes[$subRouteName]->use($filter, $path);
            } else {
                throw new SubrouteNotExistsException();
            }
        } else {
            $this->filterChain->addFilter($filter);
        }
    }
    public function addDinamicRoute($path, $data, $method = 'GET')
    {
        $splitedPath = $path === '/' ? [] : self::explodeURI($path);
        $this->addNode($splitedPath, $data, $method);
    }
    private function addNode($splitedPath, $data, $method)
    {
        if (count($splitedPath) === 0) {
            $this->controllers[$method]['class'] = $data[0];
            $this->controllers[$method]['action'] = $data[1];
            return;
        }
        if (preg_match('/^:[a-z,_]+$/', $splitedPath[0])) {
            if (!isset($this->dinamic)) {
                $this->dinamic = new Route();
            }
            $this->dinamic->errorControllers = $this->errorControllers;
            $this->labels[] = $splitedPath[0];
            array_shift($splitedPath);
            $this->dinamic->addNode($splitedPath, $data, $method);
            return;
        }
        $subRoute = $splitedPath[0];
        if (!isset($this->subRoutes[$subRoute])) {
            $this->subRoutes[$subRoute] = new Route();
        }
        $this->subRoutes[$subRoute]->
        errorControllers = $this->errorControllers;
        array_shift($splitedPath);
        $this->subRoutes[$subRoute]->addNode($splitedPath, $data, $method);
    }
    public function action(Request $request, $path = null)
    {
        if ($path === null) {
            $path = self::explodeURI($request->getPath());
        }
        if (count($path) > 0) {
            $subRoute = $path[0];
            array_shift($path);
            if (isset($this->subRoutes[$subRoute])) {
                $this->subRoutes[$subRoute]->action($request, $path);
            } elseif (isset($this->dinamic)) {
                foreach ($this->labels as $label) {
                    $request->putParam($label, $subRoute);
                }
                $this->dinamic->action($request, $path);
            } else {
                $this->runErrorController('not_found', $request);
            }
        } else {
            $method = $request->getMethod();
            if ($this->controllers[$method]) {
                $this->runController($method, $request);
            } else {
                $this->runErrorController('not_found', $request);
            }
        }
    }
    private function runController($method, Request $request)
    {
        $class  = $this->controllers[$method]['class'];
        $action = $this->controllers[$method]['action'];
        $controller = new $class($request);
        $controller->$action();
    }
    private function runErrorController($name, Request $request)
    {
        $class  = $this->errorControllers[$name]['class'];
        $action = $this->errorControllers[$name]['action'];
        $controller = new $class($request);
        $controller->$action();
    }
}
