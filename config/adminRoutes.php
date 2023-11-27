<?php

use Core\Routes\Route;

$adminRoutes = new Route();
$adminRoutes->get('/login', [App\Controllers\Admin\AdminLoginController::class, 'index']);
$adminRoutes->post('/login', [App\Controllers\Admin\AdminLoginController::class, 'post']);
$adminRoutes->delete('/image/:id', [App\Controllers\Admin\AdminImageController::class, 'delete']);
$adminRoutes->get('/home', [App\Controllers\Admin\AdminHomeController::class, 'index']);
$adminRoutes->post('/home', [App\Controllers\Admin\AdminHomeController::class, 'post']);
$adminRoutes->get('/products', [App\Controllers\Admin\AdminProductController::class, 'index']);
$adminRoutes->get('/products/edit/:id', [App\Controllers\Admin\AdminProductController::class, 'index']);
$adminRoutes->patch('/products/edit/:id', [App\Controllers\Admin\AdminProductController::class, 'edit']);
$adminRoutes->get('/products/create', [App\Controllers\Admin\AdminProductController::class, 'index']);
$adminRoutes->post('/products', [App\Controllers\Admin\AdminProductController::class, 'post']);
$adminRoutes->get('/productVariants',[App\Controllers\Admin\AdminProductVariantController::class, 'index']);
$adminRoutes->get('/productVariants/:id',[App\Controllers\Admin\AdminProductVariantController::class, 'index']);
$adminRoutes->post('/productVariants',[App\Controllers\Admin\AdminProductVariantController::class, 'post']);
$adminRoutes->patch('/productVariants/:id',[App\Controllers\Admin\AdminProductVariantController::class, 'edit']);