<?php


namespace App\Adms\Controllers\erros;

class Error403
{
    public function index()
    {
        echo "<h1> 403 - Acesso Proibido </h1>";
        echo "<p> Você não tem permissão para acessar esta página.</p>";
    }
}