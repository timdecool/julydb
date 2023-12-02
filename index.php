<?php
namespace App;
session_start();

// Imports nécessaires
use App\Services\Router;
require_once './autoloader.php';

// Détermination de la route ?page
$router = new Router();
$page = $router->run();