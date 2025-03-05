<?php

namespace App\Adms\Controllers\Login;

use App\Adms\Controllers\Services\Validation\ValidationUserPasswordService;
use App\Adms\Helpers\CSRFHelper;
use App\Adms\Helpers\GenerateLog;
use App\Adms\Models\Repository\ResetPasswordRepository;
use App\adms\Views\Services\LoadViewService;

class ResetPassword
{

    /**
     * @var array|string|null $data recebe os dados que devem ser enviados para a view
     */
    private array|string|null $data = null;
    public function index(string|null $recoverPassword): void
    {

        // Receber os dados do formulário
        $this->data['form'] = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        // Receber o código recuperar senha
        $this->data['form']['recover_password'] = (string) $recoverPassword;

        // Acessar o IF se existir o CSRF e for valido;
        if (isset($this->data['form']['csrf_token']) and CSRFHelper::validateCSRFToken('form_reset_password', $this->data['form']['csrf_token'])) {
            // Chamar o método esqueceu a senha
            $this->resetPassword();
        } else {
            // chamar o método carregar a view
            $this->viewResetPassword();
        }

    }


    private function viewResetPassword()
    {
        // Criar o título da página
        $this->data['title_head'] = "Recuperar Senha";

        // Carregar a VIEW
        $loadView = new LoadViewService("adms/Views/login/resetPassword", $this->data);
        $loadView->loadViewLogin();
    }

    private function resetPassword()
    {

        // Instanciar a classe de validação
        $validationUser = new ValidationUserPasswordService();
        $this->data['errors'] = $validationUser->validate($this->data['form']);

        // Se houver erros, recarregar a view com erros
        if (!empty($this->data['errors'])) {
            $this->viewResetPassword();
            return;
        }

        // Instanciar o Repository para recuperar o registro do banco de dados
        $viewUser = new ResetPasswordRepository();
        $this->data['user'] = $viewUser->getUser((string) $this->data['form']['email']);

        // Verificar se encontrou registro no banco de dados
        if (!$this->data['user']) {
            // Registrar o erro e redirecionar 
            GenerateLog::generateLog("error", "Usuário não encontrado", ['email' => (string) $this->data['form']['email']]);

            // Criar a mensagem de erro
            $_SESSION['error'] = "Usuário não encontrado!";

            $this->viewResetPassword();
            return;
        }

        // Verificar se o código recuperar a senha é válido
        if (($this->data['form']['recover_password'] ?? false) and ($this->data['user']['recover_password'] ?? false) and (!password_verify($this->data['form']['recover_password'], $this->data['user']['recover_password']))) {

            // Registrar o erro e redirecionar 
            GenerateLog::generateLog("error", "Código recuperar senha inválido", ['email' => (string) $this->data['form']['email']]);

            // Criar a mensagem de erro
            $_SESSION['error'] = "Código recuperar senha inválido!";

            $this->viewResetPassword();
            return;
        }

        // Verificar se a data de validade da chave recuperar senha é menor que a data atual
        if ($this->data['user']['validate_recover_password'] < date('Y-m-d H:i:s')) {

            // Registrar o erro e redirecionar 
            GenerateLog::generateLog("error", "Código recuperar senha expirado", ['email' => (string) $this->data['form']['email']]);

            // Criar a mensagem de erro
            $_SESSION['error'] = "Código recuperar senha expirado!";

            $this->viewResetPassword();
            return;
        }

           // Atualizar o usuário
           $userUpdate = new ResetPasswordRepository();
           $result = $userUpdate->updatePassword($this->data['form']);
   
           // Acessa o IF se o repository retornou TRUE
           if ($result) {
               // Cria uma mensagem de sucesso
               $_SESSION['mensagem'] = "Senha editada com sucesso!";
   
               // Redirecionar o usuário para página de login
               header("Location: {$_ENV['URL_ADM']}login");
               return;
           } else {
               $_SESSION['error'] = "Senha não editada";
   
               $this->viewResetPassword();
           }


    }

}