<?php

use App\Adms\Helpers\CSRFHelper;

echo "<h3> Editar Usuário </h3>";

echo "<a href='{$_ENV['URL_ADM']}list-users'>Listar</a><br><br>";

if (isset($this->data['errors'])) {

    foreach ($this->data['errors'] as $error) {

        echo "<p style='color: #f00;'> $error </p>";
    }
}

?>

<form action="" method="POST">

    <input type="hidden" name="csrf_token" value="<?php echo CSRFHelper::generateCSRFToken('form_create_user'); ?>">
    <input type="hidden" name="id" id="id" value ="<?php echo $this->data['form']['id'] ?? ''; ?>">
    <label for="name"> Nome: </label>
    <input type="text" name="name" id="name" placeholder="Nome Completo" value ="<?php echo $this->data['form']['name'] ?? ''; ?>">
    <br><br>
    <label for="email"> E-mail: </label>
    <input type="email" name="email" id="email" placeholder="seuemail@celk.com" value ="<?php echo $this->data['form']['email'] ?? ''; ?>">
    <br><br>
    <label for="username"> Username: </label>
    <input type="text" name="username" id="username" placeholder="Seu Apelido" value ="<?php echo $this->data['form']['username'] ?? ''; ?>">
    <br><br>
    <button type="submit">Editar</button>

</form>