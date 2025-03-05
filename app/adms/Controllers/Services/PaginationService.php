<?php

namespace App\Adms\Controllers\Services;

class PaginationService
{

    /**
     * Gerar os dados da paginação
     * @param int $totalRecords Total de registros
     * @param int $limitResult Registros por página
     * @param int $currentPage Página atual
     * @param string $urlController URL do controller
     * @return void Dados da paginação
     */
    public static function generatePagination(int $totalRecords, int $limitResult, int $currentPage, string $urlController):array
    {

        // Calcular o número total de registros
        $lastPage = (int) ceil ($totalRecords / $limitResult);

        // Retornar os dados da paginação
        return [
            'amount_records' => $totalRecords,
            'last_page' => $lastPage,
            'current_page' => $currentPage == 0 ? 1 : $currentPage,
            'url_controller' => $urlController
        ];

    }



}




?>