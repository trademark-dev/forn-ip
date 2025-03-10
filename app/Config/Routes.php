<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\Frontend\AuthenticationController;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'frontend\AuthenticationController::index');
$routes->get('/login', 'frontend\AuthenticationController::login');
$routes->post('/do-register', 'frontend\AuthenticationController::store');
$routes->post('/do-login', 'frontend\AuthenticationController::doLogin');

$routes->get('/forget-password', 'frontend\AuthenticationController::forgetPassword');
$routes->post('/do-forget-password', 'frontend\AuthenticationController::doForgetPassword');