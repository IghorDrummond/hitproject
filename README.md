# Slim Framework 3 Skeleton

Este é um projeto baseado no Slim Framework 3, um micro-framework PHP para desenvolvimento de APIs e aplicações web. Este README fornece instruções detalhadas sobre como configurar e executar o projeto, além de documentação completa das rotas da API.

---

## Passo 1 – Configuração do Ambiente

### Usando XAMPP

1. **Extraia o projeto**: Extraia o projeto na pasta `htdocs` do XAMPP.
2. **Configure o Apache**: Abra o arquivo `httpd.conf` do XAMPP e aponte a raiz do documento para a pasta `public` do projeto. Por exemplo:
   ```apache
   DocumentRoot "C:/xampp/htdocs/meu-projeto/public"
   <Directory "C:/xampp/htdocs/meu-projeto/public">

3. **Reinicie o Apache**: Reinicie o servidor Apache para aplicar as alterações.

### Usando Servidor PHP Interno

1. **Extraia o projeto**: Extraia o projeto: Extraia o projeto em uma pasta segura.

2. **Acesse a pasta public**: Abra o terminal e navegue até a pasta public do projeto.

3. **Inicie o servidor PHP**: Execute o seguinte comando para iniciar o servidor PHP:

#### php -S localhost:8000

Certifique-se de que a porta 8000 não esteja sendo usada por outra aplicação.

### Usando Docker
1. **Extraia o projeto**: Extraia o projeto em uma pasta segura.

2. **Configure o Docker**: Certifique-se de que o Docker está instalado e funcionando corretamente.

3. **Inicie os contêineres**: Execute o comando docker-compose up para iniciar os contêineres do PHP e MySQL.

## Passo 2 – Configuração do Banco de Dados

1. **Acesse o arquivo settings.php:** Localize o arquivo settings.php na pasta src do projeto.

2. **Configure as credenciais do banco de dados**: No array db, insira as credenciais do seu banco de dados MySQL. Exemplo:

'db' => [
    'driver' => 'mysql',
    'host' => 'localhost',
    'database' => 'if0_38309993_taskdb',
    'username' => 'if0_38309993',
    'password' => 'KGuSM1kERST',
    'charset' => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix' => '',
],

Nota: Se estiver usando Docker com uma porta customizada, use 'host' => 'localhost:porta'.

## Passo 3 – Criação da Tabela Task
1. **Acesse a pasta raiz do projeto**: Abra o terminal e navegue até a pasta raiz do projeto.

2. **Execute o script de banco de dados**: Execute o seguinte comando para criar a tabela Task automaticamente:

#### php db.php

Aguarde o carregamento. Se houver inconsistências, revise as credenciais do banco de dados no Passo 2.

## Passo 4 – Consumindo a API

Agora que o projeto está configurado, você pode começar a consumir as rotas da API. Abaixo está a documentação completa das rotas disponíveis:

### URL Base
**Local**: https://localhost:porta-definida/api/v1/

**Online**: https://hitproject.rf.gd/public/api/v1/

---

## Rotas da API

### Criar uma Tarefa

**Método**: POST

**URL**: https://localhost:porta-definida/api/v1/task

**Corpo da Requisição (Body)**:
{
    "name_task": "Mercado",          // OBRIGATÓRIO
    "description_task": "Realizar compras no mercado", // OBRIGATÓRIO
    "complete": false                // OPCIONAL
}

**Retorno**:
{
    "error": false,
    "message": "Tarefa Adicionada com sucesso!",
    "data": {
        "id": 1
    }
}

### Recuperar Todas as Tarefas

**Método**: GET

**URL**: https://localhost:porta-definida/api/v1/task

**Retorno**:
{
    "error": false,
    "message": "Dados recuperados com sucesso!",
    "data": [
        {
            "id": 1,
            "name_task": "Mercado 3",
            "description_task": "Realizar compras no mercado 3",
            "complete": 0,
            "actived": 1,
            "created_at": "2025-02-13T18:06:45.000000Z",
            "updated_at": "2025-02-13T18:06:45.000000Z"
        }
    ]
}

### Atualizar uma Tarefa

**Método**: PUT

**URL**: https://localhost:porta-definida/api/v1/task/:idDaTarefa

**Corpo da Requisição (Body)**:
{
    "name_task": "Mercado 3",          // OPCIONAL
    "description_task": "Realizar compras no mercado 3", // OPCIONAL
    "complete": 0,                     // OPCIONAL
    "actived": 1,                       // OPCIONAL
    "created_at": "2025-02-13T18:06:45.000000Z", // OPCIONAL
    "updated_at": "2025-02-13T18:06:45.000000Z"  // OPCIONAL
}

**Retorno**:
{
    "error": false,
    "message": "Tarefa Atualizada com sucesso!"
}

### Atualizar uma Tarefa

**Método**: DELETE

**URL**: https://localhost:porta-definida/api/v1/task/:idDaTarefa

**Retorno**:
{
    "error": false,
    "message": "Tarefa Atualizada com sucesso!"
}

### Completar uma Tarefa

**Método**: PATCH

**URL**: https://localhost:porta-definida/api/v1/task/:idDaTarefa/complete

**Retorno**:
{
    "error": false,
    "message": "Tarefa Atualizada com sucesso!"
}

---

## Conclusão
Seguindo esses passos, você deve ser capaz de configurar e executar o projeto Slim Framework 3 Skeleton sem problemas. Se encontrar alguma dificuldade, revise as configurações ou consulte a documentação oficial do Slim Framework.

--- 
## Licença

Este projeto está licenciado sob a licença MIT. Veja o arquivo LICENSE para mais detalhes.