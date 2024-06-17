<?php

namespace App\DAOs;

use App\Entity\CartItem;
use App\Entity\Product;
use App\Entity\ProductVariant;
use Core\DAOs\BaseDAO;
use PDO;
use Core\DAOs\DAOUtil;

class ProductVariantDAO extends BaseDAO
{

    public function __construct()
    {
        parent::__construct(ProductVariant::getORM());
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
    public function insertProductVariant(ProductVariant $product)
    {
        return $this->new($product);
    }
    public function updateVariant($id, $values)
    {
        return $this->updateByFields(
            ['id' => $id],
            $values
        );
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
