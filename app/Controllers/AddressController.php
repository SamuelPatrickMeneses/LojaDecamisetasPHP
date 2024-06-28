<?php

namespace App\Controllers;

use App\Lib\Flash;
use App\Services\AddressService;
use App\Validators\AddressValidator;
use Core\Controllers\BaseController;
use Core\Http\Request;

class AddressController extends BaseController
{
    private AddressService $service;
    private AddressValidator $valid;
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->service = new AddressService();
        $this->valid = new AddressValidator($this->params);
    }
    public function post()
    {
        $isValid = $this->valid->isValidAddress(
            function ($error)
            {
                Flash::message('error_message', $error['message']);
                $this->render($_SESSION['lest_page'], [
                    'postalCode' => $this->params['postalCode'] ?? '',
                    'street' => $this->params['street'] ?? '',
                    'number' => intval($this->params['number']) ?? '',
                    'complement' => $this->params['complement'] ?? '',
                    'locality' => $this->params['locality'] ?? '',
                    'city' => $this->params['city'] ?? '',
                    'region' => $this->params['region'] ?? '',
                    'countryLast' => $this->params['country'] ?? '',
                ]);
            }
        );
        if ($isValid) {
            $cep = preg_replace('/^(\d{5})-(\d{3})$/', '$1$2', $this->params['postalCode']);
            $isCreated =$this->service->create(
                $_SESSION['user']['id'],
                $this->params['street'],
                intval($this->params['number']),
                $this->params['complement'],
                $this->params['locality'],
                $this->params['city'],
                $this->params['region'],
                $cep,
                $this->params['country']);

            if (!!$isCreated) {
                Flash::message('success_message', 'save with success');
            } else {
                Flash::message('error_message', "error on persist");
            }
            $this->redirectTo('/home');
        }
    }
    public function index()
    {
        $this->render('address', ['countries' => COUNTRIES]);
    }
}
