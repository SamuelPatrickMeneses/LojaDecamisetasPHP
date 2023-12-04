<?php

namespace App\Services;

use App\DAOs\CartAndItemDAO;
use App\DAOs\ImageDAO;
use App\DAOs\ProductDAO;
use App\DAOs\ProductVariantDAO;
use App\Exceptions\InsufficientQuantityException;
use App\Exceptions\InvalidVariantIdException;
use Core\DAOs\DAOUtil;
use Exception;

class CartService
{
    private CartAndItemDAO $dao;
    private ProductVariantDAO $variantDao;
    private ProductDAO $productDao;
    private ImageDAO $imageDao;

    public function __construct()
    {
        $this->dao = new CartAndItemDAO();
        $this->variantDao = new ProductVariantDAO();
        $this->productDao = new ProductDAO();
        $this->imageDao = new ImageDAO();
    }
    public function createItem($userId, $variantId, $productId, $quantity)
    {
        try {
            DAOUtil::beginTransactionIfEnable();
            $item = $this->dao->findByUserAndVariantId($userId, $variantId);
            if (isset($item)) {
                $this->variantDao->populateCartItem($item);
                $newQantity = $item->getItemQuantity() + $quantity;
                if ($newQantity > $item->getVariant()->getStockQantity()) {
                    throw new InsufficientQuantityException();
                }
                $this->dao->updateCartItem($userId, $item->getId(), [
                    'itemQuantity' => $quantity,
                    'itemPrice' => $item->getVariant()->getPrice()
                ]);
            } else {
                $variant = $this->variantDao->findById($variantId, $productId);
                if (!isset($variant)) {
                    throw new InvalidVariantIdException();
                }
                if ($quantity > $variant->getStockQantity()) {
                    throw new InsufficientQuantityException();
                }
                $this->dao->newCartItem($userId, $quantity, $variant);
            }
            DAOUtil::commitIfEnable();
        } catch (InsufficientQuantityException $ex) {
            DAOUtil::rollbackIfEnable();
            throw $ex;
        } catch (InvalidVariantIdException $ex) {
            DAOUtil::rollbackIfEnable();
            throw $ex;
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
        return false;
    }
    public function getCartItems($userId)
    {
        DAOUtil::beginTransactionIfEnable();
        $items = $this->dao->findByUserId($userId);
        foreach ($items as $item) {
            $this->imageDao->populateCartItem($item);
            $this->variantDao->populateCartItem($item);
            $this->productDao->populateCartItem($item);
            $item->setImage($item->getImage()->getFile());
        }
        DAOUtil::commitIfEnable();
        return $items;
    }
}
