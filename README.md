## Requisitos

* PHP 7.3 ou superior;
* MySQL 8.0 ou superior;
* Composer;

## Como rodar o projeto baixado
Instalar as dependencias.
```
Composer install
```

Executar as migrations.
```
vendor/bin/phinx migrate -c database/phinx.php
```

## Sequencia para criar o projeto
Criar o arquivo composer.json com a instrução básica.
```
composer init
```

Instalar a depencia Monolog, bibilioteca PHP que permite criar arquivo de log
```
composer require monolog/monoloh
```

Instalar a biblioteca gerenciar variáveis de ambiente
```
composer require vluscas/phpdotenv
```

Instalar a bibilioteca para criar/executar migration e seed
```
php vendor/bin/phinx --version
```
```
composer require robmorgan/phinx
```
Criar o arquivo "phinx.php" com as configurações e alterar as mesmas
```
vendor/bin/phinx init -f php
```

Testas as configurações.
```
vendor/bin/phinx test
```

Criar o diretório database.
```
mkdir database/
```

Criar o diretório para migrations.
```
mkdir database/migrations/
```

Criar a migrations.
```
vendor/bin/phinx create AdmsUsers -c database/phinx.php
```

Executar as migrations.
```
vendor/bin/phinx migrate -c database/phinx.php
```

Executar o rollback na útlima migration - reverter as alterações realizadas.
```
vendor\bin\phinx rollback -c database/phinx.php
```

Criar o diretório para seed
```
mkdir dtabase/seeds/
```

Criar seed
```
vendor/bin/phinx seed:create AddAdmsUsers -c database/phinx.php
```

Executar as seed
```
vendor/bin/phinx seed:run -c database/phinx.php
```

Instalar a biblioteca para validar o formulário.
```
composer require rakit/validation
```

Instalar a biblioteca para enviar email.
```
composer require phpmailer/phpmailer
```


## Lista de erros 

001 - DbConnection.php = Erro de conexão de banco de dados;
002 - LoadPageAdm.php = Não encontrou a página;
003 - LoadPageAdm.php = Não encontrou a controller;
004 - LoadPageAdm.php = Não encontrou o método;
005 - LoadViewService.php = Não encontrou a VIEW;
