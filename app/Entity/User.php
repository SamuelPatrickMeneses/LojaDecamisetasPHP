<?php

namespace App\Entity;

class User
{
    private $id;
    private $name;
    private $password;
    private $email;
    private $phone;
    private $notfy;
    private $lastLogin;

    public function __construct(array $registry = [])
    {
        if(count($registry) > 0 ) {
            $this->setId($registry['user_id']);
            $this->setName($registry['user_name']);
            $this->setPassword($registry['user_password']);
            $this->setEmail($registry['email']);
            $this->setPhone($registry['phone']);
            $this->setNotfy($registry['notfy']);
            $this->setLastLogin($registry['last_login']);   
        }
    }
    
    public function getId()
    {
        return $this->id;
    }
    public function getName()
    {
        return $this->name;
    }
    public function getPassword()
    {
        return $this->password;
    }
    public function getEmail()
    {
        return $this->email;
    }
    public function getPhone()
    {
        return $this->phone;
    }
    public function getNotfy()
    {
        return $this->notfy;
    }
    public function getLastLogin()
    {
        return $this->lastLogin;
    }
    public function setId($id)
    {
        return $this->id = $id;
    }
    public function setName($name)
    {
        return $this->name = $name;
    }
    public function setPassword($password)
    {
        $this->password = $password;
    }
    public function setEmail($email)
    {
        return $this->email = $email;
    }
    public function setPhone($phone)
    {
        return $this->phone = $phone;
    }
    public function setNotfy($notfy)
    {
        return $this->notfy = $notfy;
    }
    public function setLastLogin($lastLogin)
    {
        return $this->lastLogin = $lastLogin;
    }
}
