<?php


namespace App\Adms\Controllers\Users;

use App\Adms\Controllers\Services\PaginationService;
use App\Adms\Models\Repository\UsersRepository;
use App\adms\Views\Services\LoadViewService;

class ListUsers
{
    /**
     * 
     * @var array|string|null data Recebe os dados que devem ser enviados para VIEW
     */
    private array|string|null $data = null;

    /** @var int $page Recebe a quantidade de registros que deve retornar do banco de dados */
    private int $limitResult = 3;

    
    public function index(string|int $page = 1)
    {
        // Instanciar o repository para recuperar os registros do BD
        $listUsers = new UsersRepository();
        $this->data['users'] = $listUsers->getAllUsers((int) $page, (int) $this->limitResult);
        $this->data['pagination'] = PaginationService::generatePagination((int)$listUsers->getAmountUsers(), (int) $this->limitResult, (int) $page, 'list-users');

        // Criar título da página
        $this->data['title_head'] = "Listar Usuários";

        // Carregar a view
        $loadView = new LoadViewService("adms/Views/users/list", $this->data);
        $loadView->loadView();

    }
}