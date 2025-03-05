<?php

namespace App\Adms\Controllers\Services\Validation;

use App\Adms\Helpers\GenerateLog;
use App\Adms\Models\Repository\LoginRepository;
use App\adms\Views\Services\LoadViewService;

class ValidationUserLogin
{

    public function validateUserLogin(array $data): bool
    {

        // Instanciar o repository para validar o usuário no banco de dados
        $login = new LoginRepository();
        $result = $login->getUser((string) $data['username']);

        // Registrar o erro e redirecionar
        if (!$result) {

            GenerateLog::generateLog("error", "Usuário incorreto", ['username' => $data['username']]);

            $_SESSION['error'] = "Usuário ou a senha incorretos!";


            return false;
        }

        if (password_verify($data['password'], $result['password'])) {

            // Extrair o array para imprimir o elemento do array através do nome
            extract($result);

            // Salvar os dados do usuário na sessão

            $_SESSION['user_id'] = $id;
            $_SESSION['user_name'] = $name;
            $_SESSION['user_email'] = $email;

            return true;

        }

        GenerateLog::generateLog("error", "Senha incorreta", ['username' => $data['username']]);
        $_SESSION['error'] = "Usuário ou a senha incorretos!";
        return false;
    }



}