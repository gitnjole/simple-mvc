<?php

/**Testing purpose file */
include '../../PHP_SHOW_ERR.php';

require_once __DIR__.'/../vendor/autoload.php';

use app\controllers\SiteController;
use app\core\Application;

$app = new Application(dirname(__DIR__));

/**
 * Routes
 */
$app->router->get('/', [SiteController::class, 'home']);

$app->router->get('/features', [SiteController::class, 'features']);

$app->router->get('/form', [SiteController::class, 'form']);
$app->router->post('/form', [SiteController::class, 'formHandler']);
/********************************************************************* */

$app->run();