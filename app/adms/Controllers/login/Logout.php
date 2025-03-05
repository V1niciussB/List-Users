<?php

namespace App\Adms\Controllers\Login;

class Logout
{

    public function index() : void
    {

        // Eliminar os valores da sessão 
        unset($_SESSION['user_id'], $_SESSION['user_name'], $_SESSION['user_email']);

        header("Location: {$_ENV['URL_ADM']}login");

    }
}






?>