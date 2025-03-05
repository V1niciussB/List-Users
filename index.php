<?php

use Routes\PageController;


session_start(); // Iniciar a sessão 


// Carregar o composer
require './vendor/autoload.php';

// Instanciar dependência de variáveis de ambiente.
$dotenv = Dotenv\Dotenv::createUnsafeImmutable(__DIR__);
$dotenv->load();

// Definir a timezone
date_default_timezone_set($_ENV['APP_TIMEZONE']);

// Instanciar a classe PageController, responsável por tratar a URL
$url = new PageController();
// Chamar o método para carregar a página ou controller;
$url->loadPage();
