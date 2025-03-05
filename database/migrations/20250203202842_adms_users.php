<?php

use Phinx\Migration\AbstractMigration;

class AdmsUsers extends AbstractMigration
{
    /** 
     * Cria a tabela AdmsUsers
     * https://book.cakephp.org/phinx/0/en/migrations.html
     */
    public function up()
    {
        // Acessa o if quando não existe a tabela no banco de dados
        if (!$this->hasTable('adms_users')) {
            // Definir o nome da tablea
            $table = $this->table('adms_users');

            // Definir colunas da tabela
            $table->addColumn('name', 'string', ['null' => false])
                ->addColumn('email', 'string', ['null' => false])
                ->addColumn('username', 'string', ['null' => false])
                ->addColumn('password', 'string', ['null' => false])
                ->addColumn('created_At', 'timestamp', ['null' => false])
                ->addColumn('updated_at', 'timestamp', ['null' => false])
                ->create();
        }

    }

    // Método down() para reverter a migração (se necessário)
    public function down()
    {
        // Apagar a tabela "adms_users";
        $this->table('adms_users')->drop()->save();
    }
}
