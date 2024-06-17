<?php

namespace App\Entity;

use Core\DAOs\Entity;
use Core\DAOs\ObjectRelacionalModel;

class User
{
    private $id;
    private $name;
    private $password;
    private $email;
    private $phone = '';
    private $notfy = 0;
    private string $lastLogin;
    private $gmtOfset;

    use Entity;
    public static function getORM(): ObjectRelacionalModel
    {
        if (!isset(self::$orm)) {
            self::$orm =  new ObjectRelacionalModel(self::class, 'users');
            self::$orm->
                add('id','user_id', ['increment' => true])->
                add('name', 'user_name')->
                add('password', 'user_password')->
                add('email', 'email')->
                add('phone', 'phone')->
                add('notify', 'notify')->
                add('lastLogin', 'last_login')->
                add('gmtOfset', 'gmt_ofset')->
                setPrimaryKey('user_id');
        } 
        return self::$orm;
    }
    public function __construct(array $registry = [])
    {
        $this->construct($this, $registry);
    }

    public function getId()
    {
        return $this->id;
    }
    public function getGmtOfset()
    {
        return $this->gmtOfset;
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
    public function setEmail($email)
    {
        $this->email = $email;
    }
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }
    public function setNotfy($notfy)
    {
        $this->notfy = $notfy;
    }
    public function setLastLogin($lastLogin)
    {
        $this->lastLogin = $lastLogin;
    }
    public function setGmtOfset($gmtOfset)
    {
        $this->gmtOfset = $gmtOfset;
    }
}
