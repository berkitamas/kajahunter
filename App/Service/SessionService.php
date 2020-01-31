<?php
/**
 * Created by PhpStorm.
 * User: Berki Tamás
 * Neptun code: PDRE31
 * Date: 2018. 03. 28.
 * Time: 16:31
 */

namespace App\Service;


class SessionService {

    public static function storeElement($field, $value): void {
        $_SESSION[$field] = $value;
    }

    public static function getElement($field) {
        return (!empty($_SESSION[$field]))?$_SESSION[$field]:null;
    }

    public static function destroyElement($field): void {
        unset($_SESSION[$field]);
    }

    public static function hasElement($field): bool {
        return !empty($_SESSION[$field]);
    }

    public static function init(): void {
        session_start();
    }

    public static function destroy(): void {
        session_destroy();
    }

    public static function flash($name, $string = '') {
        if(self::hasElement($name)) {
            $elem = self::getElement($name);
            self::destroyElement($name);
            return $elem;
        } else {
            if (empty($string)) {
                return null;
            } else {
                self::storeElement($name, $string);
            }
        }
    }
}