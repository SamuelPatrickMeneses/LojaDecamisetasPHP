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
    public function index()
    {
        switch ($this->request->getPath()) {
            case 'home'. ($this->params[':id'] ?? '');
                if ($this->isValidId()) {
                    $product = $this->service->getById(intval($this->params[':id']));
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
    public function renderProducts($pageSize = 12, $pageNumber = 1)
    {
        $products = $this->service->getProductsWithOneImage($pageSize, $pageNumber);
        $count = $this->service->count();
        $pageTotal = ceil($count / $pageSize);
        $this->render('home', [
            'products' => $products,
            'curentPage' => $pageNumber <= $pageTotal ? $pageNumber : 1,
            'pageSize' => $pageSize,
            'pageTotal' => $pageTotal ? $pageTotal : 0 ,
        ]);
    }
}
