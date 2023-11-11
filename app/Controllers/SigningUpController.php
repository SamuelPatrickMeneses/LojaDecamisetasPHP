<?php

namespace App\Controllers;

use App\Lib\Flash;
use App\Services\UserService;
use Core\Controllers\BaseController;
use Core\Http\CSRF;
use Core\Http\Request;
use Exception;

class SigningUpController extends BaseController
{
    private UserService $service;

    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->service = new UserService();
    }
    public function validateInputs($email, $password, $password2, $name)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) == $email 
        && preg_match('/^[A-Za-z0-9@#$%]{8,33}$/', $password)
        && preg_match('/^[a-zA-Z0-9]{5,100}$/',$name)
        && $password == $password2
        && strlen($email) <= 50;
        
    }
    public function post()
    {
        $created = false;
        $email = $this->params['email'] ?? '';
        $password = $this->params['password'] ?? '';
        $password2 = $this->params['password2'] ?? '';
        $name = $this->params['name'] ?? '';
        if ($this->validateInputs($email, $password, $password2, $name)) {
            $created = $this->service->signingUp($email, $password, $name);
            if ($created) {
                Flash::message('success_message', 'user successfully registered');
                echo 'sdsadsfd';
                $this->redirectTo('/login');
            } else {
                http_response_code(401);
                Flash::message('error_message', "email already exists");
                $this->render('signingUp', [
                    'email' => $email,
                    'password' => $password,
                    'password2' => $password2,
                    'name' => $name
                ]);
            }
        } else {
            http_response_code(422);
            Flash::message('error_message', "invalid credentials");
            $this->render('signingUp', [
                'email' => $email,
                'password' => $password,
                'password2' => $password2,
                'name' => $name
            ]);
        }
    }
    public function index()
    {
        $this->render('signingUp');
    }
}
