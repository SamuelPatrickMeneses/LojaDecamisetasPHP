<?php

namespace App\Services;

use App\DAOs\AddressDAO;
use App\Entity\Address;

class AddressService
{
    private AddressDAO $dao;

    public function __construct()
    {
        $this->dao = new AddressDAO();
    }
    public function getById($id)
    {
        return $this->dao->findById($id);
    }
    public function getByUser($id)
    {
        return $this->dao->findByUserId($id);
    }
    public function delete($id)
    {
        return $this->dao->deleteById($id);
    }
    public function create($user, $street, $number, $complement, $locality, $city, $region, $postalCode, $country)
    {
        $address = new Address();
        $address->setUser($user);
        $address->setStreet($street);
        $address->setNumber($number);
        $address->setComplement($complement);
        $address->setLocality($locality);
        $address->setCity($city);
        $address->setRegion($region);
        $address->setPostalCode($postalCode);
        $address->setCountry($country);
        return $this->dao->newAddress($address);
    }
}