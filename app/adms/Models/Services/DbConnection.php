<?php

namespace App\Adms\Models\Services;

use App\Adms\Helpers\GenerateLog;
use PDO;
use PDOException;

abstract class DbConnection
{

    private object $connect;
    public function getConnection(): object
    {
        try {
            // Criar nova conexão com o banco de dados, se não exisitr
            if (!isset($this->connect)) {

                $this->connect = new PDO("mysql:host={$_ENV['DB_HOST']};dbname=" . $_ENV['DB_NAME'], $_ENV['DB_USER'], $_ENV['DB_PASS']);
                // echo "Conexão realizada com sucesso";

            }

            return $this->connect;
        } catch (PDOException $err) {
            GenerateLog::generateLog("alert", "Erro ao conectar com o banco de dados:", ['error' => $err->getMessage()]);
            die("Erro 001, entre em contato com o suporte/administração");
        }


    }


}



?>