<?php
use Src\Router;
use Src\Controllers\UserController;

require __DIR__ . '/../src/Router.php';
require __DIR__ . '/../src/Controllers/UserController.php';



header('Content-Type: application/json');

$router = new Router();
$userController = new UserController();

// Definisi route TANPA nama folder proyek
$router->add('GET', '/api/v1/users', [$userController, 'index']);
$router->add('GET', '/api/v1/users/1',fn() =>$userController->show(1));

$router->run();
