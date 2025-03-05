<?php

namespace App\Adms\Helpers;


class CSRFHelper
{

    /**
     * Gerar um token CSRF único
     * 
     * @param string $formIdentifer identificados no formulário.
     * @return string Token CSRF gerado
     */

    public static function generateCSRFToken(string $formIdentifer): string
    {

        // A função random_bytes gera uma sequência de 32 bytes aleatórios.
        // A função bin2hex converte os bytes binários gerados pela 
        // random_bytes em uma representação hexadecimal.
        $token = bin2hex(random_bytes(32));

        // Salvar o token CSRF na sessão
        $_SESSION['csrf_tokens'][$formIdentifer] = $token;
        // Retornar token
        return $token;
    }

    /**
     *  Validar um token CSRF.
     * 
     * @param string $formIdentifier Identificador do formulário.
     * @param string $token Token CSRF para validar.
     * @return bool True se o token for válido, False caso contrário.
     */
    public static function validateCSRFToken(string $formIdentifer, string $token)
    {

        // Verificar se existe o csrf_token e se o valor que vem do formulário é igual o csrf salvo na sessão
        // Função hash_equals funciona para que em caso de ataque não seja possível identificar se campo está correto
        if (isset($_SESSION['csrf_tokens'][$formIdentifer]) && hash_equals($_SESSION['csrf_tokens'][$formIdentifer], $token)) {

            // Token usado deve ser invalidado;
            unset($_SESSION['csrf_tokens'][$formIdentifer]);

            return true;
        }

        return false;
    }

}
