<?php
include_once ROOT_PATH . '/config/adminRoutes.php';
use App\Filters\Config\OutputBufferizedFilter;
use App\Filters\Security\CSRFFilter;
use Core\Routes\Route;
$rootRoute = new Route;
$rootRoute->putErrorController('not_found', [App\Controllers\NotFoundController::class,'index']);
$rootRoute->use(OutputBufferizedFilter::class);
$rootRoute->use(CSRFFilter::class);
$rootRoute->setSubRoute($adminRoutes,'/admin');
$rootRoute->get('/login', [App\Controllers\LoginController::class, 'index']);
$rootRoute->post('/login', [App\Controllers\LoginController::class, 'post']);
$rootRoute->get('/logout', [App\Controllers\LogoutController::class, 'index']);
$rootRoute->get('/signingup', [App\Controllers\SigningUpController::class, 'index']);
$rootRoute->post('/signingup', [App\Controllers\SigningUpController::class, 'post']);
$rootRoute->get('/home',[App\Controllers\ProductController::class, 'index']);
$rootRoute->get('/product/:id',[App\Controllers\ProductController::class, 'index']);