<?php

use App\Adms\Helpers\CSRFHelper;

?>

<div class="col-lg-5">
    <div class="card shadow-lg border-0 rounded-lg mt-5">

        <div class="card-header">
            <h3 class="text-center font-weight-light my-4">Login</h3>
        </div>

        <div class="card-body">
            <?php
            // Inclui o arquivo que exibe mensagens de sucesso e erro
            include './app/adms/Views/partials/alerts.php';
            ?>

            <form action="" method="POST">
                <input type="hidden" name="csrf_token"
                    value="<?php echo CSRFHelper::generateCSRFToken('form_login'); ?>">

                <div class="form-floating mb-3">
                    <input type="text" name="username" id="username" class="form-control"
                        placeholder="Usuario de acesso" value="<?php echo $this->data['form']['username'] ?? ''; ?>">
                    <label for="username"> Usuario: </label>
                </div>

                <div class="form-floating mb-3">
                    <input type="password" name="password" id="password" class="form-control" placeholder="*********">
                    <label for="password"> Senha: </label>
                </div>

                <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                    <a href="<?php echo $_ENV['URL_ADM']; ?>forgot-password" class="small text-decoration-none"> Esqueceu a senha?</a>
                    <button type="submit" class="btn btn-primary" href="index.html">Acessar</button>
                </div>
            </form>
        </div>

        <div class="card-footer text-center py-3">
            <div class="small">
                <a href="<?php echo $_ENV['URL_ADM'] ?>new-user" class="text-decoration text-decoration-none"> Cadastrar </a>
            </div>
        </div>
    </div>
</div>