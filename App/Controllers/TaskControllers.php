<?php
/*
==================================================
FONTE: Task
TIPO: Controller
DESCRIÇÃO: Fonte responsável por Agrupar operações sobre a tarefa
PROGRAMADOR(A): Ighor Drummond
DATA: 12/02/2025
==================================================
*/

/*
==================================================
Namespace: App\Controllers
Descrição: Responsável por agrupar a classe de operações com tarefas
Programador(a): Ighor Drummond
Data: 12/02/2025
==================================================
Modificações:
@ Data - Descrição - Programador(a)
*/
namespace App\Controllers{
    require 'Components/Connection.php';
    use Connection\Connection;
    use Slim\Http\Request;
    use Slim\Http\Response;
    use App\Models\Task;

    /*
    ==================================================
    Classe: Task
    Extend: Connection
    Descrição: Responsável por realizar operações CRUD de tarefas
    Programador(a): Ighor Drummond
    Data: 12/02/2025
    ==================================================
    Modificações:
    @ Data - Descrição - Programador(a)
    */
    class TaskController extends Connection{
        //Constantes
        const KEYS = ['name_task', 'description_task'];//Pode adicionar mais campos caso forem obrigatórios


        public function __construct(
        ){
            //Realiza conexão com o banco de dados
            parent::__construct();
        }

        //Getters
        /*
        ==========================================
        MÉTODO: getTask()
        PARÂMETROS: $request (Request) Responsável por requisições da API / $response (Response) - Responsável por montar o cabeçalho da resposta 
        DESCRIÇÃO: Monta o cabeçalho da resposta com os headers necessários para a API
        RETORNO: Response
        PRIVADO: Sim
        DATA: 12/02/2025 
        PROGRAMADOR(A): Ighor Drummond
        ==========================================~
        Modificações:
        @ Data - Descrição - Programador(a)
        */
        public function getTask($request = null, $response = null, array $args = []){
            //Log de registro
            $this->Log("INFO", "Recuperando dados do banco de dados na Rota GET /task");

            //Pesquisa todos os registro na tabela
            $ListTask = Task::where('actived', true)->get()->toArray();
            
            //Log de registro
            $this->Log("INFO", "Retornado dados!");

            //Retorna dados pesquisado no banco de dados
            return $this->withApiHeaders($response)->withJson(["error" => false, "message" => "Dados recuperados com sucesso!", "data" => $ListTask]);
        }

        /*
        ==========================================
        MÉTODO: createTask()
        PARÂMETROS: $request (Request) Responsável por requisições da API / $response (Response) - Responsável por montar o cabeçalho da resposta 
        DESCRIÇÃO: Cria nova tarefa no banco de dados
        RETORNO: Response
        PRIVADO: Não
        DATA: 12/02/2025 
        PROGRAMADOR(A): Ighor Drummond
        ==========================================~
        Modificações:
        @ Data - Descrição - Programador(a)
        */
        public function createTask($request, $response, $args){
            //Puxa dados enviados pelo Client
            $dados = $request->getParsedBody();

            //Sanatiza dados
            forEach(self::KEYS as $k){

                //Valida se tem os campos obrigatórios
                if(!isset($dados[$k]) || empty($dados[$k])) return $this->withApiHeaders($response, 403)->withJson(['error' => true, "message" => "Falta Campo $k Obrigatório!"]);

                //Sanatiza dados
                $dados[$k] = $this->SanatizaDados($dados[$k]);
            }

            //Cria o novo registro
            $task = Task::create([
                'name_task' => $dados['name_task'],
                'description_task' => $dados['description_task'] ? $dados['description_task'] :  "",
                'completed' => isset($dados['completed']) ? $dados['completed'] : false,
            ]);

            //Valida se houve com sucesso a inclusão de dados
            if(!$task || !$task->id){
                //Registra Log de Erro
                $this->Log("ERROR", "NÃO FOI POSSÍVEL SALVAR NOVA TAREFA NO BANCO DE DADOS.");
                //Retorna erro ao client
                return $this->withApiHeaders($response, 501)->withJson(['error'=> true,'message'=> 'Não foi possível criar uma nova tarefa devido a uma inconsistência interna. Tente novamente ou mais tarde.']);
            }   
                
            //Retorna Json de sucesso
            return $this->withApiHeaders($response)->withJson(['error'=> false,'message'=> 'Tarefa Adicionada com sucesso!', 'data'=> ['id' => $task->id]]);
        }

        /*
        ==========================================
        MÉTODO: createTask()
        PARÂMETROS: $request (Request) Responsável por requisições da API / $response (Response) - Responsável por montar o cabeçalho da resposta 
        DESCRIÇÃO: Atualiza uma tarefa no banco de dados
        RETORNO: Response
        PRIVADO: Não
        DATA: 13/02/2025 
        PROGRAMADOR(A): Ighor Drummond
        ==========================================~
        Modificações:
        @ Data - Descrição - Programador(a)
        */
        public function updateTask($request, $response, $args){
            //Valida se passou o ID 
            $id = isset($args['id']) ? $args['id'] : "";

            //Recebe dados do corpo
            $data = $request->getParsedBody();

            //Valida se o campo ID está vázio
            if(empty($id)) return $this->withApiHeaders($response, 403)->withJson(['error' => true, "message" => "ID da tarefa não foi passado."]);

            //Sanatiza dados
            $id = $this->SanatizaDados($id);  

            //Validar campos obrigatórios e sanatizar dados
            forEach(self::KEYS as $key){
                //Sanatiza dados
                isset($data[$key]) ? $data[$key] = $this->SanatizaDados($data[$key]) : null;
            }

            //Pesquisar a tarefa
            $task = Task::find($id);

            //Valida se teve retorno
            if(!$task) return $this->withApiHeaders($response, 403)->withJson(["error"=> true, "message"=> "Tarefa não existe."]);

            //Prepara dados para atualização
            $dados = [
                'name_task' => isset($data['name_task']) ? $data['name_task'] : $task->name_task,
                'description_task' => isset($data['description_task']) ? $data['description_task'] : $task->description_task,
                'complete'=> isset($data['complete']) and is_bool($data['complete']) ? $data['complete'] : $task->complete
            ];

            //Valida se teve sucesso ao atualizar
            if(!$task->update($dados)) return $this->withApiHeaders($response, 403)->withJson(["error"=> true, "message"=> "Não foi possível atualizar tarefa devido a uma inconsistência interna. Tente novamente ou mais tarde."]);

            //Retorna Json de sucesso
            return $this->withApiHeaders($response)->withJson(['error'=> false,'message'=> 'Tarefa Atualizada com sucesso!']);
        }


