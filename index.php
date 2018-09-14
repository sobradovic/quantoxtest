<?php

session_start();

require_once __DIR__ . '/vendor/autoload.php';

$router = new \App\Http\Router();

$router->register('GET', '/', '\App\Http\Controllers\Controller@home');
$router->register('GET', '/login', '\App\Http\Controllers\Controller@login');
$router->register('GET', '/register', '\App\Http\Controllers\Controller@register');
$router->register('POST', '/results', '\App\Http\Controllers\Controller@results');

$router->register('POST', '/register', '\App\Http\Controllers\UserController@register');
$router->register('POST', '/login', '\App\Http\Controllers\UserController@login');


$router->dispatch();
