<?php

namespace App\Adms\Controllers\Services\Validation;

class ValidationUserService
{

    public function validate(array $data): array
    {

        // Criar o que deve receber as mensagens de erro
        $errors = [];

        // Verificar se o campo nome está vazio
        if (empty($data['name'])) {
            $errors['name'] = 'O campo nome é obrigatório';
        }

        // Verificar se o campo email está vazio e se é formato valído
        if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'O campo email é obrigatório';
        }
        // Verificar se o campo username está vazio
        if (empty($data['username'])) {
            $errors['username'] = 'O campo username é obrigatório';
        }
        // Verificar se o campo senha está vazio e corresponde a regra de senha forte
        if (empty($data['password']) || strlen($data['password']) < 6 || !preg_match('/[A-Z]/', $data['password']) || !preg_match('/[^\w\s]/', $data['password'])) {
            $errors['password'] = 'A senha deve ter no mínimo 6 caracteres, uma letra maiúscula e um caractere especial';
        }


        return $errors;


    }



}






?>