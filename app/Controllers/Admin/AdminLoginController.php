<?php

namespace App\Controllers\Admin;

use App\Lib\Flash;
use App\Services\AdminService;
use App\Validators\AdminLoginValidator;
use App\Validators\AdminValidator;
use Core\Controllers\BaseController;
use Core\Http\Request;

class AdminLoginController extends BaseController
{
    private AdminService $service;
    private AdminLoginValidator $validator;
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->service = new AdminService();
        $this->validator = new AdminValidator($this->params);
    }
    public function post()
    {
        $obj = $this;
        $valid = $this->validator->validateInputs(
            function() use ($obj)
            {
                http_response_code(422);
                Flash::message('error_message', "invalid credentials");
                $obj->render('/admin/login');
            }
        );
        if (!$valid) {
            $this->login();
        }
    }
    private function login()
    {
        $name = $this->params['name'];
        $password = $this->params['password'];
        $authenticate = $this->service->authenticate($name, $password);
        if ($authenticate) {
            $this->redirectTo('/admin/home');
        } else {
            http_response_code(401);
            Flash::message('error_message', "user or password incorect");
            $this->render('/admin/login');
        }
    }
    public function loginGet()
    {   
        $this->render('/admin/login');
    }
    public function logoutGet()
    {
        $this->service->logout();        
        $this->render('/admin/login');   
    }
}
