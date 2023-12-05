<?php

namespace App\Entity;

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

    public function __construct($registry = [])
    {
        if (isset($registry)) {
            $this->setId($registry['addr_id']);
            $this->setUser($registry['user_id']);
            $this->setStreet($registry['addr_street']);
            $this->setNumber($registry['addr_number']);
            $this->setComplement($registry['addr_complement']);
            $this->setLocality($registry['addr_lacality']);
            $this->setCity($registry['addr_city']);
            $this->setRegion($registry['addr_region']);
            $this->setPostalCode($registry['addr_postal_code']);
            $this->setCountry($registry['addr_contry']);
        }
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