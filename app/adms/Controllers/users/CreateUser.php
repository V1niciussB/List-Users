<?php

namespace App\Adms\Controllers\Users;

use App\Adms\Controllers\Services\Validation\ValidationUserRakitService;
use App\Adms\Helpers\CSRFHelper;
use App\Adms\Models\Repository\UsersRepository;
use App\adms\Views\Services\LoadViewService;

class CreateUser
{


    /**
     * @var array|string|null $data recebe os dados que devem ser enviados para a view
     */
    private array|string|null $data = null;

    public function index(): void
    {

        // Receber os dados do formulário
        $this->data['form'] = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        // Acessar o IF se existir o CSRF e for valido;
        if (isset($this->data['form']['csrf_token']) and CSRFHelper::validateCSRFToken('form_create_user', $this->data['form']['csrf_token'])) {
            // Chamar o método cadastrar
            $this->addUser();
        } else {
            // chamar o método carregar a view
            $this->viewUser();
        }
    }

    private function viewUser()
    {
        // Criar o título da página
        $this->data['title_head'] = "Cadastrar Usuário";
        
        // Carregar a VIEW
        $loadView = new LoadViewService("adms/Views/users/create", $this->data);
        $loadView->loadView();
    }



    private function addUser(): void
    {
        // Instanciar a classe validar os dados do formulário com Rakit
        $validationUser = new ValidationUserRakitService();
        $this->data['errors'] = $validationUser->validate($this->data['form']);

        // Acessa o IF quando existir campo com dados incorretos
        if (!empty($this->data['errors'])) {

            // Chamar o método carregar a view
            $this->viewUser();

            return;
        }

        // Instanciar a Repository para criar o usuário  
        $userCreate = new UsersRepository();
        $result = $userCreate->createUser($this->data['form']);

        if ($result) {
            $_SESSION['mensagem'] = "<p style='color:#079307;'>Usuário cadastrado com sucesso!</p>";
            header("Location: {$_ENV['URL_ADM']}/view-user/$result");
            exit();
        } else {
            echo "<p style='color:#9e0202'> Erro ao cadastrar usuário </p>";

                  // Chamar o método carregar a view
                  $this->viewUser();
        }




    }


}



?>