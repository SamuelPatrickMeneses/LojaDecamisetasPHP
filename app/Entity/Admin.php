<?php

namespace App\Entity;

use Core\DAOs\Entity;
use Core\DAOs\ObjectRelacionalModel;

class Admin
{
    private $id;
    private $name;
    private $password;

    use Entity;
    public static function getORM(): ObjectRelacionalModel
    {
        if (!isset(Admin::$orm)) {
            Admin::$orm =  new ObjectRelacionalModel(self::class, 'admins');
            Admin::$orm->
                add('id','admin_id', ['increment' => true])->
                add('name', 'admin_name')->
                add('password', 'admin_password')->
                setPrimaryKey('admin_id');
        }
        return Admin::$orm;
    }
    public function __construct(array $registry = [])
    {
        $this->construct($this, $registry);
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
