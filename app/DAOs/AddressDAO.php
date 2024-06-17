<?php

namespace App\DAOs;

use App\Entity\Address;
use Core\DB\DBConnectionHolder;
use Core\DAOs\BaseDAO;

class AddressDAO extends BaseDAO
{

    public function __construct()
    {
        parent::__construct(Address::getORM());
        $this->pdo = DBConnectionHolder::getConnection();
    }
    public function newAddress(Address $address)
    {
        return $this->new($address);
    }

    public function findByUserId(int $userId, $callback = null)
    {
        return $this->findByField('user',$userId, $callback);
    }
}
