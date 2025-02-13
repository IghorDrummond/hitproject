<?php
//Valida se estiver sendo executado em servidor, rodar em linha de comando
if (PHP_SAPI !== 'cli') {
    exit("Rodar via CLI");
}

//Carrega autoload
require __DIR__ . '/vendor/autoload.php';

// Instantiate the app
$settings = require __DIR__ . '/src/settings.php';
$app = new \Slim\App($settings);

// Set up dependencies
require __DIR__ . '/src/dependencies.php';

//Recupera container de Database
$db = $container->get('db');

//Cria tabela abaixo
$schema = $db->schema();

//Valida se a tabela já existe
$schema->dropIfExists('tasks');

//Cria tabela tasks com os campos listados
$schema->create('tasks', function($table){
    $table->id();
    $table->string('name_task', 50)->default('');
    $table->text('description_task')->nullable();
    $table->boolean('complete')->default(false);
    $table->boolean('actived')->default(true);
    $table->timestamp('created_at')->useCurrent();
    $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
});