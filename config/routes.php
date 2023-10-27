<?php

use Core\Routes\Route;
$rootRoute = new Route;
$rootRoute->putErrorController('not_found', [App\Controllers\NotFoundController::class,'index']);