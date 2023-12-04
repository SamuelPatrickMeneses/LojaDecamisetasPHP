<?php

namespace App\Services;

use App\DAOs\CartAndItemDAO;
use App\DAOs\UserDAO;
use App\Entity\User;
use App\Exceptions\UserNotExistisException;
use Core\DAOs\DAOUtil;

class UserService
{
    private UserDAO $dao;
    private CartAndItemDAO $cartDAO;
    public function __construct()
    {
        $this->dao = new UserDAO();
        $this->cartDAO = new CartAndItemDAO();
    }

    public function authenticate($email, $password, $gmtOfset)
    {
        try {
            $user =  $this->dao->findUserByEmail($email);
            if (password_verify($password, $user->getPassword())) {
                $_SESSION['user'] = [];
                $_SESSION['user']['id'] = $user->getId();
                $_SESSION['user']['name'] = $user->getName();
                $_SESSION['user']['phone'] = $user->getPhone();
                $_SESSION['user']['email'] = $user->getEmail();
                $_SESSION['loged'] = true;
                $this->dao->updateLastLogin($user->getId(), $gmtOfset);
                return true;
            } else {
                return false;
            }
        } catch (UserNotExistisException $ex) {
            return false;
        }
    }
    public function signingUp($email, $password, $name)
    {
        $opttions = [
            'cost' => 10
        ];
        $user = new User();
        $user->setEmail($email);
        $user->setPassword(password_hash($password, PASSWORD_BCRYPT, $opttions));
        $user->setName($name);
        DAOUtil::beginTransactionIfEnable();
        $id = $this->dao->insertUser($user);
        $this->cartDAO->newCart($id);
        DAOUtil::commitIfEnable();
        return true;
    }
    public function logout()
    {
        unset($_SESSION['user']);
        $_SESSION['loged'] = false;
    }
}
