<?php


use Phinx\Seed\AbstractSeed;

class AddAdmsUsers extends AbstractSeed
{
    /**
     *  Cadastrar usuário no banco de dados
     * 
     */
    public function run(): void
    {

        // Variável para receber os dados.
        $data = [];

        // Verificar se o registro já existe no banco
        $existingRecord = $this->query('SELECT id FROM adms_users WHERE 
        email = :email', ['email' => 'cesar@matos.com.br'])->fetch();

        // Se o registro não existir, insere os dados na variável $data para em seguida cadastrar na tabela
        if (!$existingRecord) {

            // Criar o array com dados do usuário
            $data[] = [
                'name' => 'Cesar',
                'email' => 'cesar@matos.com.br',
                'username' => 'Cesar Matos',
                'password' => password_hash('123456', PASSWORD_DEFAULT),
                'created_at' => date("Y-m-d H:i:s"),
            ];
        }

        ///////////////////////////////////////////////////////////

        // Verificar se o registro já existe no banco
        $existingRecord = $this->query('SELECT id FROM adms_users WHERE 
        email = :email', ['email' => 'Claudia@matos.com.br'])->fetch();

        // Se o registro não existir, insere os dados na variável $data para em seguida cadastrar na tabela
        if (!$existingRecord) {

            // Criar o array com dados do usuário
            $data[] = [
                'name' => 'Claudia',
                'email' => 'Claudia@matos.com.br',
                'username' => 'Claudia Matos',
                'password' => password_hash('123456', PASSWORD_DEFAULT),
                'created_at' => date("Y-m-d H:i:s"),
            ];
        }

        // Indicar em qual tabela deve salvar o registro
        $adms_users = $this->table('adms_users');

        // Inserir os registros na tabela
        $adms_users->insert($data)->save();

    }
}
