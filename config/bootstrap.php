<?php

use Core\Http\RequestFactory;
use Core\Routes\Route;
require_once './constants.php';
session_start();
require_once ROOT_PATH . '/vendor/autoload.php';

require_once ROOT_PATH . '/config/routes.php';
$request = RequestFactory::createRequest();
$rootRoute->action($request);
