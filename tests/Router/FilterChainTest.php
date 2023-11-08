<?php

namespace Tests\Router;

use PHPUnit\Framework\TestCase;
use Core\Routes\Route;
use Core\Http\Request;
use Core\Routes\Exceptions\SubrouteNotExistsException;
use PHPUnit\Framework\Assert;
use Tests\Router\MockFilter;

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
        $this->route->get('/', [MockController::class, 'nop']);
        $this->route->post('/', [MockController::class, 'nop']);
        $this->route->use(new MockFilter());
        $this->route->action($requet);
    }
    public function testFilterInSubroute()
    {
        $requet = self::createRequest('/tasks', 'GET');
        $this->route->get('/tasks', [MockController::class, 'nop']);
        $this->route->post('/tasks', [MockController::class, 'nop']);
        $this->route->use(new MockFilter(), '/tasks');
        $this->route->action($requet);
    }
    public function testMustThrowsSubrouteNotExistsException()
    {
        $requet = self::createRequest('/', 'POST');
        $this->route->get('/', [MockController::class, 'nop']);
        $this->route->post('/', [MockController::class, 'nop']);
        try {
            $this->route->use(new MockFilter(), '/tasks');
        } catch (SubrouteNotExistsException $ex) {
            $this->assertTrue(true);
        }
    }
    public function testFilterInstanciedByClassPath()
    {
        $requet = self::createRequest('/', 'GET');
        $this->route->get('/', [MockController::class, 'nop']);
        $this->route->post('/', [MockController::class, 'nop']);
        $this->route->use(MockFilter::class);
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
