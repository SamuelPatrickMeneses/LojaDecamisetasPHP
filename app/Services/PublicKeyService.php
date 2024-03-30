<?php

namespace App\Services;

use App\DAOs\ApiPublicKeyDAO;
use App\Entity\ApiPublicKey;
use App\Exceptions\ENVException;
use Core\TimeUtil;

class PublicKeyService
{
    private $token;
    private $url;
    private ApiPublicKeyDAO $dao;
    const int YEAR_TIME = 31536000000;
    public function __construct()
    {
        $this->token = $_ENV['PAGBANK_API_TOKEN'] | '';
        $this->url = $_ENV['PAGBANK_API'] . '/public-keys'  | '';
        $this->dao = new ApiPublicKeyDAO();
    }
    public function create()
    {
        ENVException::checkEnv('PAGBANK_API_TOKEN');
        ENVException::checkEnv('PAGBANK_API');
        $curl = curl_init();
        curl_setopt_array($curl, [
        CURLOPT_URL => $this->url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => json_encode([
          'type' => 'card'
        ]),
            CURLOPT_HTTPHEADER => [
              "Authorization: Bearer " . $this->token,
              "accept: application/json",
              "content-type: application/json"
            ],
        ]);
        $result = curl_exec($curl);
        curl_close($curl);
        return json_decode($result, true);
    }
    public function change()
    {
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $this->url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "PUT",
            CURLOPT_HTTPHEADER => [
                "Authorization: Bearer " . $this->token,
                "accept: application/json"
            ],
        ]);
        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response, true);
        return $response;
    }
    private function save($response)
    {
        if (isset($response['public_key']) && isset($response['created_at'])) {
            $key = new ApiPublicKey();
            $key->setTime($response['created_at']);
            $key->setText($response['public_key']);
            $this->dao->newKey($key);
            return $key->getText();
        } else {
        }
    }
    public function changeKey()
    {
        $response = $this->change();
        return $this->save($response);
    }
    public function getNewKey()
    {
        $response = $this->create();
        return $this->save($response);
    }
    public function get()
    {
        [$curentKey] = $this->dao->find();
        if (isset($curentKey)) {
            $lifeTime = TimeUtil::now() % TimeUtil::dateTimeToTime($curentKey->getTime());
            if ($lifeTime > PublicKeyService::YEAR_TIME) {
                return $this->changeKey();
            } else {
                return $curentKey->getText();
            }
        } else {
            return $this->getNewKey();
        }
    }
}
