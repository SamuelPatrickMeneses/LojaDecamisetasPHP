<?php

namespace App\DAOs;

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
    public function newImage($name, $file, $variantId, $productId)
    {
        $comand = 'INSERT INTO images (image_name, image_file, variant_id, product_id) VALUES (:image_name, :image_file, :variant_id, :product_id)';
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
    public function findByProductId($id)
    {
        $comand = 'SELECT * FROM images WHERE product_id = :id';
        $statement = $this->pdo->prepare($comand);
        $statement->bindValue(':id', $id);

        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);

        $images = [];
        foreach ($results as $result) {
            $images[] = new Image($result);
        }
        return $images;
    }
    public function findByProductVariatId($id)
    {
        $comand = 'SELECT * FROM images WHERE variant_id = :id';
        $statement = $this->pdo->prepare($comand);
        $statement->bindValue(':id', $id);

        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);

        $images = [];
        foreach ($results as $result) {
            $images[] = new Image($result);
        }
        return $images;
    }
    public function fatchProductImages(Product $product)
    {
        $images = $this->findByProductId($product->getId());
        $product->setImages($images);
        return $product;
    }
    public function fatchProductVariantImages(ProductVariant $product)
    {
        $images = $this->findByProductVariatId($product->getId());
        $product->setImages($images);
        return $product;
    }
}