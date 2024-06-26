<?php

namespace Tests\Core\Router;

use PHPUnit\Framework\TestCase;
use Core\Routes\Route;
use Core\Http\Request;

class RouteTest extends TestCase
{
    private Route $route;
    public function setup(): void
    {
        $this->route = new Route();
    }
    public function testPath()
    {
        $requet = self::createRequest('/', 'GET');
        $this->route->get('/', [MockController::class, 'itMustBeCalled']);
        $this->route->post('/', [MockController::class, 'itDontMustBeCalled']);
        $this->route->action($requet);
    }
    public function testMehotd()
    {
        $requet = self::createRequest('/', 'POST');
        $this->route->get('/', [MockController::class, 'itDontMustBeCalled']);
        $this->route->post('/', [MockController::class, 'itMustBeCalled']);
        $this->route->action($requet);
    }
    public function testNotFound()
    {
        $requet = self::createRequest('/', 'GET');
        $this->route->putErrorController('not_found', [MockController::class, 'itMustBeCalled']);
        $this->route->get('/tasks', [MockController::class, 'itDontMustBeCalled']);
        $this->route->post('/tasks', [MockController::class, 'itDontMustBeCalled']);
        $this->route->action($requet);
    }
    public function testDinamic()
    {
        $requet = self::createRequest('/1', 'GET');
        $this->route->putErrorController('not_found', [MockController::class, 'itMustBeCalled']);
        $this->route->get('/:id', [MockController::class, 'itMustBeCalled']);
        $this->route->post('/tasks', [MockController::class, 'itDontMustBeCalled']);
        $this->route->action($requet);
    }
    public function testMultDinamic()
    {
        $requet = self::createRequest('/1/1', 'GET');
        $this->route->putErrorController('not_found', [MockController::class, 'itDontMustBeCalled']);
        $this->route->get('/:id/:id2', [MockController::class, 'itMustBeCalled']);
        $this->route->action($requet);
    }
    public function testSubrouteNotFound()
    {
        $requet = self::createRequest('/tasks/remove', 'GET');
        $this->route->putErrorController('not_found', [MockController::class, 'itMustBeCalled']);
        $this->route->get('/tasks', [MockController::class, 'itDontMustBeCalled']);
        $this->route->post('/tasks', [MockController::class, 'itDontMustBeCalled']);
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
