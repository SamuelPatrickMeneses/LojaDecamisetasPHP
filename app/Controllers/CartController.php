<?php

namespace App\Controllers;

use App\Exceptions\InsufficientQuantityException;
use App\Exceptions\InvalidVariantIdException;
use App\Lib\Flash;
use App\Services\CartService;
use App\Validators\CartValidator;
use Core\Controllers\BaseController;
use Core\Http\Request;

class CartController extends BaseController
{
    private CartService $service;
    private CartValidator $valid;
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->service = new CartService();
        $this->valid = new CartValidator($this->params);
    }
    public function post()
    {
        if ($this->valid->isValidCreateItem()) {
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
