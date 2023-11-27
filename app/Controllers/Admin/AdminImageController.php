<?php

namespace App\Controllers\Admin;

use App\Lib\Flash;
use App\Services\ImageService;
use Core\Controllers\BaseController;

class AdminImageController extends BaseController
{
    private $service;

    public function __construct($request)
    {

        parent::__construct($request);
        $this->service = new ImageService();
    }
    public function isValidId()
    {
        return isset($this->params[':id']) && intval($this->params[':id']) > 0;
    }
    public function delete()
    {
        if ($this->isValidId()) {
            $this->service->deleteById(intval($this->params[':id']));
            Flash::message('success_message', "deleted with success!");
        } else {
            Flash::message('error_message', "invalid id");
        }
        $this->redirectTo($_SESSION['lest_page'] ?? '/admin/products');
    }
}