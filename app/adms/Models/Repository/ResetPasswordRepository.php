<?php

namespace App\Adms\Models\Repository;

use App\Adms\Helpers\GenerateLog;
use App\Adms\Models\Services\DbConnection;
use Cake\Core\Exception\Exception;
use PDO;

/**
 *  Repository responsável em buscar os usuários no banco de dados
 */
class ResetPasswordRepository extends DbConnection
{
    /**
     *  Recuperar os usuários
     */
    public function getUser(string $email)
    {

        // QUERY para recuperar os registros do banco de dados
        $sql = 'SELECT id, name, email, recover_password, validate_recover_password FROM adms_users WHERE email = :email'; 
        // preparar a query
        $stmt = $this->getConnection()->prepare($sql);

        // Substituir o link da query pelo seu devido valor
        $stmt->bindValue(":email", $email, PDO::PARAM_STR);

        // Executar a Query
        $stmt->execute();

        // ler os registros e retornar;
        return $stmt->fetch(PDO::FETCH_ASSOC);

    }

     /**
     *  Editar os dados do usuário
     * @param array $data Dados atualizados do usuário
     * @return void Sucesso ou falha
     */
    public function updateForgotPassword(array $data): bool
    {

        try { // Permanece no try se não houver erro
            // Query para atualizar usuário
            $sql = 'UPDATE adms_users SET recover_password = :recover_password, validate_recover_password = :validate_recover_password, updated_at = :updated_at';

            // Condição para indicar qual registro editar
            $sql .= ' WHERE email = :email LIMIT 1';

            // Preparar a query
            $stmt = $this->getConnection()->prepare($sql);

            $stmt->bindValue(':recover_password', $data['recover_password'], PDO::PARAM_STR);
            $stmt->bindValue(':validate_recover_password', $data['validate_recover_password']);
            $stmt->bindValue(':updated_at', date("Y-m-d H:i:s"));
            $stmt->bindValue(':email', $data['form']['email'], PDO::PARAM_STR);

            return $stmt->execute();

        } catch (\PDOException $e) { // Acessa o catch quando houver erro no try
            GenerateLog::generateLog("error", "Recuperar senha não salvo no banco de dados.", ['email' => $data['email'], 'error' => $e->getMessage()]);

            return false;
        }

    }



    public function updatePassword(array $data): bool
    {
        var_dump($data);
        try { // Permanece no try se não houver erro
            // Query para atualizar usuário
            $sql = 'UPDATE adms_users SET password = :password, recover_password = NULL, validate_recover_password = NULL, updated_At = :updated_at WHERE email = :email';

            // Preparar a query
            $stmt = $this->getConnection()->prepare($sql);

            $stmt->bindValue(':password', password_hash($data['password'], PASSWORD_DEFAULT), PDO::PARAM_STR);
            $stmt->bindValue(':email', $data['email'], PDO::PARAM_STR);
            $stmt->bindValue(':updated_at', date("Y-m-d H:i:s"));

            return $stmt->execute();
        } catch (\PDOException $e) { // Acessa o catch quando houver erro no try
            GenerateLog::generateLog("error", "Senha não editada.", ['email' => (string) $data['email'],'erro' => $e]);

            return false;
        }

    }

}

?>