<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AddRecoverPasswordToAdmsUsers extends AbstractMigration
{

    /**
     * Adicionar as colunas recovery_password e validade_recover_password
     * @return void
     */
    public function up(): void
    {
        // Acessa o IF quando a tabela existe no banco de dados
        if ($this->hasTable('adms_users')) {
            $table = $this->table('adms_users');

            // Alterar a tabela e adicionar as colunas recover_password e validate_recover_password
            $table->addColumn('recover_password', 'string', [
                'null' => true,
                'after' => 'password'
            ])
                ->addColumn('validade_recover_password', 'datetime', [
                    'null' => true,
                    'after' => 'recover_password'
                ])
                ->update();
        }

    }
    /**
     * Rowback para remover as colunas "Recover_password" e validade_recover_password da tabela adms_users
     * @return void
     */
    public function down(): void
    {   
        // Acessa o if quando a tabela existe no banco de dados
        if ($this->hasTable('adms_users')) {

            // Alterar a tabela e remover as colunas
            $table = $this->table('adms_users');
            $table->removeColumn('recover_password')
                ->removeColumn('validate_recover_password')
                ->update();

        }

    }
}
