<?php

namespace App\Controllers\Admin;

use App\Services\AdminService;
use Core\Controllers\BaseController;
use Core\Http\Request;

class AdminHomeController extends BaseController
{
    private AdminService $service;

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
