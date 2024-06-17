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
    public function create(
        int $user,
        string $street,
        $number, string
        $complement,
        string $locality,
        string $city,
        string $region,
        string $postalCode,
        string $country)
    {
        $address = new Address(compact(
            'user',
            'street',
            'number',
            'complement',
            'locality',
            'city',
            'region',
            'postalCode',
            'country'
        ));
        return $this->dao->newAddress($address);
    }
}
