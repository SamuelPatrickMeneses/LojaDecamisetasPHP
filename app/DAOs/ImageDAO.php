<?php

namespace App\DAOs;

use App\Entity\CartItem;
use App\Entity\Image;
use App\Entity\Product;
use App\Entity\ProductVariant;
use Core\DAOs\BaseDAO;
use Core\DAOs\PaginationExpression;
use Core\DAOs\QueryBuilder;

class ImageDAO extends BaseDAO
{
    public function __construct()
    {
        parent::__construct(Image::getORM());  
    }
    public function newImage(string $name, string $file, int $product, int $productVariant)
    {
        $comand =  QueryBuilder::insert($this->orm);
        $statement = $this->pdo->prepare($comand);
        $this->bindNew($statement, compact(
            'name', 'file', 'product',
            'productVariant'
        ));
        return $this->execute($statement);
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

    public function findByProductId(int $id)
    {
        return $this->findByField('product', $id);
    }
    public function findOneByProductId($product)
    {
        $comand = QueryBuilder::find($this->orm)->
            byField('product')->
            setPagination(new PaginationExpression(1, 0));
        $statement = $this->pdo->prepare($comand);
        $statement->bindValue(':product', $product);
        return $this->fetchOne($statement);
    }
    public function populateProductVariat(ProductVariant $variant)
    {
        $images = $this->findByField('productVariant', $variant->getId());
        $variant->setImages($images);
        return $variant;
    }
}
