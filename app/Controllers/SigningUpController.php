<?php

    namespace App\Controllers;

use App\Lib\Flash;
use App\Services\UserService;
use App\Validators\SigningValidator;
use Core\Controllers\BaseController;
use Core\Http\Request;

class SigningUpController extends BaseController
{
    private UserService $service;
    private SigningValidator $validator;

    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->service = new UserService();
        $this->validator = new SigningValidator($this->params);
    }
    public function post()
    {
        $obj = $this;
        $isValid = $this->validator->validateInputs(
            function() use ($obj)
            {
                http_response_code(422);
                Flash::message('error_message', "invalid credentials");
                $obj->render('signingUp', [
                    'email' => $obj->params['email'],
                    'password' => $obj->params['password'],
                    'password2' => $obj->params['password2'],
                    'name' => $obj->params['name']
                ]);

            }
        );
        if (!$isValid) {
            $this->signingUp();
        }
    }
    private function signingUp()
    {
        $email = $this->params['email'];
        $password = $this->params['password'];
        $password2 = $this->params['password2'];
        $name = $this->params['name'];
        $created = $this->service->signingUp($email, $password, $name);
        if ($created) {
            Flash::message('success_message', 'user successfully registered');
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

    }
    public function index()
    {
        $this->render('signingUp');
    }
}
