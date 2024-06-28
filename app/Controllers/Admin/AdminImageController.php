<?php

namespace App\Controllers\Admin;

use App\Lib\Flash;
use App\Services\ImageService;
use App\Validators\AdminImageValidator;
use Core\Controllers\BaseController;

class AdminImageController extends BaseController
{
    private $service;
    private AdminImageValidator $validator;
    public function __construct($request)
    {

        parent::__construct($request);
        $this->service = new ImageService();
        $this->validator = new AdminImageValidator($this->params);
    }
    public function delete()
    {
        if ($this->validator->isValidId()) {
            $this->service->deleteById(intval($this->params[':id']));
            Flash::message('success_message', "deleted with success!");
        } else {
            Flash::message('error_message', "invalid id");
        }
        $this->redirectTo($_SESSION['lest_page'] ?? '/admin/products');
    }
}
