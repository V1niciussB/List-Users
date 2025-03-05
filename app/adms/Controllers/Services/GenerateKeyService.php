<?php

namespace App\Adms\Controllers\Services;

class GenerateKeyService
{

    public static function generateKey(): array
    {
        // Definindo os caracteres possíveis
        $chars = 'abcdefghijklmnopqrstuvwxyz123456789';
        // Embaralhnado os caracteres
         $shuffle = str_shuffle($chars);
        // Extraindo a chave de 12 caracteres 
         $key = substr($shuffle, 0, 12);
        // Criptografando a chave
          $encryptedKey = password_hash($key, PASSWORD_DEFAULT);
            // Retornar a chave em texto claro e criptografia
          return ['key' => $key, 'encryptedKey' => $encryptedKey];
    }



}