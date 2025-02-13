<?php
/*
==================================================
FONTE: Connection.php
TIPO: roteamento 
DESCRIÇÃO: Fonte responsável por rotear as rotas
PROGRAMADOR(A): Ighor Drummond
DATA: 12/02/2025
==================================================
*/


/*
==================================================
Namespace: Connection
Descrição: Responsável por agrupar a classe de conexão com o banco de dados
Programador(a): Ighor Drummond
Data: 12/02/2025
==================================================
Modificações:
@ Data - Descrição - Programador(a)
*/
namespace Connection{

    /*
    ==================================================
    Classe: Connection
    Extend: Não há
    Descrição: Responsável por estabelecer a conexão com o banco de dados
    Programador(a): Ighor Drummond
    Data: 12/02/2025
    ==================================================
    Modificações:
    @ Data - Descrição - Programador(a)
    */
    class Connection{
        //Constantes
        const DIR_LOG = "../../../logs/log_"; //Diretório do arquivo de log

        //Construtor
        public function __construct(){}

        /*
        ==========================================
        MÉTODO: Log
        PARÂMETROS: $type (String) - Tipo de informação a ser registrada no Log / $msg (String) - Mensagem a ser registrada no Log
        DESCRIÇÃO: Registra Eventos no arquivo de Log
        RETORNO: Não há - Void
        PRIVADO: Não
        DATA: 12/02/2025 
        PROGRAMADOR(A): Ighor Drummond
        ==========================================
        Modificações:
        @ Data - Descrição - Programador(a)
        */
        public function Log(
            $type = "SUCCESS",
            $msg = ""
        ){
            //Declaração de variavel
            //String - c
            $cMsg = "";
            //Integer
            $nHandle = 0;
            //Data - d
            $dData = date("Y-m-d");
            $dTime = date("H:i:s");

            //Abre log e caso não existir, cria e abre
            $nHandle = fopen(self::DIR_LOG . $dData. ".log", "a+");

            //Escreve mensagem de logs para o sistema
            $cMsg = "=========================== $dData - $dTime ========================" . PHP_EOL;
            $cMsg .= strtoupper( trim($type) ) . " - MENSSAGE: " . $msg . PHP_EOL;
            $cMsg .= "========================================================================" . PHP_EOL;

            //Escreve no arquivo
            fwrite($nHandle, $cMsg);

            //Fecha arquivo
            fclose($nHandle);
        }

        /*
        ==========================================
        MÉTODO: withApiHeaders()
        PARÂMETROS: $response (Response) - Responsável por montar o cabeçalho da resposta / $statusCode (int) - Código de retorno HTTP
        DESCRIÇÃO: Monta o cabeçalho da resposta com os headers necessários para a API
        RETORNO: Response
        PRIVADO: Não
        DATA: 12/02/2025 
        PROGRAMADOR(A): Ighor Drummond
        ==========================================~
        Modificações:
        @ Data - Descrição - Programador(a)
        */
        public function withApiHeaders($response, $statusCode = 200)
        {
            //Evita ataques XSS
            return $response
                ->withStatus($statusCode)
                ->withHeader('Content-Type', 'application/json')
                ->withHeader('Content-Security-Policy', "default-src 'self'; script-src 'self'; style-src 'self'; img-src 'self'")
                ->withHeader('X-Content-Type-Options', 'nosniff')
                ->withHeader('X-Frame-Options', 'DENY')
                ->withHeader('X-XSS-Protection', '1; mode=block')
                ->withHeader('Strict-Transport-Security', 'max-age=31536000; includeSubDomains; preload')
                ->withHeader('Referrer-Policy', 'no-referrer')
                ->withHeader('Permissions-Policy', 'geolocation=(), microphone=(), camera=()')
                ->withHeader('Cache-Control', 'no-cache, no-store, must-revalidate')
                ->withHeader('Pragma', 'no-cache')
                ->withHeader('Expires', '0')
                ->withHeader('Access-Control-Allow-Origin', 'https://seusite.com')
                ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS')
                ->withHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization')
                ->withHeader('Access-Control-Expose-Headers', 'X-Custom-Header')
                ->withHeader('Access-Control-Allow-Credentials', 'true')
                ->withHeader('Set-Cookie', 'sessionid=12345; Secure; HttpOnly; SameSite=Strict')
                ->withHeader('Expect-CT', 'enforce, max-age=86400')
                ->withHeader('X-Permitted-Cross-Domain-Policies', 'none')
                ->withHeader('X-Download-Options', 'noopen')
                ->withHeader('X-Powered-By', 'PHP/8.1');
        }
    }
}
?>