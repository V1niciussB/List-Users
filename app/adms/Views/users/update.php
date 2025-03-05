<?php
use App\Adms\Helpers\CSRFHelper;
?>

<div class="container-fluid px-4">
    <div class="mb-1 hstack gap-2">
        <h2 class="mt-3"> Usuários </h2>

        <ol class="breadcrumb mb-3 mt-3 ms-auto">
            <li class="breadcrumb-item"><a href="<?php echo $_ENV['URL_ADM']; ?>dashboard" class="text-decoration-none">
                    Dashboard </a></li>
            <li class="breadcrumb-item"><a href="<?php echo $_ENV['URL_ADM']; ?>list-users"
                    class="text-decoration-none"> Usuários </a></li>
            <li class="breadcrumb-item"> Editar </li>
        </ol>
    </div>

    <div class="card mb-4 border-light shadow">
        <div class="card-header hstack gap-2">
            <span> Editar </span>
            <span class="ms-auto d-sm-flex flex-row">
                <a href="<?php echo $_ENV['URL_ADM']; ?>list-users" class="btn btn-info btn-sm me-1 mb-1"><i
                        class="fa-solid fa-list"></i> Listar</a>

                <a href='<?php echo $_ENV['URL_ADM'] . 'view-user/' . ($this->data['form']['id'] ?? ''); ?>'
                    class="btn btn-primary btn-sm me-1 mb-1">
                    <i class="fa-regular fa-eye"></i> Visualizar </a>
            </span>
        </div>

        <div class="card-body">

            <?php include './app/adms/Views/partials/alerts.php'; ?>

            <form action="" method="POST" class="row g-3">

            <input type="hidden" name="csrf_token" value="<?php echo CSRFHelper::generateCSRFToken('form_update_user'); ?>">

                <input type="hidden" name="id" id="id" value="<?php echo $this->data['form']['id'] ?? ''; ?>">

                <div class="col-12">
                    <label for="username"> Nome: </label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Nome Completo"
                        value="<?php echo $this->data['form']['name'] ?? ''; ?>">
                </div>

                <div class="col-12">
                    <label for="username"> E-mail: </label>
                    <input type="text" name="email" id="email" class="form-control" placeholder="seuemail@celk.com"
                        value="<?php echo $this->data['form']['email'] ?? ''; ?>">
                </div>

                <div class="col-12">
                    <label for="username"> Usuario: </label>
                    <input type="text" name="username" id="username" class="form-control"
                        placeholder="Usuario de acesso" value="<?php echo $this->data['form']['username'] ?? ''; ?>">
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-warning" href="index.html">Editar</button>
                </div>

            </form>
        </div>
    </div>

</div>