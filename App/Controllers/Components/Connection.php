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
    @ 13/02/2025 - Removido método que setava cabeçalhos pois foi transferido para Middleware - Ighor Drummond
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
    }
}
?>