<?php

namespace Routes;

use App\adms\Helpers\ClearUrl;
use App\Adms\Helpers\SlugController;

/**
 * Recebe a URL e manipula
 * 
 * @author Vinicius
 */
class PageController
{
    /**
     * Summary of url
     * @var string url Receber a url do .htaccess
     */
    private string $url;

    /**
     * Recebe a URL convertida para array
     * @var array $urlArray
     */
    private array $urlArray;

    private string $urlController = "";

    private string $urlParameter = "";

    /**
     * Recebe a URL do .htaccess
     */
    public function __construct()
    {
        if(!empty(filter_input(INPUT_GET, "url", FILTER_DEFAULT))){
            // Recebe o valor da váriavel url enviada pelo .htaccess
            $this->url = filter_input(INPUT_GET, "url", FILTER_DEFAULT);

            // Chamar a classe helper para limpar a URL
            $this->url = ClearUrl::clearUrl($this->url);

            // Converter a string da URL em array  
            $this->urlArray = explode("/", $this->url);

            //Veririfcar se existe a controller na URL
            if(isset($this->urlArray[0])){

                $this->urlController = SlugController::slugController($this->urlArray[0]);

                // $this->urlController = $this->urlArray[0];
            }else{
                $this->urlController =SlugController::slugController("Login");
            }

            // Verificar se existe o parâmetro na URL 
            if(isset($this->urlArray[1])){
                $this->urlParameter = $this->urlArray[1];
            }
            

        }else{
            $this->urlController =SlugController::slugController("Login");
        }
    }
    /**
     * Carregar página/controller
     * Instanciar a classe para validar e carregar página/controller
     * @return void
     */
    public function loadPage(): void
    {

        // Instanciar a classe para validar e carregar página/controller
        $loadPageAdm = new LoadPageAdm();

        // Chamar o método e enviar como parâmetro a controller e o parâmetro da URL
        $loadPageAdm->loadPageAdm($this->urlController, $this->urlParameter);

    }

}