<?php

use App\Adms\Helpers\CSRFHelper;

?>

<div class="col-lg-5">
    <div class="card shadow-lg border-0 rounded-lg mt-5">

        <div class="card-header">
            <h3 class="text-center font-weight-light my-4">Recuperar Usuário</h3>
        </div>

        <div class="card-body">
            <?php
            // Inclui o arquivo que exibe mensagens de sucesso e erro
            include './app/adms/Views/partials/alerts.php';
            ?>


            <form action="" method="POST">
                <input type="hidden" name="csrf_token"
                    value="<?php echo CSRFHelper::generateCSRFToken('form_forgot_password'); ?>">

                <div class="form-floating mb-3">
                    <input type="email" name="email" id="email" class="form-control"
                        placeholder="Usuario de acesso" value="<?php echo $this->data['form']['email'] ?? ''; ?>">
                    <label for="email"> email: </label>
                </div>

                <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                    <button type="submit" class="btn btn-primary" href="index.html">Acessar</button>
                </div>
            </form>
        </div>
        <div class="card-footer text-center py-3">
            <div class="small">
                <a href="<?php echo $_ENV['URL_ADM'] ?>login" class="text-decoration text-decoration-none"> Login</a>
            </div>
        </div>
    </div>
</div>