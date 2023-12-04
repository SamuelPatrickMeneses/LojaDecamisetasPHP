<?php

namespace App\Services;

use App\DAOs\AdminDAO;
use App\Exceptions\UserNotExistisException;

class AdminService
{
    private AdminDAO $dao;
    public function __construct()
    {
        $this->dao = new AdminDAO();
    }

    public function authenticate($name, $password)
    {
        try {
            $admin =  $this->dao->findAdminByName($name);
            if (password_verify($password, $admin->getPassword())) {
                $_SESSION['admin'] = [];
                $_SESSION['admin']['id'] = $admin->getId();
                $_SESSION['admin']['name'] = $admin->getName();
                $_SESSION['admin']['password'] = $admin->getPassword();
                $_SESSION['loged'] = true;
                return true;
            } else {
                return false;
            }
        } catch (UserNotExistisException $ex) {
            return false;
        }
    }
    public function logout()
    {
        unset($_SESSION['admin']);
        $_SESSION['loged'] = false;
    }
}
