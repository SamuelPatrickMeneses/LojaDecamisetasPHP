<?php

namespace App\Controllers;

use Core\Controllers\BaseController;

class NotFoundController extends BaseController
{
    public function index()
    {
        $this->render('NotFound');
    }
}
