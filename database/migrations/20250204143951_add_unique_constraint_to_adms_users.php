<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AddUniqueConstraintToAdmsUsers extends AbstractMigration
{
    /**
     * Alterar as colunas email e username para serem unicas
     */
    public function up(): void
    {

        // Acessa o if qundo a tabela existe no BD
        if ($this->hasTable('adms_users')) {

            // Alterar a tabela para adicionar indices úicos
            $table = $this->table('adms_users');

            // Adicionar índices únicos ás colunas email e username
            $table->addIndex(['email'], ['unique' => true, 'name' => 'idx_unique_email'])
                ->addIndex(['username'], ['unique' => true, 'name' => 'idx_unique_username'])
                ->update();

        }

    }

    // Métodos down() para reverter a migração (caso necessário)
    public function down(): void
    {

        //  Acessa o IF quando a tabela existe no BD
        if ($this->hasTable('adms_users')) {
            // Indicar a tabela para remover os índices únicos
            $table = $this->table('adms_users');

            // Remover os índices únicos
            $table->removeIndexByName('idx_unique_email')
                ->removeIndexByName('idx_unique_username')
                ->update();

        }

    }

}
