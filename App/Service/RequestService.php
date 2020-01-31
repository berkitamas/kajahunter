<?php
/**
 * Created by PhpStorm.
 * User: Berki Tamás
 * Neptun code: PDRE31
 * Date: 2018. 03. 28.
 * Time: 21:09
 */

namespace App\Service;


class RequestService {
    public static function exists(string $field): bool {
        return (is_string(self::fetch($field)));
    }

    public static function get(string $field): ?string {
        return (!empty($_GET[$field]))?$_GET[$field]:null;
    }

    public static function post(string $field): ?string {
        return (!empty($_POST[$field]))?$_POST[$field]:null;
    }

    public static function fetch(string $field): ?string {
        if (self::get($field)) {
            return self::get($field);
        }
        elseif (self::post($field)) {
            return self::post($field);
        } else {
            return null;
        }
    }

    public static function getAll(): array {
        return array_merge($_GET, $_POST);
    }
}