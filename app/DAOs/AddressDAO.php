<?php

namespace App\DAOs;

use App\Entity\Address;
use Core\DB\DBConnectionHolder;
use PDO;
use PDOException;
use PDOStatement;

class AddressDAO
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = DBConnectionHolder::getConnection();
    }
    public function newAddress(Address $address)
    {
        $comand = "INSERT INTO addresses
        (user_id,
        addr_street,
        addr_number,
        addr_complement,
        addr_locality,
        addr_city,
        addr_region,
        addr_postal_code,
        addr_country) VALUES
        (:user_id,
        :addr_street,
        :addr_number,
        :addr_complement,
        :addr_locality,
        :addr_city,
        :addr_region,
        :addr_postal_code,
        :addr_country)";
        $statement = $this->pdo->prepare($comand);

        $statement->bindValue(':user_id', $address->getId());
        $statement->bindValue(':addr_street', $address->getStreet());
        $statement->bindValue(':addr_number', $address->getNumber());
        $statement->bindValue(':addr_complement', $address->getComplement());
        $statement->bindValue(':addr_locality', $address->getLocality());
        $statement->bindValue(':addr_city', $address->getCity());
        $statement->bindValue(':addr_region', $address->getRegion());
        $statement->bindValue(':addr_postal_code', $address->getPostalCode());
        $statement->bindValue(':addr_country', $address->getCountry());

        try {
            $statement->execute();
            return $this->pdo->lastInsertId();
        } catch (PDOException $ex) {
            return false;
        }
    }

    public function findByUserId($userId)
    {
        $comand = "SELECT * FROM addresses WHERE user_id = :user_id";
        $statement = $this->pdo->prepare($comand);

        $statement->bindValue(':user_id', $userId);
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        $products = [];
        foreach ($results as $result) {
            $products[] = new Address($result);
        }
        return $products;
    }
    public function findById($id)
    {
        $comand = "SELECT * FROM addresses WHERE addr_id = :addr_id";
        $statement = $this->pdo->prepare($comand);

        $statement->bindValue(':addr_id', $id);
        try {
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            if (isset($result[0])) {
                return new Address($result[0]);
            }
            return null;
        } catch (PDOException $ex) {
            return null;
        }
    }
    public function deleteById($id)
    {
        $comand = 'DELETE FROM addresses WHERE addr_id = :addr_id';
        $statement = $this->pdo->prepare($comand);
        $statement->bindValue(':addr_id', $id);
        try {
            $statement->execute();
            return true;
        } catch (PDOException $ex) {
            return false;
        }
    }
}
