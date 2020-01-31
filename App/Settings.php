<?php
/**
 * Created by PhpStorm.
 * User: Berki Tamás
 * Neptun code: PDRE31
 * Date: 2018. 03. 30.
 * Time: 21:30
 */

namespace App;


class Settings {
    private static $settings;
    public static function get(string $field) {
        return self::$settings[$field];
    }

    public static function set(string $field, $value) {
        self::$settings[$field] = $value;
    }
}