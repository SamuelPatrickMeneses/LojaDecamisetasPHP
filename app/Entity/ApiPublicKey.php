<?php

namespace App\Entity;

use Core\DAOs\Entity;
use Core\DAOs\ObjectRelacionalModel;

class ApiPublicKey
{
    private string $text;
    private int $id;
    private $time;

    use Entity;
    public static function getORM(): ObjectRelacionalModel
    {
        if (!isset(ApiPublicKey::$orm)) {
            ApiPublicKey::$orm =  new ObjectRelacionalModel(self::class, 'api_public_key');
            ApiPublicKey::$orm->
                add('id','apk_id', ['increment' => true])->
                add('text', 'apt_text')->
                add('time', 'apk_time')->
                setPrimaryKey('apk_id');
        }
        return ApiPublicKey::$orm;
    }
    public function __construct(array $registry = [])
    {
        $this->construct($this, $registry);
    }
    public function getText()
    {
        return $this->text;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTime()
    {
        return $this->time;
    }
    public function setText(string $text)
    {
        $this->text = $text;
    }

    public function setId(int $id)
    {
        $this->id = $id;
    }

    public function setTime(int | string $time)
    {
        if (is_int($time)) {
            $time = gmdate('Y-m-d H:i:s', $time);
        }
        $this->time = $time;
    }
}
