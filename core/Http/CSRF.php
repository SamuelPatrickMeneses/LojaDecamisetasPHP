<?php

namespace Core\Http;


class CSRF
{
    private static $token;

    public static function getToken()
    {
        if (!isset(self::$token)) {
            self::$token = md5(uniqid());
            $_SESSION['csrf_token'] = self::$token;
        }
        return self::$token;
    }
    public static function validateToken($token)
    {
        if (!isset($_SESSION['csrf_token'])) {
            return false;
        }
        $oldToken = $_SESSION['csrf_token'] ;
        return strcmp($token, $oldToken) === 0;
    }
}
