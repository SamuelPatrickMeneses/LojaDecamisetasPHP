<?php

namespace App\Controllers;

use App\Exceptions\InsufficientQuantityException;
use App\Exceptions\InvalidVariantIdException;
use App\Lib\Flash;
use App\Services\CartService;
use Core\Controllers\BaseController;
use Core\Http\Request;

class CartController extends BaseController
{
    private CartService $service;
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->service = new CartService();
    }
    public function isValidCreateItem()
    {
        return isset($this->params['variantId']) && intval($this->params['variantId']) > 0
        && isset($this->params['quantity']) && intval($this->params['quantity']) > 0;
    }
    public function post()
    {
        if ($this->isValidCreateItem()) {
            try {
                $quantity = (intval($this->params['quantity']));
                $variantId = intval($this->params['variantId']);
                $producid = intval($this->params['productId']);
                $this->service->createItem($_SESSION['user']['id'], $variantId, $producid, $quantity);
                Flash::message('success_message', "added to cart!");
            } catch (InsufficientQuantityException $ex) {
                Flash::message('error_message', "insufficient quantity");
            } catch (InvalidVariantIdException $ex) {
                Flash::message('error_message', "invalid variant id");
            }
            $this->redirectTo($_SESSION['lest_page']);
        }
    }
    public function index()
    {
        $items = $this->service->getCartItems($_SESSION['user']['id']);
        $this->render('cart', [
            'items' => $items
        ]);
    }
}
