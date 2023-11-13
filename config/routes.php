<?php

use App\Filters\Config\OutputBufferizedFilter;
use App\Filters\Security\CSRFFilter;
use Core\Routes\Route;
$rootRoute = new Route;
$rootRoute->putErrorController('not_found', [App\Controllers\NotFoundController::class,'index']);
$rootRoute->use(OutputBufferizedFilter::class);
$rootRoute->use(CSRFFilter::class);
$rootRoute->get('/login', [App\Controllers\LoginController::class, 'index']);
$rootRoute->post('/login', [App\Controllers\LoginController::class, 'post']);
$rootRoute->get('/logout', [App\Controllers\LogoutController::class, 'index']);
$rootRoute->get('/signingup', [App\Controllers\SigningUpController::class, 'index']);
$rootRoute->post('/signingup', [App\Controllers\SigningUpController::class, 'post']);
$rootRoute->get('/admin/login', [App\Controllers\AdminLoginController::class, 'index']);
$rootRoute->post('/admin/login', [App\Controllers\AdminLoginController::class, 'post']);