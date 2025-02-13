<?php

use PHPUnit\Framework\TestCase;
use Slim\App;
use Slim\Container;
use App\Controllers\TaskController;

class TaskControllerTest extends TestCase
{
    private $app;
    private $container;

    protected function setUp()
    {
        // Configuração inicial do Slim app e container
        $this->container = new Container();
        $this->app = new App($this->container);

        // Defina as rotas que você quer testar
        $this->app->get('/task', function ($request, $response) {
            return $response->withJson(['message' => 'Teste']);
        });
    }

    public function testGetTask()
    {
        // Crie um request e execute o app
        $response = $this->app->handle(
            \Slim\Http\Request::createFromEnvironment(new \Slim\Http\Environment($_SERVER))
        );

        // Verifique se o status da resposta está correto
        $this->assertEquals(200, $response->getStatusCode());

        // Verifique se o conteúdo da resposta está correto
        $this->assertJsonStringEqualsJsonString(
            json_encode(['message' => 'Teste']),
            $response->getBody()->__toString()
        );
    }
}
