<?php
/**
 * Created by PhpStorm.
 * User: Berki Tamás
 * Neptun code: PDRE31
 * Date: 2018. 03. 28.
 * Time: 21:35
 */

namespace App\Service;


class TokenService {
    private static $token;

    public static function token(): string {
        if(!self::$token) {
            self::$token = md5(uniqid());
            SessionService::storeElement("token", self::$token);
        }
        return self::$token;
    }

    public static function checkToken(?string $token): bool {
        return ($token && SessionService::getElement("token") == $token);
    }
}