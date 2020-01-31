<?php
/**
 * Created by PhpStorm.
 * User: Berki Tamás
 * Neptun code: PDRE31
 * Date: 2018. 03. 28.
 * Time: 16:32
 */

namespace App\Middleware;


use App\Core\RoutR;
use App\Service\RequestService;
use App\Service\TokenService;
use Closure;

class CSRFMiddleware {
    public static function handle(RoutR $router, Closure $next): ?Closure {
        if ($router->getRequestMethod() != "GET") {
            if (!TokenService::checkToken(RequestService::fetch("token"))) {
                $router->callErrorPage(400);
                return null;
            }
        }
        return $next($router);
    }
}