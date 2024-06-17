<?php

namespace App\DAOs;

use App\Entity\CartItem;
use App\Entity\Product;
use Core\DAOs\BaseDAO;
use Core\DAOs\PaginationExpression;

class ProductDAO extends BaseDAO
{

    public function __construct()
    {
        parent::__construct(Product::getORM());
    }
    public function findProductsByTitle($title, $pageZise = 0, $pageNumber = 1)
    {
        return $this->findByField('title', $title, null, $pageZise, $pageNumber);
    }
    public function findProductsByTitleWithOneImage($title, $pageZise = 0, $pageNumber = 1)
    {
        $pagination = new PaginationExpression($pageZise, $pageNumber);
        $comand = "SELECT
        product_id,
        product_title,
        product_description,
        product_price,
        product_status,
        MIN(image_file) AS image_file
        FROM products JOIN images using(product_id)
        WHERE MATCH (product_title) AGAINST (:title)
        GROUP BY product_id $pagination";
        $statement = $this->pdo->prepare($comand);
        $statement->bindValue(':title', $title);
        return $this->fetch($statement);
    }
    public function findAll($pageZise = 0, $pageNumber = 1)
    {
        return $this->find(null, $pageZise, $pageNumber);
    }
    public function findAllWithOneImage($pageSise = 0, $pageNumber = 1)
    {
        $pagination = new PaginationExpression($pageSise, $pageNumber);
        $comand = "SELECT
        product_id,
        product_title,
        product_description,
        product_price,
        product_status,
        MAX(image_file) AS image_file
        FROM products RIGHT JOIN images using(product_id)
        GROUP BY product_id $pagination";
        $statement = $this->pdo->prepare($comand);
        return $this->fetch($statement, null, $pageSise, $pageNumber);
    }
    public function insertProduct(Product $product)
    {
        return $this->new($product);
    }
    public function updateProduct($id, $values)
    {
        return $this->updateByFields(
            ['id' => $id],
            $values
        );
    }
    public function populateCartItem(CartItem $item)
    {
        $product = $this->findById($item->getProduct());
        $item->setProduct($product);
    }
}
