<?php

namespace App\adms\Views\Services;

/**
 * Carregar as páginas da view
 */
class LoadViewService
{

    /** @var string $view Recebe o endereço da VIEW  */
    private string $view;

    /**
     * Receber o endereço da VIEW e os dados
     * @param string $nameView Endereço da VIEW que deve ser carregada
     * @param array|string|null $data $data Dados que a VIEW deve receber.
     */
    public function __construct(private string $nameView, private array|string|null $data)
    {
        
    }

    /**
     * Caerregar a VIEW
     * Verificar se o arquivo existe, e carrregar caso exista, não existindo para o carregamento
     * @return void
     */
    public function loadView():void
    {

        // Definir o caminho da view
        $this->view = './app/' . $this->nameView . '.php';

        if(file_exists($this->view))
        {
            // Incluir o layout
            include './app/adms/Views/layouts/main.php';
        }else{
            die("Erro 005: Falha ao carregar a página");
        }

    }
    /**
     * Caerregar a VIEW
     * Verificar se o arquivo existe, e carrregar caso exista, não existindo para o carregamento
     * @return void
     */
    public function loadViewLogin():void
    {

        // Definir o caminho da view
        $this->view = './app/' . $this->nameView . '.php';

        if(file_exists($this->view))
        {
            // Incluir o layout
            include './app/adms/Views/layouts/login.php';
        }else{
            die("Erro 005: Falha ao carregar a página");
        }

    }

}