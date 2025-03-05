<?php

namespace App\Adms\Controllers\Users;

use App\Adms\Helpers\GenerateLog;
use App\Adms\Models\Repository\UsersRepository;
use App\adms\Views\Services\LoadViewService;

class DeleteUser
{
    /*
     * @var array|string|null $data recebe os dados que devem ser enviados para a view
     */
    private array|string|null $data = null;

    public function index(): void
    {
        $deleteUser = new UsersRepository();
        $id = (int) $_POST['id'] ?? 0;
        $this->data['user'] = $deleteUser->getUser($id);


        if (empty($this->data['user'])) {
            // Chamar o método para salvar o log
            GenerateLog::generateLog("error", "Usuário não encontrado", ['id' => $id]);
            // Criar a mensagem de erro
            $_SESSION['mensagem'] = "<p style='color: #f00;'>Usuário não encontrado!! <br></p>";
            // Redirecionar o usuário para página listar
            header("Location: {$_ENV['URL_ADM']}list-users");
            exit();
        }

        if ($deleteUser->deleteUser((int) $this->data['user']['id'])) {
            $_SESSION['mensagem'] = "<p style='color: #079307;'> Usuário Deletado!! <br></p>";
            header("Location: {$_ENV['URL_ADM']}list-users");
        } else {
            GenerateLog::generateLog("error", "Usuário não pode ser deletado", ['id' => (int) $this->data['user']['id']]);
            // Criar a mensagem de erro
            $_SESSION['mensagem'] = "<p style='color: #f00;'>Usuário não pode ser deletado!! <br></p>";
        }

    }

}



?>