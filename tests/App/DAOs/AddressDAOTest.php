<?php

namespace Tests\Core\DAOs;

use App\DAOs\AddressDAO;
use App\Entity\Address;
use Tests\DBTestCase;

class AddressDAOTest extends DBTestCase
{
    private AddressDAO $dao;
    private Address $addr;
    public function setUp(): void
    {
        parent::setUp();
        $this->dao = new AddressDAO();
        $this->addr = new Address([
            #"id" => 2,
            "user" => 1,
            "street" => "machado",
            "number" => 128,
            "complement" => NULL,
            "locality" => "centreo",
            "city" => "altamira",
            "region" => "Para",
            "postalCode" => "85270000",
            "country" => "BR",
            "complement" => "sfsdf"
        ]);
       # $dao->newAddress($addr);
       # $dao->findByfieldLike('number', '128');
       # $result = $dao->deleteById(2, fn(PDOException $ex) => var_dump($ex->getMessage()));
    }
    public function testFind()
    {
        $result = $this->dao->findByUserId(1);
        $this->assertEquals(1, $result[0]->getId());
    }
    public function testNotFound()
    {
        $result = $this->dao->findByUserId(10);
        $this->assertEmpty($result);
    }
    public function testDeletebyId()
    {
        $this->dao->deleteById(1);
        $result = $this->dao->find();
        $this->assertEquals(0, count($result));
    }
    public function testNew()
    {
        $this->dao->new($this->addr);
        $result = $this->dao->find();
        $this->assertEquals(2, count($result));
    }
   # public function testInsertAllc()
   # {
   # }
}
