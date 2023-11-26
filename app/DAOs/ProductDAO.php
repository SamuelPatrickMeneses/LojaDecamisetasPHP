<?php

namespace App\DAOs;

use App\Entity\Product;
use App\Entity\ProductVariant;
use Core\DB\DBConnectionHolder;
use PDO;
use PDOException;
use Core\DAOs\DAOUtil;

class ProductDAO
{
    private $pdo;
    private const updateProps = [
        'title' => 'product_title',
        'description' => 'product_description',
        'price' => 'product_price',
        'status' => 'product_status'
    ];

    public function __construct()
    {
        $this->pdo = DBConnectionHolder::getConnection();
    }
    public function findById($id)
    {
        $comand = 'SELECT * FROM products WHERE product_id = :id';
        $statement = $this->pdo->prepare($comand);
        $statement->bindParam(':id', $id);

        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        if (isset($result[0])) {
            return new Product($result[0]);
        }
        return null;
    }
    public function count()
    {
        $comand = 'SELECT COUNT(*) FROM products';
        $statement = $this->pdo->prepare($comand);

        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        if (isset($result[0])) {
            return $result[0]['COUNT(*)'];
        }
        return null;
    }
    public function findProductsByTitle($title, $pageZise = 0, $pageNumber = 1)
    {
        $comand = 'SELECT * FROM products WHERE MATCH (product_title) AGAINST (:title)';
        $comand .= DAOUtil::buildPagination($pageZise, $pageNumber);
        $statement = $this->pdo->prepare($comand);
        $statement->bindParam(':title', $title);

        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        $products = [];
        foreach ($results as $result) {
            $products[] = new Product($result);
        }
        return $products;
    }
    public function findAll($pageZise = 0, $pageNumber = 1)
    {
        $comand = 'SELECT * FROM products ';
        $comand .= DAOUtil::buildPagination($pageZise, $pageNumber);
        $statement = $this->pdo->prepare($comand);
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        $products = [];
        foreach ($results as $result) {
            $products[] = new Product($result);
        }
        return $products;
    }
    public function findAllWithOneImage($pageZise = 0, $pageNumber = 1)
    {
        $comand = 'SELECT  product_id, product_title, product_description, product_price, product_status, image_file FROM products RIGHT JOIN images using(product_id) ';
        $comand .= DAOUtil::buildPagination($pageZise, $pageNumber);
        $statement = $this->pdo->prepare($comand);
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        $products = [];
        foreach ($results as $result) {
            $products[] = new Product($result);
        }
        return $products;
    }
    public function insertProduct(Product $product)
    {
        $comand = 'INSERT INTO products (product_title, product_description, product_price, product_status) VALUES (:product_title, :product_description, :product_price, 1)';
        $statement = $this->pdo->prepare($comand);

        $statement->bindValue(':product_title', $product->getTitle());
        $statement->bindValue(':product_description', $product->getDescription());
        $statement->bindValue(':product_price', $product->getPrice());

        try {
            $statement->execute();
            return true;
        } catch (PDOException $ex) {
            var_dump($ex->getMessage());
            return false;
        }
    }
    public function updateProduct($id, $values)
    {
        $comand = 'UPDATE products SET ' . DAOUtil::buildUpdateSets($values, self::updateProps) . ' WHERE product_id = :id';
        $statement = $this->pdo->prepare($comand);
        foreach ($values as $index => $value) {
            $statement->bindValue($index, $value);
        }
        $statement->bindValue(':id', $id);
        try {
            $statement->execute();
            return true;
        } catch (PDOException $ex) {
            return false;
        }
    }
    public function fetchProductByVariant(ProductVariant $variant)
    {
        $product = $this->findById($variant->getProduct());
        $product->setVariants($product);
    }
}