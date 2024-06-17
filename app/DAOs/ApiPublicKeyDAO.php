<?php

namespace App\DAOs;

use App\Entity\ApiPublicKey;
use Core\DAOs\BaseDAO;

class ApiPublicKeyDAO extends BaseDAO
{
    public function __construct()
    {
        parent::__construct(ApiPublicKey::getORM());
    }
   # public function find($pageZise = 0, $pageNumber = 1)
   # {
   #     $comand = 'SELECT * FROM api_public_key ';
   #     $comand .= DAOUtil::buildPagination($pageZise, $pageNumber);
   #     $statement = $this->pdo->prepare($comand);
   #     $statement->execute();
   #     $results = $statement->fetchAll(PDO::FETCH_ASSOC);
   #     $keys = [];
   #     foreach ($results as $result) {
   #         $keys[] = new ApiPublicKey($result);
   #     }
   #     return $keys;
   # }
    public function newKey(ApiPublicKey $key, $callback = null)
    {
        return $this->new($key, $callback);
    }
}
