<?php

namespace App\Adms\Controllers\Services\Validation;

use Rakit\Validation\Validator;

class ValidationLoginService
{

    /**
     * Validar os dados do formulário
     * 
     * @param array $data Dados do formulário;
     * @return array Lista de erros.
     */
    public function validate(array $data): array
    {

        // Criar o array para receber mensagens de erro
        $errors = [];

        // Instanciar a classe validar formulário
        $validator = new Validator();

        // Definir as regras de validação
        $validation = $validator->make($data, [
            'username' => 'required',
            'password' => 'required|same:password',
        ]);

        // Definir mensagens personalizadas  
        $validation->setMessages([
            'username:required' => 'O campo usuário é obrigatório.',
            'password:required' => ' O campo senha é obrigatório.',
        ]);

        // Validar os dados
        $validation->validate();

        // Retornar erros, se houver
        if ($validation->fails()) {

            // Recuperar os erros
            $arrayErrors = $validation->errors();

            // Percorrer o array de erros
            // firstOfAll - obter a primeira mensagem de erro para cada campo validado.
            foreach ($arrayErrors->firstOfAll() as $key => $message) {
                $errors[$key] = $message;
            }
        }

        return $errors;
    }
}



?>