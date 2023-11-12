<?php

namespace App\Controllers;

use App\Lib\Flash;
use App\Services\UserService;
use Core\Controllers\BaseController;
use Core\Http\CSRF;
use Core\Http\Request;
use Exception;

class LoginController extends BaseController
{
    private UserService $service;

    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->service = new UserService();
    }
    public function validateInputs($email, $password, $gmtOfset)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL, ['options' => ['max_range' => 50]]) == $email
        && preg_match('/^[A-Za-z0-9@#$%]{8,33}$/', $password)
        && $gmtOfset < 13 && $gmtOfset > -13;
    }
    public function post()
    {
        $authenticate = false;
        $email = $this->params['email'];
        $password = $this->params['password'];
        $gmtOfset = intval($this->params['timezoneOfset']) ?? 0;
        if ($this->validateInputs($email, $password, $gmtOfset)) {
            $authenticate = $this->service->authenticate($email, $password, $gmtOfset);
            if ($authenticate) {
                $this->redirectTo('/home');
            } else {
                http_response_code(401);
                Flash::message('error_message', "user or password incorect");
                $this->render('login');
            }
        } else {
            http_response_code(422);
            Flash::message('error_message', "invalid credentials");
            $this->render('login');
        }
    }
    public function index()
    {
        $this->render('login');
    }
}
