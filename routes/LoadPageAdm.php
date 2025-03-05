<?php

namespace Routes;

use App\Adms\Helpers\GenerateLog;

class LoadPageAdm
{
    /** @var string $urlController recebe da URL o nome da controller */
    private string $urlController;
    /** @var string $urlParameter Recebe da URL o parâmetro*/
    private string $urlParameter;
    private string $classLoad;

    // Recebe a lista de páginas públicas
    private array $listPgPublic = ["Login", "Error403", "NewUser", "ForgotPassword", "ResetPassword"];
    // Recebe a lista de páginas privadas
    private array $listPgPrivate = ["Dashboard", "ListUsers", "ViewUser", "CreateUser", "UpdateUser", "DeleteUser", "Logout"];
    private array $listDirectory = ["login", "dashboard", "users", "erros"];

    private array $listPackages = ["adms"];

    /**
     * Verificar se existe a página com o método checkPageExists
     * Verfificar se existe a classe com o método checkControllerExists
     * @param string|null $urlController  Recebe da URL o nome da controller
     * @param string|null $urlParameter  Recebe da URL o parâmetro
     * @return void
     */
    public function loadPageAdm(string|null $urlController, string|null $urlParameter): void
    {

        $this->urlController = $urlController;
        $this->urlParameter = $urlParameter;
        // Verificar se existe a página
        if (!$this->checkPageExists()) {
            // Chamar o método para salvar o log
            GenerateLog::generateLog("error", "Página não encontrada.", ['pagina' => $this->urlController, 'parametro' => $this->urlParameter]);
           
            // die("Erro 002, entre em contato com o suporte/administração");

            // Criar mensagem de erro
            $_SESSION['error'] = 'Necessário estar logado para acessar a página restrita!';

            // Redirecionar o usuário quando não estiver logado e tentar acesar pgPrivada
            header("Location: {$_ENV['URL_ADM']}login");
        }

        // Verificar se a classe existe 
        if (!$this->checkControllersExists()) {
            // Chamar o método para salvar o log
            GenerateLog::generateLog("error", "Controller não encontrada.", ['pagina' => $this->urlController, 'parametro' => $this->urlParameter]);
            die("Erro 003, entre em contato com o suporte/administração");
        }
    }
    //Verificar se existe no array páginas públicas ou privadas
    private function checkPageExists(): bool
    {
        // Verificar se existe a página no array de páginas públicas
        if (in_array($this->urlController, $this->listPgPublic)) {
            return true;
        }

        if ($this->checkPagePrivateExists()) {
            return true;
        }

        return false;
    }

    private function checkPagePrivateExists(): bool
    {
        // Verificar se existe a página no array de páginas privadas
        if (!in_array($this->urlController, $this->listPgPrivate)) {
            return false;
        }

        // Verificar se o usuário está logado
        if (!isset($_SESSION['user_id']) and !isset($_SESSION['user_name']) and !isset($_SESSION['user_email'])) {
            return false;
        }

        return true;
    }

    private function checkControllersExists(): bool
    {

        // Percorrer o array de pacotes
        foreach ($this->listPackages as $package) {

            // Percorrer o array de diretórios
            foreach ($this->listDirectory as $directory) {

                // Criar o caminho da controller/classe
                $this->classLoad = "\\App\\$package\\Controllers\\$directory\\" . $this->urlController;

                // Verificar se a classe existe;  
                if (class_exists($this->classLoad)) {
                    // Chamar o método para validar o método;
                    $this->loadMetodo();

                    return true;
                }
            }
        }

        return false;
    }

    private function loadMetodo(): void
    {
        $classLoad = new $this->classLoad();

        if (method_exists($classLoad, "index")) {
            // Chamar o método para salvar o log
            GenerateLog::generateLog("info", "Página acessada.", ['pagina' => $this->urlController, 'parametro' => $this->urlParameter]);
            // Carregar o método
            $classLoad->{"index"}($this->urlParameter);
        } else {
            GenerateLog::generateLog("error", "Método não encontrada.", ['pagina' => $this->urlController, 'parametro' => $this->urlParameter]);
            die("Erro 004, entre em contato com o suporte/administração");
        }
    }

}