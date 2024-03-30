<?php

namespace App\DAOs;

use App\Entity\ApiPublicKey;
use Core\DAOs\DAOUtil;
use Core\DB\DBConnectionHolder;
use PDO;
use PDOException;

class ApiPublicKeyDAO
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = DBConnectionHolder::getConnection();
    }

    public function find($pageZise = 0, $pageNumber = 1)
    {
        $comand = 'SELECT * FROM api_public_key ';
        $comand .= DAOUtil::buildPagination($pageZise, $pageNumber);
        $statement = $this->pdo->prepare($comand);
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        $keys = [];
        foreach ($results as $result) {
            $keys[] = new ApiPublicKey($result);
        }
        return $keys;
    }
    public function newKey(ApiPublicKey $key)
    {
        $comand = 'INSERT INTO api_public_key (apk_text, apk_time)
        VALUES (:apk_text, :apk_time)';
        $statement = $this->pdo->prepare($comand);

        $statement->bindValue(':apk_text', $key->getText());
        $statement->bindValue(':apk_time', $key->getTime());
        try {
            $statement->execute();
            return true;
        } catch (PDOException $ex) {
            var_dump($ex->getMessage());
            return false;
        }
    }
}
