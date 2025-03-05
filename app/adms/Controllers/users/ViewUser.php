<?php

namespace App\Adms\Controllers\Users;

use App\Adms\Helpers\GenerateLog;
use App\Adms\Models\Repository\UsersRepository;
use App\adms\Views\Services\LoadViewService;

/**
 *  Controlle visualizar usuários
 */
class ViewUser
{
    /**
     * 
     * @var array|string|null $data recebe os dados que devem ser enviados para a view
     */
    private array|string|null $data = null;

    /**
     * Recuperar os detalhes do usuário
     * @param int|string $id id do usuário
     * @return void
     */
    public function index(int|string $id): void
    {
        // Acessa o if se o id for valor do tipo inteiro
        if (!(int) $id) {

            // Chamar o método para salvar o log
            GenerateLog::generateLog("error", "Usuário não encontrado", ['id' => (int) $id]);
            // Criar a mensagem de erro
            $_SESSION['mensagem'] = "<p style='color: #f00;'>Usuário não encontrado!! <br></p>";

            // Redirecionar o usuário para página listar
            header("Location: {$_ENV['URL_ADM']}list-users");
            return;
        }

        // Instanciar o Repository para recuperar o registro do banco de dados
        $viewUser = new UsersRepository();
        $this->data['user'] = $viewUser->getUser((int) $id);

        // Criar o título da página
        $this->data['title_head'] = "Visualizar Usuário";

        // Carregar a view
        $loadView = new LoadViewService("adms/Views/users/listUser", $this->data);
        $loadView->loadView();

    }
}