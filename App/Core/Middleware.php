<?php
/**
 * Created by PhpStorm.
 * User: Berki Tamás
 * Neptun code: PDRE31
 * Date: 2018. 03. 28.
 * Time: 17:23
 */

namespace App\Core;


use App\Core\RoutR;
use Closure;

class Middleware {
    private static $middlewares = [];

    public static function registerMiddleware($label, $class) {
        self::$middlewares[$label] = $class;
    }

    public function callMiddlewareChain(?array $labels, RoutR $router, Closure $next) {
        if (!$labels) $labels = [];
        array_unshift($labels, "csrf");
        $mw_chain = function ($router) use ($next) {
            $next($router);
        };
        $count_labels = count($labels);
        while ($count_labels) {
            $label = $labels[--$count_labels];
            foreach (self::$middlewares as $name => $class) {
                if ($label == $name) {
                    $mw_chain = function ($router) use ($class, $mw_chain) {
                        $class::handle($router, $mw_chain);
                    };
                }
            }
        }
        $mw_chain($router);
    }
}