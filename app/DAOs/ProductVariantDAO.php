<?php

namespace App\DAOs;

use App\Entity\CartItem;
use App\Entity\Grid;
use App\Entity\Product;
use App\Entity\ProductVariant;
use Core\DB\DBConnectionHolder;
use PDO;
use PDOException;
use Core\DAOs\DAOUtil;

class ProductVariantDAO
{
    private $pdo;
    private const UPDATE_PROPS = [
        'grid' => 'grid_id',
        'StockQuantity' => 'stock_quantity',
        'price' => 'price',
        'status' => 'variant_status'
    ];

    public function __construct()
    {
        $this->pdo = DBConnectionHolder::getConnection();
    }
    public function populateProduct(Product $product, $pageZise = 0, $pageNumber = 1)
    {
        $comand = 'SELECT grid_id, price, variant_id, product_id, stock_quantity, grid_label, variant_status
        FROM product_variants JOIN grids using(grid_id) WHERE product_id = :id ';
        $comand .= DAOUtil::buildPagination($pageZise, $pageNumber);
        $statement = $this->pdo->prepare($comand);
        $statement->bindValue(':id', $product->getId());

        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        $variants = [];
        foreach ($results as $result) {
            $variants[] = new ProductVariant($result);
        }
        $product->setVariants($variants);
    }
    public function findById($id): ProductVariant | null
    {
        $comand = 'SELECT * FROM product_variants WHERE variant_id = :variant_id ';
        $statement = $this->pdo->prepare($comand);
        $statement->bindValue(':variant_id', $id);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        if (isset($result[0])) {
            return new ProductVariant($result[0]);
        }
        return null;
    }
    public function insertProductVariant(ProductVariant $product)
    {
        $comand = 'INSERT INTO product_variants (stock_quantity, price, grid_id, product_id, variant_status)
        VALUES (:stock_quantity, :price, :grid_id, :product_id, 1)';
        $statement = $this->pdo->prepare($comand);

        $statement->bindValue(':stock_quantity', $product->getStockQantity());
        $statement->bindValue(':price', $product->getPrice());
        var_dump($product->getGrid());
        $statement->bindValue(':grid_id', $product->getGrid());
        $statement->bindValue(':product_id', $product->getProduct());
        try {
            $statement->execute();
            return intval($this->pdo->lastInsertId());
        } catch (PDOException $ex) {
            return false;
        }
    }
    public function updateVariant($id, $values)
    {
        $comand = 'UPDATE product_variants SET '
        . DAOUtil::buildUpdateSets($values, self::UPDATE_PROPS)
        . ' WHERE variant_id = :variant_id ';
        $statement = $this->pdo->prepare($comand);
        foreach ($values as $index => $value) {
            $statement->bindValue($index, $value);
        }
        $statement->bindValue(':variant_id', $id);
        try {
            $statement->execute();
            return true;
        } catch (PDOException $ex) {
            return false;
        }
    }
    public function populateCartItem(CartItem $item)
    {
        $comand = 'SELECT grid_id, price, variant_id, product_id, stock_quantity, grid_label, variant_status
        FROM product_variants JOIN grids using(grid_id) WHERE variant_id = :id ';
        $statement = $this->pdo->prepare($comand);
        $statement->bindValue(':id', $item->getVariant());
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        if (isset($result[0])) {
            $item->setVariant(new ProductVariant($result[0]));
        }
        return $item;
    }
}
