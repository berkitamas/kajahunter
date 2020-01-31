<?php
/**
 * Created by PhpStorm.
 * User: Berki Tamás
 * Neptun code: PDRE31
 * Date: 2018. 03. 01.
 * Time: 15:09
 */


use App\Core\RoutR;

RoutR::get("/", 'RootController@index');
RoutR::get("/bejelentkezes", 'AuthenticationController@authenticate');
RoutR::post("/bejelentkezes", 'AuthenticationController@login(email, password, rememberme)');
RoutR::get("/regisztracio", 'AuthenticationController@register');
RoutR::post("/regisztracio", 'AuthenticationController@store(regtype)');
RoutR::get("/etterem", 'RestaurantController@list');
RoutR::get("/etterem/{id}", 'RestaurantController@restaurantDetails');
RoutR::get("/megrendelesek", 'OrderController@list');
RoutR::error(404, 'ErrorController@error_404');