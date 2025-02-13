<?php
//ob_start(); // Inicia o buffer de saída
use Slim\Http\Request;
use Slim\Http\Response;
//Chama arquivo Controller
require "../App/Controllers/TaskControllers.php";
use App\Controllers\TaskController;

//Inicia Controller
$Task = new TaskController();

// Routes

//Agrupa rotas para versão 1 da API
$app->group('/api/v1', function() use ($Task) { 

    //---------MÉTODOS GET:
    // Recupera todas as task criadas, sejam completas ou não
    $this->get('/task', function ($request, $response) use ($Task) {
        return $Task->getTask($request, $response);
    });

    //---------MÉTODOS POST:
    // Cria uma nova lista de Task
    $this->post("/task", function ($request, $response, $args) use ($Task) {
        return $Task->createTask($request, $response, $args);
    });

    //---------MÉTODOS PUT:
    // Atualiza uma tarefa existente
    $this->put("/task/{id}", function ($request, $response, $args) use ($Task) {
        return $Task->updateTask($request, $response, $args);
    });

    //---------MÉTODOS DELETE:
    // Deleta uma tarefa
    $this->delete("/task/{id}", function ($request, $response, $args) use ($Task) {
        return $Task->deleteTask($request, $response, $args);
    });

    //---------MÉTODOS PATCH:
    // Lista uma tarefa como completa
    $this->patch("/task/{id}/complete", function ($request, $response, $args) use ($Task) {
        return $Task->completeTask($request, $response, $args);
    });
});