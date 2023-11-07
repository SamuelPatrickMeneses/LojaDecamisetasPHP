<?php

namespace Tests\Router;

use PHPUnit\Framework\TestCase;
use Core\Routes\Route;
use Core\Http\Request;
use Core\Routes\Exceptions\SubrouteNotExistsException;
use PHPUnit\Framework\Assert;

include_once 'MockFilter.php';

class FilterChainTest extends TestCase
{
    private Route $route;
    public function setup(): void
    {
        $this->route = new Route();
    }
    public function testFilterInRoot()
    {
        $requet = self::createRequest('/', 'GET');
        $this->route->get('/', [MockController::class, 'itMustBeCalled']);
        $this->route->post('/', [MockController::class, 'itDontMustBeCalled']);
        $this->route->use(new MockFilter());
        $this->route->action($requet);
    }
    public function testFilterInSubroute()
    {
        $requet = self::createRequest('/tasks', 'GET');
        $this->route->get('/tasks', [MockController::class, 'itMustBeCalled']);
        $this->route->post('/tasks', [MockController::class, 'itDontMustBeCalled']);
        $this->route->use(new MockFilter(), '/tasks');
        $this->route->action($requet);
    }
    public function testMustThrowsSubrouteNotExistsException()
    {
        $requet = self::createRequest('/', 'POST');
        $this->route->get('/', [MockController::class, 'itDontMustBeCalled']);
        $this->route->post('/', [MockController::class, 'itMustBeCalled']);
        try {
            $this->route->use(new MockFilter(), '/tasks');

        } catch (SubrouteNotExistsException $ex) {
            $this->assertTrue(true);
        }
    }
    public function testFilterInstanciedByClassPath()
    {
        $requet = self::createRequest('/', 'GET');
        $this->route->get('/', [MockController::class, 'itMustBeCalled']);
        $this->route->post('/', [MockController::class, 'itDontMustBeCalled']);
        $this->route->use(Tests\Router\MockFilter::class);
        $this->route->action($requet);
    }
    private static function createRequest($path, $method): Request
    {
        $requet = new Request();
        $requet->setPath($path);
        $requet->setMethod($method);
        $requet->setParams([]);
        return $requet;
    }
}
