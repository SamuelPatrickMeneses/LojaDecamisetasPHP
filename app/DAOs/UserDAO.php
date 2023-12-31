<?php

namespace App\DAOs;

use App\Entity\User;
use App\Exceptions\UserNotExistisException;
use Core\DB\DBConnectionHolder;
use PDO;
use PDOException;
use PDOStatement;

class UserDAO
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = DBConnectionHolder::getConnection();
    }

    public function findUserByEmail($email)
    {
        $statemant = $this->pdo->prepare('select * from users where email = :email');
        $statemant->bindParam(':email', $email);

        $statemant->execute();
        $result = $statemant->fetchAll(PDO::FETCH_ASSOC);

        if (isset($result[0])) {
            return new User($result[0]);
        }
        throw new UserNotExistisException();
    }
    public function insertUser(User $user)
    {
        $comand = 'insert into users (user_name, user_password, email) values (:user_name, :user_password, :email)';
        $statement = $this->pdo->prepare($comand);

        $statement->bindValue(':user_name', $user->getName());
        $statement->bindValue(':user_password', $user->getPassword());
        $statement->bindValue(':email', $user->getEmail());

        try {
            $statement->execute();
            return true;
        } catch (PDOException $ex) {
            return false;
        }
    }
    public function updateLastLogin($userId, $gmtOfset)
    {
        $timestamp = gmdate('Y-m-d H:i:s');
        $comand = 'update users set last_login = :last_login, gmt_ofset = :gmt_ofset where user_id = :id';
        $statement = $this->pdo->prepare($comand);
        $statement->bindValue(':id', $userId);
        $statement->bindValue(':last_login', $timestamp);
        $statement->bindValue(':gmt_ofset', $gmtOfset);
        try {
            $statement->execute();
            return true;
        } catch (PDOException $ex) {
            return false;
        }
    }
}
