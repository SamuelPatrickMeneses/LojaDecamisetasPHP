<?php

namespace App\Controllers;

use Core\Controllers\BaseController;

class OrderController extends BaseController
{
    public function index()
    {
        $this->render('/creditCard');
    }
}
