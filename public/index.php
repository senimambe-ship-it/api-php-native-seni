<?php
require_once __DIR__ . '/../src/Router.php';
require_once __DIR__ . '/../src/Controllers/UserController.php';

use Src\Router;
use Src\Controllers\UserController;

header('Content-Type: application/json');

$router = new Router();
$userController = new UserController();

// Definisi route TANPA nama folder proyek
$router->add('GET', '/api/v1/users', [$userController, 'index']);
$router->add('GET', '/api/v1/users/{id}', [$userController, 'show']);

$router->run();
