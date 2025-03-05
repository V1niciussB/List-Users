<?php

namespace App\Adms\Models\Repository;

use App\Adms\Helpers\GenerateLog;
use App\Adms\Models\Services\DbConnection;
use Cake\Core\Exception\Exception;
use PDO;

/**
 *  Repository responsável em buscar os usuários no banco de dados
 */
class UsersRepository extends DbConnection
{
    /**
     *  Recuperar os usuários
     */
    public function getAllUsers(int $page = 1, int $limitResult = 10)
    {

        // Calcular o registro inicial, função max para garantir valor mínimo 0
        $offset = max(0, ($page - 1) * $limitResult);

        // QUERY para recuperar os registros do banco de dados
        $sql = 'SELECT id, name, email FROM adms_users ORDER BY id DESC LIMIT :limit OFFSET :offset'; 
        // preparar a query
        $stmt = $this->getConnection()->prepare($sql);

        // Substituir o link da query pelo seu devido valor
        $stmt->bindValue(":limit", $limitResult, PDO::PARAM_INT);
        $stmt->bindValue(":offset", $offset, PDO::PARAM_INT);


        // Executar a Query
        $stmt->execute();
        // ler os registros e retornar;
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    public function getAmountUsers(): int|bool
    {

        //  Querry para recuperar quantidade de registros
        $sql = 'SELECT COUNT(id) as amount_records FROM adms_users ';

        $stmt = $this->getConnection()->prepare($sql);

        $stmt->execute();


        return ($stmt->fetch(PDO::FETCH_ASSOC)['amount_records']) ?? 0;
    }



    /**
     * @return array|bool Uusário recuperado do banco de dados
     */
    public function getUser(int $id): array|bool
    {
        // QUERY para recuperar o registro do banco de dados
        $sql = 'SELECT id, name, email, username, created_at, updated_at FROM adms_users WHERE id = :id';

        // preparar a query
        $stmt = $this->getConnection()->prepare($sql);

        // Substituir o link da QUERY pelo valor
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        // Executar a Query
        $stmt->execute();
        // ler os registros e retornar;
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createUser(array $formData): bool|int
    {
        try {
            // Query do SQL
            $sql = 'INSERT INTO adms_users (name, email, username, password) VALUES (:name, :email, :username, :password)';
            // Preparando a query (selecionando qual será a conexão)
            $stmt = $this->getConnection()->prepare($sql);
            // Atribuindo valores as variáveis, evitando sql inject 
            $stmt->bindValue(':name', $formData['name'], PDO::PARAM_STR);
            $stmt->bindValue(':email', $formData['email'], PDO::PARAM_STR);
            $stmt->bindValue(':username', $formData['username'], PDO::PARAM_STR);
            // Criptografando senha ->
            $stmt->bindValue(':password', password_hash($formData['password'], PASSWORD_DEFAULT), PDO::PARAM_STR);
            // Executando a query
            $stmt->execute();

            return $this->getConnection()->lastInsertId(); // Retorna o id do usuário

        } catch (\PDOException $e) { // acessa o catch quando houver erro no try

            GenerateLog::generateLog("error", "Usuário não cadastrado.", ['erro' => $e]);

            return false;
        }

    }

    /**
     *  Editar os dados do usuário
     * @param array $data Dados atualizados do usuário
     * @return void Sucesso ou falha
     */
    public function updateUser(array $data): bool
    {

        try { // Permanece no try se não houver erro
            // Query para atualizar usuário
            $sql = 'UPDATE adms_users SET name = :name, email = :email, username = :username, updated_at = :updated_at';

            // Verificar se a senha está inclusa nos dados e, se sim, adicionar no sql
            if (!empty($data['password'])) {
                $sql .= ', password = :password';
            }

            // Condição para indicar qual registro editar
            $sql .= ' WHERE id = :id';

            // Preparar a query
            $stmt = $this->getConnection()->prepare($sql);

            $stmt->bindValue(':name', $data['name'], PDO::PARAM_STR);
            $stmt->bindValue(':email', $data['email'], PDO::PARAM_STR);
            $stmt->bindValue(':username', $data['username'], PDO::PARAM_STR);
            $stmt->bindValue(':updated_at', date("Y-m-d H:i:s"));
            $stmt->bindValue(':id', $data['id'], PDO::PARAM_INT);

            // Substituir o link da senha se a mesma estiver presente
            if (!empty($data['password'])) {
                $$stmt->bindValue(':password', password_hash($data['password'], PASSWORD_DEFAULT), PDO::PARAM_STR);
            }

            $stmt->execute();

            $affectRows = $stmt->rowCount();

            if ($affectRows > 0) {
                return true;
            } else {
                GenerateLog::generateLog("error", "Usuário não editado.", ['erro' => "dados inválidos"]);

                return false;
            }

        } catch (\PDOException $e) { // Acessa o catch quando houver erro no try
            GenerateLog::generateLog("error", "Usuário não editado.", ['erro' => $e]);

            return false;
        }

    }

    public function deleteUser(int $id): bool
    {
        try {
            // Consulta sql
            $sql = "DELETE FROM adms_users WHERE id = :id";
            // Realizando a conexão e preparando a query
            $stmt = $this->getConnection()->prepare($sql);
            // Substituindo valor do link
            $stmt->bindValue('id', $id, PDO::PARAM_INT);
            // Executar a query
            $stmt->execute();

            // Verifica o número de linhas afetadase, se > 0, consulta ok
            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                GenerateLog::generateLog("error", "Usuário não deletado.", ['erro' => "Não foi possível deletar o usuário"]);

                return false;
            }
        } catch (\PDOException $e) {
            GenerateLog::generateLog("error", "Usuário não deletado.", ['erro' => $e->getMessage()]);

            return false;
        }
    }



}



?>