<?php

use App\Adms\Helpers\CSRFHelper;

?>

<div class="col-lg-5">
    <div class="card shadow-lg border-0 rounded-lg mt-5">

        <div class="card-header">
            <h3 class="text-center font-weight-light my-4">Novo Usuário</h3>
        </div>

        <div class="card-body">
            <?php
            // Inclui o arquivo que exibe mensagens de sucesso e erro
            include './app/adms/Views/partials/alerts.php';
            ?>


            <form action="" method="POST">

                <input type="hidden" name="csrf_token"
                    value="<?php echo CSRFHelper::generateCSRFToken('form_new_user'); ?>">



                <div class="form-floating mb-3">
                    <input type="text" name="name" id="name" class="form-control" placeholder="Nome Completo"
                        value="<?php echo $this->data['form']['name'] ?? ''; ?>">
                    <label for="username"> Nome: </label>
                </div>

                <div class="form-floating mb-3">
                    <input type="text" name="email" id="email" class="form-control" placeholder="seuemail@celk.com"
                        value="<?php echo $this->data['form']['email'] ?? ''; ?>">
                    <label for="username"> E-mail: </label>
                </div>

                <div class="form-floating mb-3">
                    <input type="text" name="username" id="username" class="form-control" placeholder="Seu Apelido"
                        value="<?php echo $this->data['form']['username'] ?? ''; ?>">
                    <label for="username"> Username: </label>
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
                    <button type="submit" class="btn btn-primary">Cadastrar</button>
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
</div>