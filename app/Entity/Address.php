<?php

namespace App\Entity;

use Core\DAOs\ObjectRelacionalModel;
use Core\DAOs\Entity;
class Address
{
    private $id;
    private $user;
    private $street;
    private $number;
    private $complement;
    private $locality;
    private $city;
    private $region;
    private $postalCode;
    private $country;
    use Entity;
    public static function getORM(): ObjectRelacionalModel
    {
        if (!isset(Address::$orm)) {
            Address::$orm =  new ObjectRelacionalModel(self::class, 'addresses');
            Address::$orm->
                add('id','addr_id', ['increment' => true])->
                add('user', 'user_id')->
                add('street', 'addr_street')->
                add('number', 'addr_number')->
                add('complement', 'addr_complement')->
                add('locality', 'addr_locality')->
                add('city', 'addr_city')->
                add('region', 'addr_region')->
                add('postalCode', 'addr_postal_code')->
                add('country', 'addr_country')
                ->setPrimaryKey('addr_id');
        }
        return Address::$orm;
    }
    public function __construct($registry = [])
    {
        $this->construct($this, $registry);
    }
    
    public function getId()
    {
        return $this->id;
    }
    public function setId($id): self
    {
        $this->id = $id;

        return $this;
    }
    public function getUser()
    {
        return $this->user;
    }
    public function setUser($user): self
    {
        $this->user = $user;

        return $this;
    }
    public function getStreet()
    {
        return $this->street;
    }
    public function setStreet($street): self
    {
        $this->street = $street;

        return $this;
    }
    public function getNumber()
    {
        return $this->number;
    }
    public function setNumber($number): self
    {
        $this->number = $number;

        return $this;
    }
    public function getComplement()
    {
        return $this->complement;
    }
    public function setComplement($complement): self
    {
        $this->complement = $complement;

        return $this;
    }
    public function getLocality()
    {
        return $this->locality;
    }
    public function setLocality($locality): self
    {
        $this->locality = $locality;

        return $this;
    }
    public function getCity()
    {
        return $this->city;
    }
    public function setCity($city): self
    {
        $this->city = $city;

        return $this;
    }
    public function getRegion()
    {
        return $this->region;
    }
    public function setRegion($region): self
    {
        $this->region = $region;

        return $this;
    }
    public function getPostalCode()
    {
        return $this->postalCode;
    }
    public function setPostalCode($postalCode): self
    {
        $this->postalCode = $postalCode;

        return $this;
    }
    public function getCountry()
    {
        return $this->country;
    }
    public function setCountry($country): self
    {
        $this->country = $country;

        return $this;
    }
}
