<?php

namespace App\Controllers;

use App\Services\UserService;
use Core\Controllers\BaseController;
use Core\Http\Request;

class LogoutController extends BaseController
{
    private UserService $service;

    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->service = new UserService();
    }
    public function index()
    {
        $this->service->logout();
        $this->redirectTo('/home');
    }
}
