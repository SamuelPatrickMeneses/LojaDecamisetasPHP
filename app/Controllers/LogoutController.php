<?php

namespace App\Controllers;

use App\Lib\Flash;
use App\Services\UserService;
use Core\Controllers\BaseController;
use Core\Http\CSRF;
use Core\Http\Request;
use Exception;

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
