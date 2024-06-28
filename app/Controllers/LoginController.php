<?php

namespace App\Controllers;

use App\Lib\Flash;
use App\Services\UserService;
use App\Validators\LoginValidator;
use Core\Controllers\BaseController;
use Core\Http\Request;

class LoginController extends BaseController
{
    private UserService $service;
    private LoginValidator $validator;
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->service = new UserService();
        $this->validator = new LoginValidator($this->params);
    }
    public function post()
    {
        $obj = $this;
        $valid = $this->validator->validateAll(
            function($errors) use ($obj)
            {
                http_response_code(422);
                foreach ($errors as $error){
                    Flash::message('error_message', $error['message']);
                }
                $obj->render('login');
            }
        );
        if ($valid) {
            $email = $this->params['email'];
            $password = $this->params['password'];
            $gmtOfset = intval($this->params['timezoneOfset']);
            $authenticate = $this->service->authenticate($email, $password, $gmtOfset);
            if ($authenticate) {
                $this->redirectTo('/home');
            } else {
                http_response_code(401);
                Flash::message('error_message', "user or password incorect");
                $this->render('login');
            }
        } 
    }
    public function index()
    {
        $this->render('login');
    }
}
