<?php

use App\Filters\Config\OutputBufferizedFilter;
use App\Filters\Security\CheckAdminAuthenticationFilter;
use App\Filters\Security\CSRFFilter;
use Core\Routes\Route;

$adminRoutes = new Route();

$adminRoutes->putErrorController('not_found', [App\Controllers\NotFoundController::class,'index']);
$adminRoutes->use(OutputBufferizedFilter::class);
$adminRoutes->use(CSRFFilter::class);
$adminRoutes->get('/login', [App\Controllers\Admin\AdminLoginController::class, 'index']);
$adminRoutes->get('/logout', [App\Controllers\Admin\AdminLoginController::class, 'index']);
$adminRoutes->post('/login', [App\Controllers\Admin\AdminLoginController::class, 'post']);
$adminRoutes->delete('/image/:id', [App\Controllers\Admin\AdminImageController::class, 'delete']);
$adminRoutes->get('/home', [App\Controllers\Admin\AdminHomeController::class, 'index']);
$adminRoutes->get('/', [App\Controllers\Admin\AdminHomeController::class, 'index']);
$adminRoutes->post('/home', [App\Controllers\Admin\AdminHomeController::class, 'post']);
$adminRoutes->get('/products', [App\Controllers\Admin\AdminProductController::class, 'index']);
$adminRoutes->get('/products/:id', [App\Controllers\Admin\AdminProductController::class, 'index']);
$adminRoutes->patch('/products/:id', [App\Controllers\Admin\AdminProductController::class, 'edit']);
$adminRoutes->get('/products/create', [App\Controllers\Admin\AdminProductController::class, 'index']);
$adminRoutes->post('/products', [App\Controllers\Admin\AdminProductController::class, 'post']);
$adminRoutes->get('/productVariants',[App\Controllers\Admin\AdminProductVariantController::class, 'index']);
$adminRoutes->get('/productVariants /:variantId',[App\Controllers\Admin\AdminProductVariantController::class, 'index']);
$adminRoutes->post('/productVariants',[App\Controllers\Admin\AdminProductVariantController::class, 'post']);
$adminRoutes->patch('/productVariants/:variantId',[App\Controllers\Admin\AdminProductVariantController::class, 'edit']);
$adminFilter = new CheckAdminAuthenticationFilter(['GET', 'POST', 'PATCH', 'DELETE']);
$adminRoutes->use($adminFilter, '/logout');
$adminRoutes->use($adminFilter, '/image');
$adminRoutes->use($adminFilter, '/home');
$adminRoutes->use($adminFilter, '/products');
$adminRoutes->use($adminFilter, '/productVariants');
