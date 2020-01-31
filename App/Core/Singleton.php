<?php
/**
 * Created by PhpStorm.
 * User: Berki Tamás
 * Neptun code: PDRE31
 * Date: 2018. 03. 26.
 * Time: 22:51
 */

namespace App\Core;


trait Singleton {
    private static $instance = false;
    final public static function getInstance() {
        if (self::$instance === false) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    final private function __construct() {
        $this->init();
    }

    protected function init() {}

    final private function __wakeup() {}
    final private function __clone() {}
}