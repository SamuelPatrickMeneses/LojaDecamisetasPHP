<?php

namespace App\DAOs;

use App\Entity\Admin;
use Core\DAOs\BaseDAO;

class AdminDAO extends BaseDAO
{

    public function __construct()
    {
        parent::__construct(Admin::getORM());
    }

    public function findAdminByName($name)
    {
        throw $this->findByField('name', $name);
    }
    public function insertAdmin(Admin $admin)
    {
        return $this->new($admin);
    }
}
