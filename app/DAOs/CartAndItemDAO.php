<?php

namespace App\DAOs;

use App\Entity\CartItem;
use App\Entity\ProductVariant;
use Core\DAOs\BaseDAO;
use Core\DAOs\PaginationExpression;
use Core\DAOs\QueryBuilder;

class CartAndItemDAO extends BaseDAO
{
    public function __construct()
    {
        parent::__construct(CartItem::getORM());
    }
    public function newCart($userId)
    {
        $comand = QueryBuilder::insert($this->orm)->
            addColumn('user_id', 'user');
        $statement = $this->pdo->prepare($comand);
        $statement->bindValue(':user_id', $userId);
        return $this->execute($statement);
    }
    public function newCartItem(int $userId, int $quantity, ProductVariant  $variant)
    {
        return $this->new([
            'user' => $userId,
            'quantity' => $quantity,
            'varinat' => $variant->getId()

        ]) ;
    }
    public function findByUserId($id)
    {
        return $this->findByField('user', $id);
    }
    public function findByUserAndVariantId($userId, $variantId): CartItem | null
    {
        return $this->findByFields(
            [
                'user' => $userId,
                'variant' => $variantId
            ], 
            null,
            1,
            0
        )[0];
    }

    public function hasItem($variantId, $userId)
    {
        $comand = QueryBuilder::count(CartItem::getORM())->
            byField('user')->
            byField('variant')->
            setPagination(new PaginationExpression(1, 0));
        $statement = $this->pdo->prepare($comand);
        $this->bindValues($statement, [
            'variant' => $variantId,
            'user' => $userId
        ]);
        return $statement->execute();
    }
    public function updateCartItem($userId, $itemId, $values)
    {
        return $this->updateByFields([
            'user' => $userId,
            'item' => $itemId
        ],
        $values);
    }
    public function deleteByIds($itemId, $userId)
    {
        $comand = QueryBuilder::delete(CartItem::getORM()) ->
            byId()->
            byField('user');
        $statement = $this->pdo->prepare($comand);
        $this->bindValues($statement, [
            'id' => $itemId,
            'user' => $userId
        ]);
        return $this->executeAndCount($statement);
    }
}
