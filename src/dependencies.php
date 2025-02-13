<?php
// DIC configuration

$container = $app->getContainer();

// view renderer
$container['renderer'] = function ($c) {
    $settings = $c->get('settings')['renderer'];
    return new Slim\Views\PhpRenderer($settings['template_path']);
};

// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], Monolog\Logger::DEBUG));
    return $logger;
};

//Database
$container['db'] = function ($c){
    $capsule = new \Illuminate\Database\Capsule\Manager;//Inicia objeto

    //Configurações do banco de dados
    $capsule->addConnection($c->get('settings')['db']);

    //Faz ficar visto em todo o projeto
    $capsule->setAsGlobal();

    //Realiza comunicação com o banco de dados
    $capsule->bootEloquent();

    return $capsule;
};
