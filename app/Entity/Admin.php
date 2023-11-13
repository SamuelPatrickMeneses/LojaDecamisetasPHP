<?php

namespace App\Entity;

class Admin
{
    private $id;
    private $name;
    private $password;
   

    public function __construct(array $registry = [])
    {
        if (count($registry) > 0) {
            $this->setId($registry['admin_id']);
            $this->setName($registry['admin_name']);
            $this->setPassword($registry['admin_password']);
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
    
    public function setId($id)
    {
        $this->id = $id;
    }
    public function setName($name)
    {
        $this->name = $name;
    }
    public function setPassword($password)
    {
        $this->password = $password;
    }
}
