<?php

namespace App\Controllers\Admin;

use App\Lib\Flash;
use App\Services\ProductService;
use App\Validators\AdminProductValidator;
use Core\Controllers\BaseController;
use Core\Http\Request;

class AdminProductController extends BaseController
{
    private ProductService $service;
    private AdminProductValidator $validator;
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->service = new ProductService();
        $this->validator = new AdminProductValidator($this->params);
    }
    public function post()
    {
        if ($this->validator->isValidCreateUser()) {
            $title = $this->params['title'];
            $description = $this->params['description'];
            $price = intval($this->params['price']) * 100;
            $result = $this->service->newProduct($title, $description, $price);
            if ($result) {
                http_response_code(201);
                Flash::message('success_message', 'product successfully created');
                $this->renderProducts();
            } else {
                Flash::message('error_message', "error on persist");
                $this->redirectTo($_SESSION['lest_page'] ?? '/home');
            }
        } else {
            Flash::message('error_message', "invalid values");
            $this->redirectTo($_SESSION['lest_page'] ?? '/home');
        }
    }
    public function edit()
    {
        if ($this->validator->isValidEditUser()) {
            $id = intval($this->params[':id']);
            $title = $this->params['title'];
            $description = $this->params['description'];
            $price = intval($this->params['price']) * 100;
            $result = $this->service->editProduct($id, $title, $description, $price);
            if ($result) {
                http_response_code(201);
                $this->renderProducts();
            } else {
                Flash::message('error_message', "error on persist");
                $this->redirectTo($_SESSION['lest_page'] ?? '/home');
            }
        } else {
            Flash::message('error_message', "invalid values");
            $this->redirectTo($_SESSION['lest_page'] ?? '/home');
        }
    }
    public function index()
    {
        if ($this->validator->isValidPagination()) {
            $pageSize = intval($this->params['ps']);
            $pageNumber = intval($this->params['pn']);
            $this->renderProducts($pageSize, $pageNumber);
        } else {
            $this->renderProducts();
        }
    }
    public function createForm()
    {
        $this->render('admin/createProduct');
    }
    public function showProduct()
    {
        if ($this->validator->isValidId()) {
            $product = $this->service->getById(intval($this->params[':id']));
            if (isset($product)) {
                $this->render('admin/editProduct', ['product' => $product]);
            } else {
                Flash::message('error_message', "unexistent product");
                $this->renderProducts();
            }
        } else {
            Flash::message('error_message', "invalid id");
            $this->renderProducts();
        }

    }
    private function renderProducts($pageSize = 10, $pageNumber = 1)
    {
        $products = $this->service->getProducts($pageSize, $pageNumber);
        $this->render('admin/products', ['products' => $products]);
    }
}
