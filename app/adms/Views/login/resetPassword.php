<?php

use App\Adms\Helpers\CSRFHelper;

?>

<div class="col-lg-5">
    <div class="card shadow-lg border-0 rounded-lg mt-5">

        <div class="card-header">
            <h3 class="text-center font-weight-light my-4"> Nova senha </h3>
        </div>

        <div class="card-body">
            <?php
            // Inclui o arquivo que exibe mensagens de sucesso e erro
            include './app/adms/Views/partials/alerts.php';
            ?>

            <form action="" method="POST">

                <input type="hidden" name="csrf_token"
                    value="<?php echo CSRFHelper::generateCSRFToken('form_reset_password'); ?>">


                <div class="form-floating mb-3">
                    <input type="email" name="email" id="email" class="form-control" placeholder="" seuemail@celk.com""
                        value="<?php echo $this->data['form']['email'] ?? '' ?>">
                    <label for="email"> E-mail: </label>
                </div>

                <div class="form-floating mb-3">
                    <input type="password" name="password" id="password" class="form-control" placeholder="*********">
                    <label for="password"> Senha: </label>
                </div>

                <div class="form-floating mb-3">
                    <input type="password" name="confirm_password" id="confirm_password" class="form-control"
                        placeholder="*********">
                    <label for="password"> Confirmar Senha: </label>
                </div>

                <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                    <button type="submit" class="btn btn-primary" href="index.html">Salvar</button>
                </div>

            </form>
        </div>

        <div class="card-footer text-center py-3">
            <div class="small">
                <a href="<?php echo $_ENV['URL_ADM'] ?>login" class="text-decoration text-decoration-none"> Login
                </a>
            </div>
    </div>
</div>