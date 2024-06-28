<?php

namespace App\Controllers;

use App\Lib\Flash;
use App\Services\ProductService;
use App\Validators\ProductValidator;
use Core\Controllers\BaseController;
use Core\Http\Request;

class ProductController extends BaseController
{
    private ProductService $service;
    private ProductValidator $validator;
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->service = new ProductService();
        $this->validator = new ProductValidator($this->params);
    }
    public function index()
    {
        if ($this->validator->isValidId()) {
            $product = $this->service->getByIdwithImages(intval($this->params[':id']));
            if (isset($product)) {
                $this->render('product', ['product' => $product]);
            } else {
                Flash::message('error_message', "unexistent product");
                $this->renderProducts();
            }
        } else {
            Flash::message('error_message', "invalid id");
            $this->renderProducts();
        }
    }
    public function home() {
        $paginationValidity = $this->validator->isValidPagination();
        $searchValidity = $this->validator->isValidSearch();
        $search = $searchValidity ? $this->params['search'] : null;
        if (isset($search) && !$searchValidity) {
            Flash::message('error_message', "invalid search text");
        }
        $pageSize = $paginationValidity ? intval($this->params['ps']) : 12;
        $pageNumber = $paginationValidity ? intval($this->params['pn']) : 1;
        $this->renderProducts($pageSize, $pageNumber, $search);
    }
    public function renderProducts($pageSize = 12, $pageNumber = 1, $title = null)
    {
        $products = [];
        if (isset($title)) {
            $products = $this->service->searchProductsWithOneImage($title, $pageSize, $pageNumber);
        } else {
            $products = $this->service->getProductsWithOneImage($pageSize, $pageNumber);
        }
        $count = $this->service->count();
        $pageTotal = ceil($count / $pageSize);
        $this->render('home', [
            'products' => $products,
            'curentPage' => $pageNumber <= $pageTotal ? $pageNumber : 1,
            'pageSize' => $pageSize,
            'pageTotal' => $pageTotal ? $pageTotal : 0 ,
            'search' => $title
        ]);
    }
}
