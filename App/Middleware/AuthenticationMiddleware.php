<?php
/**
 * Created by PhpStorm.
 * User: Berki Tamás
 * Neptun code: PDRE31
 * Date: 2018. 03. 28.
 * Time: 16:48
 */

namespace App\Middleware;


use App\Core\RoutR;
use Closure;

class AuthenticationMiddleware {
    public static function handle(RoutR $router, Closure $next) {
        return $next($router);
    }
}