        /*
        ==========================================
        MÉTODO: deleteTask()
        PARÂMETROS: $request (Request) Responsável por requisições da API / $response (Response) - Responsável por montar o cabeçalho da resposta 
        DESCRIÇÃO: deleta uma tarefa no banco de dados
        RETORNO: Response
        PRIVADO: Não
        DATA: 13/02/2025 
        PROGRAMADOR(A): Ighor Drummond
        ==========================================~
        Modificações:
        @ Data - Descrição - Programador(a)
        */
        public function deleteTask($request, $response, $args){
            //Valida se passou o ID 
            $id = isset($args['id']) ? $args['id'] : "";

            //Valida se o campo ID está vázio
            if(empty($id)) return $this->withApiHeaders($response, 403)->withJson(['error' => true, "message" => "ID da tarefa não foi passado."]);

            //Sanatiza dados
            $id = $this->SanatizaDados($id);  

            //Pesquisar a tarefa
            $task = Task::where('id', $id)->first();

            //Valida se teve retorno
            if(!$task) return $this->withApiHeaders($response, 403)->withJson(["error"=> true, "message"=> "Tarefa não existe."]);

            //Valida se teve sucesso ao atualizar
            if(!$task->update(['actived' => false])) return $this->withApiHeaders($response, 403)->withJson(["error"=> true, "message"=> "Não foi possível deletar tarefa $id devido a uma inconsistência interna. Tente novamente ou mais tarde."]);

            //Retorna Json de sucesso
            return $this->withApiHeaders($response)->withJson(['error'=> false,'message'=> 'Tarefa Deletada com sucesso!', 'data' => ['id'=> $task->id]]);  
        }

        /*
        ==========================================
        MÉTODO: completeTask()
        PARÂMETROS: $request (Request) Responsável por requisições da API / $response (Response) - Responsável por montar o cabeçalho da resposta 
        DESCRIÇÃO: completa uma tarefa no banco de dados
        RETORNO: Response
        PRIVADO: Não
        DATA: 13/02/2025 
        PROGRAMADOR(A): Ighor Drummond
        ==========================================~
        Modificações:
        @ Data - Descrição - Programador(a)
        */
        public function completeTask($request, $response, $args){
            //Valida se passou o ID 
            $id = isset($args['id']) ? $args['id'] : "";

            //Valida se o campo ID está vázio
            if(empty($id)) return $this->withApiHeaders($response, 403)->withJson(['error' => true, "message" => "ID da tarefa não foi passado."]);

            //Sanatiza dados
            $id = $this->SanatizaDados($id);  

            //Pesquisar a tarefa
            $task = Task::find($id);

            //Valida se teve retorno
            if(!$task) return $this->withApiHeaders($response, 403)->withJson(["error"=> true, "message"=> "Tarefa não existe."]);

            //Valida se teve sucesso ao atualizar
            if(!$task->update(['complete' => true])) return $this->withApiHeaders($response, 403)->withJson(["error"=> true, "message"=> "Não foi possível atualizar tarefa devido a uma inconsistência interna. Tente novamente ou mais tarde."]);

            //Retorna Json de sucesso
            return $this->withApiHeaders($response)->withJson(['error'=> false,'message'=> 'Tarefa Atualizada com sucesso!']);
        }

        /*
        ==========================================
        MÉTODO: SanatizaDados
        PARÂMETROS: $dados (indefinido) - Dado para ser sanatizado
        DESCRIÇÃO: Sanatiza dados para evitar ataques XSS no sistema
        RETORNO: Varios - mixed
        PRIVADO: Sim
        DATA: 12/02/2025 
        PROGRAMADOR(A): Ighor Drummond
        ==========================================~
        Modificações:
        @ Data - Descrição - Programador(a)
        */
        private function SanatizaDados($dados){
            //Sanatiza dados de acordo com seu tipo
            if (is_int($dados)) {
                return filter_var($dados, FILTER_VALIDATE_INT);
            } elseif (is_float($dados)) {
                return filter_var($dados, FILTER_VALIDATE_FLOAT);
            } elseif (is_string($dados)) {
                return filter_var($dados, FILTER_SANITIZE_STRING);
            } elseif (is_array($dados)) {
                return filter_var($dados, FILTER_SANITIZE_STRING);
            } elseif (is_object($dados)) {
                return filter_var($dados, FILTER_SANITIZE_STRING);
            } elseif (is_bool($dados)) {
                return filter_var($dados, FILTER_VALIDATE_BOOLEAN);
            } else {
                return $dados; // Retorna o dado original se não for possível sanatizar
            }
        }
    }
}