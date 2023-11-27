<?php

namespace App\Controllers\Admin;

use App\Lib\Flash;
use App\Services\ProductService;
use Core\Controllers\BaseController;
use Core\Http\Request;

class AdminProductController extends BaseController
{
    private ProductService $service;

    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->service = new ProductService();
    }
    public function isValidId()
    {
        return isset($this->params[':id']) && intval($this->params[':id']) > 0;
    }
    public function isValidPagination()
    {
        if (isset($this->params['ps']) && isset($this->params['pn'])) {
            $size = intval($this->params['ps']);
            $number = intval($this->params['pn']);
            return $size > 0 && $size < 51 && $number > 0;
        } else {
            return false;
        }
    }
    public function isValidCreateUser()
    {
        return filter_input(INPUT_POST, 'title') === $this->params['title']
        && strlen($this->params['title']) >= 3 && strlen($this->params['title']) <= 500
        && filter_input(INPUT_POST, 'description') === $this->params['description']
        && strlen($this->params['description']) >= 3 && strlen($this->params['description']) <= 1000
        && isset($this->params['price'])
        && floatval($this->params['price']) > 0;
    }
    public function isValidEditUser()
    {
        return $this->isValidCreateUser()
        && $this->isValidId();
    }
    public function post()
    {
        if ($this->isValidCreateUser()) {
            $title = $this->params['title'];
            $description = $this->params['description'];
            $price = intval($this->params['price']) * 100;
            
            $result = $this->service->newProduct($title, $description, $price);
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
    public function edit()
    {
        if ($this->isValidEditUser()) {
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
        switch ($this->request->getPath()) {
            case '/admin/products/create';
                $this->render('admin/createProduct');
                break;
            case '/admin/products/edit/'. ($this->params[':id'] ?? '');
                if ($this->isValidId()) {
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
                break;
            default:
                if ($this->isValidPagination()) {
                    $pageSize = intval($this->params['ps']);
                    $pageNumber = intval($this->params['pn']);
                    $this->renderProducts($pageSize, $pageNumber);
                } else {
                    $this->renderProducts();
                }
        }
    }
    public function renderProducts($pageSize = 10, $pageNumber = 1)
    {
        $products = $this->service->getProducts($pageSize, $pageNumber);
        $this->render('admin/products', ['products' => $products]);
    }
}
