<?php

namespace App\Controllers\Admin;

use Core\Controllers\BaseController;
use Core\Http\Request;

class AdminHomeController extends BaseController
{

    public function __construct(Request $request)
    {
        parent::__construct($request);
    }
    public function post()
    {

    }
    public function index()
    {
        $this->render('/admin/home');
    }
}
