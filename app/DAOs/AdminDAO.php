<?php

namespace App\DAOs;

use App\Entity\Admin;
use App\Entity\User;
use App\Exceptions\UserNotExistisException;
use Core\DB\DBConnectionHolder;
use PDO;
use PDOException;
use PDOStatement;

class AdminDAO
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = DBConnectionHolder::getConnection();
    }

    public function findAdminByName($name)
    {
        $statemant = $this->pdo->prepare('select * from admins where admin_name = :name');
        $statemant->bindParam(':name', $name);

        $statemant->execute();
        $result = $statemant->fetchAll(PDO::FETCH_ASSOC);

        if (isset($result[0])) {
            return new Admin($result[0]);
        }
        throw new UserNotExistisException();
    }
    public function insertAdmin(Admin $admin)
    {
        $comand = 'INSERT INTO admins (admin_name, admin_password) VALUES (:admin_name, :admin_password)';
        $statement = $this->pdo->prepare($comand);

        $statement->bindValue(':admin_name', $admin->getName());
        $statement->bindValue(':admin_password', $admin->getPassword());

        try {
            $statement->execute();
            return true;
        } catch (PDOException $ex) {
            return false;
        }
    }
}
