<?php
if (PHP_SAPI == 'cli-server') {
    // To help the built-in PHP dev server, check if the request was actually for
    // something which should probably be served as a static file
    $file = __DIR__ . $_SERVER['REQUEST_URI'];
    if (is_file($file)) {
        return false;
    }
}

// Variáveis globais para armazenar métricas
$metrics = [
    'total_requests' => 0,
    'requests_by_method' => [], // Inicializa vazio para aceitar qualquer método
    'response_times' => [],
];

require __DIR__ . '/../vendor/autoload.php';

session_start();

// Instantiate the app
$settings = require __DIR__ . '/../src/settings.php';
$app = new \Slim\App($settings);

// Set up dependencies
require __DIR__ . '/../src/dependencies.php';

// Register middleware
require __DIR__ . '/../src/middleware.php';

// Register routes
$container->get('db');//Realiza a conexão com o banco de dados
require __DIR__ . '/../src/routes.php';

// Run app
$app->run();
