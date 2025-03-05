<?php

use App\Adms\Helpers\CSRFHelper;

// Gera o token CSRF para proteger o fórmulario de deleção
$csrf_token = CSRFHelper::generateCSRFToken('form_delete_user');

?>

<div class="container-fluid px-4">

    <div class="mb-1 hstack gap-2">
        <h2 class="mt-3"> Usuários </h2>

        <ol class="breadcrumb mb-3 mt-3 ms-auto">
            <li class="breadcrumb-item"><a href="<?php echo $_ENV['URL_ADM']; ?>dashboard" class="text-decoration-none">
                    Dashboard </a></li>
            <li class="breadcrumb-item"><a href="<?php echo $_ENV['URL_ADM']; ?>list-users"
                    class="text-decoration-none"> Usuários </a></li>
            <li class="breadcrumb-item"> Visualizar </li>
        </ol>

    </div>

    <div class="card mb-4 border-light shadow">

        <div class="card-header hstack gap-2">
            <span> Visualizar </span>

            <span class="ms-auto d-sm-flex flex-row gap-2">
                <a href="<?php echo $_ENV['URL_ADM']; ?>list-users" class="btn btn-info btn-sm"><i
                        class="fa-solid fa-list"></i> Listar </a>
                <a href="<?php echo $_ENV['URL_ADM'] . 'update-user/' . ($this->data['user']['id'] ?? ''); ?>"
                    class="btn btn-warning btn-sm"><i class="fa-solid fa-pen-to-square"></i> Editar </a>
                <form id="formDelete<?php echo ($this->data['user']['id'] ?? ''); ?>" action="<?php echo $_ENV['URL_ADM']; ?>delete-user" method="POST">

                    <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">

                    <input type="hidden" name="id" id="id" value="<?php echo ($this->data['user']['id'] ?? ''); ?>">

                    <button type="submit" class="btn btn-danger btn-sm me-1 mb-1"
                                            onclick="confirmDeletion(event, <?php echo ($this->data['user']['id'] ?? ''); ?>)"><i
                                                class="fa-regular fa-trash-can"></i> Apagar </button>

                </form>
                <br>
            </span>
        </div>

        <div class="card-body">

            <?php include './app/adms/Views/partials/alerts.php';

            if ($this->data['user']['id']) {

                extract($this->data['user']);
                ?>

                <dl class="row">
                    <dt class="col-sm-3">ID: </dt>
                    <dd class="col-sm-9"><?php echo $id; ?> </dd>
                    <dt class="col-sm-3">Nome: </dt>
                    <dd class="col-sm-9"><?php echo $name; ?> </dd>
                    <dt class="col-sm-3">E-mail: </dt>
                    <dd class="col-sm-9"><?php echo $email; ?> </dd>
                    <dt class="col-sm-3">Usuário: </dt>
                    <dd class="col-sm-9"><?php echo $username; ?> </dd>
                    <dt class="col-sm-3">Data de Criação: </dt>
                    <dd class="col-sm-9"><?php echo ($created_at ? date('d/m/Y H:i:s', strtotime($created_at)) : "") ?>
                    </dd>
                    <dt class="col-sm-3">Data de Edição: </dt>
                    <dd class="col-sm-9"><?php echo ($updated_at ? date('d/m/Y H:i:s', strtotime($updated_at)) : "") ?>
                    </dd>
                </dl>



            <?php } else { // Acessa o else quando não existir registros
                echo "<div class='alert alert-danger' role='alert'> Nenhum usuário encontrado! </div>";
            } ?>


        </div>

    </div>