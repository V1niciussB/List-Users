<?php


namespace App\Adms\Controllers\Login;

use App\Adms\Controllers\Services\Validation\ValidationLoginService;
use App\Adms\Controllers\Services\Validation\ValidationUserLogin;
use App\Adms\Controllers\Services\Validation\ValidationUserRakitService;
use App\Adms\Helpers\CSRFHelper;
use App\adms\Views\Services\LoadViewService;



class Login
{

    /**
     * 
     * @var array|string|null $dados Recebe os dados que devem ser enviados para VIEW
     */
    private array|string|null $data = null;

    public function index()
    {

        // Receber os dados do formulário
        $this->data['form'] = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        // Acessar o IF se existir o CSRF e for valido;
        if (isset($this->data['form']['csrf_token']) and CSRFHelper::validateCSRFToken('form_login', $this->data['form']['csrf_token'])) {
            // Chamar o método login
            $this->login();
        } else {
            // chamar o método carregar a view
            $this->viewLogin();
        }

    }


    private function login(): void
    {
        // Instanciar a classe validar os dados do formulário com Rakit
        $validationLogin = new ValidationLoginService();
        $this->data['errors'] = $validationLogin->validate($this->data['form']);


        // Acessa o IF quando existir campo com dados incorretos
        if (!empty($this->data['errors'])) {
            // Chamar o método carregar a view
            $this->viewLogin();
            return;
        }

        //  Instaciar a classe validar o usuário e a senha 
        $validationUserLogin = new ValidationUserLogin();
        $result = $validationUserLogin->validateUserLogin(($this->data['form']));

        if ($result) {
            header("Location: {$_ENV['URL_ADM']}dashboard");
        } else {

            // Chamar o método para cerregar a view login
            $this->viewLogin();

            return;

        }

    }




    /**
     *  Carregar a visualização login.
     * 
     * Este método configura os dados necessários e carrega a view para o login.
     * 
     * @return void
     */
    private function viewLogin()
    {
        // Criar o título da página
        $this->data['title_head'] = "Login";

        // Carregar a view
        $loadView = new LoadViewService("adms/Views/login/login", $this->data);
        $loadView->loadViewLogin();
    }


}