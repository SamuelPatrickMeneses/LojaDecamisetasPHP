<?php

namespace App\Controllers\Admin;

use App\Lib\Flash;
use App\Services\AdminService;
use Core\Controllers\BaseController;
use Core\Http\Request;

class AdminLoginController extends BaseController
{
    private AdminService $service;

    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->service = new AdminService();
    }
    public function validateInputs($name, $password)
    {
        return preg_match('/^[a-zA-Z0-9]{5,100}$/', $name)
        && preg_match('/^[A-Za-z0-9@#$%]{8,33}$/', $password);
    }
    public function post()
    {
        $authenticate = false;
        $name = $this->params['name'];
        $password = $this->params['password'];
        var_dump($this->validateInputs($name, $password));
        if ($this->validateInputs($name, $password)) {
            $authenticate = $this->service->authenticate($name, $password);
            if ($authenticate) {
                $this->redirectTo('/admin/home');
            } else {
                http_response_code(401);
                Flash::message('error_message', "user or password incorect");
                $this->render('/admin/login');
            }
        } else {
            http_response_code(422);
            Flash::message('error_message', "invalid credentials");
            $this->render('/admin/login');
        }
    }
    public function index()
    {   
        switch ($this->request->getPath()) {
            case '/admin/login':
                $this->render('/admin/login');
                break;
            case '/admin/logout':
                $this->service->logout();
                $this->render('/admin/login');
        }
    }
}
