<?php

namespace App\Adms\Controllers\Users;

use App\Adms\Controllers\Services\Validation\ValidationUserRakitService;
use App\Adms\Helpers\CSRFHelper;
use App\Adms\Helpers\GenerateLog;
use App\Adms\Models\Repository\UsersRepository;
use App\adms\Views\Services\LoadViewService;



class UpdateUser
{


    /**
     * @var array|string|null $data recebe os dados que devem ser enviados para a view
     */
    private array|string|null $data = null;

    /**
     * Editar o usuário
     * @param int|string $id
     * @return void
     */
    public function index(int|string $id): void
    {
        // Receber os dados do formulário
        $this->data['form'] = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        // Acessar o IF se existir o CSRF e for valido;
        if (isset($this->data['form']['csrf_token']) and CSRFHelper::validateCSRFToken('form_update_user', $this->data['form']['csrf_token'])) {

            // Chamar o método cadastrar
            $this->editUser();
        } else {
            // Instanciar o Repository para recuperar o registro do banco de dados
            $viewUser = new UsersRepository();
            $this->data['form'] = $viewUser->getUser((int) $id);

            // Verificar se encontrou o registro no banco de dados
            if (!$this->data['form']) {

                // Chamar o método para salvar o log
                GenerateLog::generateLog("error", "Usuário não encontrado", ['id' => (int) $id]);

                // Criar a mensagem de erro
                $_SESSION['mensagem'] = "<p style='color: #f00;'>Usuário não encontrado!! <br></p>";

                // Redirecionar o usuário para a página listar
                header("Location: {$_ENV['URL_ADM']}list-users");
                return;
            }
            // Chamatr o método carregar a view
            $this->viewUser();
        }
    }

    private function viewUser()
    {
        // Criar o título da página
        $this->data['title_head'] = "Editar Usuário";

        // Carregar a VIEW
        $loadView = new LoadViewService("adms/Views/users/update", $this->data);
        $loadView->loadView();
    }

    /**
     * Editar usuário
     * 
     * Este método realiza a edição de um usuário existente no sistema. Ele valida os dados do formulário usando a
     * classe 'ValidationUserRakitService', exibi a view com os erros caso existam campos com dsdos incorretos,
     * chama o repositorio para atualizar o usuário e, dependendo do resultado, redireciona o usuário ou exibe
     * uma mensagem de erro.
     *      * @return void
     */
    private function editUser(): void
    {
        $validationUser = new ValidationUserRakitService();
        $this->data['errors'] = $validationUser->validateUpdate($this->data['form']);
        
        // Instanciar o repository para editar o usuário
        $userUpdate = new UsersRepository();
        $result = $userUpdate->updateUser($this->data['form']);

        if ($result) {
            $_SESSION['mensagem'] = "Usuário editado com sucesso! <br>";

            $this->viewUser();
        } else {
            $_SESSION['error'] = "Usuário não editado! <br>";

            $this->viewUser();
        }
    }

}
