<?php

/**Testing purpose file */
include '../PHP_SHOW_ERR.php';

require_once __DIR__.'/../vendor/autoload.php';
use app\core\Application;

$app = new Application();

$app->router->get('/', function(){
    return 'Home Page';
});

$app->run();