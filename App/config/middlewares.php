<?php
/**
 * Created by PhpStorm.
 * User: Berki Tamás
 * Neptun code: PDRE31
 * Date: 2018. 03. 28.
 * Time: 18:32
 */

use App\Core\Middleware;

Middleware::registerMiddleware("csrf", \App\Middleware\CSRFMiddleware::class);
Middleware::registerMiddleware("auth", \App\Middleware\AuthenticationMiddleware::class);
