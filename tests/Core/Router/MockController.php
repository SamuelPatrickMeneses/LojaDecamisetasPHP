<?php

namespace Tests\Core\Router;

use Core\Controllers\BaseController;
use PHPUnit\Framework\Assert;

class MockController extends BaseController
{
    public function itMustBeCalled()
    {
        Assert::assertTrue(true);
    }
    public function itDontMustBeCalled()
    {
        Assert::assertTrue(false);
    }
    public function nop()
    {
    }
}
