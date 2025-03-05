<?php

namespace App\Adms\Helpers;

/**
 * Converter a controller  enviada na URL parta o formato de clase
 */
class SlugController
{

    public static function slugController(string $slugController): string
    {

        // Converter para minusculo
        $slugController = strtolower($slugController);

        // Converter o traço para espaço em branco
        $slugController = str_replace("-", " ", $slugController);

        // Converter a primeira letra de cada palavra para maiusculo
        $slugController = ucwords($slugController);

        // Retirar espaço em branco
        $slugController = str_replace(" ", "", $slugController);

        return $slugController;
    }

}