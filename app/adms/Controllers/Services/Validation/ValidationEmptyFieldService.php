<?php

namespace App\Adms\Controllers\Services\Validation;

class ValidationEmptyFieldService
{

    public function validate(array $data): array
    {

        // Criar o array para receber as mensagens de erro
        $errors = [];

        // Retirar espaço em branco no valor
        $data = array_map('trim', $data);

        // Veririfcar se algum elemento do array está vazio indicando que o campo não possui valor
        if(in_array('',$data)){
            $errors['msg'] = 'Necessário preencher todos os campos.';
        }

        return $errors;
    }   



}





?>