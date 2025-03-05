<?php

namespace App\Adms\Helpers;

use Monolog\Level;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Psr\Log\LogLevel;

class GenerateLog
{

    public static function generateLog(string $level, string $message, array|null $content): void
    {
        // Criar o logger
        $log = new Logger('name');

        // Obter a data atual no firmado "ddmmyyyy"
        $nameFileLog = date('dmY') . ".log";

        // Criar o caminho dos logs
        $filePath = 'logs/' . $nameFileLog;

        // Verificar se o arquivo existe
        if(!file_exists($filePath)){

            // Abrir o arquivo para escrita 
            $fileOpen = fopen($filePath, 'w');

            // Fechar o arquivo 
            fclose($fileOpen);
        }

        $log->pushHandler(new StreamHandler($filePath, LogLevel::DEBUG));

        $log->$level($message, $content);


    }


}