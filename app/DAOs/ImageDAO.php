<?php

namespace App\DAOs;

use App\Entity\CartItem;
use App\Entity\Image;
use App\Entity\Product;
use App\Entity\ProductVariant;
use Core\DB\DBConnectionHolder;
use PDO;
use PDOException;

class ImageDAO
{
    private $pdo;
    public function __construct()
    {
        $this->pdo = DBConnectionHolder::getConnection();
    }
    public function newImage($name, $file, $productId, $variantId)
    {
        $comand = "INSERT INTO images (image_name, image_file, variant_id, product_id)
        VALUES (:image_name, :image_file, :variant_id, :product_id)";
        $statement = $this->pdo->prepare($comand);
        $statement->bindValue(':image_name', $name);
        $statement->bindValue(':image_file', $file);
        $statement->bindValue(':variant_id', $variantId);
        $statement->bindValue(':product_id', $productId);
        try {
            $statement->execute();
            return intval($this->pdo->lastInsertId());
        } catch (PDOException $ex) {
            return false;
        }
    }
    public function findById($id)
    {
        $comand = 'SELECT * FROM images WHERE image_id = :id';
        $statement = $this->pdo->prepare($comand);
        $statement->bindValue(':id', $id);

        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        if (isset($result[0])) {
            return new Image($result[0]);
        }
        return null;
    }
    public function deleteById($id)
    {
        $comand = 'DELETE FROM images WHERE image_id = :id';
        $statement = $this->pdo->prepare($comand);
        $statement->bindValue(':id', $id);
        try {
            $statement->execute();
            return true;
        } catch (PDOException $ex) {
            return false;
        }

        return null;
    }
    public function populateCartItem(CartItem $item)
    {
        $image = $this->findOneByProductId($item->getProduct());
        $item->setImage($image);
        return $item;
    }
    public function populateProduct(Product $product)
    {
        $images = $this->findByProductId($product->getId());
        $product->setImages($images);
    }

    public function findByProductId($id)
    {
        $comand = 'SELECT * FROM images WHERE product_id = :product_id';
        $statement = $this->pdo->prepare($comand);
        $statement->bindValue(':product_id', $id);

        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);

        $images = [];
        foreach ($results as $result) {
            $images[] = new Image($result);
        }
        return $images;
    }
    public function findOneByProductId($id)
    {
        $comand = 'SELECT * FROM images WHERE product_id = :id LIMIT 1 OFFSET 0';
        $statement = $this->pdo->prepare($comand);
        $statement->bindValue(':id', $id);

        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        if ($results[0]) {
            return new Image($results[0]);
        }
        return null;
    }
    public function populateProductVariat(ProductVariant $variant)
    {
        $comand = 'SELECT * FROM images WHERE variant_id = :variant_id ';//AND product_id = :product_id';
        $statement = $this->pdo->prepare($comand);
        $statement->bindValue(':variant_id', $variant->getId());
        //$statement->bindValue(':product_id', $variant->getProduct());
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        $images = [];
        foreach ($results as $result) {
            $images[] = new Image($result);
        }
        $variant->setImages($images);
    }
}
