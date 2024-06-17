<?php

namespace App\DAOs;

use App\Entity\Grid;
use App\Entity\ProductVariant;
use Core\DAOs\BaseDAO;
use Core\DAOs\QueryBuilder;
use PDO;

class GridDAO extends BaseDAO
{
    public function __construct()
    {
        parent::__construct(Grid::getORM());
    }
    public function getColorList()
    {
        $comand = 'SELECT grid_color FROM grids GROUP BY grid_color';
        $statement = $this->pdo->prepare($comand);
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC) ?? [];
        $colorNumber = count($results);
        for ($i = 0; $i < $colorNumber; $i++) {
            $results[$i] = $results[$i]['grid_color'];
        }
        return $results;
    }
    public function newColor($color)
    {
        $comand = "INSERT INTO grids (grid_size, grid_color, grid_gender, grid_label) VALUES 
            ('PPP', '$color', 'M', 'PPP/$color/M'),
            ('PP' , '$color', 'M', 'PP/$color/M'),
            ('P'  , '$color', 'M', 'P/$color/M'),
            ('M'  , '$color', 'M', 'M/$color/M'),
            ('G'  , '$color', 'M', 'G/$color/M'),
            ('2G' , '$color', 'M', '2G/$color/M'),
            ('3G' , '$color', 'M', '3G/$color/M'),
            ('4G' , '$color', 'M', '4G/$color/M'),
            ('PPP', '$color', 'F', 'PPP/$color/F'),
            ('PP' , '$color', 'F', 'PP/$color/F'),
            ('P'  , '$color', 'F', 'P/$color/F'),
            ('M'  , '$color', 'F', 'M/$color/F'),
            ('G'  , '$color', 'F', 'G/$color/F'),
            ('2G' , '$color', 'F', '2G/$color/F'),
            ('3G' , '$color', 'F', '3G/$color/F'),
            ('4G' , '$color', 'F', '4G/$color/F')";
        $statement = $this->pdo->prepare($comand);
        return $this->execute($statement);
    }
    public function findByLabel($size = null, $color = null, $gender = null)
    {
        $label = ($size ?? '%') . '/' . ($color ?? '%') . '/' . ($gender ?? '%');
        $comand = QueryBuilder::find($this->orm)->
           byFieldLike('label') . 'SELECT * FROM grids WHERE grid_label like :label';
        $statement = $this->pdo->prepare($comand);
        $statement->bindParam(':label', $label);
        return $this->fetch($statement);
    }
    public function populateProductVariant(ProductVariant $productVariant)
    {
        $result = $this->findById($productVariant->getGrid());
        $productVariant->setGrid($result);
        return $productVariant;
    }
}
