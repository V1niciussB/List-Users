<?php

namespace App\Adms\Controllers\Login;

use App\Adms\Controllers\Services\GenerateKeyService;
use App\Adms\Controllers\Services\RecoverPassword;
use App\Adms\Controllers\Services\Validation\ValidationEmailService;
use App\Adms\Helpers\CSRFHelper;
use App\Adms\Helpers\GenerateLog;
use App\Adms\Helpers\SendEmailService;
use App\Adms\Models\Repository\LoginRepository;
use App\Adms\Models\Repository\ResetPasswordRepository;
use App\adms\Views\Services\LoadViewService;

class ForgotPassword
{
    /**
     * @var array|string|null $data recebe os dados que devem ser enviados para a view
     */
    private array|string|null $data = null;

    public function index(): void
    {
        // $sendEmail = new SendEmailService();
        // $sendEmail->sendEmail('atendimento2@gamer.com', 'Atendimento Dev', 'Recuperar Senha', 'Conteúdo com HTML', 'Conteúdo sem HTML');

        // Receber os dados do formulário
        $this->data['form'] = filter_input_array(INPUT_POST, FILTER_DEFAULT);


        // Acessar o IF se existir o CSRF e for valido;
        if (isset($this->data['form']['csrf_token']) and CSRFHelper::validateCSRFToken('form_forgot_password', $this->data['form']['csrf_token'])) {
            // Chamar o método esqueceu a senha
            $this->forgotPassword();
        } else {
            // chamar o método carregar a view
            $this->viewForgotPassword();
        }


    }

    private function viewForgotPassword()
    {
        // Criar o título da página
        $this->data['title_head'] = "Recuperar Senha";

        // Carregar a VIEW
        $loadView = new LoadViewService("adms/Views/login/forgotPassword", $this->data);
        $loadView->loadViewLogin();
    }

    private function forgotPassword(): void
    {

        // Instanciar a classe de validação
        $validationEmail = new ValidationEmailService();
        $this->data['errors'] = $validationEmail->validate($this->data['form']);

        // Se houver erros, recarregar a view com erros
        if (!empty($this->data['errors'])) {
            $this->viewForgotPassword();
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

            $this->viewForgotPassword();
            return;
        }

        // Instanciar o serviço para recuperar a senha  
         $recoverPassword = new RecoverPassword();
         $resultRecoverPassword = $recoverPassword->recoverPassword($this->data);

         // Verficiar se enviou o e-mail com sucesso
         if(!$resultRecoverPassword){

            // Chamar o método para salvar o log
            GenerateLog::generateLog("error", "E-mail com as instruções para recupar a senha não enviado", ['email' => (string) $this->data['form']['email']]);

            // Criar a mensagem de erro
            $_SESSION['error'] = "E-mail com as instruções para recuperar a senha não enviado, tente novamente.";

            // Chamar o método carregar a view 
            $this->viewForgotPassword();

            return;
         }
        
         // Criar a mensagem de sucesso
         $_SESSION['mensagem'] = "Enviado e-mail com instruções para recuperar a senha. Acesse a sua caixa de e-mail para recuperar a senha!";

         // Redirecionar o usuário para a página de login
         header("Location: {$_ENV['URL_ADM']}login");
    }

}
