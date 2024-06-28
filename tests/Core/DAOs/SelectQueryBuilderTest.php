<?php

namespace Tests\Core\DAOs;

use App\Entity\Address;
use PHPUnit\Framework\TestCase;
use Core\DAOs\QueryBuilder;
use Core\DAOS\ObjectRelacionalModel;

class SelectQueryBuilderTest extends TestCase
{
    public function testFind()
    {
        $expect = 'SELECT addr_id AS id, user_id AS user, addr_street AS street, addr_number AS number, addr_complement AS complement, addr_locality AS locality, addr_city AS city, addr_region AS region, addr_postal_code AS postalCode, addr_country AS country FROM addresses';
        $result = QueryBuilder::find(Address::getORM());
        $this->assertEquals($expect, $result->__toString());
    }

    public function testFindById()
    {
        $expect = 'SELECT addr_id AS id, user_id AS user, addr_street AS street, addr_number AS number, addr_complement AS complement, addr_locality AS locality, addr_city AS city, addr_region AS region, addr_postal_code AS postalCode, addr_country AS country FROM addresses WHERE addr_id = :id';
        $result = QueryBuilder::find(Address::getORM())->byId();
        $this->assertEquals($expect, $result->__toString());
    }
}
