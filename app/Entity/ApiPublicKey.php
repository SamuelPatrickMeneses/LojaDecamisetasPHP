<?php

namespace App\Entity;

class ApiPublicKey
{
    private string $text;
    private int $id;
    private $time;

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
