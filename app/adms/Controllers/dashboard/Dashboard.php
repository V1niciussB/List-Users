<?php


namespace App\Adms\Controllers\dashboard;

use App\adms\Views\Services\LoadViewService;

class Dashboard
{

    /**
     * @var array|string|null $dados Recebe os dados que devem ser enviados para VIEW
     */
    private array|string|null $data = null;

    public function index()
    {

        // Definir o titulo da página
        $this->data['title_head'] = "Dashboard";

        // Carregar a VIEW
        $loadView = new LoadViewService("adms/Views/dashboard/dashboard", $this->data);
        $loadView->loadView();

    }
}