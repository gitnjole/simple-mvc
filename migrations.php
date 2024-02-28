<?php

use gitnjole\simplemvc\Application;

require_once __DIR__.'/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$config = [
    'db' => [
        'DSN' => $_ENV['DB_DSN'],
        'USERNAME' => $_ENV['DB_USER'],
        'PASSWORD' => $_ENV['DB_PASSWORD']
    ]
    ];

$app = new Application(__DIR__, $config);

$app->db->applyMigrations();