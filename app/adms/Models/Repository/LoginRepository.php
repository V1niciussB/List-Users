<?php

namespace App\Adms\Models\Repository;

use App\Adms\Models\Services\DbConnection;
use PDO;

/**
 *  Repository responsável em buscar os usuários no banco de dados
 */
class LoginRepository extends DbConnection
{

    /**
     * @return array|bool Uusário recuperado do banco de dados
     */
    public function getUser(string $username): array|bool
    {
        // QUERY para recuperar o registro do banco de dados
        $sql = 'SELECT  id, name, email, username, password FROM adms_users WHERE username = :username';

        // preparar a query
        $stmt = $this->getConnection()->prepare($sql);

        // Substituir o link da QUERY pelo valor
        $stmt->bindValue(':username', $username, PDO::PARAM_STR);

        // Executar a Query
        $stmt->execute();

        // ler os registros e retornar;
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
