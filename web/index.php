<?php

/**Testing purpose file */
/* include '../PHP_SHOW_ERR.php'; */

require_once __DIR__.'/../vendor/autoload.php';
use app\core\Application;

$app = new Application(dirname(__DIR__));

$app->router->get('/', 'home');
$app->router->get('/features', 'features');


$app->run();