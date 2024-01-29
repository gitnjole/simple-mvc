<?php

/**Testing purpose file */
include '../../DUMP.php';
include '../../PHP_SHOW_ERR.php';

use app\controllers\SiteController;
use app\controllers\AuthController;
use app\core\Application;

require_once __DIR__.'/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

$config = [
    'db' => [
        'DSN' => $_ENV['DB_DSN'],
        'USERNAME' => $_ENV['DB_USER'],
        'PASSWORD' => $_ENV['DB_PASSWORD']
    ]
    ];

$app = new Application(dirname(__DIR__), $config);

//Routes
$app->router->get('/', [SiteController::class, 'home']);

$app->router->get('/features', [SiteController::class, 'features']);

$app->router->get('/form', [SiteController::class, 'form']);
$app->router->post('/form', [SiteController::class, 'formHandler']);

$app->router->get('/login', [AuthController::class, 'login']);
$app->router->post('/login', [AuthController::class, 'login']);
$app->router->get('/register', [AuthController::class, 'register']);
$app->router->post('/register', [AuthController::class, 'register']);
/********************************************************************* */

$app->run();