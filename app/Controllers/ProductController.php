<?php

namespace App\Controllers;

use App\Lib\Flash;
use App\Services\ProductService;
use Core\Controllers\BaseController;
use Core\Http\Request;

class ProductController extends BaseController
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
    public function isValidSearch()
    {
        return isset($this->params['search']) && filter_input(INPUT_GET, 'search') === $this->params['search'];
    }
    public function index()
    {
        switch ($this->request->getPath()) {
            case '/product/' . ($this->params[':id'] ?? ''):
                if ($this->isValidId()) {
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
                break;
            case '/home':
                $paginationValidity = $this->isValidPagination();
                $searchValidity = $this->isValidSearch();
                $search = $searchValidity ? $this->params['search'] : null;
                if (isset($this->params['search']) && !$searchValidity) {
                    Flash::message('error_message', "invalid search text");
                }
                $pageSize = $paginationValidity ? intval($this->params['ps']) : 12;
                $pageNumber = $paginationValidity ? intval($this->params['pn']) : 1;
                $this->renderProducts($pageSize, $pageNumber, $search);
        }
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
