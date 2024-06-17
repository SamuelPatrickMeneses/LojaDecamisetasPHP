<?php

namespace App\DAOs;

use App\Entity\User;
use App\Exceptions\UserNotExistisException;
use Core\DAOs\BaseDAO;

class UserDAO extends BaseDAO
{
    

    public function __construct()
    {
        parent::__construct(User::getORM());
    }

    public function findUserByEmail(string $email): User
    {
        $user = $this->findByField('email', $email)[0];
        if (isset($user)) {
            return $user;
        }
        throw new UserNotExistisException();
    }
    public function insertUser(User $user)
    {
        $comand = 'insert into users (user_name, user_password, email) values (:user_name, :user_password, :email)';
        $statement = $this->pdo->prepare($comand);
        $this->bindValues($statement,[
            'name' => $user->getName(),
            'password' => $user->getPassword(),
            'email' => $user->getEmail()
        ]);
        return $this->execute($statement);
    }
    public function updateLastLogin($userId, $gmtOfset)
    {
        $timestamp = gmdate('Y-m-d H:i:s');
        return $this->updateByFields(
            ['id' => $userId],
            [
                'lastLogin' => $timestamp,
                'gmtOfset' => $gmtOfset
            ]
        );
    }
}
