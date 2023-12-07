<?php

namespace App\Controllers;

use App\Lib\Flash;
use App\Services\AddressService;
use Core\Controllers\BaseController;
use Core\Http\Request;

class AddressController extends BaseController
{
    private AddressService $service;

    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->service = new AddressService();
    }
    public function isValidAddress()
    {
        return isset($this->params['street']) && preg_match('/^[ a-zA-Z0-9]{1,160}$/',$this->params['street'])
        && isset($this->params['number']) && preg_match('/^[0-9]{1,5}$/',$this->params['number'])
        && isset($this->params['complement']) && preg_match('/^[ a-zA-Z0-9]{1,40}$/',$this->params['complement'])
        && isset($this->params['country']) && key_exists($this->params['country'], COUNTRIES)
        && isset($this->params['city']) && preg_match('/^[ a-zA-Z0-9]{1,99}$/',$this->params['city'])
        && isset($this->params['region']) && preg_match('/^[ a-zA-Z0-9]{1,50}$/',$this->params['region'])
        && isset($this->params['locality']) && preg_match('/^[ a-zA-Z0-9]{1,60}$/',$this->params['locality'])
        && isset($this->params['postalCode']) && preg_match('/^\d{5}-\d{3}$/', $this->params['postalCode']);
    }
    public function post()
    {
        if ($this->isValidAddress()) {
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
        } else {
            Flash::message('error_message', "invalid values");
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
    }
    public function index()
    {
        $this->render('address', ['countries' => COUNTRIES]);
    }
}