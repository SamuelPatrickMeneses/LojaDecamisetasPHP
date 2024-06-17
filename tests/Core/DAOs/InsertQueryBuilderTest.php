<?php

namespace Tests\Core\DAOs;

use App\DAOs\AddressDAO;
use App\Entity\Address;
use PHPUnit\Framework\TestCase;
use Core\DAOs\QueryBuilder;
use PDOException;

class InsertQueryBuilderTest extends TestCase
{
    public function setup(): void
    {
        $dao = new AddressDAO();
        $addr = new Address([
            #"id" => 2,
            "user" => 1,
            "street" => "visente machado",
            "number" => 128,
            "complement" => NULL,
            "locality" => "centreo",
            "city" => "palmital",
            "region" => "Parana",
            "postalCode" => "85270000",
            "country" => "BR",
            "complement" => "lavacar"
        ]);
        $dao->newAddress($addr);
        $dao->findByFieldLike('number', '128');
        $result = $dao->deleteById(2, fn(PDOException $ex) => var_dump($ex->getMessage()));
    }
    public function testInsert()
    {
        $expect = 'INSERT INTO addresses (user_id, addr_street, addr_number, addr_complement, addr_locality, addr_city, addr_region, addr_postal_code, addr_country) VALUES (:user, :street, :number, :complement, :locality, :city, :region, :postalCode, :country)';
        $result = QueryBuilder::insert(Address::getORM());
        $this->assertEquals($expect, $result->__toString());
    }

    public function testInsertAllc()
    {
        $expect = 'INSERT INTO addresses (addr_id, user_id, addr_street, addr_number, addr_complement, addr_locality, addr_city, addr_region, addr_postal_code, addr_country) VALUES (:id, :user, :street, :number, :complement, :locality, :city, :region, :postalCode, :country)';
        $result = QueryBuilder::insertAll(Address::getORM());
        $this->assertEquals($expect, $result->__toString());
    }
}
