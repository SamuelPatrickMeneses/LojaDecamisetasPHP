<?php

namespace App\DAOs;

use App\Entity\CartItem;
use App\Entity\ProductVariant;
use Core\DAOs\DAOUtil;
use Core\DB\DBConnectionHolder;
use PDO;
use PDOException;

class CartAndItemDAO
{
    private $pdo;
    private const UPDATE_CART_ITEM = [
        'itemQuantity' => 'cart_item_quantity',
        'itemPrice' => 'cart_item_price'
    ];
    public function __construct()
    {
        $this->pdo = DBConnectionHolder::getConnection();
    }
    public function newCart($userId)
    {
        $comand = 'INSERT INTO carts (user_id) VALUES (:user_id)';
        $statement = $this->pdo->prepare($comand);
        $statement->bindValue(':user_id', $userId);
        try {
            $statement->execute();
            return intval($this->pdo->lastInsertId());
        } catch (PDOException $ex) {
            return false;
        }
    }
    public function newCartItem($userId, $quantity, ProductVariant $variant)
    {
        $comand = "INSERT INTO cart_items (user_id, variant_id, product_id, cart_item_quantity, cart_item_price)
        VALUES (:user_id, :variant_id, :product_id, :cart_item_quantity, :cart_item_price)";
        $statement = $this->pdo->prepare($comand);
        $statement->bindValue(':user_id', $userId);
        $statement->bindValue(':variant_id', $variant->getId());
        $statement->bindValue(':product_id', $variant->getProduct());
        $statement->bindValue(':cart_item_price', $variant->getPrice());
        $statement->bindValue(':cart_item_quantity', $quantity);
        try {
            $statement->execute();
            return intval($this->pdo->lastInsertId());
        } catch (PDOException $ex) {
            return false;
        }
    }
    public function findByUserId($id)
    {
        $comand = 'SELECT * FROM cart_items WHERE user_id = :id';
        $statement = $this->pdo->prepare($comand);
        $statement->bindValue(':id', $id);

        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);

        $items = [];
        foreach ($results as $result) {
            $items[] = new CartItem($result);
        }
        return $items;
    }
    public function findByUserAndVariantId($userId, $variantId)
    {
        $comand = 'SELECT * FROM cart_items WHERE user_id = :user_id AND variant_id = :variant_id';
        $statement = $this->pdo->prepare($comand);
        $statement->bindValue(':user_id', $userId);
        $statement->bindValue(':variant_id', $variantId);

        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        if (isset($result[0])) {
            return new CartItem($result[0]);
        }
        return null;
    }

    public function hasItem($variantId, $userId)
    {
        $comand = "SELECT COUNT(*) AS count FROM cart_items 
        WHERE variant_id = :variant_id AND user_id = :user_id LIMIT 1 OFFSET 0";
        $statement = $this->pdo->prepare($comand);
        $statement->bindValue(':variant_id', $variantId);
        $statement->bindValue(':user_id', $userId);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result['count'];
    }
    public function updateCartItem($userId, $itemId, $values)
    {
        $comand = 'UPDATE cart_items SET '
        . DAOUtil::buildUpdateSets($values, self::UPDATE_CART_ITEM)
        . ' WHERE item_id = :item_id AND user_id = :user_id';
        $statement = $this->pdo->prepare($comand);
        foreach ($values as $index => $value) {
            $statement->bindValue($index, $value);
        }
        $statement->bindValue(':item_id', $itemId);
        $statement->bindValue(':user_id', $userId);
        try {
            $statement->execute();
            return $statement->rowCount();
        } catch (PDOException $ex) {
            return false;
        }
    }
    public function deleteById($itemId, $userId)
    {
        $comand = 'DELETE FROM cart_items WHERE item_id = :item_id AND user_id = :user_id';
        $statement = $this->pdo->prepare($comand);
        $statement->bindValue(':item_id', $itemId);
        $statement->bindValue(':user_id', $userId);
        try {
            $statement->execute();
            return $statement->rowCount();
        } catch (PDOException $ex) {
            return false;
        }
    }
}
